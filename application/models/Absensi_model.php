<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_rekap_absen($unit_id, $tahun, $bulan)
    {
        $this->db->select('
            pd.nip,
            pd.nama as nama_pegawai,
            ud.unit_nama,
            ra.ra_bobot as bobot,
            COALESCE(ra.H, 0) as hadir,
            COALESCE(ra.I, 0) as izin,
            COALESCE(ra.S, 0) as sakit,
            COALESCE(ra.CT, 0) as cuti,
            COALESCE(ra.TK, 0) as tidak_hadir,
            0 as terlambat,
            0 as pulang_cepat
        ');
        $this->db->from('jabatan_data jd');
        $this->db->join('pegawai_data pd', 'jd.jabatan_nip = pd.nip', 'left');
        $this->db->join('unit_data ud', 'jd.unit_id = ud.unit_id', 'left');
        $this->db->join('rekap_absen ra', 'pd.nip = ra.nip AND ra.tahun = ' . $this->db->escape($tahun) . ' AND ra.bulan = ' . $this->db->escape($bulan), 'left');
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

    public function get_monthly_attendance_detail($nip, $tahun, $bulan)
    {
        $this->db->from('absen_data');
        $this->db->where('nip', $nip);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->result();
    }
    
    public function get_pegawai_info($nip)
    {
        $this->db->select('pd.nip, pd.nama, jd.unit_id, jd.jabatan_nama');
        $this->db->from('pegawai_data pd');
        $this->db->join('jabatan_data jd', 'jd.jabatan_nip = pd.nip', 'left');
        $this->db->where('nip', $nip);
        return $this->db->get()->row();
    }

    public function get_rekap_absen_by_nip($nip, $tahun, $bulan)
    {
        $this->db->from('rekap_absen');
        $this->db->where('nip', $nip);
        $this->db->where('tahun', $tahun);
        $this->db->where('bulan', $bulan);
        return $this->db->get()->row();
    }

    public function get_scanlog_data($nip = null, $tahun = null, $bulan = null)
    {
        $this->db->select('tsa.sn, tsa.scan_date, tsa.pin');
        $this->db->from('tb_scanlog_ars tsa');
        $this->db->join('tb_pegawai tp', 'tsa.pin = tp.pin', 'left');

        if ($nip) {
            $this->db->where('tp.nip', $nip);
        }
        if ($tahun) {
            $this->db->where('YEAR(tsa.scan_date)', $tahun);
        }
        if ($bulan) {
            $this->db->where('MONTH(tsa.scan_date)', $bulan);
        }

        $this->db->order_by('tsa.scan_date', 'DESC');
        $this->db->limit(1000); // Limit the results to avoid performance issues
        return $this->db->get()->result();
    }

    public function get_absen_exceptions($unit_id, $tahun, $bulan)
    {
        $this->db->select('ae.*, pd.nama as nama_pegawai');
        $this->db->from('absen_excp ae');
        $this->db->join('pegawai_data pd', 'ae.nip = pd.nip', 'left');
        $this->db->join('jabatan_data jd', 'pd.nip = jd.jabatan_nip', 'left');
        
        if ($unit_id) {
            $this->db->where('jd.unit_id', $unit_id);
        }
        if ($tahun) {
            $this->db->where('YEAR(ae.tgl_mulai)', $tahun);
        }
        if ($bulan) {
            $this->db->where('MONTH(ae.tgl_mulai)', $bulan);
        }

        $this->db->order_by('ae.tgl_mulai', 'DESC');
        return $this->db->get()->result();
    }

    public function get_exception_by_id($id)
    {
        return $this->db->get_where('absen_excp', ['excp_id' => $id])->row();
    }

    public function insert_exception($data)
    {
        return $this->db->insert('absen_excp', $data);
    }

    public function update_exception($id, $data)
    {
        $this->db->where('excp_id', $id);
        return $this->db->update('absen_excp', $data);
    }

    public function delete_exception($id)
    {
        $this->db->where('excp_id', $id);
        return $this->db->delete('absen_excp');
    }

    public function get_kode_absen()
    {
        return $this->db->get('kodeabsen')->result();
    }


	function apel_all($tahun=0, $bulan=0) 
	{
	$tanggal = $tahun."-".str_pad($bulan, 2, "0", STR_PAD_LEFT)."-";
	$query = $this -> db -> query("		
			SELECT 
				Y.*, W.*

			FROM 
				absen_apel Y
				LEFT JOIN absen_lokasi W 
				ON W.lokasi_id = Y.lokasi_id

			WHERE
				Y.apel_tanggal LIKE '$tanggal%'
			ORDER BY Y.apel_tanggal ASC
				");
		// $data = $query -> row_array();
		// return $query -> row_array();
		return $query -> result();
	}

    function pegawai_info($nip=0) {

        $kondisi = "WHERE A.nip = '".$nip."'";
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
            $kondisi
            order by  D.tpp ASC, D.jabatan_aktif DESC
            limit 1         

                ");
        $data = $query -> row_array();
        $jabatan_atasan = $this -> jabatan_atasan($data['jabatan_id']);
        $data['atasan_nip'] = $jabatan_atasan['jabatan_nip'];
        return $data;
    }
    function pegawai_all($unit_id=0) {

        if($unit_id==0) {return array();}  
                $kondisi = "WHERE B.unit_id = '".$unit_id."' ";

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
            $kondisi        
            AND A.status_pns >= 0   
            order by 
            
            if(D.jabatan_jenis_id = '' or D.jabatan_jenis_id is null,1,0),D.jabatan_jenis_id ASC,
            A.pangkat_id DESC 
            -- , A.pegawai_jabatan ASC  
                ");
    //  return $query -> row_array();
        return $query -> result();
    }
    function jabatan_atasan($jabatan_id=0) {

        for ($i=0; $i < 4; $i++) { 
        $query = $this -> db -> query("
            SELECT 
                B.*, A.*,  C.*
            FROM 
                jabatan_data X
            left join jabatan_data A
                    on A.jabatan_id = X.jabatan_atasan_id
            left join pegawai_data B
                    on A.jabatan_nip = B.nip
            left join kode_jabatan C
                    on A.jabatan_jenis_id = C.jabatan_jenis_id
            WHERE X.jabatan_id = '$jabatan_id'
            order by A.jabatan_jenis_id ASC 
                ");
        $data = $query -> row_array();
        //jabatan_atasan


        if($data['jabatan_nip']>0)
            { return $data; }
        
        $jabatan_id=$data['jabatan_id'];
        }

    }
	function get_pin($nip=0) 
	{
		$query = $this -> db -> query("		
			SELECT 
				Y.pin
			FROM 
				tb_pegawai Y
			WHERE
			Y.nip = '$nip'
				");
		 $hasil=$query -> row_array();
		 return $hasil['pin'];
	}
	
	function hari_shd_jml($tahun,$bulan) {
		//$bulan adalah bulan
		// $jml_hari = 0;
		if ($bulan == 1) {
			$jml_hari = 31;
		} elseif ($bulan == 2) {
			if($tahun % 4 == 0)
			{$jml_hari = 29;} else {$jml_hari = 28;}
		} elseif ($bulan == 3) {
			$jml_hari = 31;
		} elseif ($bulan == 4) {
			$jml_hari = 30;
		} elseif ($bulan == 5) {
			$jml_hari = 31;
		} elseif ($bulan == 6) {
			$jml_hari = 30;
		} elseif ($bulan == 7) {
			$jml_hari = 31;
		} elseif ($bulan == 8) {
			$jml_hari = 31;
		} elseif ($bulan == 9) {
			$jml_hari = 30;
		} elseif ($bulan == 10) {
			$jml_hari = 31;
		} elseif ($bulan == 11) {
			$jml_hari = 30;
		} elseif ($bulan == 12) {
			$jml_hari = 31;
		} 
		else {
			$jml_hari = 0;
		}
		return $jml_hari;
	}
    function nama_bulan($x) {
        if ($x == 1) {
            $bulan = "Januari";
        } elseif ($x == 2) {
            $bulan = "Februari";
        } elseif ($x == 3) {
            $bulan = "Maret";
        } elseif ($x == 4) {
            $bulan = "April";
        } elseif ($x == 5) {
            $bulan = "Mei";
        } elseif ($x == 6) {
            $bulan = "Juni";
        } elseif ($x == 7) {
            $bulan = "Juli";
        } elseif ($x == 8) {
            $bulan = "Agustus";
        } elseif ($x == 9) {
            $bulan = "September";
        } elseif ($x == 10) {
            $bulan = "Oktober";
        } elseif ($x == 11) {
            $bulan = "November";
        } elseif ($x == 12) {
            $bulan = "Desember";
        }
        return $bulan;
    }

    
	function hapus_absen_data($nip=0, $tahun=0,$bulan=0) 
	{
	$tanggal_awal = $tahun."-".str_pad($bulan, 2, "0", STR_PAD_LEFT)."-"."01";
	$tanggal_akhir = $tahun."-".str_pad($bulan, 2, "0", STR_PAD_LEFT)."-".$this->hari_shd_jml($tahun,$bulan);
	$query = $this -> db -> query("		
			DELETE 
			FROM 
				absen_data

			WHERE
			nip = '$nip'
			AND tanggal <= '$tanggal_akhir'
			AND tanggal >= '$tanggal_awal'
				");
		// $data = $query -> row_array();
		// return $query -> row_array();
		// return $query -> result();
		return;			
	}
    function absen_log_all($pin=0, $tahun=0,$bulan=0) 
	{
	$tanggal = $tahun."-".str_pad($bulan, 2, "0", STR_PAD_LEFT)."-";

	$query = $this -> db -> query("		
			SELECT 
				Z.sn, Z.scan_date, Z.workcode, Z.pin
				, count(Z.sn) as jml_dobel,
				date(Z.scan_date) as tanggal,
				time(Z.scan_date) as waktu_scan,
				C.instansi as unit_sn
			FROM 
				tb_scanlog_ars Z
				left join instansi C
					on Z.sn = C.sn
			WHERE Z.pin = '$pin'
				AND Z.scan_date like '$tanggal%'
			group BY Z.sn,	Z.scan_date, Z.workcode, Z.pin
			ORDER BY Z.scan_date ASC, jml_dobel DESC
				");
			return $query -> result();
	}


	function absen_waktu_all() 
	{
	$query = $this -> db -> query("		
			SELECT 
				Z.*
			FROM 
				absen_waktu Z
				");
		// return $query -> row_array();
		return $query -> result();			
	}



	function ramadhan_cek($tanggal=0)
	{
	// $tanggal = $tahun."-".str_pad($bulan, 2, "0", STR_PAD_LEFT)."-";

	$query = $this -> db -> query("		
			SELECT 
			count(W.ramadhan_id) as cek

			FROM 
				absen_ramadhan W
	
			WHERE
				'$tanggal' >= W.ramadhan_mulai 
				AND '$tanggal' <= W.ramadhan_akhir
				");
		return $query -> row_array();
		// return $query -> result();			
	}

    function absen_data_all($nip=0, $tahun=0,$bulan=0) 
	    {
	    $tanggal = $tahun."-".str_pad($bulan, 2, "0", STR_PAD_LEFT)."-";
	
	    $query = $this -> db -> query("		
				SELECT 
					Y.*, Y.masuk_unit, Y.keluar_unit, X.hari_nama, 
					W.ramadhan_cek,
					Z.waktu_nama, U.simbol_induk
	
				FROM 
					absen_data Y
					left join absen_hari X
						on X.hari_id = dayofweek(Y.tanggal)
					left join kodeabsen U
						on U.simbol = Y.kode
					left join absen_waktu Z
						on Z.waktu_id = Y.waktu_id
					left join harilibur V
						on V.tanggal = Y.tanggal
					left join absen_ramadhan W
						on Y.tanggal >= W.ramadhan_mulai AND Y.tanggal <= W.ramadhan_akhir
	
				WHERE
				Y.nip = '$nip'
				AND Y.tanggal LIKE '$tanggal%'
				order by Y.tanggal ASC, Y.waktu_id ASC, Y.ad_id DESC
					");
			// return $query -> row_array();
			return $query -> result();			
		}
	function data_harian($nip=0, $tanggal=0) 
	{

	$query = $this -> db -> query("		
			SELECT 
				X.hari_id,
				X.hari_nama,	
				X.hari_waktu,
				V.id As libur_id,
				V.keterangan as libur_ket,
				W.ramadhan_cek,
				(SELECT O.kode 
					from absen_excp O 
					WHERE O.tgl_mulai <= '$tanggal'
					AND O.tgl_akhir >= '$tanggal'
					AND O.nip = '$nip'
					LIMIT 1
					) as kode,

				(SELECT P.keterangan 
					from absen_excp P
					WHERE P.tgl_mulai <= '$tanggal'
					AND P.tgl_akhir >= '$tanggal'
					AND P.nip = '$nip'
					LIMIT 1
					) as excp_ket,

				(SELECT M.non_tpp
					from kodeabsen M
					WHERE kode = M.simbol
					LIMIT 1
					) as non_tpp,

				(SELECT M.pengurangan
					from kodeabsen M
					WHERE kode = M.simbol
					LIMIT 1
					) as pengurangan,
				(SELECT Q.me_id
					from absen_mesinerror Q
					WHERE '$tanggal' >= Q.me_mulai 
					AND '$tanggal' <= Q.me_akhir
					AND S.unit_id = Q.unit_id
					LIMIT 1
					) as me_id

			FROM 
				absen_hari X
				left join harilibur V
					on V.tanggal like '$tanggal'
				left join absen_ramadhan W
					on '$tanggal' >= W.ramadhan_mulai AND '$tanggal' <= W.ramadhan_akhir
				left join jabatan_data S
					on $nip = S.jabatan_nip 
					AND S.jabatan_aktif >= 0
			WHERE
			X.hari_id = dayofweek('$tanggal') 
			LIMIT 1
				");
		return $query -> row_array();
		// return $query -> result();			


	}

	function excp_jumlah($nip=0,$tahun=0) {
        $awal = $tahun."-01-01";
        $akhir = $tahun."-12-31";
        $query = $this -> db -> query("		
        SELECT 
            Z.*, DATEDIFF(Z.tgl_akhir, Z.tgl_mulai)+1 AS jml_hari
        FROM 
            absen_excp Z
        WHERE
            Z.nip like '$nip'
            AND
            (
                (Z.tgl_mulai BETWEEN '$awal' AND '$akhir')
                OR
                (Z.tgl_akhir BETWEEN '$awal' AND '$akhir')
            )
        ORDER BY Z.tgl_mulai DESC,  Z.tgl_akhir DESC	
            ");
    // return $query -> row_array();
    return $query -> result();			
}

function ra_hapus($nip=0,$tahun=0,$bulan=0) {
    $ada=count($this->ra_info($nip,$tahun,$bulan));
    if($ada>0)
    {
    $query = $this -> db -> query("
        DELETE
        FROM 
            rekap_absen
        WHERE
        nip = '$nip'
        AND bulan = '$bulan'
        AND tahun = '$tahun' 
            ");
    }
    return;
}
function ra_info($nip=0,$tahun=0,$bulan=0) {
    $query = $this -> db -> query("
        SELECT 
            Y.nip,Y.tahun,Y.bulan,sum(Y.ra_bobot) as ra_bobot
        FROM 
            rekap_absen Y
        WHERE
        Y.nip = '$nip'
        AND Y.bulan = '$bulan'
        AND Y.tahun = '$tahun' 
        group by Y.nip,Y.tahun,Y.bulan
            ");
    return $query -> row_array();
}
function edit($id, $data, $tabel, $kunci) {
    $this -> db -> where($kunci, $id);
    $result = $this -> db -> update($tabel, $data);
    return $result;
}

function tambah($data, $tabel) {
    $result = $this -> db -> insert($tabel, $data);
    return $result;
}

function delete($id, $tabel, $kunci) {
    // $data_log['del_tgl'] = date("Y-m-d");
    $data_log['del_tabel'] = $tabel;
    $data_log['del_user'] = $this -> session -> userdata('nip');
    $data_log['del_log'] = json_encode($this -> select_all($id, $tabel, $kunci));

    if(isset($_SERVER['HTTP_REFERER']))
    {$data_log['del_url'] = htmlspecialchars($_SERVER['HTTP_REFERER']);} else
    {$data_log['del_url']="#";}

    $result1 = $this -> tambah($data_log, 'log_del');



    // echo br(); print_r($data_log);
        $this -> db -> where($kunci, $id);
    $result = $this -> db -> delete($tabel);
    return $result;
}

}
