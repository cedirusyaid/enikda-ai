<?php
// print_r($absen_data_all) ;
// print_r($pegawai_info) ;
// $table_jml1 = 
$CAmax = 12;
$CBmax = 12;
?>
tes
<div class="row hidden-print">
    <div class="col-xs-12 col-md-12 text-right">
                          <button type="button" class='btn <?php  if($update==1){echo "btn-default";} else {echo "btn-primary";} ?>  btn-xs' data-toggle="modal" data-target="#update_" title="update">UPDATE DATA ABSEN</button>


                          <div class="modal fade" id="update_" tabindex="-1" role="dialog" aria-lebelledby="update_">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <?php
                                // if ($kbll -> jml == 0) {
                                ?>
                                <div class="modal-header bg-success-800">
                                <h6 class="modal-title" id="update_">Update data absen</h6>
                                </div>
                                <div class="modal-body text-left">
                                <!-- <h6> -->
                                  Update data absen untuk melakukan perhitungan data dari mesin absen dan bila telah melakukan update data izin, sakit, dinas luar dsb. <br/>
                                  Proses ini membutuhkan waktu yang agak lama, mohon bersabar.
                                  <!-- Yakin melakukan update data? -->
                                <!-- </h6> -->
                                </div>
                                <div class="modal-footer">        
                                <a class="btn  btn-success  btn-xs" href="<?php
                                echo base_url('absensi/proses_sppd/').$nip.'/'.$tahun.'/'.$bulan;
                                // echo current_url().'?update=1';
                                ?>" role="botton">Update</a>
                                <button type="button" class="btn btn-success  btn-xs" data-dismiss="modal">Batal</button>
                                </div>
                                </div>
                            </div>
                          </div>          
    </div>

</div>

<div class="row">
	<div class="col-xs-2 col-md-2">
	</div>
	<div class="col-xs-8 col-md-8">
		<h3 class="text-center">ABSENSI PEGAWAI</h3>
		<table border="0" class="table-bordered visible-print">
			<tr>
				<td>Nama</td>
				<td><?php echo $pegawai_info['nama'] ?> / <?php echo $pegawai_info['nip'] ?></td>
			</tr>
			<!--
		<tr>
			<td>Jabatan</td>
			<td><?php echo $pegawai_info['jabatan_nama'] ?></td>
		</tr>
	-->
			<tr>
				<td>Bulan</td>
				<td><?php echo $this->Absensi_model->nama_bulan($bulan) . "  " . $tahun ?></td>


			</tr>
		</table>
		<br />
	</div>
	<div class="col-xs-3 col-md-3">
	</div>
</div>
<?php
 if(count($absen_data_all) > 0 ) 
 {
?>	



<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12">
		<h4 class="text-center">ABSENSI HARIAN</h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2">Tgl</th>
					<th rowspan="2">Hari</th>
					<th colspan="2">Absen</th>
					<th colspan="3">Pengurangan (%)</th>

					<th rowspan="2">Ket</th>
				</tr>
				<tr>
					<th>Masuk</th>
					<th>Pulang</th>
					<th>Masuk</th>
					<th>Pulang</th>
					<th>Lainnya </th>

				</tr>
			</thead>



			<?php
			$target = 0;
			$waktu = 0;
			$waktu_id_last = 0;
			$tanggal_last = 0;
			$pengurangan = 0;
			$pengurangan_max = 0;
			$pengurangan_masuk = 0;
			$pengurangan_keluar = 0;
			$pengurangan_lainnya = 0;
			$pengurangan_max = 0;

			$i = 0;

			$I = 0;
			$S = 0;
			$CT = 0;
			$H = 0;
			$TK = 0;
			$HK = 0;

			$L = 0;
			$last_tanggal = 0;


			//perhitungan cuti harian & besar
			$CA = $CB = 0;

			//perhitungan cuti melahirkan
			$CM = 0;
			//perhitungan cuti sakit
			$jml_CS_tahun = 0;
			$jml_I_tahun = 0;
			$jml_CS_bulan = 0;

			foreach ($excp_jumlah as $en) {
				if ($en->kode == 'CS') {
					$jml_CS_tahun = $jml_CS_tahun + $en->jml_hari;
				}
				if ($en->kode == 'I') {
					$jml_I_tahun = $jml_I_tahun + $en->jml_hari;
				}
			}





			foreach ($absen_data_all as $abda) {

				if ($last_tanggal != $abda->tanggal) {

					// print_r($abda);
					$i++;


					if ($abda->simbol_induk == "CT") {
						$CT++;
					} elseif ($abda->simbol_induk == "S") {
						$S++;
					} elseif ($abda->simbol_induk == "I") {
						$I++;
					} elseif ($abda->masuk > '00:00:00' or $abda->keluar > '00:00:00' or $abda->simbol_induk == "H") {
						$H++;
					} elseif ($abda->kode == "L") {
						$L++;
					} else {
						$TK++;
					}

					$HK = $H + $I + $S + $CT + $TK;
					// $HK = ($i-$L);
					// $TK = $HK-($H+$I+$S+$CT);


					if ($abda->kode == "CS") {
						$jml_CS_bulan++;
					}
					if ($abda->kode == "CA") {
						$CA++;
					}
					if ($abda->kode == "CB") {
						$CB++;
					}
					if ($abda->kode == "CM") {
						$CM++;
					}

					if ($abda->kode == "CA" and $CA > $CAmax) {
						$abda->pengurangan_lainnya = 3;
						$abda->keterangan = $abda->keterangan . ", lewat batas cuti minmal TPP ";
					}
					if ($abda->kode == "CB" and $CB > $CBmax) {
						$abda->pengurangan_lainnya = 3;
						$abda->keterangan = $abda->keterangan . ", lewat batas cuti minmal TPP ";
					}


					$pengurangan_masuk = $pengurangan_masuk + $abda->pengurangan_masuk;
					$pengurangan_keluar = $pengurangan_keluar + $abda->pengurangan_keluar;
					$pengurangan_lainnya = $pengurangan_lainnya + $abda->pengurangan_lainnya;
					$pengurangan = $pengurangan + $abda->pengurangan_masuk + $abda->pengurangan_keluar + $abda->pengurangan_lainnya;
					if ($abda->target > 0) {
						$pengurangan_max = $pengurangan_max + 3;
					}
			?>
					<tr>
						<?php
						$waktu = $waktu + $abda->waktu;
						$target = $target + $abda->target;
						$date = date_create($abda->tanggal);
						$tanda = 0;
						$tanda_masuk = $tanda_keluar = "";
						$title_masuk = $title_keluar = "";


						if ($abda->masuk == '00:00:00') {
							$tanda_masuk = "text-warning";
							$title_masuk = "tidak absen";
						} elseif (($abda->masuk_unit == $pegawai_info['unit_id'] or $abda->masuk_unit == '730700' or $abda->masuk_unit == '730701') and $abda->pengurangan_masuk == 0) {
							$tanda_masuk = "text-success";
							$title_masuk = "";
						} elseif (!($abda->masuk_unit == $pegawai_info['unit_id'] or $abda->masuk_unit == '730700' or $abda->masuk_unit == '730701')) {
							$tanda_masuk = "text-secondary";
							$title_masuk = "absen di luar kantor";
						} elseif (($abda->masuk_unit == $pegawai_info['unit_id'] or $abda->masuk_unit == '730700' or $abda->masuk_unit == '730701') and $abda->pengurangan_masuk > 0) {
							$tanda_masuk = "text-warning";
							$title_masuk = "terlambat";
						} else {
							$tanda_masuk = "";
							$title_masuk = "";
						}

						if ($abda->keluar == '00:00:00') {
							$tanda_keluar = "text-warning";
							$title_keluar = "tidak absen";
						} elseif (($abda->keluar_unit == $pegawai_info['unit_id'] or $abda->keluar_unit == '730700' or $abda->keluar_unit == '730701') and $abda->pengurangan_keluar == 0) {
							$tanda_keluar = "text-success";
						} elseif (!($abda->keluar_unit == $pegawai_info['unit_id'] or $abda->keluar_unit == '730700' or $abda->keluar_unit == '730701')) {
							$tanda_keluar = "text-secondary";
							$title_keluar = "absen di luar kantor";
						} elseif (($abda->keluar_unit == $pegawai_info['unit_id'] or $abda->keluar_unit == '730700' or $abda->keluar_unit == '730701') and $abda->pengurangan_keluar > 0) {
							$tanda_keluar = "text-warning";
							$title_keluar = "cepat pulang";
						} else {
							$tanda_keluar = "text-secondary";
						}

						if (!empty($abda->kode)) {
							$tanda = "bg-info";
							$tanda_masuk = $tanda_keluar = "";
						}



						if ($abda->kode == 'L') {
							$tanda = "bg-danger";
							$tanda_masuk = $tanda_keluar = "";
						}

						?>
						<td class="text-center">
							<?php
							// echo $abda->tanggal.br();
							// echo $userdata['unit_id'];
							// print_r($abda);
							echo date_format($date, "j");
							?>
						</td>
						<td class="text-center">
							<?php echo $abda->hari_nama; ?>
						</td>
						<td class="<?= $tanda_masuk ?> text-center" title="<?php echo $title_masuk; ?>">
							<?php
							if ($abda->masuk != '00:00:00' and $abda->masuk <= '12:00:00') {
								echo $abda->masuk;
							} else {
								echo "";
							}
							?>
						</td>
						<td class="<?= $tanda_keluar ?> text-center" title="<?php echo $title_keluar; ?>">
							<?php
							if ($abda->keluar != '00:00:00' and  $abda->keluar >= '12:00:00') {
								echo $abda->keluar;
							} else {
								echo "";
							}
							?>
						</td>
						<td class="text-right"
							<?php

							?>>
							<?php

							echo $abda->pengurangan_masuk;
							?>
						</td>
						<td class="text-right">
							<?php

							echo $abda->pengurangan_keluar;
							// echo $abda->waktu;
							?>
						</td>
						<td class="text-right">
							<?php

							echo $abda->pengurangan_lainnya;
							// echo $abda->waktu;
							?>
						</td>
						<td class="text-center <?php echo $tanda; ?>" title="<?php echo $abda->keterangan; ?>">
							<?php
							echo $abda->kode;
							// .br().$keterangan
							// echo br().$abda->ramadhan_cek;
							// print_r($abda);
							?>
						</td>
					</tr>

			<?php
				}
				$last_tanggal = $abda->tanggal;
			}

			?>

			<tr>
				<td colspan="4" class="text-left ">Jumlah Pengurangan</td>
				<td class="text-right "><?php echo $pengurangan_masuk; ?></td>
				<td class="text-right "><?php echo $pengurangan_keluar; ?></td>
				<td class="text-right "><?php echo $pengurangan_lainnya; ?></td>
				<td></td>

			</tr>
			<!-- 		<tr>
			<td colspan="6" class="text-left">Pengurangan Absen Harian</td>
			<td class="text-right" ><?php echo $pengurangan; ?></td>
					<td></td>

				</tr> -->
		</table>

		<?php $jml_pengurangan_harian = $pengurangan; ?>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12">

		<h4 class="text-center">ABSENSI APEL</h4>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Tgl</th>
					<!-- <th>Hari</th> -->
					<th>Uraian</th>
					<th>Absen</th>
					<th>Pengurangan<br>(%)</th>

				</tr>
			</thead>

			<?php




			$i = 1;
			$jml_pengurangan_apel = 0;
			foreach ($apel_all as $apall) {
				$apel_hadir = $this->absen_model->apel_hadir($pin, $apall->apel_id);
				if ($apel_hadir > 0 or $apall->apel_aktif == 0) {
					$pengurangan_apel = 0;
				} else {
					$pengurangan_apel = 2;
				}
				$pengurangan_max = $pengurangan_max + $pengurangan_apel;
				$pengurangan = $pengurangan + $pengurangan_apel;

				if ($apall->apel_aktif > 0) {
					$jml_pengurangan_apel = $jml_pengurangan_apel + $pengurangan_apel;;


			?>
					<tr>
						<td class="text-center">


							<?php echo $this->pegawai_model->urai_tgl($apall->apel_tanggal); ?>

						</td>
						<td class="text-left" width="25%">
							<?php echo $apall->apel_nama; ?>
						</td>
						<td class="text-center">
							<?php echo $apel_hadir; ?>

						</td>

						<td class="text-right">
							<?php echo $pengurangan_apel; ?>
							<!-- <?php print_r($apall); ?> -->
						</td>
					</tr>

			<?php
				}
			}
			?>
			<tr>
				<td colspan="3" class="text-left">Pengurangan Absen Apel/Upacara</td>
				<td class="text-right"><?php echo $jml_pengurangan_apel; ?></td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<br>
		<h4 class="text-center">PERHITUNGAN KEHADIRAN</h4>
		<?php
		$pengurangan_akhir = round((100 * $pengurangan / $pengurangan_max), 2);
		// $pengurangan_akhir = round(($pengurangan*$pengurangan_max/100), 2);

		$ra_bobot = (100 - $pengurangan_akhir);

		?>
		<table class="table table-striped table-hover">
			<tr>
				<td>Bobot Absen 1 bulan</td>
				<td width="15%" class="text-right">100 %
				</td>
			</tr>
			<tr>
				<td>Pengurangan Absen Harian </td>
				<td width="15%" class="text-right"><?php echo $jml_pengurangan_harian; ?> %
				</td>
			</tr>
			<tr>
				<td>Pengurangan Absen Apel/Upacara </td>
				<td width="15%" class="text-right"><?php echo $jml_pengurangan_apel; ?> %
				</td>
			</tr>
			<tr>
				<td>Pengurangan Absen Harian + Pengurangan Apel</td>
				<td width="15%" class="text-right"><?php echo $pengurangan; ?> %
				</td>
			</tr>

			<tr>
				<td>Pengurangan Maksimal Bulan Ini *</td>
				<td width="15%" class="text-right"><?php echo $pengurangan_max; ?> %</td>
			</tr>

			<tr>
				<td>Pengurangan (Pengurangan Absen Harian & Apel/Upacara / Pengurangan Maksimal * 100%)</td>
				<td width="15%" class="text-right"><?php echo number_format($pengurangan_akhir, 2, ",", "."); ?> %</td>
			</tr>
			<tr>
				<td>Bobot Absen (100% - Pengurangan)</td>
				<td width="15%" class="text-right bg-warning"><?php echo number_format($ra_bobot, 2, ",", "."); ?> %</td>
			</tr>
		</table>


		<table class="table-hover">
			<thead>
				<tr>
					<th class="text-center" width="35px" title="Hadir">H</th>
					<th class="text-center" width="35px" title="Izin">I</th>
					<th class="text-center" width="35px" title="Sakit">S</th>
					<th class="text-center" width="35px" title="Cuti">CT</th>
					<th class="text-center" width="35px" title="Tanpa Keterangan">TK</th>
					<th class="text-center" width="35px" title="Hari Kerja">HK</th>
					<!-- <th>L</th> -->
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center"><?= $H ?></td>
					<td class="text-center"><?= $I ?></td>
					<td class="text-center"><?= $S ?></td>
					<td class="text-center"><?= $CT ?></td>
					<td class="text-center"><?= $TK ?></td>
					<td class="text-center"><?= $HK ?></td>
					<!-- <td></td> -->
				</tr>
			</tbody>
		</table>

	</div>
</div>
Ket :<br>
* Pengurangan maksimal = (hari kerja * 3 %) + (apel/upacara * 2%)

<br />
<div class="text-right">
	Pin : <?php echo $pin; ?>
	<br>
	Update tgl : <?php echo date('d-m-Y'); ?>
	<br>
	<div class=" hidden-print">
		<a href="<?php echo base_url('absensi/scanlog/') . $pin . "/" . $tahun . "/" . $bulan; ?>">lihat log absen</a>


		<?php
		if (($userdata['admin_kabupaten'] > 0 or $userdata['admin_unit'] > 0) and $update > 0) {
		?>
			<br>
			<a href="<?php echo base_url('absensi/fixing/') . $nip . "/" . $tahun . "/" . $bulan; ?>">edit manual absen</a>
			<br>
			<br>
		<?php
		}
		?>

	</div>

</div>

<?php
// if ($target>0) {
// 	$ipt['ra_bobot']=number_format(($waktu/$target)*100,2);
// } else {
// 	$ipt['ra_bobot']=0;
// }

// print_r($ipt);
if ($update > 0) {
	$ipt['nip'] = $nip;
	$ipt['bulan'] = (int)$bulan;
	$ipt['tahun'] = $tahun;
	$ipt['ra_bobot'] = $ra_bobot;

	$ipt['I'] = $I;
	$ipt['H'] = $H;
	$ipt['S'] = $S;
	$ipt['CT'] = $CT;
	$ipt['TK'] = $TK;
	$ipt['HK'] = $HK;

	if (($jml_CS_bulan >= 15 or $jml_CS_bulan == $HK) and $jml_CS_tahun < 182) {
		$ipt['tpp_persen'] = 75;
		$ipt['tpp_ket'] = "Cuti Sakit";
	} elseif (($jml_CS_bulan >= 15 or $jml_CS_bulan == $HK) and $jml_CS_tahun < 365) {
		$ipt['tpp_persen'] = 50;
		$ipt['tpp_ket'] = "Cuti Sakit";
	} elseif (($jml_CS_bulan >= 15 or $jml_CS_bulan == $HK) and $jml_CS_tahun < 547) {
		$ipt['tpp_persen'] = 25;
		$ipt['tpp_ket'] = "Cuti Sakit";
	} elseif (($jml_CS_bulan >= 15 or $jml_CS_bulan == $HK) and $jml_CS_tahun >= 547) {
		$ipt['tpp_persen'] = 0;
		$ipt['tpp_ket'] = "Cuti Sakit";
	} elseif ($CM >= 12 or $CM == $HK) {
		$ipt['tpp_persen'] = 60;
		$ipt['tpp_ket'] = "Cuti Melahirkan";
	} else {
		$ipt['tpp_persen'] = 100;
	}

	$result0 = $this->Absensi_model->tambah($ipt, 'rekap_absen');
	$result1 = $this->Absensi_model->ra_hapus($nip, $tahun, $bulan);
	$result = $this->Absensi_model->tambah($ipt, 'rekap_absen');

	// $this -> absen_model->rekapTahun_ar($nip, $tahun, $bulan);


	if ($result and $this->input->get('kbr') == 1) {
		$result2 = $this->pegawai_model->tpp_data_proses($nip, $tahun, $bulan);
		if ($result2) {
			header('Location: ' . (base_url("/kinerja/kbr/" . $nip . "/" . $tahun . "/" . $bulan)));
		}
	}
	// echo $ipt['ra_bobot'];
	# code...
}


?>
<?php //echo "jml_CS_tahun " . $jml_CS_tahun . br() ?>
<?php //echo "jml_CS_bulan " . $jml_CS_bulan . br() ?>
<?php //echo "tpp_persen' " . $ipt['tpp_persen'] . br() ?>



<?php
 }
