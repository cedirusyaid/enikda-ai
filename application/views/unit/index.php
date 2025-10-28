    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Organisasi Perangkat daerah</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">unit</li>
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
                            <h3 class="card-title">Data OPD</h3>
                            <div class="card-tools">
                                <a href="<?php echo site_url('unit/create'); ?>" class="btn btn-primary btn-sm" title="Tambah Data"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>ID</th>
                                        <th>Nama Unit</th>
                                        <th>Jumlah Pegawai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($units as $unit): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $i++; ?></td>
                                        <td class="text-left"><?php echo $unit->unit_id; ?></td>
                                        <td class="text-left"><?php echo $unit->unit_nama; ?></td>
                                        <td class="text-center"><?php echo $unit->jumlah_pegawai; ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo site_url('unit/edit/'.$unit->unit_id); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fas fa-edit"></i></a>
                                            <?php if ($unit->jumlah_pegawai == 0): ?>
                                            <a href="<?php echo site_url('unit/delete/'.$unit->unit_id); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
