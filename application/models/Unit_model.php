
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_model extends CI_Model {

    private $table = 'unit_data';
    private $primary_key = 'unit_id';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_all_with_employee_count()
    {
        $this->db->select('unit_data.*, COUNT(DISTINCT pegawai_data.nip) as jumlah_pegawai, COUNT(DISTINCT jabatan_data.jabatan_id) as jumlah_jabatan');
        $this->db->from('unit_data');
        $this->db->join('jabatan_data', 'unit_data.unit_id = jabatan_data.unit_id', 'left');
        $this->db->join('pegawai_data', 'jabatan_data.jabatan_nip = pegawai_data.nip', 'left');
        $this->db->group_by('unit_data.unit_id');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primary_key => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, [$this->primary_key => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }
}
