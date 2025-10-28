<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Laporan Penilaian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('ekin/penilaian_pegawai_list'); ?>">Laporan Penilaian</a></li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pegawai: <strong><?php echo $pegawai_nama; ?></strong></h3>
                        <div class="card-tools">
                             <a href="<?php echo site_url('ekin/penilaian_pegawai_list'); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tahun SKP</th>
                                    <th>Jabatan</th>
                                    <th>Hasil Kerja</th>
                                    <th>Perilaku Kerja</th>
                                    <th>Hasil Akhir</th>
                                    <th>Waktu Dinilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($penilaian_data as $row) {
                                ?>
                                    <tr>
                                        <td class="text-right"><?php echo $no++; ?></td>
                                        <td class="text-center"><?php echo $row->tahun_skp; ?></td>
                                        <td><?php echo $row->skp_jabatan; ?></td>
                                        <td class="text-center"><?php echo $row->hasil_kerja; ?></td>
                                        <td class="text-center"><?php echo $row->perilaku_kerja; ?></td>
                                        <td class="text-center"><span class="badge badge-info"><?php echo $row->hasil_akhir; ?></span></td>
                                        <td><?php echo $row->waktu_dinilai; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
