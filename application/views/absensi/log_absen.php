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
                    <li class="breadcrumb-item active">Log Absensi</li>
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
                            Log Absensi untuk <?php echo $pegawai->nama; ?> (<?php echo $pegawai->nip; ?>) - 
                            <?php echo $bulan_options[$selected_bulan]; ?> <?php echo $selected_tahun; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>SN</th>
                                    <th>Waktu Scan</th>
                                    <th>PIN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($scanlog)):
                                    $urut=1;
                                    foreach ($scanlog as $log):
                                ?>
                                        <tr>
                                            <td class="text-right"><?=$urut++?></td>
                                            <td><?php echo $log->sn; ?></td>
                                            <td><?php echo $log->scan_date; ?></td>
                                            <td><?php echo $log->pin; ?></td>
                                        </tr>
                                    <?php 
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data log absensi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>