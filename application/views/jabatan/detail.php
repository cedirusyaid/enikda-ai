    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Jabatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('jabatan'); ?>">Daftar Jabatan</a></li>
              <li class="breadcrumb-item active">Detail Jabatan</li>
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
                            <h3 class="card-title">Detail Jabatan</h3>
                            <div class="card-tools">
                                <a href="<?php echo site_url('jabatan/crud/edit/' . $jabatan->unit_id."/".$jabatan->jabatan_id); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Jabatan</th>
                                    <td><?php echo $jabatan->jabatan_nama; ?></td>
                                </tr>
                                <tr>
                                    <th>Grup Jabatan</th>
                                    <td><?php echo $jabatan->jabatan_grup; ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis Jabatan</th>
                                    <td><?php echo $jabatan->jabatan_jenis_nama; ?></td>
                                </tr>
                                <tr>
                                    <th>Eselon</th>
                                    <td><?php echo $jabatan->jabatan_jenis_eselon; ?></td>
                                </tr>
                                <tr>
                                    <th>Kelas Jabatan</th>
                                    <td><?php echo $jabatan->jabatan_kelas; ?></td>
                                </tr>
                                <tr>
                                    <th>Atasan</th>
                                    <td><?php echo $jabatan->atasan_nama; ?></td>
                                </tr>
                                <tr>
                                    <th>Pegawai</th>
                                    <td><?php echo $jabatan->nama_pegawai; ?></td>
                                </tr>
                                <tr>
                                    <th>NIP</th>
                                    <td><?php echo $jabatan->jabatan_nip; ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo $jabatan->jabatan_aktif ? 'Aktif' : 'Tidak Aktif'; ?></td>
                                </tr>
                                <tr>
                                    <th>Status Jabatan</th>
                                    <td><?php echo $jabatan->jabatan_status; ?></td>
                                </tr>
                            </table>
                            <a href="<?php echo site_url('jabatan/index/' . $jabatan->unit_id); ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>