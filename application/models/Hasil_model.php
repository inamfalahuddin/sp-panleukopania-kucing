<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_model extends CI_Model
{
    protected $table_def        = 'hasil_diagnosa';
    protected $table_def_detail = 'hasil_diagnosa_detail';
    protected $table_gejala     = 'gejala';
    protected $table_penyakit   = 'penyakit';
    protected $table_himpunan   = 'himpunan';

    public function __construct()
    {
        parent::__construct();
    }

    public function store($data)
    {
        $this->db->insert($this->table_def, $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_all()
    {
        $this->db->select('
            hasil_diagnosa.*, 
            himpunan.variabel AS nama_penyakit, 
            GROUP_CONCAT(gejala.kode ORDER BY gejala.kode) AS gejala_kode, 
            GROUP_CONCAT(gejala.nama ORDER BY gejala.kode) AS gejala_nama
        ');
        $this->db->from($this->table_def);
        $this->db->join($this->table_def_detail, 'hasil_diagnosa.id = hasil_diagnosa_detail.hasil_id', 'left');
        $this->db->join($this->table_gejala, 'hasil_diagnosa_detail.gejala_id = gejala.id', 'left');
        $this->db->join($this->table_himpunan, 'hasil_diagnosa.himpunan_id = himpunan.id', 'left');
        $this->db->group_by('hasil_diagnosa.id');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function get_by_id($riwayat_id)
    {
        $this->db->select('
            hasil_diagnosa.id as hasil_id, hasil_diagnosa.user_id, hasil_diagnosa.nama as user_nama, hasil_diagnosa.alamat, hasil_diagnosa.jenis_kelamin, hasil_diagnosa.umur, hasil_diagnosa.no_hp,
            gejala.id as gejala_id, gejala.kode as gejala_kode, gejala.nama as gejala_nama, gejala.bobot as gejala_bobot');
        $this->db->from('hasil_diagnosa');
        $this->db->join('hasil_diagnosa_detail', 'hasil_diagnosa.id = hasil_diagnosa_detail.hasil_id');
        $this->db->join('gejala', 'gejala.id = hasil_diagnosa_detail.gejala_id');
        $this->db->where('hasil_diagnosa.id', $riwayat_id);

        $query = $this->db->get();
        $result = $query->result();

        if (empty($result)) return null;

        $data = [
            'id'            => $result[0]->hasil_id,
            'user_id'       => $result[0]->user_id,
            'nama_user'     => $result[0]->user_nama,
            'alamat'        => $result[0]->alamat,
            'jenis_kelamin' => $result[0]->jenis_kelamin,
            'umur'          => $result[0]->umur,
            'no_hp'         => $result[0]->no_hp,
            'gejala'        => []
        ];

        foreach ($result as $row) {
            $data['gejala'][] = [
                'id'    => $row->gejala_id,
                'kode'  => $row->gejala_kode,
                'nama'  => $row->gejala_nama,
                'nilai' => $row->gejala_bobot
            ];
        }

        return $data;
    }

    public function update_penyakit_id($riwayat_id, $penyakit_id, $probabilitas)
    {
        $this->db->where('id', $riwayat_id);
        $this->db->update($this->table_def, ['himpunan_id' => $penyakit_id, 'probabilitas' => $probabilitas]);
        return $this->db->affected_rows() > 0;
    }

    public function delete($riwayat_id)
    {
        // delete hasil detail
        $this->db->where('hasil_id', $riwayat_id);
        $this->db->delete($this->table_def_detail);

        // check if detail deleted
        if ($this->db->affected_rows() > 0) {
            $this->db->where('id', $riwayat_id);
            $this->db->delete($this->table_def);
            return $this->db->affected_rows() > 0;
        }
        return false;
    }

    public function get_himpunan_all()
    {
        return $this->db->get($this->table_himpunan)->result_array();
    }

    public function get_himpunan($bobot)
    {
        $this->db->from('himpunan');
        $this->db->where("'{$bobot}' BETWEEN batas_bawah AND batas_atas");
        $query = $this->db->get();

        return $query->row();
    }
}
