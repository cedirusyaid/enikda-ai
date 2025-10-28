<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Management Status Berkas TPP</h5>
        <div>
            <a href="<?= base_url('berkas/export') ?>" class="btn btn-success btn-sm me-2">
                <i class="fas fa-file-excel me-1"></i> Export
            </a>
            <a href="<?= base_url('berkas/dashboard') ?>" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar me-1"></i> Dashboard
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="get" action="<?= base_url('berkas/management') ?>" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="all">Semua Status</option>
                        <option value="draft" <?= $this->input->get('status') == 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="submitted" <?= $this->input->get('status') == 'submitted' ? 'selected' : '' ?>>Submitted</option>
                        <option value="approved" <?= $this->input->get('status') == 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= $this->input->get('status') == 'rejected' ? 'selected' : '' ?>>Rejected</option>
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
                    <select name="tahun" class="form-select">
                        <option value="all">Semua Tahun</option>
                        <?php for ($i = date('Y'); $i >= 2020; $i--): ?>
                            <option value="<?= $i ?>" <?= $this->input->get('tahun') == $i ? 'selected' : '' ?>>
                                <?= $i ?>
                            </option>
                        <?php endfor; ?>
                    </select>
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
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Status Summary -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4><?= $status_count['total'] ?></h4>
                        <small>Total Berkas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <h4><?= $status_count['draft'] ?></h4>
                        <small>Draft</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h4><?= $status_count['submitted'] ?></h4>
                        <small>Submitted</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4><?= $status_count['approved'] ?></h4>
                        <small>Approved</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h4><?= $status_count['rejected'] ?></h4>
                        <small>Rejected</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Action Form -->
        <form method="post" action="<?= base_url('berkas/bulk_action') ?>" id="bulkForm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <select name="action" class="form-select me-2 d-inline-block w-auto" required>
                        <option value="">Pilih Aksi</option>
                        <option value="approved">Setujui</option>
                        <option value="rejected">Tolak</option>
                        <option value="submitted">Kembalikan ke Submitted</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-play me-1"></i> Jalankan Aksi
                    </button>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="selectAll">
                    <label class="form-check-label" for="selectAll">Pilih Semua</label>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="30">
                                <input type="checkbox" id="selectAllCheckbox">
                            </th>
                            <th>#</th>
                            <th>Unit Kerja</th>
                            <th>Bulan/Tahun</th>
                            <th>Status</th>
                            <th>Jumlah File</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submissions as $index => $submission): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected[]" value="<?= $submission->id ?>" 
                                       class="submission-checkbox">
                            </td>
                            <td><?= $index + 1 ?></td>
                            <td><?= $submission->unit_nama ?></td>
                            <td>
                                <strong><?= strtoupper($submission->bulan) ?> <?= $submission->tahun ?></strong>
                            </td>
                            <td>
                                <span class="badge 
                                    <?= $submission->status == 'approved' ? 'bg-success' : '' ?>
                                    <?= $submission->status == 'rejected' ? 'bg-danger' : '' ?>
                                    <?= $submission->status == 'submitted' ? 'bg-warning text-dark' : '' ?>
                                    <?= $submission->status == 'draft' ? 'bg-secondary' : '' ?>
                                ">
                                    <?= strtoupper($submission->status) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info"><?= $submission->jumlah_file ?></span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($submission->created_at)) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('berkas/detail/' . $submission->id) ?>" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($submission->status == 'submitted'): ?>
                                        <a href="#" class="btn btn-success approve-btn" 
                                           data-id="<?= $submission->id ?>" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger reject-btn" 
                                           data-id="<?= $submission->id ?>" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>

        <?php if (empty($submissions)): ?>
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada data berkas</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal untuk Approve/Reject -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="statusForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="submission_id" id="submissionId">
                    <input type="hidden" name="status" id="statusValue">
                    
                    <div class="mb-3">
                        <label class="form-label">Status Baru</label>
                        <div id="statusDisplay" class="fw-bold"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan <span class="text-danger">*</span></label>
                        <textarea name="catatan" class="form-control" rows="4" 
                                  placeholder="Berikan catatan untuk perubahan status..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Bulk selection
document.getElementById('selectAllCheckbox').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.submission-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Status modal handling
document.querySelectorAll('.approve-btn, .reject-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        const submissionId = this.getAttribute('data-id');
        const isApprove = this.classList.contains('approve-btn');
        
        document.getElementById('submissionId').value = submissionId;
        document.getElementById('statusValue').value = isApprove ? 'approved' : 'rejected';
        document.getElementById('statusDisplay').textContent = isApprove ? 'APPROVED' : 'REJECTED';
        document.getElementById('statusDisplay').className = isApprove ? 
            'fw-bold text-success' : 'fw-bold text-danger';
        document.getElementById('modalTitle').textContent = isApprove ? 
            'Setujui Berkas' : 'Tolak Berkas';
        
        // Set form action
        document.getElementById('statusForm').action = 
            '<?= base_url('berkas/update_status/') ?>' + submissionId;
        
        // Show modal
        new bootstrap.Modal(document.getElementById('statusModal')).show();
    });
});

// Form validation
document.getElementById('bulkForm').addEventListener('submit', function(e) {
    const selected = document.querySelectorAll('.submission-checkbox:checked');
    if (selected.length === 0) {
        e.preventDefault();
        alert('Pilih minimal satu berkas!');
    }
});
</script>