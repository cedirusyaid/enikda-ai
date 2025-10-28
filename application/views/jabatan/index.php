    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Daftar Jabatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Daftar Jabatan</li>
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
                            <h3 class="card-title">Daftar Jabatan</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('jabatan/crud/tambah/' . $unit_id) ?>" class="btn btn-primary btn-sm" title="Tambah Jabatan"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="unit">Unit Kerja</label>
                                <select name="unit" id="unit" class="form-control" onchange="if (this.value) window.location.href='<?= base_url('jabatan/index/') ?>' + this.value">
                                    <option value="">-- Pilih Unit Kerja --</option>
                                    <?php foreach ($unit_all as $unit) : ?>
                                        <option value="<?= $unit->unit_id ?>" <?= ($unit->unit_id == $unit_id) ? 'selected' : '' ?>><?= $unit->unit_nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <table id="example1" class="table table-bordered table-striped" style="margin-top: 15px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jabatan</th>
                                        <th>Jenis Jabatan / Eselon</th>
                                        <th>Pejabat</th>
                                        <th>Kelas Jabatan</th>
                                        <th>TPP</th>
                                        <th>Ket</th>
                                        <th>Proses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($jabatan_all)): ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($jabatan_all as $jabatan) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $jabatan->jabatan_nama ?></td>
                                                <td><?= $jabatan->jabatan_jenis_nama ?> / <?= $jabatan->jabatan_jenis_eselon ?></td>
                                                <td 
                                                    <?php if ((int)$jabatan->jabatan_nip==0) {
                                                        echo "class='bg-danger'";
                                                    }
                                                    ?>
                                                >
                                                       
                                                    <?php if ((int)$jabatan->jabatan_nip>0) { ?>
                                                        <?= $jabatan->nama_pegawai ?><br>(<?= $jabatan->jabatan_nip ?>)
                                                    <?php } ?>
                                                </td>
                                                <td><?= $jabatan->jabatan_kelas ?></td>
                                                <td>
                                                    <?php if (isset($jabatan->tpp) && $jabatan->tpp == 1) : ?>
                                                        100%
                                                    <?php elseif (isset($jabatan->tpp) && $jabatan->tpp == 2) : ?>
                                                        20%
                                                    <?php else : ?>
                                                        0%
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= (!empty($jabatan->admin_unit) && $jabatan->admin_unit == 1) ? 'Admin OPD' : '' ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-sm" role="group">
                                                        
                                                    <a href="<?= base_url('jabatan/detail/' . $jabatan->jabatan_id) ?>" class="btn btn-sm btn-success" title="Detail"><i class="fas fa-info-circle  "></i></a>
                                                    <a href="<?= base_url('jabatan/crud/edit/' . $unit_id . '/' . $jabatan->jabatan_id) ?>" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    <?php if ((int)$jabatan->jabatan_nip==0) {
                                                       ?>

                                                            <a href="<?= base_url('jabatan/delete/' . $jabatan->jabatan_id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                                                       <?php                                                    } 
                                                    ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data jabatan untuk unit kerja ini.</td>
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