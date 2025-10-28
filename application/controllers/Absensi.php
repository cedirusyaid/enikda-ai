<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->model('Unit_model'); // To get unit data for dropdown
        $this->load->library('session');
    }

    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            header('Location: ' . (base_url("/user/login/")));
        }
    }

    public function index($unit_id = null, $tahun = null, $bulan = null)
    {
        $this->is_logged_in();
        $data['judul'] = 'Rekap Absensi';
        $data['user_data'] = $this->session->userdata();

        // Default values for unit, year, month
        if ($unit_id === null || $unit_id === '') {
            $unit_id = $data['user_data']['unit_id'] ?? ''; // Use user's unit_id if available
        }
        if ($tahun === null) {
            $tahun = date('Y');
        }
        if ($bulan === null) {
            $bulan = date('m');
        }

        $data['selected_unit_id'] = $unit_id;
        $data['selected_tahun'] = $tahun;
        $data['selected_bulan'] = $bulan;

        // Fetch data for dropdowns
        $data['unit_all'] = $this->Unit_model->get_all(); // Assuming Unit_model has get_all()
        $data['tahun_options'] = $this->Absensi_model->get_tahun_options();
        $data['bulan_options'] = $this->Absensi_model->get_bulan_options();

        // Fetch rekap absensi data
        $data['rekap_absen'] = $this->Absensi_model->get_rekap_absen($unit_id, $tahun, $bulan);

        $this->load->view('template/header', $data);
        $this->load->view('absensi/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function detail($nip, $tahun, $bulan)
    {
        $this->is_logged_in();
        
        $data['judul'] = 'Detail Absensi Bulanan';
        $data['pegawai'] = $this->Absensi_model->get_pegawai_info($nip);
        $data['selected_tahun'] = $tahun;
        $data['selected_bulan'] = $bulan;
        $data['absensi_detail'] = $this->Absensi_model->get_monthly_attendance_detail($nip, $tahun, $bulan);
        $data['rekap_absen'] = $this->Absensi_model->get_rekap_absen_by_nip($nip, $tahun, $bulan);
        $data['bulan_options'] = $this->Absensi_model->get_bulan_options();
        $data['active_tab'] = 'detail';
        
        if (!$data['pegawai']) {
            show_404();
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('absensi/detail', $data);
        $this->load->view('template/footer');
    }
    
    public function log_absen($nip, $tahun, $bulan)
    {
        $this->is_logged_in();
        
        $data['judul'] = 'Log Absensi';
        $data['scanlog'] = $this->Absensi_model->get_scanlog_data($nip, $tahun, $bulan);
        $data['pegawai'] = $this->Absensi_model->get_pegawai_info($nip);
        $data['selected_tahun'] = $tahun;
        $data['selected_bulan'] = $bulan;
        $data['bulan_options'] = $this->Absensi_model->get_bulan_options();
        $data['active_tab'] = 'log';

        if (!$data['pegawai']) {
            show_404();
        }

        $this->load->view('template/header', $data);
        $this->load->view('absensi/log_absen', $data);
        $this->load->view('template/footer');
    }

    public function exception($unit_id = null, $tahun = null, $bulan = null)
    {

    }

    public function proses($tahun = null, $bulan = null)
    {
        $this->is_logged_in();

        $tahun = $this->input->get('tahun') ?: ($tahun ?? date('Y'));
        $bulan = $this->input->get('bulan') ?: ($bulan ?? date('m'));

        $data['judul'] = 'Proses Absensi';
        $data['exceptions'] = $this->Absensi_model->get_absen_exceptions($tahun, $bulan);
        
        $data['tahun_options'] = $this->Absensi_model->get_tahun_options();
        $data['bulan_options'] = $this->Absensi_model->get_bulan_options();
        $data['selected_tahun'] = $tahun;
        $data['selected_bulan'] = $bulan;


        $this->load->view('template/header', $data);
        $this->load->view('absensi/proses', $data);
        $this->load->view('template/footer');
    }


	function proses_sppd($nip=0, $tahun=0, $bulan=0)
	{	
		// $url = base_url('absensi/harian/').$nip.'/'.$tahun.'/'.$bulan;

		// $url = 'http://localhost/office/api/sppd_pegawai/'.$nip.'/'.$tahun.'/'.$bulan;
		$url = 'http://apps.sinjaikab.go.id/office/api/sppd_pegawai/'.$nip.'/'.$tahun.'/'.$bulan;
		
		$data_sppd = json_decode(file_get_contents($url));

   		// print_r($data_sppd);
		$data_update = array();
		$urut = 1;
		foreach ($data_sppd as $dsppd) {
			if ($dsppd -> sppd_aktif == 1) {
				$data_update['kode'] = 'P';
				$data_update['sppd_id'] = $dsppd -> sppd_id;
				$data_update['nip'] = $dsppd -> sppd_nip;
				$data_update['tgl_mulai'] = $dsppd -> st_mulai;
				$data_update['tgl_akhir'] = $dsppd -> st_akhir;
				$data_update['keterangan'] = $dsppd -> st_uraian.' di '.$dsppd -> st_tempat;
				if (!empty($dsppd -> desa_nama)) {
					$data_update['keterangan'] = $data_update['keterangan'].', Desa '.$dsppd -> desa_nama;
				}
				if (!empty($dsppd -> kecamatan_nama)) {
					$data_update['keterangan'] = $data_update['keterangan'].', Kecamatan '.$dsppd -> kecamatan_nama;
				}
				if (!empty($dsppd -> kabupaten_nama)) {
					$data_update['keterangan'] = $data_update['keterangan'].', '.$dsppd -> kabupaten_nama;
				}
				if (!empty($dsppd -> provinsi_nama)) {
					$data_update['keterangan'] = $data_update['keterangan'].', '.$dsppd -> provinsi_nama;
				}

				$cari_sppd = $this -> Absensi_model -> cari_sppd($dsppd -> sppd_id);
			// print_r($cari_sppd);
				if (is_array($cari_sppd) AND count($cari_sppd)>0) {
					$result[$urut] = $this -> pegawai_model -> edit($data_update['sppd_id'], $data_update, 'absen_excp', 'sppd_id');
					if($result[$urut]) {
						echo br(2)."- berhasil update <strong>".$data_update['keterangan']."</strong>";
					}

				} else {
					$result[$urut] = $this -> pegawai_model -> tambah($data_update,'absen_excp');
					if($result[$urut]) {
						echo br(2)."- berhasil input  <strong>".$data_update['keterangan']."</strong>";
					}
				}

			}
			$urut++;
		}
		// header('Location: ' . (base_url("/absensi/rekap")));

		// $this->proses_rekap_tahunan($nip, $tahun, $bulan);

		$tujuan = base_url('absensi/harian/').$nip.'/'.$tahun.'/'.$bulan.'?update=1';

		header('Refresh: 5; url='.$tujuan);
	}


	function harian($nip=0, $tahun=0, $bulan=0) {
	// ini_set("memory_limit","1024M");
        $this->is_logged_in();
		$data['userdata'] = $userdata = $this -> session -> userdata();

		$data['update'] = $update = 0;
		$data['update'] = $update = $this -> input -> get('update');

		if($update == 1) 
		{

				$import_bulanan = $this -> import_bulanan_new($nip,$tahun,$bulan);
		}


		// KONVERT DATA ABSEN EXCP
		// $absen_excp_import = $this -> Absensi_model -> absen_excp_import();
		$data["absen_apel"] = $this -> absen_apel($nip,$tahun, $bulan);

		$tahun_sys= (int)date("Y");
		$bulan_sys= (int)date("n");
		$tanggal_sys= (int)date("j");
		if ($bulan_sys>1) {
			$thn_skrg = $tahun_sys;
			$bln_skrg = $bulan_sys-1;
		} 
		else
		{	
			$thn_skrg = $tahun_sys-1;
			$bln_skrg = 12;
		}

		$data["bulan_skrg"]=$bulan_skrg=$bln_skrg;
		$data["tahun_skrg"]=$tahun_skrg=$thn_skrg;


		if(!isset($nip) OR $nip == 0) {
            $nip=$userdata['nip'];
        }
		if ($nip==0 OR $tahun==0) {
			header('Location: ' . (base_url("/". $this -> uri -> segment(1) . "/". $this -> uri -> segment(2) . "/".$nip."/".$tahun_skrg."/".$bulan_skrg)));
		}
		$data["nip"]=$nip;
		$data["jabatan_id"]=$jabatan_id=$userdata['jabatan_id'];
		// echo 
		$data["tahun"]=$tahun;
		$data["bulan"]=$bulan;


		$data["pegawai_info"] = $pegawai_info = $this -> Absensi_model -> pegawai_info($nip);
		$data['judul'] = 'Absen Harian'." - ".$pegawai_info['nama'];
		$data["unit_id"] = $unit_id = $pegawai_info['unit_id'];
		$data["pegawai_all"] = $this -> Absensi_model -> pegawai_all($unit_id);
		$data["pin"] = $pin = $this -> Absensi_model -> get_pin($nip);
		$data["apel_all"] = $this -> Absensi_model -> apel_all($tahun, $bulan);

		$data["hari_shd_jml"] = $hari_shd_jml = $this -> Absensi_model -> hari_shd_jml($tahun,$bulan);
		$data["absen_data_all"] = $absen_data_all = $this -> Absensi_model -> absen_data_all($nip,$tahun,$bulan);
		$data["tabel_jml1"] = floor($hari_shd_jml/2)+1;
		$data["tabel_jml2"] = $hari_shd_jml-$data["tabel_jml1"];

		$data["excp_jumlah"] = $excp_jumlah = $this -> Absensi_model -> excp_jumlah($nip,$tahun);
		


		// print_r($data); die();

		$this -> load -> view("template/header", $data);
		// $this -> load -> view("absensi/dropdown_harian", $data);
		// if(count($absen_data_all) > 0 ) 
		// { 
		$this -> load -> view("absensi/harian", $data); 
		// }
		$this -> load -> view("template/footer", $data);
	} 
	function absen_apel($nip=0, $tahun=0, $bulan=0) {
		// $data["apel_all"] = $this -> Absensi_model -> apel_all($tahun, $bulan);
		// return $data["apel_all"];
        return array(); // Temporarily return an empty array
	}

	function import_bulanan_new($nip=0, $tahun=0, $bulan=0) {
		ini_set("memory_limit","1024M");
		// echo "import data bulanan";
		// $data['judul'] = 'Absen Harian';
		$hapus_absen_data = $this -> Absensi_model ->hapus_absen_data($nip,$tahun,$bulan);

		$data['userdata'] = $userdata = $this -> session -> userdata();
		$pin =  $this -> Absensi_model -> get_pin($nip);
		$absen_log_all = $this -> Absensi_model -> absen_log_all($pin, $tahun, $bulan);
		$absen_waktu_all = $this -> Absensi_model -> absen_waktu_all();
		$data["hari_shd_jml"] = $hari_shd_jml = $this -> Absensi_model -> hari_shd_jml($tahun,$bulan);
		$pegawai_info = $this -> Absensi_model -> pegawai_info($nip);

		$waktu_id_last=0;
		$tanggal_last=0;

		for ($i=1; $i <= $hari_shd_jml ; $i++) { 
			$tanggal = $tahun."-".str_pad($bulan, 2, "0", STR_PAD_LEFT)."-".str_pad($i, 2, "0", STR_PAD_LEFT);
			$data_harian = $this -> Absensi_model -> data_harian($nip, $tanggal);
			foreach ($absen_waktu_all as $awa) {
				$waktu_id = $awa->waktu_id;
				if ($waktu_id == 0)
				{
					                	$data_update['kode'] = "";
					                	$data_update['keterangan'] = "";
					                	$data_update['masuk'] = "00:00:00";
					                	$data_update['keluar'] = "00:00:00";
					                	$data_update['waktu'] = 0;
					                	$data_update['masuk_unit'] = null; // Initialize
					                	$data_update['keluar_unit'] = null; // Initialize
					
					                	$date1=strtotime($awa->waktu_keluar);
					                	$date2=strtotime($awa->waktu_masuk);
					                	$target=round(($date1-$date2)/60);
					                	$data_update['pengurangan_lainnya']=0;	
					
					
					                	$kode_hari = date("w", mktime(0,0,0,$bulan,$i,$tahun));
					
					
					                	$ramadhan_cek 	= $this -> Absensi_model -> ramadhan_cek($tanggal);
					
					
					                	$waktu_masuk =$awa->waktu_masuk;
					                	$waktu_keluar =$awa->waktu_keluar;
					                	$waktu_masuk_awal =$awa->waktu_masuk_awal;
					                	$waktu_masuk_akhir =$awa->waktu_masuk_akhir;
					                	$waktu_keluar_awal =$awa->waktu_keluar_awal;
					                	$waktu_keluar_akhir =$awa->waktu_keluar_akhir;
					                	$data_update['masuk'] = '00:00:00';
					                	$data_update['keluar'] = '00:00:00';
					
					                	
					
					                	//DINAS KESEHATAN
					                	// if($pegawai_info['unit_id'] == '730722' and $awa->waktu_id == 0)
					                	if($pegawai_info['unit_id'] == '730722') //edit by rahim
					                	{
					                		$waktu_keluar_akhir = '22:00:00';
					                	} 
					
					                	$ex=0;
					                	foreach ($absen_log_all as $amla  ) {
					                		if($amla->tanggal == $tanggal and ($waktu_masuk_awal <= $amla->waktu_scan) and ($waktu_keluar_akhir > $amla->waktu_scan) and $amla->waktu_scan > '00:00:00') {
					                			if ($ex==0)
					                			{ 
					                				$data_update['masuk'] = $amla->waktu_scan; 
					                				if (isset($amla->unit_sn)) { // Check if unit_sn exists
					                					$data_update['masuk_unit'] = $amla->unit_sn; 
					                				}
					                			}
					                			$data_update['keluar'] = $amla->waktu_scan; 
					                			if (isset($amla->unit_sn)) { // Check if unit_sn exists
					                				$data_update['keluar_unit'] = $amla->unit_sn; 
					                			}
					                			$ex++;
					                		}
					                	}
					if ($waktu_masuk_awal <= $data_update['masuk'] AND $waktu_masuk_akhir >= $data_update['masuk'] ) 
						{ $hitung['masuk'] = $waktu_masuk; } 
					else
						{ $hitung['masuk'] = $data_update['masuk']; } 

					if ($waktu_keluar_awal <= $data_update['keluar'] AND $waktu_keluar_akhir >= $data_update['keluar'] ) 
						{ $hitung['keluar'] = $waktu_keluar; } 
					else
						{ $hitung['keluar'] = $data_update['keluar']; } 

								
					if($ramadhan_cek['cek']>0) //edit by rahim
					{
						$data_update['target'] = 150;	
						if($kode_hari == 5){
							$waktu_keluar = '15:30:00';
						}else{
							$waktu_keluar = '15:00:00';
						}

					} 	else {
						$data_update['target']=$target;
						// $data_update['target'] = 150;
					}

					if ($data_update['masuk_unit'] == $pegawai_info['unit_id'] OR $data_update['masuk_unit'] == '730700' OR $data_update['masuk_unit'] == '730701') {
						$data_update['pengurangan_masuk']=$this->pengurangan($data_update['masuk'],$waktu_masuk) ;	
						} else {
						$data_update['pengurangan_masuk'] = 1.5;
						}
 
					if ($data_update['keluar_unit'] == $pegawai_info['unit_id'] OR $data_update['keluar_unit'] == '730700' OR $data_update['keluar_unit'] == '730701') {
						$data_update['pengurangan_keluar']=$this->pengurangan($waktu_keluar,$data_update['keluar']) ;	
						} else {
						$data_update['pengurangan_keluar'] = 1.5;
						}
					// $data_update['pengurangan_keluar']=$this->pengurangan($waktu_keluar,$data_update['keluar']) ;	
 
						
 

					$data_update['pengurangan_lainnya']=0;	

					$data_update['tanggal']=$tanggal;	
					$data_update['waktu_id']=$waktu_id;	
					$data_update['nip']=$nip;	

					if($data_harian['me_id']>0) {
						$data_update['keterangan'] = "Mesin Error";
						$data_update['masuk'] = "";
						$data_update['keluar'] = "";
						$data_update['kode']="Mf";
						$data_update['waktu']=$data_update['target'];

						$data_update['pengurangan_masuk']=0;	
						$data_update['pengurangan_keluar']=0;


					}

					if(!is_null($data_harian['kode']) or !empty($data_harian['kode'])) {
						$data_update['keterangan'] = $data_harian['excp_ket'];
						$data_update['masuk'] = "";
						$data_update['keluar'] = "";
						$data_update['kode']=$data_harian['kode'];
						$data_update['pengurangan_masuk']=0;	
						$data_update['pengurangan_keluar']=0;
						$data_update['pengurangan_lainnya']=$data_harian['pengurangan'];	
						$data_update['waktu']=$data_update['target'];
					}

					if ($data_harian['hari_id'] == 1 OR $data_harian['hari_id'] == 7 OR $data_harian['libur_id']>0) {
						$data_update['kode']="L";
						$data_update['masuk'] = "";
						$data_update['keluar'] = "";
						$data_update['waktu'] = 0;
						$data_update['target']=0;
						$data_update['keterangan'] = "Libur ".$data_harian['libur_ket'];
						$data_update['pengurangan_masuk']=0;
						$data_update['pengurangan_keluar']=0;
						$data_update['pengurangan_lainnya']=0;


					}

					if($data_harian['non_tpp'] > 0) {
						$data_update['waktu'] = 0;
					}

			// print_r($data_update);
					$result = $this -> Absensi_model -> tambah($data_update,'absen_data');
			} // waktu_id=0
			} //foreach absen_waktu_all
		} //for

	}	


	function pengurangan($date01='00:00:00', $date02='00:00:00') {
		$date1=strtotime($date01);
		$date2=strtotime($date02);

		$selisih=round(($date1-$date2)/60);
		if ($selisih>91) {
			$pengurangan = 1.5;
		} elseif ($selisih>61) {
			$pengurangan = 1.25;
		} elseif ($selisih>31) {
			$pengurangan = 1;
		} elseif ($selisih>0) {
			$pengurangan = 0.5;
		} else  {
			$pengurangan = 0;
		}

		if ($date01=='00:00:00' or $date01=='00:00:00') {
			$pengurangan = 1.5;
		} 
		return $pengurangan;
	}


}
