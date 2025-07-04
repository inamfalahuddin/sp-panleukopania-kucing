<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi_model extends CI_Model
{
    protected $table_riwayat        = 'hasil_diagnosa';
    protected $table_riwayat_detail = 'hasil_diagnosa_detail';
    protected $table_gejala         = 'gejala';
    protected $table_penyakit       = 'penyakit';
    protected $table_himpunan       = 'himpunan';

    public function __construct()
    {
        parent::__construct();
    }

    public function store($data)
    {
        $this->db->trans_start();

        $data_chunk = [
            'user_id'       => $data['user_id'] ?? null,
            'nama'          => $data['nama'],
            'alamat'        => $data['alamat'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'umur'          => $data['umur'],
            'no_hp'         => $data['no_hp'],
            'himpunan_id'   => null,
            'created_at'    => date('Y-m-d H:i:s'),
            'created_by'    => $data['user_id'] ?? null,
            'update_at'     => date('Y-m-d H:i:s'),
            'update_by'     => $data['user_id'] ?? null,
            'deleted'       => 0
        ];

        $this->db->insert($this->table_riwayat, $data_chunk);
        $riwayat_id = $this->db->insert_id();

        $data_detail = [];
        foreach ($data['gejala'] as $value) {
            $data_detail[] = [
                'hasil_id' => $riwayat_id,
                'gejala_id'  => $value,
            ];
        }

        $this->db->insert_batch($this->table_riwayat_detail, $data_detail);
        $this->db->trans_complete();

        return $riwayat_id;
    }

    public function get_by_id($riwayat_id)
    {
        $this->db->select('hasil_diagnosa.*, himpunan.variabel as nama_penyakit, GROUP_CONCAT(gejala.kode) as gejala_kode, GROUP_CONCAT(gejala.nama) as gejala_nama');
        $this->db->from($this->table_riwayat);
        $this->db->join($this->table_riwayat_detail, 'hasil_diagnosa.id = hasil_diagnosa_detail.hasil_id', 'left');
        $this->db->join($this->table_gejala, 'hasil_diagnosa_detail.gejala_id = gejala.id', 'left');
        $this->db->join($this->table_himpunan, 'hasil_diagnosa.himpunan_id = himpunan.id', 'left');
        $this->db->where('hasil_diagnosa.id', $riwayat_id);
        $this->db->group_by('hasil_diagnosa.id');

        return $this->db->get()->row();
    }

    public function hitung($id)
    {
        // ambil data pasien 1
        $get_riwayat = $this->Konsultasi_model->get_by_id($id);
        $get_gejalas = $get_riwayat['gejala'];
        $get_master_gejala = $this->Gejala_model->get_all();
        $get_master_penyakit = $this->Penyakit_model->get_all();

        // 1. menentukan nilai nc pasa masing" penyakit
        $penyakit = $this->Penyakit_model->get_all();

        $nilai_nc = [];
        foreach ($penyakit as $key => $item) {

            $rule = [];
            foreach ($get_gejalas as $gejala) {
                $rule[] = [
                    'rule_id' => null,
                    'gejala_id' => $gejala['id'],
                    'gejala_kode' => $gejala['kode'],
                    'gejala_selected' => $this->Penyakit_model->check_exist($item['id'], $gejala['id']),
                ];
            }

            $tmp = [
                'penyakit_id'       => $item['id'],
                'penyakit_kode'     => $item['kode'],
                'nama'              => $item['nama'],
                'total_penyakit'    => count($get_master_penyakit),
                'n'                 => 1,
                'm'                 => count($get_master_gejala),
                'rules'             => $rule,
            ];

            $tmp['nilai_nc'] = number_format($tmp['n'] / $tmp['total_penyakit'], 4, '.', '');

            $nilai_nc[] = $tmp;
        }

        // 2. Menghitung nilai P(ai|vj) dan menghitung nilai P(vj)
        $nilai_p = [];
        foreach ($nilai_nc as $key => $item) {

            $tmp = [
                'penyakit_id'           => $item['penyakit_id'],
                'penyakit_kode'        => $item['penyakit_kode'],
                'penyakit_nama'        => $item['nama'],
                'penyakit_total'       => $item['total_penyakit'],
                'penyakit_n'           => $item['n'],
                'penyakit_m'           => $item['m'],
                'nilai_nc'             => $item['nilai_nc'],
            ];

            $rules = [];
            foreach ($item['rules'] as $rule) {
                $pembilang  = $rule['gejala_selected'] + $item['m'] * $item['nilai_nc'];
                $pembagi    = $item['n'] + $item['m'];
                $result     = $pembilang / $pembagi;

                $rules[] = [
                    'rule_id'              => $rule['rule_id'],
                    'gejala_id'            => $rule['gejala_id'],
                    'gejala_kode'          => $rule['gejala_kode'],
                    'gejala_selected'      => $rule['gejala_selected'],
                    'nilai_p'              => number_format($result, 4, '.', '')
                ];
            }

            $tmp['rules'] = $rules;
            $nilai_p[] = $tmp;
        }

        // 3. Menghitung P(ai|vj) x P(vj) untuk tiap v
        $probabilitas = [];
        foreach ($nilai_p as $item) {
            $hasil_perkalian = 1;
            foreach ($item['rules'] as $r) {
                $hasil_perkalian *= $r['nilai_p'];
            }

            $result = $item['nilai_nc'] * $hasil_perkalian;
            $probabilitas[] = [
                'penyakit_id'    => $item['penyakit_id'],
                'penyakit_kode'  => $item['penyakit_kode'],
                'penyakit_nama'  => $item['penyakit_nama'],
                'probabilitas'   => number_format($result, 8, '.', ''),
            ];
        }

        // 4. Hasil. ambil hasil terbesar
        $hasil = [];
        $max = 0;
        foreach ($probabilitas as $item) {
            if ($item['probabilitas'] > $max) {
                $max = $item['probabilitas'];
                $hasil = [
                    'penyakit_id'    => $item['penyakit_id'],
                    'penyakit_kode'  => $item['penyakit_kode'],
                    'penyakit_nama'  => $item['penyakit_nama'],
                    'probabilitas'   => $item['probabilitas'],
                ];
            }
        }

        return $hasil;
    }
}
