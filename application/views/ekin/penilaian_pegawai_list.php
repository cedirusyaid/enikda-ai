<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Penilaian per Pegawai</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">E-Kinerja</a></li>
                    <li class="breadcrumb-item active">Laporan Penilaian</li>
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
                        <h3 class="card-title">Daftar Pegawai</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="50px">No.</th>
                                    <th>Nama Pegawai</th>
                                    <th>NIP</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pegawai_data as $p) {
                                ?>
                                    <tr>
                                        <td class="text-right"><?php echo $no++; ?></td>
                                        <td><?php echo $p->nama; ?></td>
                                        <td><?php echo $p->nip; ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo site_url('ekin/lihat_penilaian/' . $p->nip); ?>" class="btn btn-primary btn-xs" title="Lihat Detail Penilaian"><i class="fas fa-search"></i> Lihat Detail</a>
                                        </td>
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
