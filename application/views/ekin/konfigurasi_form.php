<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $title; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('ekin/konfigurasi'); ?>">Konfigurasi</a></li>
                    <li class="breadcrumb-item active"><?php echo $button; ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Konfigurasi</h3>
                    </div>
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="environment_name">Nama Environment <?php echo form_error('environment_name') ?></label>
                                <input type="text" class="form-control" name="environment_name" id="environment_name" placeholder="Contoh: Production / Development" value="<?php echo $environment_name; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="address_kinerja">Alamat API Kinerja <?php echo form_error('address_kinerja') ?></label>
                                <input type="text" class="form-control" name="address_kinerja" id="address_kinerja" placeholder="http://localhost:8000" value="<?php echo $address_kinerja; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="token">Token <?php echo form_error('token') ?></label>
                                <textarea class="form-control" rows="5" name="token" id="token" placeholder="Bearer Token"><?php echo $token; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="is_active">Aktif <?php echo form_error('is_active') ?></label>
                                <select name="is_active" class="form-control">
                                    <option value="1" <?php echo ($is_active == 1) ? 'selected' : ''; ?>>Ya</option>
                                    <option value="0" <?php echo ($is_active == 0) ? 'selected' : ''; ?>>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="config_id" value="<?php echo $config_id; ?>" />
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo $button ?></button>
                            <a href="<?php echo site_url('ekin/konfigurasi') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>