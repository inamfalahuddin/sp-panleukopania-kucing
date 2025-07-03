<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit_model extends CI_Model
{
    protected $table_def    = 'penyakit';
    protected $table_rules  = 'rules';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->table_def, $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table_def);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function get_rules_by_id($penyakit_id)
    {
        $this->db->select('rules.id, gejala.id as gejala_id, gejala.kode as gejala_kode, gejala.nama as gejala_nama');
        $this->db->from($this->table_rules);
        $this->db->join('gejala', 'rules.gejala_id = gejala.id', 'left');
        $this->db->where('rules.penyakit_id', $penyakit_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table_def, $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table_def);
    }

    public function check_exist($penyakit_id, $gejala_id)
    {
        $this->db->from('rules');
        $this->db->where('penyakit_id', $penyakit_id);
        $this->db->where('gejala_id', $gejala_id);

        $query = $this->db->get();
        $row = $query->row();

        if ($row && isset($row->nilai)) {
            return floatval(rtrim(rtrim(number_format($row->nilai, 4, '.', ''), '0'), '.'));
        }

        return 0;
    }
}
