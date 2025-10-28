
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo isset($unit) ? 'Edit' : 'Tambah'; ?> Unit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('unit'); ?>">Data Unit</a></li>
                        <li class="breadcrumb-item active"><?php echo isset($unit) ? 'Edit' : 'Tambah'; ?></li>
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
                            <h3 class="card-title"><?php echo isset($unit) ? 'Edit' : 'Tambah'; ?> Data Unit</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo isset($unit) ? site_url('unit/update/'.$unit->unit_id) : site_url('unit/store'); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit_id">ID Unit</label>
                                            <input type="text" class="form-control" id="unit_id" name="unit_id" value="<?php echo isset($unit) ? $unit->unit_id : ''; ?>" <?php echo isset($unit) ? 'readonly' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="kabupaten_id">ID Kabupaten</label>
                                            <input type="text" class="form-control" id="kabupaten_id" name="kabupaten_id" value="<?php echo isset($unit) ? $unit->kabupaten_id : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_kode">Kode Unit</label>
                                            <input type="text" class="form-control" id="unit_kode" name="unit_kode" value="<?php echo isset($unit) ? $unit->unit_kode : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_nama">Nama Unit</label>
                                            <input type="text" class="form-control" id="unit_nama" name="unit_nama" value="<?php echo isset($unit) ? $unit->unit_nama : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_alamat">Alamat Unit</label>
                                            <input type="text" class="form-control" id="unit_alamat" name="unit_alamat" value="<?php echo isset($unit) ? $unit->unit_alamat : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_telepon">Telepon Unit</label>
                                            <input type="text" class="form-control" id="unit_telepon" name="unit_telepon" value="<?php echo isset($unit) ? $unit->unit_telepon : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit_fax">Fax Unit</label>
                                            <input type="text" class="form-control" id="unit_fax" name="unit_fax" value="<?php echo isset($unit) ? $unit->unit_fax : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_email">Email Unit</label>
                                            <input type="text" class="form-control" id="unit_email" name="unit_email" value="<?php echo isset($unit) ? $unit->unit_email : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_web">Website Unit</label>
                                            <input type="text" class="form-control" id="unit_web" name="unit_web" value="<?php echo isset($unit) ? $unit->unit_web : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_facebook">Facebook Unit</label>
                                            <input type="text" class="form-control" id="unit_facebook" name="unit_facebook" value="<?php echo isset($unit) ? $unit->unit_facebook : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_instagram">Instagram Unit</label>
                                            <input type="text" class="form-control" id="unit_instagram" name="unit_instagram" value="<?php echo isset($unit) ? $unit->unit_instagram : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_twitter">Twitter Unit</label>
                                            <input type="text" class="form-control" id="unit_twitter" name="unit_twitter" value="<?php echo isset($unit) ? $unit->unit_twitter : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="<?php echo site_url('unit'); ?>" class="btn btn-secondary">Batal</a>
                            </form>     </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

