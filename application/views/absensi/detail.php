<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $judul; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php
                        $absensi_url = site_url('absensi/index/' . $pegawai->unit_id . '/' . $selected_tahun . '/' . $selected_bulan);
                    ?>
                    <li class="breadcrumb-item"><a href="<?=$absensi_url; ?>">Rekap Absensi</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline card-tabs">
                    <?php 
                    $tab_data['pegawai'] = $pegawai;
                    $tab_data['selected_tahun'] = $selected_tahun;
                    $tab_data['selected_bulan'] = $selected_bulan;
                    $tab_data['active_tab'] = $active_tab;
                    $this->load->view('absensi/nav_tabs', $tab_data); 
                    ?>
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo $pegawai->nama; ?> (<?php echo $pegawai->nip; ?>) - 
                            <?php echo $bulan_options[$selected_bulan]; ?> <?php echo $selected_tahun; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Kode</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($absensi_detail)):
                                    foreach ($absensi_detail as $detail):
                                ?>
                                        <tr>
                                            <td><?php echo date('d-m-Y', strtotime($detail->tanggal)); ?></td>
                                            <td><?php echo $detail->masuk; ?></td>
                                            <td><?php echo $detail->keluar; ?></td>
                                            <td><?php echo $detail->kode; ?></td>
                                            <td><?php echo $detail->keterangan; ?></td>
                                        </tr>
                                    <?php 
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data absensi untuk periode ini.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <?php if ($rekap_absen): ?>
                            <tfoot>
                                <tr class="table-primary">
                                    <th colspan="5">Ringkasan Absensi</th>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="row">
                                            <div class="col-md-3"><strong>Bobot:</strong> <?php echo $rekap_absen->ra_bobot; ?>%</div>
                                            <div class="col-md-3"><strong>Hadir:</strong> <?php echo $rekap_absen->H; ?> hari</div>
                                            <div class="col-md-3"><strong>Sakit:</strong> <?php echo $rekap_absen->S; ?> hari</div>
                                            <div class="col-md-3"><strong>Izin:</strong> <?php echo $rekap_absen->I; ?> hari</div>
                                            <div class="col-md-3"><strong>Cuti:</strong> <?php echo $rekap_absen->CT; ?> hari</div>
                                            <div class="col-md-3"><strong>Tanpa Keterangan:</strong> <?php echo $rekap_absen->TK; ?> hari</div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                            <?php endif; ?>
                        </table>
                        <a href="<?php echo site_url('absensi'); ?>" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>