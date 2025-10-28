<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-file-archive me-2"></i>
            <?= $this->session->userdata('admin_kabupaten') > 0 ? 'Semua Berkas TPP' : 'Berkas TPP Unit Saya' ?>
        </h5>
        <?php if ($this->session->userdata('admin_kabupaten') > 0): ?>
            <a href="<?= base_url('berkas/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Unggah Berkas Baru
            </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <!-- Filter untuk Admin Kabupaten -->
        <?php if ($this->session->userdata('admin_kabupaten') > 0): ?>
        <form action="<?= base_url('berkas/index') ?>" method="get" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="unit_id">Filter Unit Kerja:</label>
                        <select name="unit_id" id="unit_id" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Unit Kerja --</option>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?= $unit->unit_id ?>" <?= ($selected_unit_id == $unit->unit_id) ? 'selected' : '' ?>><?= $unit->unit_nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tahun">Filter Tahun:</label>
                        <select name="tahun" id="tahun" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Tahun --</option>
                            <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                <option value="<?= $y ?>" <?= ($selected_tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bulan">Filter Bulan:</label>
                        <select name="bulan" id="bulan" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Bulan --</option>
                            <?php
                            $bulan_options = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                              '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
                            foreach ($bulan_options as $num => $name): ?>
                                <option value="<?= $num ?>" <?= ($selected_bulan == $num) ? 'selected' : '' ?>><?= $name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">Filter Status:</label>
                        <select name="status" id="status" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="all" <?= ($selected_status == 'all') ? 'selected' : '' ?>>-- Semua Status --</option>
                            <option value="draft" <?= ($selected_status == 'draft') ? 'selected' : '' ?>>Draft</option>
                            <option value="submitted" <?= ($selected_status == 'submitted') ? 'selected' : '' ?>>Diajukan</option>
                            <option value="approved" <?= ($selected_status == 'approved') ? 'selected' : '' ?>>Disetujui</option>
                            <option value="rejected" <?= ($selected_status == 'rejected') ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <?php else: ?>
        <!-- Filter Status untuk Admin OPD -->
        <form action="<?= base_url('berkas/index') ?>" method="get" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tahun">Filter Tahun:</label>
                        <select name="tahun" id="tahun" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Tahun --</option>
                            <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                <option value="<?= $y ?>" <?= ($selected_tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bulan">Filter Bulan:</label>
                        <select name="bulan" id="bulan" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Bulan --</option>
                            <?php
                            $bulan_options = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                              '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
                            foreach ($bulan_options as $num => $name): ?>
                                <option value="<?= $num ?>" <?= ($selected_bulan == $num) ? 'selected' : '' ?>><?= $name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status">Filter Status:</label>
                        <select name="status" id="status" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="all" <?= ($selected_status == 'all') ? 'selected' : '' ?>>-- Semua Status --</option>
                            <option value="draft" <?= ($selected_status == 'draft') ? 'selected' : '' ?>>Draft</option>
                            <option value="submitted" <?= ($selected_status == 'submitted') ? 'selected' : '' ?>>Diajukan</option>
                            <option value="approved" <?= ($selected_status == 'approved') ? 'selected' : '' ?>>Disetujui</option>
                            <option value="rejected" <?= ($selected_status == 'rejected') ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <!-- Info untuk Admin OPD -->
        <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Info:</strong> Anda hanya dapat melihat berkas dari unit kerja Anda sendiri.
            Unit: <strong><?= $this->session->userdata('unit_nama') ?></strong>
        </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Bulan/Tahun</th>
                        <?php if ($this->session->userdata('admin_kabupaten') > 0): ?>
                        <th>Unit Kerja</th>
                        <?php endif; ?>
                        <th>Status</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($submissions)): ?>
                        <tr>
                            <td colspan="<?= $this->session->userdata('admin_kabupaten') > 0 ? '6' : '5' ?>" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Tidak ada data berkas</p>
                                <?php if ($this->session->userdata('admin_kabupaten') == 0): ?>
                                    <a href="<?= base_url('berkas/create') ?>" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus me-1"></i> Unggah Berkas Pertama
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = $this->input->get('per_page') ? $this->input->get('per_page') + 1 : 1; ?>
                        <?php foreach ($submissions as $index => $submission): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= strtoupper($submission->bulan) ?> <?= $submission->tahun ?></strong>
                            </td>
                            <?php if ($this->session->userdata('admin_kabupaten') > 0): ?>
                            <td>
                                <strong><?= $submission->unit_nama ?></strong>
                                <?php if ($submission->unit_id == $this->session->userdata('unit_id')): ?>
                                    <span class="badge bg-info ms-1">Unit Saya</span>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
                            <td>
                                <span class="badge 
                                    <?= $submission->status == 'approved' ? 'bg-success' : '' ?>
                                    <?= $submission->status == 'rejected' ? 'bg-danger' : '' ?>
                                    <?= $submission->status == 'submitted' ? 'bg-warning text-dark' : '' ?>
                                    <?= $submission->status == 'draft' ? 'bg-secondary' : '' ?>
                                ">
                                    <i class="fas 
                                        <?= $submission->status == 'approved' ? 'fa-check' : '' ?>
                                        <?= $submission->status == 'rejected' ? 'fa-times' : '' ?>
                                        <?= $submission->status == 'submitted' ? 'fa-paper-plane' : '' ?>
                                        <?= $submission->status == 'draft' ? 'fa-edit' : '' ?>
                                    me-1"></i>
                                    <?= strtoupper($submission->status) ?>
                                </span>
                                <?php if ($submission->status == 'rejected' && !empty($submission->catatan)): ?>
                                    <br><small class="text-muted" title="<?= $submission->catatan ?>">
                                        <i class="fas fa-comment"></i> <?= character_limiter($submission->catatan, 30) ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($submission->created_at)) ?>
                                <br><small class="text-muted"><?= date('H:i', strtotime($submission->created_at)) ?></small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
<!--                                     <a href="<?= base_url('berkas/edit/' . $submission->id) ?>" 
                                       class="btn btn-warning" title="Edit Berkas">
                                        <i class="fas fa-edit"></i>
                                    </a>
 -->                                    
                                    <a href="<?= base_url('berkas/detail/' . $submission->id) ?>" 
                                       class="btn btn-warning" title="Info Berkas">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    
                                    <?php if ($this->session->userdata('admin_kabupaten') == 0 || $submission->unit_id == $this->session->userdata('unit_id')): ?>
                                        <?php if ($submission->status == 'draft'): ?>
                                            <a href="<?= base_url('berkas/submit/' . $submission->id) ?>" 
                                               class="btn btn-info" title="Ajukan Review"
                                               onclick="return confirm('Ajukan berkas untuk review?')">
                                                <i class="fas fa-paper-plane"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (in_array($submission->status, ['draft', 'rejected'])): ?>
                                            <a href="<?= base_url('berkas/delete/' . $submission->id) ?>" 
                                               class="btn btn-danger" title="Hapus Berkas"
                                               onclick="return confirm('Hapus berkas ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <!-- Tombol preview untuk admin kabupaten -->

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?= $pagination_links ?>
        
        <!-- Statistik untuk Admin OPD -->
        <?php if ($this->session->userdata('admin_kabupaten') == 0 && !empty($submissions)): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <h6><i class="fas fa-chart-pie me-2"></i>Statistik Berkas Unit</h6>
                <div class="row">
                    <?php
                    $stats = [
                        'draft' => 0,
                        'submitted' => 0,
                        'approved' => 0,
                        'rejected' => 0
                    ];
                    
                    foreach ($submissions as $sub) {
                        if (isset($stats[$sub->status])) {
                            $stats[$sub->status]++;
                        }
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body text-center p-2">
                                <h5 class="mb-0"><?= $stats['draft'] ?></h5>
                                <small>Draft</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body text-center p-2">
                                <h5 class="mb-0"><?= $stats['submitted'] ?></h5>
                                <small>Diajukan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center p-2">
                                <h5 class="mb-0"><?= $stats['approved'] ?></h5>
                                <small>Disetujui</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center p-2">
                                <h5 class="mb-0"><?= $stats['rejected'] ?></h5>
                                <small>Ditolak</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.badge {
    font-size: 0.75em;
}
.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
</style>