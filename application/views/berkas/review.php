<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-clipboard-check me-2"></i>Review Berkas TPP
        </h5>
        <div>
            <a href="<?= base_url('berkas/review_report') ?>" class="btn btn-info btn-sm me-2">
                <i class="fas fa-chart-bar me-1"></i> Laporan Review
            </a>
            <a href="<?= base_url('berkas/management') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-cog me-1"></i> Management
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Review Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h3><?= $review_stats['waiting_review'] ?></h3>
                        <small>Menunggu Review</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3><?= $review_stats['reviewed_today'] ?></h3>
                        <small>Direview Hari Ini</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3><?= $review_stats['monthly_approved'] ?></h3>
                        <small>Disetujui Bulan Ini</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h3><?= $review_stats['monthly_rejected'] ?></h3>
                        <small>Ditolak Bulan Ini</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="get" action="<?= base_url('berkas/review') ?>" class="mb-4">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="submitted" <?= $this->input->get('status') == 'submitted' ? 'selected' : '' ?>>Menunggu Review</option>
                        <option value="approved" <?= $this->input->get('status') == 'approved' ? 'selected' : '' ?>>Disetujui</option>
                        <option value="rejected" <?= $this->input->get('status') == 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                        <option value="all" <?= $this->input->get('status') == 'all' ? 'selected' : '' ?>>Semua Status</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="all">Semua Bulan</option>
                        <?php
                        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        foreach ($bulan as $b) {
                            $selected = $this->input->get('bulan') == $b ? 'selected' : '';
                            echo "<option value='$b' $selected>$b</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="<?= $this->input->get('tahun') ?: date('Y') ?>" min="2020" max="2030">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unit Kerja</label>
                    <select name="unit_id" class="form-select">
                        <option value="all">Semua Unit</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?= $unit->unit_id ?>" 
                                <?= $this->input->get('unit_id') == $unit->unit_id ? 'selected' : '' ?>>
                                <?= $unit->unit_nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Quick Action Form -->
        <?php if ($this->input->get('status') == 'submitted'): ?>
        <form method="post" action="<?= base_url('berkas/quick_approve') ?>" id="quickApproveForm" class="mb-3">
            <div class="alert alert-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Quick Approve:</strong> Pilih berkas yang sudah lengkap untuk disetujui sekaligus
                    </div>
                    <div class="d-flex gap-2">
                        <textarea name="catatan" class="form-control form-control-sm" 
                                  placeholder="Catatan untuk semua berkas yang dipilih" style="width: 200px;"></textarea>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-check-double me-1"></i> Quick Approve
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Submissions Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <?php if ($this->input->get('status') == 'submitted'): ?>
                        <th width="30">
                            <input type="checkbox" id="selectAllReview">
                        </th>
                        <?php endif; ?>
                        <th width="50">#</th>
                        <th>Unit Kerja</th>
                        <th>Periode</th>
                        <th>Diupload Oleh</th>
                        <th>Tanggal Upload</th>
                        <th>Lama Menunggu</th>
                        <th>Kelengkapan</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $index => $submission): ?>
                    <tr class="<?= $submission->status == 'submitted' ? 'table-warning' : '' ?>">
                        <?php if ($this->input->get('status') == 'submitted'): ?>
                        <td>
                            <input type="checkbox" name="selected[]" value="<?= $submission->id ?>" 
                                   class="review-checkbox">
                        </td>
                        <?php endif; ?>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <strong><?= $submission->unit_nama ?></strong>
                            <br><small class="text-muted"><?= $submission->unit_alamat ?></small>
                        </td>
                        <td>
                            <strong><?= strtoupper($submission->bulan) ?> <?= $submission->tahun ?></strong>
                        </td>
                        <td>
                            <small><?= isset($submission->uploader_nama) ? $submission->uploader_nama : 'Unknown' ?></small>
                            <br><small class="text-muted">
                                <?= isset($submission->uploader_nip) ? $submission->uploader_nip : 'N/A' ?>
                            </small>
                        </td>
                        <td>
                            <?= date('d/m/Y', strtotime($submission->created_at)) ?>
                            <br><small class="text-muted"><?= date('H:i', strtotime($submission->created_at)) ?></small>
                        </td>
                        <td>
                            <?php
                            $waiting_days = floor((time() - strtotime($submission->created_at)) / (60 * 60 * 24));
                            if ($waiting_days == 0) {
                                echo '<span class="badge bg-success">Hari Ini</span>';
                            } else {
                                echo '<span class="badge bg-' . ($waiting_days > 3 ? 'danger' : 'warning') . '">';
                                echo $waiting_days . ' hari</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $missing = $this->Berkas_model->check_missing_required_files($submission->id);
                            if (empty($missing)) {
                                echo '<span class="badge bg-success"><i class="fas fa-check"></i> Lengkap</span>';
                            } else {
                                echo '<span class="badge bg-danger"><i class="fas fa-times"></i> ' . count($missing) . ' missing</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <span class="badge 
                                <?= $submission->status == 'approved' ? 'bg-success' : '' ?>
                                <?= $submission->status == 'rejected' ? 'bg-danger' : '' ?>
                                <?= $submission->status == 'submitted' ? 'bg-warning text-dark' : '' ?>
                            ">
                                <?= strtoupper($submission->status) ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= base_url('berkas/review_detail/' . $submission->id) ?>" 
                                   class="btn btn-info" title="Review Detail">
                                    <i class="fas fa-search"></i>
                                </a>
                                <?php if ($submission->status == 'submitted'): ?>
                                    <a href="<?= base_url('berkas/review_detail/' . $submission->id) ?>#approve" 
                                       class="btn btn-success" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </a>
                                <?php elseif (in_array($submission->status, ['approved', 'rejected'])): ?>
                                    <a href="<?= base_url('berkas/return_to_submitted/' . $submission->id) ?>" 
                                       class="btn btn-warning" title="Kembalikan"
                                       onclick="return confirm('Kembalikan berkas ke status submitted?')">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($this->input->get('status') == 'submitted'): ?>
        </form>
        <?php endif; ?>

        <?php if (empty($submissions)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada berkas untuk direview</h5>
                <p class="text-muted">Semua berkas telah diproses atau tidak ada yang menunggu review</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Select all for review
document.getElementById('selectAllReview')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.review-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Quick approve form validation
document.getElementById('quickApproveForm')?.addEventListener('submit', function(e) {
    const selected = document.querySelectorAll('.review-checkbox:checked');
    if (selected.length === 0) {
        e.preventDefault();
        alert('Pilih minimal satu berkas untuk quick approve!');
    }
});

// Auto refresh every 5 minutes untuk halaman review
<?php if ($this->input->get('status') == 'submitted'): ?>
setTimeout(function() {
    window.location.reload();
}, 300000); // 5 minutes
<?php endif; ?>
</script>