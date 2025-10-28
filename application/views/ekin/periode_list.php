<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Periode e-Kinerja</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Periode E-Kinerja</li>
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
                        <h3 class="card-title">Data Periode</h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('ekin/sinkron_periode_api'); ?>" class="btn btn-primary btn-sm" title="Sinkronisasi dengan API" onclick="return confirm('Ini akan mengambil data dari API dan menimpa data yang ada dengan ID yang sama. Lanjutkan?')"><i class="fas fa-sync-alt"></i> Sinkronisasi</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Tahun</th>
                                    <th>Periode</th>
                                    <th>Batas Pengisian</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($periode_data as $p) {
                                ?>
                                    <tr>
                                        <td class="text-right"><?php echo $no++; ?></td>
                                        <td><?php echo $p->nama; ?></td>
                                        <td class="text-center"><?php echo $p->tahun; ?></td>
                                        <td class="text-center"><?php echo $p->periode_awal . ' s/d ' . $p->periode_akhir; ?></td>
                                        <td class="text-center"><?php echo $p->batas_pengisian; ?></td>
                                        <td class="text-center"><?php echo $p->tipe_periodik; ?></td>
                                        <td class="text-center" width="120px">
                                            <a href="<?php echo site_url('ekin/periode_ubah/' . $p->id); ?>" class="btn btn-info btn-xs" title="Ubah"><i class="fas fa-edit"></i></a>
                                            <a href="<?php echo site_url('ekin/periode_hapus/' . $p->id); ?>" class="btn btn-danger btn-xs" title="Hapus" onclick="return confirm('Yakin akan menghapus data ini?')"><i class="fas fa-trash"></i></a>
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
