<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_model extends CI_Model
{
    protected $table_def        = 'riwayat';
    protected $table_def_detail = 'riwayat_detail';
    protected $table_gejala     = 'gejala';
    protected $table_penyakit   = 'penyakit';

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
            riwayat.*, 
            penyakit.nama AS nama_penyakit, 
            GROUP_CONCAT(gejala.kode ORDER BY gejala.kode) AS gejala_kode, 
            GROUP_CONCAT(gejala.nama ORDER BY gejala.kode) AS gejala_nama
        ');
        $this->db->from($this->table_def);
        $this->db->join($this->table_def_detail, 'riwayat.id = riwayat_detail.riwayat_id', 'left');
        $this->db->join($this->table_gejala, 'riwayat_detail.gejala_id = gejala.id', 'left');
        $this->db->join($this->table_penyakit, 'riwayat.penyakit_id = penyakit.id', 'left');
        $this->db->group_by('riwayat.id');

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
            riwayat.id as riwayat_id, riwayat.user_id, riwayat.nama as user_nama, riwayat.alamat, riwayat.jenis_kelamin, riwayat.umur, riwayat.no_hp,
            gejala.id as gejala_id, gejala.kode as gejala_kode, gejala.nama as gejala_nama');
        $this->db->from('riwayat');
        $this->db->join('riwayat_detail', 'riwayat.id = riwayat_detail.riwayat_id');
        $this->db->join('gejala', 'gejala.id = riwayat_detail.gejala_id');
        $this->db->where('riwayat.id', $riwayat_id);

        $query = $this->db->get();
        $result = $query->result();

        if (empty($result)) return null;

        $data = [
            'id'            => $result[0]->riwayat_id,
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
                'nilai' => 1
            ];
        }

        return $data;
    }

    public function update_penyakit_id($riwayat_id, $penyakit_id, $probabilitas)
    {
        $this->db->where('id', $riwayat_id);
        $this->db->update($this->table_def, ['penyakit_id' => $penyakit_id, 'probabilitas' => $probabilitas]);
        return $this->db->affected_rows() > 0;
    }

    public function delete($riwayat_id)
    {
        // delete riwayat detail
        $this->db->where('riwayat_id', $riwayat_id);
        $this->db->delete($this->table_def_detail);

        // check if detail deleted
        if ($this->db->affected_rows() > 0) {
            $this->db->where('id', $riwayat_id);
            $this->db->delete($this->table_def);
            return $this->db->affected_rows() > 0;
        }
        return false;
    }
}
