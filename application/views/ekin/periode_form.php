<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $title; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('ekin/periode'); ?>">Periode</a></li>
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
                        <h3 class="card-title">Form Periode</h3>
                    </div>
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama Periode <?php echo form_error('nama') ?></label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Contoh: Periode 1 Januari - 15 Januari" value="<?php echo $nama; ?>" />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun <?php echo form_error('tahun') ?></label>
                                        <input type="number" class="form-control" name="tahun" id="tahun" placeholder="2024" value="<?php echo $tahun; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="angka_periodik">Angka Periodik <?php echo form_error('angka_periodik') ?></label>
                                        <input type="number" class="form-control" name="angka_periodik" id="angka_periodik" placeholder="1" value="<?php echo $angka_periodik; ?>" />
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="periode_awal">Periode Awal <?php echo form_error('periode_awal') ?></label>
                                        <input type="text" class="form-control" name="periode_awal" id="periode_awal" placeholder="MM-DD (e.g. 01-01)" value="<?php echo $periode_awal; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="periode_akhir">Periode Akhir <?php echo form_error('periode_akhir') ?></label>
                                        <input type="text" class="form-control" name="periode_akhir" id="periode_akhir" placeholder="MM-DD (e.g. 01-15)" value="<?php echo $periode_akhir; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="batas_pengisian">Batas Pengisian <?php echo form_error('batas_pengisian') ?></label>
                                        <input type="text" class="form-control" name="batas_pengisian" id="batas_pengisian" placeholder="MM-DD (e.g. 01-23)" value="<?php echo $batas_pengisian; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_periode">Jenis Periode <?php echo form_error('jenis_periode') ?></label>
                                        <input type="text" class="form-control" name="jenis_periode" id="jenis_periode" placeholder="(Opsional)" value="<?php echo $jenis_periode; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipe_periodik">Tipe Periodik <?php echo form_error('tipe_periodik') ?></label>
                                        <input type="text" class="form-control" name="tipe_periodik" id="tipe_periodik" placeholder="bulanan" value="<?php echo $tipe_periodik; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo $button ?></button>
                            <a href="<?php echo site_url('ekin/periode') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
