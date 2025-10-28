<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sinkronisasi Laporan Penilaian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">E-Kinerja</a></li>
                    <li class="breadcrumb-item active">Sinkronisasi Penilaian</li>
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
                        <h3 class="card-title">Filter Pengambilan Data</h3>
                    </div>
                    <form action="<?php echo site_url('ekin/run_sinkron_penilaian'); ?>" method="post">
                        <div class="card-body">
                            <?php if($this->session->flashdata('message')): ?>
                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-info"></i> Notifikasi</h5>
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="nip">NIP Pegawai <?php echo form_error('nip') ?></label>
                                <input type="text" class="form-control" name="nip" id="nip" placeholder="Masukkan NIP" value="<?php echo set_value('nip'); ?>" />
                                <small class="form-text text-muted">Kosongkan NIP untuk mengambil data semua pegawai pada periode yang dipilih.</small>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun <?php echo form_error('tahun') ?></label>
                                        <input type="number" class="form-control" name="tahun" id="tahun" placeholder="Contoh: 2024" value="<?php echo set_value('tahun', date('Y')); ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="periode_id">Periode <?php echo form_error('periode_id') ?></label>
                                        <select name="periode_id" id="periode_id" class="form-control" required>
                                            <option value="">-- Pilih Periode --</option>
                                            <?php foreach($periode_data as $p): ?>
                                                <option value="<?php echo $p->id; ?>" <?php echo set_select('periode_id', $p->id); ?> >
                                                    <?php echo $p->nama . ' (' . $p->tahun . ')'; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Ambil Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
