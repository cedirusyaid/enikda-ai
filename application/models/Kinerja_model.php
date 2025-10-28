<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kinerja_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_rekap_kinerja($unit_id, $tahun, $bulan)
    {
        $this->db->select('
            pd.nip,
            pd.nama as nama_pegawai,
            ud.unit_nama,
            rk.rk_bobot as bobot
        ');
        $this->db->from('jabatan_data jd');
        $this->db->join('pegawai_data pd', 'jd.jabatan_nip = pd.nip', 'left');
        $this->db->join('unit_data ud', 'jd.unit_id = ud.unit_id', 'left');
        $this->db->join('rekap_kinerja rk', 'pd.nip = rk.nip AND rk.tahun = ' . $this->db->escape($tahun) . ' AND rk.bulan = ' . $this->db->escape((int)$bulan), 'left');
        $this->db->where('pd.nip >', 0);

        if ($unit_id != '') {
            $this->db->where('jd.unit_id', $unit_id);
        }
        $this->db->group_by('pd.nip');
        $this->db->order_by('jd.jabatan_jenis_id', 'ASC');
        // $this->db->order_by('pd.nama', 'ASC');

        return $this->db->get()->result();
    }

    public function get_tahun_options()
    {
        // Placeholder: Generate or fetch available years
        $current_year = date('Y');
        $years = [];
        for ($i = $current_year - 5; $i <= $current_year + 1; $i++) {
            $years[] = (string)$i;
        }
        return $years;
    }

    public function get_bulan_options()
    {
        // Placeholder: Generate month names
        return [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }
}
