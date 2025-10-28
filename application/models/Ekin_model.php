<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ekin_model extends CI_Model {

    private $table = 'ekin_konfigurasi_api';

    public function get_all()
    {
        return $this->db->order_by('updated_at', 'DESC')->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['config_id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['config_id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['config_id' => $id]);
    }

    /**
     * Mengatur satu konfigurasi menjadi aktif dan menonaktifkan yang lain.
     */
    public function set_active($id)
    {
        // Mulai transaksi
        $this->db->trans_start();

        // Set semua menjadi tidak aktif
        $this->db->update($this->table, ['is_active' => 0]);

        // Set yang dipilih menjadi aktif
        $this->db->update($this->table, ['is_active' => 1], ['config_id' => $id]);

        // Selesaikan transaksi
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // --- Periode Methods ---

    public function get_all_periode()
    {
        return $this->db->order_by('tahun', 'DESC')->order_by('angka_periodik', 'ASC')->get('ekin_ref_periode')->result();
    }

    public function get_periode_by_id($id)
    {
        return $this->db->get_where('ekin_ref_periode', ['id' => $id])->row();
    }

    public function insert_periode($data)
    {
        return $this->db->insert('ekin_ref_periode', $data);
    }

    public function update_periode($id, $data)
    {
        return $this->db->update('ekin_ref_periode', $data, ['id' => $id]);
    }

    public function delete_periode($id)
    {
        return $this->db->delete('ekin_ref_periode', ['id' => $id]);
    }

    // --- Laporan Penilaian Methods ---

    public function get_pegawai_with_penilaian()
    {
        return $this->db->distinct()
                        ->select('nip, nama')
                        ->from('ekin_laporan_penilaian')
                        ->where('nip IS NOT NULL')
                        ->where('nama IS NOT NULL')
                        ->order_by('nama', 'ASC')
                        ->get()
                        ->result();
    }

    public function get_penilaian_by_nip($nip)
    {
        return $this->db->from('ekin_laporan_penilaian')
                        ->where('nip', $nip)
                        ->order_by('tahun_skp', 'DESC')
                        ->order_by('created_at', 'DESC')
                        ->get()
                        ->result();
    }

    public function get_all_units()
    {
        return $this->db->order_by('unit_nama', 'ASC')->get('unit_data')->result();
    }

    // public function get_penilaian_by_unit_and_periode($unit_id, $periode_id)
    // {
    //     // Ambil semua NIP yang ada di unit tersebut dari tabel jabatan_data
    //     $nips = $this->db->select('jabatan_nip')
    //                      ->from('jabatan_data')
    //                      ->where('unit_id', $unit_id)
    //                      ->where('jabatan_nip IS NOT NULL')
    //                      ->get()
    //                      ->result_array();

    //     if (empty($nips)) {
    //         return [];
    //     }

    //     // Ubah array of objects menjadi array of NIPs
    //     $nip_list = array_column($nips, 'jabatan_nip');

    //     // Ambil data penilaian berdasaelpan daftar NIP dan periode
    //     return $this->db->from('ekin_laporan_penilaian')
    //                     ->where_in('nip', $nip_list)
    //                     ->where('periode_id', $periode_id)
    //                     ->order_by('nama', 'ASC')
    //                     ->get()
    //                     ->result();
    // }

    public function get_periode_by_year_and_month($tahun, $bulan)
    {
        return $this->db->from('ekin_ref_periode')
                        ->where('tahun', $tahun)
                        ->where('angka_periodik', $bulan)
                        ->get()
                        ->row();
    }

    public function get_nips_by_unit($unit_id)
    {
        return $this->db->distinct()
                        ->select('jabatan_nip')
                        ->from('jabatan_data')
                        ->where('unit_id', $unit_id)
                        ->where('jabatan_nip IS NOT NULL')
                        ->get()
                        ->result_array();
    }

    public function get_penilaian_by_unit_and_periode($unit_id, $periode_id)
    {
        $this->db->select('
        pd.nama as nama_pegawai,
        elp.*,
        jd.jabatan_nip as nip,
        jd.jabatan_id, 
        jd.jabatan_nama as jabatan
        ');
        $this->db->from('jabatan_data jd');
        $this->db->join('pegawai_data pd', 'jd.jabatan_nip = pd.nip', 'left');
        $this->db->join('unit_data ud', 'jd.unit_id = ud.unit_id', 'left');
        $this->db->join('ekin_laporan_penilaian elp', 'pd.nip = elp.nip AND elp.periode_id = ' . $this->db->escape($periode_id), 'left');
        $this->db->where('pd.nip >', 0);

        if ($unit_id != '') {
            $this->db->where('jd.unit_id', $unit_id);
        }
        $this->db->group_by('pd.nip');
        $this->db->order_by('jd.jabatan_jenis_id', 'ASC');
        // $this->db->order_by('pd.nama', 'ASC');

        return $this->db->get()->result();
    }

    public function get_last_update_time($unit_id, $periode_id)
    {
        $this->db->select_max('created_at');
        $this->db->from('ekin_laporan_penilaian');
        $this->db->where('periode_id', $periode_id);
        
        // Subquery to get NIPs from the specified unit
        $this->db->where("nip IN (SELECT jabatan_nip FROM jabatan_data WHERE unit_id = ".$this->db->escape($unit_id).")", NULL, FALSE);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->created_at;
        }

        return null;
    }

}
