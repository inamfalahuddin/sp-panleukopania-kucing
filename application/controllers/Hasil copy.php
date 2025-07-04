<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil extends My_Controller
{
    protected $for_role = 'admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Hasil_model');
        $this->load->model('Gejala_model');
        $this->load->model('Users_model');
        $this->load->model('Konsultasi_model');
        $this->load->model('Penyakit_model');
    }

    public function index()
    {
        $data['title'] = 'Data Riwayat';
        $data['riwayat'] = $this->Hasil_model->get_all();
        $data['contents'] = $this->load->view('diagnosa_view', $data, true);
        $this->load->view('templates/admin_templates', $data);
    }

    // public function perhitungan()
    // {
    //     $data['title'] = 'Perhitungan Riwayat';

    //     $get_riwayat_all = $this->Hasil_model->get_all();

    //     $data['hasils'] = [];
    //     foreach ($get_riwayat_all as $riwayat) {
    //         $hasil = $this->hitung($riwayat['id']);
    //         $data['hasils'][] = [
    //             'hasil_id'      => $riwayat['id'],
    //             'user_id'       => $hasil['user_id'],
    //             'user_nama'     => $hasil['user_nama'],
    //             'penyakit_id'   => $hasil['hasil']['penyakit_id'],
    //             'penyakit_kode' => $hasil['hasil']['penyakit_kode'],
    //             'penyakit_nama' => $hasil['hasil']['penyakit_nama'],
    //             'probabilitas'  => $hasil['hasil']['probabilitas'],
    //             'persentase'    => $hasil['hasil']['persentase'],
    //             'diagnosa'     => $hasil['diagnosa'],
    //             'total_persentase' => $hasil['total_persentase'],
    //             'perhitungan'   => $hasil['perhitungan'],
    //             'total_bayes'  => $hasil['total_bayes']
    //         ];
    //     }

    //     $data['contents'] = $this->load->view('diagnosa_perhitungan_view', $data, true);
    //     $this->load->view('templates/admin_templates', $data);
    // }

    public function perhitungan()
    {
        $data['title'] = 'Perhitungan Riwayat';

        $get_riwayat_all = $this->Hasil_model->get_all();

        $data['hasils'] = [];
        foreach ($get_riwayat_all as $riwayat) {
            // Panggil fungsi hitung yang sudah kita modifikasi sebelumnya
            $hasil = $this->hitung($riwayat['id']);

            // Bangun array untuk dikirim ke view
            // Kunci 'total_persentase' dan 'total_bayes' dihapus karena tidak lagi digunakan
            $data['hasils'][] = [
                'hasil_id'      => $riwayat['id'],
                'user_id'       => $hasil['user_id'],
                'user_nama'     => $hasil['user_nama'],
                'penyakit_id'   => $hasil['hasil']['penyakit_id'],
                'penyakit_kode' => $hasil['hasil']['penyakit_kode'],
                'penyakit_nama' => $hasil['hasil']['penyakit_nama'],
                'probabilitas'  => $hasil['hasil']['probabilitas'],
                'persentase'    => $hasil['hasil']['persentase'], // Persentase dari penyakit tertinggi
                'diagnosa'      => $hasil['diagnosa'],           // Hasil dari tabel himpunan (e.g., "Terjangkit Parah")
                'perhitungan'   => $hasil['perhitungan'],
            ];
        }

        $data['contents'] = $this->load->view('diagnosa_perhitungan_view', $data, true);
        $this->load->view('templates/admin_templates', $data);
    }

    // public function perhitungan()
    // {
    //     $data['title'] = 'Perhitungan Riwayat';

    //     $get_riwayat_all = $this->Hasil_model->get_all();

    //     $data['hasils'] = [];
    //     foreach ($get_riwayat_all as $riwayat) {
    //         $hasil = $this->hitung($riwayat['id']);
    //         $data['hasils'][] = [
    //             'hasil_id'      => $riwayat['id'],
    //             'user_id'       => $hasil['user_id'],
    //             'user_nama'     => $hasil['user_nama'],
    //             'penyakit_id'   => $hasil['hasil']['penyakit_id'],
    //             'penyakit_kode' => $hasil['hasil']['penyakit_kode'],
    //             'penyakit_nama' => $hasil['hasil']['penyakit_nama'],
    //             'probabilitas'  => $hasil['hasil']['probabilitas'],
    //             'perhitungan'   => $hasil['perhitungan']
    //         ];
    //     }

    //     $data['contents'] = $this->load->view('diagnosa_perhitungan_view', $data, true);
    //     $this->load->view('templates/admin_templates', $data);
    // }

    // public function hitung($id)
    // {
    //     // ambil data pasien 1
    //     $get_riwayat            = $this->Hasil_model->get_by_id($id);
    //     $get_gejalas            = $get_riwayat['gejala'];
    //     $get_master_gejala      = $this->Gejala_model->get_all();
    //     $get_master_penyakit    = $this->Penyakit_model->get_all();

    //     // 1. menentukan nilai nc pasa masing" penyakit
    //     $penyakit = $this->Penyakit_model->get_all();

    //     $nilai_nc = [];
    //     foreach ($penyakit as $key => $item) {

    //         $rule = [];
    //         foreach ($get_gejalas as $gejala) {
    //             $rule[] = [
    //                 'rule_id'           => null,
    //                 'gejala_id'         => $gejala['id'],
    //                 'gejala_kode'       => $gejala['kode'],
    //                 'gejala_selected'   => $this->Penyakit_model->check_exist($item['id'], $gejala['id']),
    //             ];
    //         }

    //         $tmp = [
    //             'pasien_id'         => $get_riwayat['id'],
    //             'pasien_nama'       => $get_riwayat['nama_user'],
    //             'penyakit_id'       => $item['id'],
    //             'penyakit_kode'     => $item['kode'],
    //             'nama'              => $item['nama'],
    //             'total_penyakit'    => count($get_master_penyakit),
    //             'n'                 => 1,
    //             'm'                 => count($get_master_gejala),
    //             'rules'             => $rule,
    //         ];

    //         $nilai_nc_f = $tmp['n'] / $tmp['total_penyakit'];
    //         $nilai_nc_f = floor($nilai_nc_f * 1000) / 1000;
    //         $tmp['nilai_nc'] = $nilai_nc_f;

    //         $nilai_nc[] = $tmp;
    //     }

    //     // 2. Menghitung nilai P(ai|vj) dan menghitung nilai P(vj)
    //     $nilai_p = [];

    //     foreach ($nilai_nc as $item) {
    //         $tmp = [
    //             'penyakit_id'     => $item['penyakit_id'],
    //             'penyakit_kode'   => $item['penyakit_kode'],
    //             'penyakit_nama'   => $item['nama'],
    //             'penyakit_total'  => $item['total_penyakit'],
    //             'penyakit_n'      => $item['n'],
    //             'penyakit_m'      => $item['m'],
    //             'nilai_nc'        => $item['nilai_nc'],
    //         ];

    //         $rules = [];
    //         foreach ($item['rules'] as $rule) {
    //             $pembilang  = $rule['gejala_selected'] + ($item['m'] * $item['nilai_nc']);
    //             $pembagi    = $item['n'] + $item['m'];
    //             $result     = $pembilang / $pembagi;

    //             $rules[] = [
    //                 'rule_id'         => $rule['rule_id'],
    //                 'gejala_id'       => $rule['gejala_id'],
    //                 'gejala_kode'     => $rule['gejala_kode'],
    //                 'gejala_selected' => $rule['gejala_selected'],
    //                 'nilai_p'         => floor($result * 1000) / 1000,
    //             ];
    //         }

    //         $tmp['rules'] = $rules;
    //         $nilai_p[] = $tmp;
    //     }

    //     // 3. Menghitung P(ai|vj) x P(vj) untuk tiap v dan menambahkannya ke $nilai_p
    //     $probabilitas = [];

    //     foreach ($nilai_p as $index => $item) {
    //         $hasil_perkalian = 1;
    //         foreach ($item['rules'] as $r) {
    //             $nilai = $r['nilai_p'];
    //             $nilai_terpotong = floor($nilai * 1000) / 1000;
    //             $hasil_perkalian *= number_format($r['nilai_p'], 3, '.', '');
    //         }

    //         $result = $item['nilai_nc'] * $hasil_perkalian;
    //         $nilai_p[$index]['probabilitas'] = round($result, 8); // dimasukkan ke dalam nilai_p

    //         $probabilitas[] = [
    //             'penyakit_id'    => $item['penyakit_id'],
    //             'penyakit_kode'  => $item['penyakit_kode'],
    //             'penyakit_nama'  => $item['penyakit_nama'],
    //             'probabilitas'   => round($result, 8),
    //         ];
    //     }

    //     // Menentukan penyakit dengan probabilitas tertinggi
    //     $hasil = null;
    //     $max = 0;

    //     foreach ($nilai_p as $item) {
    //         if ($item['probabilitas'] > $max) {
    //             $max = $item['probabilitas'];
    //             $hasil = [
    //                 'penyakit_id'    => $item['penyakit_id'],
    //                 'penyakit_kode'  => $item['penyakit_kode'],
    //                 'penyakit_nama'  => $item['penyakit_nama'],
    //                 'probabilitas'   => $item['probabilitas'],
    //             ];
    //         }
    //     }

    //     // Jika tidak ada hasil, pastikan tetap ada struktur kosong (opsional tapi aman)
    //     if ($hasil === null) {
    //         $hasil = [
    //             'penyakit_id'    => null,
    //             'penyakit_kode'  => null,
    //             'penyakit_nama'  => null,
    //             'probabilitas'   => 0,
    //         ];
    //     }

    //     // Output akhir
    //     $output = [
    //         'user_id'     => $get_riwayat['user_id'],
    //         'user_nama'   => $get_riwayat['nama_user'],
    //         'hasil'       => $hasil,
    //         'perhitungan' => $nilai_p
    //     ];

    //     return $output;
    // }

    // public function hitung($id)
    // {
    //     // ambil data pasien
    //     $get_riwayat            = $this->Hasil_model->get_by_id($id);
    //     $get_gejalas            = $get_riwayat['gejala'];
    //     $get_master_penyakit    = $this->Penyakit_model->get_all();

    //     // 1. Hitung nilai probabilitas gejala untuk setiap penyakit
    //     $probabilitas_gejala = [];
    //     foreach ($get_master_penyakit as $penyakit) {
    //         foreach ($get_gejalas as $gejala) {
    //             $probabilitas = $this->Penyakit_model->check_exist($penyakit['id'], $gejala['id']);
    //             if ($probabilitas > 0) {
    //                 $probabilitas_gejala[$gejala['kode']][$penyakit['kode']] = $probabilitas;
    //             }
    //         }
    //     }

    //     // 2. Hitung total probabilitas gejala (nilai semesta)
    //     $total_probabilitas = 0;
    //     foreach ($get_gejalas as $gejala) {
    //         $kode_gejala = $gejala['kode'];
    //         if (isset($probabilitas_gejala[$kode_gejala])) {
    //             $max_prob = max($probabilitas_gejala[$kode_gejala]);
    //             $total_probabilitas += $max_prob;
    //         }
    //     }

    //     // 3. Hitung P(Hi) untuk setiap penyakit
    //     $penyakit_probabilitas = [];
    //     foreach ($get_master_penyakit as $penyakit) {
    //         $total_gejala_penyakit = 0;

    //         foreach ($get_gejalas as $gejala) {
    //             $kode_gejala = $gejala['kode'];
    //             $probabilitas = $this->Penyakit_model->check_exist($penyakit['id'], $gejala['id']);
    //             if ($probabilitas > 0) {
    //                 $total_gejala_penyakit += $probabilitas;
    //             }
    //         }

    //         if ($total_probabilitas > 0) {
    //             $p_hi = $total_gejala_penyakit / $total_probabilitas;
    //         } else {
    //             $p_hi = 0;
    //         }

    //         $penyakit_probabilitas[$penyakit['id']] = [
    //             'penyakit_id' => $penyakit['id'],
    //             'penyakit_kode' => $penyakit['kode'],
    //             'penyakit_nama' => $penyakit['nama'],
    //             'p_hi' => round($p_hi, 4),
    //             'gejala' => []
    //         ];
    //     }

    //     // 4. Hitung P(E|Hi) untuk setiap penyakit dan gejala
    //     foreach ($get_master_penyakit as $penyakit) {
    //         foreach ($get_gejalas as $gejala) {
    //             $p_e_hi = $this->Penyakit_model->check_exist($penyakit['id'], $gejala['id']);

    //             $penyakit_probabilitas[$penyakit['id']]['gejala'][] = [
    //                 'gejala_id' => $gejala['id'],
    //                 'gejala_kode' => $gejala['kode'],
    //                 'p_e_hi' => $p_e_hi
    //             ];
    //         }
    //     }

    //     // 5. Hitung P(Hi) x P(E|Hi) untuk setiap penyakit
    //     $total_p_hi_p_e_hi = 0;
    //     foreach ($penyakit_probabilitas as &$penyakit) {
    //         $p_hi_p_e_hi = $penyakit['p_hi'];
    //         foreach ($penyakit['gejala'] as $gejala) {
    //             $p_hi_p_e_hi *= $gejala['p_e_hi'];
    //         }
    //         $penyakit['p_hi_p_e_hi'] = round($p_hi_p_e_hi, 6);
    //         $total_p_hi_p_e_hi += $p_hi_p_e_hi;
    //     }

    //     // 6. Hitung P(Hi|E) untuk setiap penyakit
    //     $total_p_hi_e = 0;
    //     foreach ($penyakit_probabilitas as &$penyakit) {
    //         if ($total_p_hi_p_e_hi > 0) {
    //             $p_hi_e = ($penyakit['p_hi_p_e_hi'] / $total_p_hi_p_e_hi);
    //         } else {
    //             $p_hi_e = 0;
    //         }
    //         $penyakit['p_hi_e'] = round($p_hi_e, 6);
    //         $total_p_hi_e += $p_hi_e;
    //     }

    //     // 7. Hitung total nilai bayes dan persentase
    //     $total_bayes = $total_p_hi_e;
    //     $persentase = round($total_bayes * 100, 2);

    //     // 8. Tentukan hasil diagnosa
    //     $hasil_diagnosa = "Tidak Terjangkit";
    //     if ($persentase > 70) {
    //         $hasil_diagnosa = "Terjangkit Tinggi";
    //     } elseif ($persentase > 30) {
    //         $hasil_diagnosa = "Terjangkit Rendah";
    //     }

    //     // 9. Temukan penyakit dengan probabilitas tertinggi
    //     $max_prob = 0;
    //     $hasil_penyakit = null;
    //     foreach ($penyakit_probabilitas as $penyakit) {
    //         if ($penyakit['p_hi_e'] > $max_prob) {
    //             $max_prob = $penyakit['p_hi_e'];
    //             $hasil_penyakit = [
    //                 'penyakit_id' => $penyakit['penyakit_id'],
    //                 'penyakit_kode' => $penyakit['penyakit_kode'],
    //                 'penyakit_nama' => $penyakit['penyakit_nama'],
    //                 'probabilitas' => $penyakit['p_hi_e'],
    //                 'persentase' => round($penyakit['p_hi_e'] * 100, 2)
    //             ];
    //         }
    //     }

    //     // Jika tidak ada hasil, buat struktur kosong
    //     if ($hasil_penyakit === null) {
    //         $hasil_penyakit = [
    //             'penyakit_id' => null,
    //             'penyakit_kode' => null,
    //             'penyakit_nama' => null,
    //             'probabilitas' => 0,
    //             'persentase' => 0
    //         ];
    //     }

    //     // Output akhir
    //     $output = [
    //         'user_id' => $get_riwayat['user_id'],
    //         'user_nama' => $get_riwayat['nama_user'],
    //         'hasil' => $hasil_penyakit,
    //         'diagnosa' => $hasil_diagnosa,
    //         'total_persentase' => $persentase,
    //         'perhitungan' => array_values($penyakit_probabilitas),
    //         'total_bayes' => $total_bayes
    //     ];

    //     return $output;
    // }

    public function hitung($id)
    {
        // Asumsi Anda sudah load model ini di constructor: $this->load->model('Himpunan_model');

        // Ambil data pasien, penyakit, dan himpunan diagnosa
        $get_riwayat           = $this->Hasil_model->get_by_id($id);
        $get_gejalas           = $get_riwayat['gejala'];
        $get_master_penyakit   = $this->Penyakit_model->get_all();
        $get_himpunan_diagnosa = $this->Hasil_model->get_himpunan_all(); // <-- TAMBAHKAN INI

        // Langkah 1 s/d 6: Perhitungan Naive Bayes (SAMA SEPERTI KODE ANDA)
        // 1. Hitung nilai probabilitas gejala untuk setiap penyakit
        $probabilitas_gejala = [];
        foreach ($get_master_penyakit as $penyakit) {
            foreach ($get_gejalas as $gejala) {
                $probabilitas = $this->Penyakit_model->check_exist($penyakit['id'], $gejala['id']);
                if ($probabilitas > 0) {
                    $probabilitas_gejala[$gejala['kode']][$penyakit['kode']] = $probabilitas;
                }
            }
        }

        // 2. Hitung total probabilitas gejala (nilai semesta)
        $total_probabilitas = 0;
        foreach ($get_gejalas as $gejala) {
            $kode_gejala = $gejala['kode'];
            if (isset($probabilitas_gejala[$kode_gejala])) {
                $max_prob = max($probabilitas_gejala[$kode_gejala]);
                $total_probabilitas += $max_prob;
            }
        }

        // 3. Hitung P(Hi) untuk setiap penyakit
        $penyakit_probabilitas = [];
        foreach ($get_master_penyakit as $penyakit) {
            $total_gejala_penyakit = 0;
            foreach ($get_gejalas as $gejala) {
                $kode_gejala = $gejala['kode'];
                $probabilitas = $this->Penyakit_model->check_exist($penyakit['id'], $gejala['id']);
                if ($probabilitas > 0) {
                    $total_gejala_penyakit += $probabilitas;
                }
            }
            $p_hi = ($total_probabilitas > 0) ? ($total_gejala_penyakit / $total_probabilitas) : 0;
            $penyakit_probabilitas[$penyakit['id']] = [
                'penyakit_id'   => $penyakit['id'],
                'penyakit_kode' => $penyakit['kode'],
                'penyakit_nama' => $penyakit['nama'],
                'p_hi'          => round($p_hi, 4),
                'gejala'        => []
            ];
        }

        // 4. Hitung P(E|Hi) untuk setiap penyakit dan gejala
        foreach ($get_master_penyakit as $penyakit) {
            foreach ($get_gejalas as $gejala) {
                $p_e_hi = $this->Penyakit_model->check_exist($penyakit['id'], $gejala['id']);
                $penyakit_probabilitas[$penyakit['id']]['gejala'][] = [
                    'gejala_id'   => $gejala['id'],
                    'gejala_kode' => $gejala['kode'],
                    'p_e_hi'      => $p_e_hi
                ];
            }
        }

        // 5. Hitung P(Hi) x P(E|Hi) untuk setiap penyakit
        $total_p_hi_p_e_hi = 0;
        foreach ($penyakit_probabilitas as &$penyakit) {
            $p_hi_p_e_hi = $penyakit['p_hi'];
            foreach ($penyakit['gejala'] as $gejala) {
                if ($gejala['p_e_hi'] > 0) { // Hanya kalikan jika ada gejala yang berhubungan
                    $p_hi_p_e_hi *= $gejala['p_e_hi'];
                }
            }
            $penyakit['p_hi_p_e_hi'] = round($p_hi_p_e_hi, 6);
            $total_p_hi_p_e_hi += $penyakit['p_hi_p_e_hi'];
        }

        // 6. Hitung P(Hi|E) untuk setiap penyakit (Probabilitas Posterior)
        foreach ($penyakit_probabilitas as &$penyakit) {
            $p_hi_e = ($total_p_hi_p_e_hi > 0) ? ($penyakit['p_hi_p_e_hi'] / $total_p_hi_p_e_hi) : 0;
            $penyakit['p_hi_e'] = round($p_hi_e, 6);
        }
        unset($penyakit); // hapus referensi terakhir

        // =======================================================================
        // BAGIAN YANG DIMODIFIKASI
        // =======================================================================

        // 7. Temukan penyakit dengan probabilitas tertinggi (Logika dari langkah 9 Anda, dipindahkan ke sini)
        $max_prob = 0;
        $hasil_penyakit = null;
        foreach ($penyakit_probabilitas as $penyakit) {
            if ($penyakit['p_hi_e'] > $max_prob) {
                $max_prob = $penyakit['p_hi_e'];
                $hasil_penyakit = [
                    'penyakit_id'   => $penyakit['penyakit_id'],
                    'penyakit_kode' => $penyakit['penyakit_kode'],
                    'penyakit_nama' => $penyakit['penyakit_nama'],
                    'probabilitas'  => $penyakit['p_hi_e'], // Nilai 0.00 s/d 1.00
                    'persentase'    => round($penyakit['p_hi_e'] * 100, 2)
                ];
            }
        }

        // Jika tidak ada hasil, buat struktur kosong
        if ($hasil_penyakit === null) {
            $hasil_penyakit = [
                'penyakit_id' => null,
                'penyakit_kode' => null,
                'penyakit_nama' => null,
                'probabilitas' => 0,
                'persentase' => 0
            ];
        }

        // 8. Tentukan hasil diagnosa berdasarkan himpunan dinamis
        $hasil_diagnosa = "Status Tidak Didefinisikan"; // Nilai default
        $nilai_diagnosa = $hasil_penyakit['probabilitas']; // Gunakan probabilitas tertinggi (nilai antara 0-1)

        foreach ($get_himpunan_diagnosa as $himpunan) {
            // Konversi batas bawah/atas dari string (e.g., "0,21") ke float (0.21)
            $batas_bawah = (float) str_replace(',', '.', $himpunan['batas_bawah']);
            $batas_atas  = (float) str_replace(',', '.', $himpunan['batas_atas']);

            if ($nilai_diagnosa >= $batas_bawah && $nilai_diagnosa <= $batas_atas) {
                $hasil_diagnosa = $himpunan['variabel'];
                break; // Hentikan loop jika sudah menemukan rentang yang sesuai
            }
        }

        // 9. Output akhir
        $output = [
            'user_id'         => $get_riwayat['user_id'],
            'user_nama'       => $get_riwayat['nama_user'],
            'hasil'           => $hasil_penyakit, // Penyakit dengan probabilitas tertinggi
            'diagnosa'        => $hasil_diagnosa, // Hasil dari tabel himpunan
            'persentase_keyakinan' => $hasil_penyakit['persentase'], // Persentase penyakit tertinggi
            'perhitungan'     => array_values($penyakit_probabilitas),
        ];

        return $output;
    }

    public function delete($id)
    {
        // select apakah datanya ada ? 
        $riwayat = $this->Hasil_model->get_by_id($id);
        if (!$riwayat) {
            $this->session->set_flashdata('error', 'Data riwayat tidak ditemukan.');
            redirect('hasil');
        }

        // delete data
        $this->Hasil_model->delete($id);

        $this->session->set_flashdata('message', 'Data riwayat berhasil dihapus.');
        redirect('hasil');
    }
}
