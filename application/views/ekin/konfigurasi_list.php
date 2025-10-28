<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Konfigurasi API e-Kinerja</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Konfigurasi E-Kinerja</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Konfigurasi</h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('ekin/konfigurasi_tambah'); ?>" class="btn btn-primary btn-sm" title="Tambah Data"><i class="fas fa-plus"></i> Tambah</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Environment</th>
                                    <th>Alamat API</th>
                                    <th>Token</th>
                                    <th>Aktif</th>
                                    <th>Terakhir Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($konfigurasi as $k) {
                                ?>
                                    <tr>
                                        <td class="text-right"><?php echo $no++; ?></td>
                                        <td><?php echo $k->environment_name; ?></td>
                                        <td><?php echo $k->address_kinerja; ?></td>
                                        <td style="word-break: break-all;"><?php echo substr($k->token, 0, 30) . '...'; ?></td>
                                        <td class="text-center">
                                            <?php if ($k->is_active) : ?>
                                                <span class="badge badge-success">Ya</span>
                                            <?php else : ?>
                                                <span class="badge badge-danger">Tidak</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $k->updated_at; ?></td>
                                        <td class="text-center" width="150px">
                                            <?php if (!$k->is_active) : ?>
                                                <a href="<?php echo site_url('ekin/konfigurasi_set_aktif/' . $k->config_id); ?>" class="btn btn-success btn-xs" title="Set Aktif" onclick="return confirm('Yakin ingin mengaktifkan konfigurasi ini?')"><i class="fas fa-check"></i></a>
                                            <?php endif; ?>
                                            <a href="<?php echo site_url('ekin/konfigurasi_ubah/' . $k->config_id); ?>" class="btn btn-info btn-xs" title="Ubah"><i class="fas fa-edit"></i></a>
                                            <a href="<?php echo site_url('ekin/konfigurasi_copy/' . $k->config_id); ?>" class="btn btn-warning btn-xs" title="Copy"><i class="fas fa-copy"></i></a>
                                            <a href="<?php echo site_url('ekin/konfigurasi_hapus/' . $k->config_id); ?>" class="btn btn-danger btn-xs" title="Hapus" onclick="return confirm('Yakin akan menghapus data ini?')"><i class="fas fa-trash"></i></a>
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