<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan_model extends CI_Model {

    public function get_jabatan_by_unit($unit_id)
    {
        $this->db->select('*, pegawai_data.nama as nama_pegawai, kode_jabatan.jabatan_jenis_nama, kode_jabatan.jabatan_jenis_eselon');
        $this->db->from('jabatan_data');
        $this->db->join('pegawai_data', 'jabatan_data.jabatan_nip = pegawai_data.nip', 'left');
        $this->db->join('kode_jabatan', 'jabatan_data.jabatan_jenis_id = kode_jabatan.jabatan_jenis_id', 'left');
        $this->db->where('jabatan_data.unit_id', $unit_id);
        
        $this->db->order_by('jabatan_data.jabatan_kelas', 'desc');
        $this->db->order_by('jabatan_data.jabatan_jenis_id', 'asc');
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Fungsi dari pegawai_model lama untuk mendapatkan semua jabatan dalam satu unit.
     */
 
    public function unit_all() {
        $query = $this -> db -> query("
            SELECT 
                B.*, count(C.nip) as jml_pegawai
            FROM 
                unit_data B
                left join jabatan_data A
                    on A.unit_id = B.unit_id
                left join pegawai_data C
                    on C.nip = A.jabatan_nip
            group by B.unit_id
            order by B.unit_nama ASC,  B.unit_id ASC    
                ");
        return $query -> result();
    }


    public function jabatan_all($unit_id=0) {
        if($unit_id == 0) {
            $kondisi = "WHERE A.unit_id > 0"; 
        } else {
            $kondisi = "WHERE A.unit_id = '".$unit_id."' ";
        }
        
        $query = $this->db->query("
            SELECT 
                A.*, B.*, C.*, 
                D.jabatan_nama as jabatan_nama_atasan, 
                D.jabatan_nip as jabatan_nip_atasan,
                A.unit_id as unit_id,
                E.nama as nama_atasan
            FROM 
                jabatan_data A
            LEFT JOIN pegawai_data B ON A.jabatan_nip = B.nip
            LEFT JOIN kode_jabatan C ON A.jabatan_jenis_id = C.jabatan_jenis_id
            LEFT JOIN jabatan_data D ON A.jabatan_atasan_id = D.jabatan_id
            LEFT JOIN pegawai_data E ON D.jabatan_nip = E.nip
            $kondisi
            ORDER BY A.jabatan_nilai+1 DESC, A.jabatan_jenis_id ASC, A.jabatan_nama ASC      
        ");
        return $query->result();
    }




    /**
     * Fungsi dari pegawai_model lama untuk mendapatkan semua jenis/kode jabatan.
     */
    public function kode_jabatan_all() {
        $query = $this->db->query("
            SELECT A.*
            FROM kode_jabatan A
            ORDER BY A.jabatan_jenis_id ASC    
        ");
        return $query->result();
    }
    
    // Ini adalah duplikat fungsionalitas dari kode_jabatan_all, bisa dipilih salah satu
    public function get_jabatan_jenis()
    {
        $query = $this->db->get('kode_jabatan');
        return $query->result();
    }

    public function get_jabatan_by_id($jabatan_id)
    {
        $query = $this->db->get_where('jabatan_data', array('jabatan_id' => $jabatan_id));
        return $query->row();
    }
    
    public function delete_jabatan($jabatan_id)
    {
        $this->db->where('jabatan_id', $jabatan_id);
        $this->db->delete('jabatan_data');
    }

    public function get_jabatan_detail_by_id($jabatan_id)
    {
        $this->db->select('j.*, p.nama as nama_pegawai, kj.jabatan_jenis_nama, kj.jabatan_jenis_eselon, atasan.jabatan_nama as atasan_nama');
        $this->db->from('jabatan_data j');
        $this->db->join('pegawai_data p', 'j.jabatan_nip = p.nip', 'left');
        $this->db->join('kode_jabatan kj', 'j.jabatan_jenis_id = kj.jabatan_jenis_id', 'left');
        $this->db->join('jabatan_data atasan', 'j.jabatan_atasan_id = atasan.jabatan_id', 'left');
        $this->db->where('j.jabatan_id', $jabatan_id);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Fungsi generik untuk INSERT dari pegawai_model lama.
     */

    public function unit_info($unit_id = 0)
    {
        if ($unit_id == 0) {
            return null;
        }

        $this->db->from('unit_data');
        $this->db->where('unit_id', $unit_id);
        $query = $this->db->get();
        $data = $query->row_array();

        if ($data) {
            // Menghitung jumlah pegawai sama seperti di kode lama
            $data['jml_pegawai'] = count($this->pegawai_all($unit_id));
        }
        
        return $data;
    }

    public function pegawai_all($unit_id = 0)
    {
        if ($unit_id == 0) {
            $where = "";
        } else {
            $where = "WHERE B.unit_id = '$unit_id'";
        }
        $query = $this->db->query("
            SELECT 
                A.nip, A.status_pns, A.nama, B.unit_id, D.jabatan_nama
            FROM 
                pegawai_data A
                left join jabatan_data D
                    on A.nip = D.jabatan_nip
                left join unit_data B
                    on D.unit_id = B.unit_id
                left join kode_pangkat C
                    on A.pangkat_id = C.pangkat_id
                left join kode_jabatan E
                    on D.jabatan_jenis_id = E.jabatan_jenis_id
            $where
            ORDER BY D.jabatan_jenis_id ASC
            ");
        return $query->result();
    }
    function pegawai_tanpa_jabatan() {
//      echo br().br().br().br().br()."page : ".$pg.br()."limit : ".$lmt;

                // $kondisi = "WHERE A.unit_id = ".$unit_id;
        $query = $this -> db -> query("
            SELECT 
                A.*, C.*, D.*, E.*
            FROM 
                pegawai_data A
                left join jabatan_data D
                    on A.nip = D.jabatan_nip
                left join unit_data B
                    on D.unit_id = B.unit_id
                left join kode_pangkat C
                    on A.pangkat_id = C.pangkat_id
                left join kode_jabatan E
                    on D.jabatan_jenis_id = E.jabatan_jenis_id
            WHERE (D.jabatan_jenis_id IS NULL OR D.jabatan_jenis_id = '')   
            AND A.status_pns >= 0   
            order by 
            A.pangkat_id DESC, D.jabatan_jenis_id ASC
            -- , A.pegawai_jabatan ASC  
                ");
    //  return $query -> row_array();
        return $query -> result();
    }

    function pegawai_pensiun() {

        $query = $this -> db -> query("
            SELECT 
                A.*, C.*, D.*, E.*
            FROM 
                pegawai_data A
                left join jabatan_data D
                    on A.nip = D.jabatan_nip
                left join unit_data B
                    on D.unit_id = B.unit_id
                left join kode_pangkat C
                    on A.pangkat_id = C.pangkat_id
                left join kode_jabatan E
                    on D.jabatan_jenis_id = E.jabatan_jenis_id
            WHERE A.status_pns = '-1'       
            order by 
            A.pangkat_id DESC, D.jabatan_jenis_id ASC
            -- , A.pegawai_jabatan ASC  
                ");
    //  return $query -> row_array();
        return $query -> result();
    }
        
    public function tambah($data, $tabel) {
        $result = $this->db->insert($tabel, $data);
        return $result;
    }

    /**
     * Fungsi generik untuk UPDATE dari pegawai_model lama.
     */
    public function edit($id, $data, $tabel, $kunci) {
        $this->db->where($kunci, $id);
        $result = $this->db->update($tabel, $data);
        return $result;
    }
    
    // Fungsi insert_jabatan dan update_jabatan yang spesifik bisa dihapus jika tidak digunakan lagi
    // public function insert_jabatan($data) ...
    // public function update_jabatan($jabatan_id, $data) ...
}