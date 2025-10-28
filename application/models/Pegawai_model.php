<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_model extends CI_Model {

    private $table = 'pegawai_data';

    public function get_all_pegawai($status = 'aktif', $unit_id = null)
    {
        $this->db->select('pegawai_data.*, jabatan_data.jabatan_nama');
        $this->db->from($this->table);
        $this->db->join('jabatan_data', 'pegawai_data.nip = jabatan_data.jabatan_nip', 'left');

        if ($status == 'aktif') {
            $this->db->where('pegawai_data.status_pns', '1');
        } elseif ($status == 'tidak_aktif') {
            $this->db->where('pegawai_data.status_pns !=', '1');
        }

        if ($unit_id) {
            $this->db->where('jabatan_data.unit_id', $unit_id);
        }

        return $this->db->get()->result();
    }

    public function get_pegawai_by_id($nip)
    {
        return $this->db->get_where($this->table, ['nip' => $nip])->row();
    }

    public function insert_pegawai($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_pegawai($nip, $data)
    {
        $this->db->where('nip', $nip);
        return $this->db->update($this->table, $data);
    }

    public function delete_pegawai($nip)
    {
        $this->db->where('nip', $nip);
        return $this->db->delete($this->table);
    }

}
