<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi extends CI_Controller
{
    protected $for_role = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Gejala_model');
        $this->load->model('Users_model');
        $this->load->model('Konsultasi_model');
        $this->load->model('Hasil_model');
        $this->load->model('Penyakit_model');
        check_role($this->for_role);
    }

    public function index()
    {
        $data['gejala'] = $this->Gejala_model->get_all();
        $data['user']   = $this->Users_model->get_by_email($this->session->userdata('email'));

        $data['contents'] = $this->load->view('konsultasi_view', $data, true);
        $this->load->view('templates/user_templates', $data);
    }

    public function hasil()
    {
        // for ($i = 1; $i <= 30; $i++) {
        //     $riwayat_id = $i;
        //     $get_hasil = $this->hitung($riwayat_id);

        //     $this->Hasil_model->update_penyakit_id($riwayat_id, $get_hasil['penyakit_id'], $get_hasil['probabilitas']);
        // }

        $riwayat_id = $this->input->get('id');
        $get_hasil = $this->hitung($riwayat_id)[0] ?? null;

        // echo "<pre>";
        // print_r($get_hasil);
        // echo "</pre>"; die;

        $this->Hasil_model->update_penyakit_id($riwayat_id, $get_hasil['himpunan_id'], $get_hasil['hitung_total_bayes']['total']    );

        $data['riwayat'] = null;

        if ($riwayat_id) {
            $data['riwayat'] = $this->Konsultasi_model->get_by_id($riwayat_id);
        }

        $data['title'] = 'Hasil Konsultasi';
        $data['contents'] = $this->load->view('konsultasi_hasil_view', $data, true);
        $this->load->view('templates/user_templates', $data);
    }

    public function submit()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['gejala'] = $this->Gejala_model->get_all();
            $data['user']   = (object)[
                'nama'          => set_value('nama'),
                'jenis_kelamin' => set_value('jenis_kelamin'),
                'alamat'        => set_value('alamat'),
            ];
            $data['alert_danger'] = validation_errors();

            $data['contents'] = $this->load->view('konsultasi_view', $data, true);
            $this->load->view('templates/user_templates', $data);
        } else {

            $result = $this->Konsultasi_model->store([
                'user_id'       => $this->session->userdata('user_id'),
                'nama'          => $this->input->post('nama', true),
                'nama_kucing'   => $this->input->post('nama_kucing', true),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
                'alamat'        => $this->input->post('alamat', true),
                'gejala'        => $this->input->post('gejala') ?? []
            ]);

            $this->session->set_flashdata('alert_success', 'Data berhasil disimpan.');
            redirect('konsultasi/hasil?id=' . $result);
        }
    }

    public function hitung($id)
    {
        $get_riwayat         = $this->Hasil_model->get_by_id($id);
        $get_gejalas         = $get_riwayat['gejala'];
        $get_master_penyakit = $this->Penyakit_model->get_all();
        $penyakit            = $this->Penyakit_model->get_all();

        $nilai_nc = [];

        if(!$penyakit) {
            return [];
        }

        foreach ($penyakit as $item) {
            $rule = [];

            if(!$get_gejalas) {
                continue;
            }
            foreach ($get_gejalas as $gejala) {
                $rule[] = [
                    'gejala_id'        => $gejala['id'],
                    'gejala_kode'      => $gejala['kode'],
                    'gejala_selected'  => $this->Penyakit_model->check_exist($item['id'], $gejala['id']),
                ];
            }

            // 1. Hitung nilai semesta dan ph_i
            $semesta = array_sum(array_column($rule, 'gejala_selected'));

            foreach ($rule as &$r) {
                $selected = floatval($r['gejala_selected']);
                $ph_i = $semesta > 0 ? $selected / $semesta : 0;
                $r['ph_i'] = floor($ph_i * 100) / 100;
            }
            unset($r);

            // 2. Hitung Probabilitas Hipotesis
            $formula_text  = [];
            $formula_value = [];
            $perkalian     = [];
            $total         = 0;

            foreach ($rule as $r) {
                $ph = floatval($r['ph_i']);
                $pe = floor(floatval($r['gejala_selected']) * 10) / 10;

                if ($ph > 0 && $pe > 0) {
                    $hasil = $ph * $pe;
                    $angka = (int) preg_replace('/\D/', '', $r['gejala_kode']);

                    $formula_text[]   = "(P(H{$angka}) x P(E | H{$angka}))";
                    $formula_value[]  = "(" . number_format($ph, 2, '.', '') . " x " . $pe . ")";
                    $perkalian[]      = number_format(floor($hasil * 100) / 100, 2, '.', '');
                    $total           += $hasil;
                }
            }

            $total_hipotesis = floatval(number_format($total, 3, '.', ''));

            $probabilitas_hipotesis = [
                'formula_text'  => implode(' + ', $formula_text),
                'formula_value' => implode(' + ', $formula_value),
                'perkalian'     => implode(' + ', $perkalian),
                'total'         => $total_hipotesis,
            ];

            // 3. Hitung nilai P(Hi | E) per gejala
            $phi_e_gejala = [];
            foreach ($rule as $r) {
                $selected = floatval($r['gejala_selected']);
                $ph_i     = floatval($r['ph_i']);
                $hasil    = $selected * $ph_i;
                $hasil_fix = floor($hasil * 100) / 100;
                $phi_e    = $total_hipotesis > 0 ? ($hasil_fix * $selected) / $total_hipotesis : 0;

                $angka = (int) preg_replace('/\D/', '', $r['gejala_kode']);

                $phi_e_gejala[] = [
                    'kode_gejala' => "P(H{$angka} | E)",
                    'rumus'       => "(" . $selected . " × " . $hasil_fix . ") / " . $total_hipotesis,
                    'hasil'       => floatval(number_format($phi_e, 3, '.', '')),
                ];
            }

            // 4. Hitung total nilai bayes
            $phi_hasil_array = array_column($phi_e_gejala, 'hasil');
            $bayes_formula   = implode(' + ', $phi_hasil_array);
            $bayes_total     = array_sum($phi_hasil_array);
            $bayes_percent   = floor($bayes_total * 100);

            $hitung_total_bayes = [
                'formula'    => $bayes_formula,
                'total'      => floatval(number_format($bayes_total, 3, '.', '')),
                'persentase' => $bayes_percent . '%'
            ];

            // 5. Gabungkan semua ke 1 paket
            $tmp = [
                'penyakit_id'            => $item['id'],
                'penyakit_kode'          => $item['kode'],
                'nama'                   => $item['nama'],
                'total_penyakit'         => count($get_master_penyakit),
                'semesta'                => $semesta,
                'rules'                  => $rule,
                'probabilitas_hipotesis' => $probabilitas_hipotesis,
                'phi_e'                  => $phi_e_gejala,
                'hitung_total_bayes'     => $hitung_total_bayes,
                'himpunan_id'            => $this->Hasil_model->get_himpunan($hitung_total_bayes['total'])->id ?? null,
            ];

            $nilai_nc[] = $tmp;
        }

        // 6. Urutkan berdasarkan nilai bayes tertinggi
        usort($nilai_nc, function ($a, $b) {
            return $b['hitung_total_bayes']['total'] <=> $a['hitung_total_bayes']['total'];
        });

        // 7. Ambil hanya 1 penyakit terbaik
        $hasil_tertinggi = array_slice($nilai_nc, 0, 1);

        // Debug hasil (jika perlu)
        // echo "<pre>";
        // print_r($hasil_tertinggi);
        // echo "</pre>";

        return $hasil_tertinggi;
    }

    public function perhitungan()
    {
        $data['title'] = 'Perhitungan Bayesian';
        $get_riwayat_all = $this->Hasil_model->get_all();

        $data['himpunan_data'] = $this->db->get('himpunan')->result_array();

        $data['hasils'] = [];
        foreach ($get_riwayat_all as $riwayat) {
            $hasil = $this->hitung($riwayat['id']);
            $user_data = $this->Hasil_model->get_by_id($riwayat['id']);

            $data['hasils'][] = [
                'user_nama' => $user_data['nama_user'], 
                'nama' => $hasil[0]['nama'],
                'semesta' => $hasil[0]['semesta'],
                'rules' => $hasil[0]['rules'],
                'probabilitas_hipotesis' => $hasil[0]['probabilitas_hipotesis'],
                'phi_e' => $hasil[0]['phi_e'],
                'hitung_total_bayes' => $hasil[0]['hitung_total_bayes'],
                'himpunan_id' => $hasil[0]['himpunan_id'],
            ];
        }


        // echo "<pre>";
        // print_r($data['hasils']);
        // echo "</pre>";

        $this->load->view('templates/admin_templates', [
            'contents' => $this->load->view('diagnosa_perhitungan_view', $data, true),
            'title' => $data['title']
        ]);
    }
}
