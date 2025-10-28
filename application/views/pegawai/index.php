<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Pegawai</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Data Pegawai</li>
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
                        <div class="card-tools">
                            <a href="<?php echo site_url('pegawai/crud/tambah'); ?>" class="btn btn-primary btn-sm" title="Tambah Pegawai"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')):
                            echo '<div class="alert alert-success" role="alert">'. $this->session->flashdata('success') .'</div>';
                         endif; ?>
                        <form action="<?php echo site_url('pegawai/index'); ?>" method="get" class="form-inline mb-3">
                            <div class="form-group mr-2">
                                <label for="status" class="mr-2">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="all" <?php echo ($selected_status == 'all') ? 'selected' : ''; ?>>Semua</option>
                                    <option value="aktif" <?php echo ($selected_status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="tidak_aktif" <?php echo ($selected_status == 'tidak_aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label for="unit_id" class="mr-2">Unit</label>
                                <select name="unit_id" id="unit_id" class="form-control">
                                    <option value="">Semua Unit</option>
                                    <?php foreach($units as $unit): ?>
                                        <option value="<?php echo $unit->unit_id; ?>" <?php echo ($selected_unit == $unit->unit_id) ? 'selected' : ''; ?>><?php echo $unit->unit_nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>No. HP</th>
                                    <th>Status PNS</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pegawai)):
                                    $no = 1;
                                    foreach ($pegawai as $p):
                                 ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $p->nip; ?></td>
                                            <td><?php echo $p->nama; ?></td>
                                            <td><?php echo $p->jabatan_nama; ?></td>
                                            <td><?php echo $p->nomor_hp; ?></td>
                                            <td><?php echo $p->status_pns == '1' ? 'Aktif' : 'Tidak Aktif'; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-sm">
                                                    <a href="<?php echo site_url('pegawai/crud/edit/' . $p->nip); ?>" class="btn btn-info" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="<?php echo site_url('pegawai/delete/' . $p->nip); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php 
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pegawai.</td>
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