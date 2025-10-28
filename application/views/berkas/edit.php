<?php
// print_r($this->session->userdata());
?>


<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-edit me-2"></i>Edit Berkas TPP
        </h5>
        <div>
            <a href="<?= base_url('berkas') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Status Alert -->
        <div class="alert alert-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Status Saat Ini:</strong> 
                    <span class="badge 
                        <?= $submission->status == 'approved' ? 'bg-success' : '' ?>
                        <?= $submission->status == 'rejected' ? 'bg-danger' : '' ?>
                        <?= $submission->status == 'submitted' ? 'bg-warning text-dark' : '' ?>
                        <?= $submission->status == 'draft' ? 'bg-secondary' : '' ?>
                    ">
                        <?= strtoupper($submission->status) ?>
                    </span>
                    
                    <?php if (in_array($submission->status, ['rejected', 'submitted'])): ?>
                    <span class="ms-3">
                        <a href="<?= base_url('berkas/reset_to_draft/' . $submission->id) ?>" 
                           class="btn btn-sm btn-outline-warning"
                           onclick="return confirm('Reset berkas ke status draft?')">
                            <i class="fas fa-undo me-1"></i> Reset ke Draft
                        </a>
                    </span>
                    <?php endif; ?>
                </div>
                
                <?php if ($submission->status == 'draft'): ?>
                <div>
                    <a href="<?= base_url('berkas/submit/' . $submission->id) ?>" 
                       class="btn btn-success btn-sm"
                       onclick="return confirm('Ajukan berkas untuk review?')">
                        <i class="fas fa-paper-plane me-1"></i> Ajukan untuk Review
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Edit Form -->
        <form method="post" action="<?= base_url('berkas/update/' . $submission->id) ?>" enctype="multipart/form-data" id="editForm">    
            <div class="row mb-4">
                <!-- Basic Information -->
                <div class="col-md-<?= $this->session->userdata('admin_kabupaten') ? '12' : '12' ?>">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php if ($this->session->userdata('admin_kabupaten') == 1): ?>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Unit Kerja *</label>
                                        <select name="unit_id" class="form-select" required>
                                            <option value="">Pilih Unit Kerja</option>
                                            <?php foreach ($units as $unit): ?>
                                                <option value="<?= $unit->unit_id ?>" 
                                                    <?= $unit->unit_id == $submission->unit_id ? 'selected' : '' ?>>
                                                    <?= $unit->unit_nama ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Bulan *</label>
                                        <select name="bulan" class="form-select" required>
                                            <option value="">Pilih Bulan</option>
                                            <?php
                                            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                                     'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                            foreach ($bulan as $b) {
                                                $selected = $b == $submission->bulan ? 'selected' : '';
                                                echo "<option value='$b' $selected>$b</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tahun *</label>
                                        <input type="number" name="tahun" class="form-control" 
                                               value="<?= $submission->tahun ?>" min="2020" max="2030" required>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Unit Kerja</label>
                                        <input type="text" class="form-control" value="<?= $submission->unit_nama ?>" readonly>
                                        <small class="text-muted">Tidak dapat diubah</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Bulan</label>
                                        <input type="text" class="form-control" value="<?= $submission->bulan ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" class="form-control" value="<?= $submission->tahun ?>" readonly>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Submission Info -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        Dibuat: <?= date('d/m/Y H:i', strtotime($submission->created_at)) ?>
                                    </small>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">
                                        <i class="fas fa-sync me-1"></i>
                                        Terakhir update: <?= date('d/m/Y H:i', strtotime($submission->updated_at)) ?>
                                    </small>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">
                                        <i class="fas fa-file me-1"></i>
                                        Jumlah file: <?= count($files) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Dokumen Berkas</h6>
                    <small>Unggah file baru untuk mengganti file yang sudah ada</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Jenis Dokumen</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">File Saat Ini</th>
                                    <th width="20%">Upload File Baru</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($files as $index => $file): ?>
                                <tr class="<?= $file->required && !$file->is_uploaded ? 'table-danger' : '' ?>">
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= $file->jenis_dokumen ?></strong>
                                        <?php if ($file->required): ?>
                                            <span class="badge bg-danger ms-1">WAJIB</span>
                                        <?php endif; ?>
                                        <?php if ($file->deskripsi): ?>
                                            <br><small class="text-muted"><?= $file->deskripsi ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($file->is_uploaded): ?>
                                            <span class="badge bg-success"><i class="fas fa-check"></i> Terupload</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><i class="fas fa-times"></i> Belum</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($file->is_uploaded): ?>
                                            <div class="file-info">
                                                <small class="text-success">
                                                    <i class="fas fa-file me-1"></i>
                                                    <?= $file->nama_file ?>
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    <?= number_format($file->size / 1024 / 1024, 2) ?> MB
                                                </small>
                                            </div>
                                        <?php else: ?>
                                            <small class="text-muted">-</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="file" name="document_<?= $file->id ?>" 
                                               class="form-control form-control-sm" 
                                               accept=".pdf,.doc,.docx">
                                        <small class="text-muted">
                                            Max: <?= $file->id == 1 ? '1MB' : '10MB' ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php if ($file->is_uploaded): ?>
                                            <div class="btn-group-vertical btn-group-sm">
                                                <a href="<?= base_url('berkas/preview_file/' . $file->id) ?>" 
                                                   target="_blank" class="btn btn-outline-primary btn-sm"
                                                   title="Preview">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('uploads/berkas/' . $file->nama_file) ?>" 
                                                   class="btn btn-outline-success btn-sm"
                                                   title="Download" download>
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete-file-btn"
                                                        data-file-id="<?= $file->id ?>"
                                                        data-file-name="<?= $file->jenis_dokumen ?>"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Validation Summary -->
                    <?php
                    $missing_required = array_filter($files, function($f) { 
                        return $f->required && !$f->is_uploaded; 
                    });
                    ?>
                    <div class="alert <?= empty($missing_required) ? 'alert-success' : 'alert-warning' ?> mt-3">
                        <strong>Status Kelengkapan:</strong>
                        <?php if (empty($missing_required)): ?>
                            <i class="fas fa-check-circle text-success"></i> Semua dokumen wajib sudah lengkap
                        <?php else: ?>
                            <i class="fas fa-exclamation-triangle text-warning"></i> 
                            <?= count($missing_required) ?> dokumen wajib belum diupload
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
                <div class="col-md-6">
                    <a href="<?= base_url('berkas') ?>" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                </div>
            </div>
        </form>

        <!-- Edit History -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Perubahan</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($history)): ?>
                <div class="timeline">
                    <?php foreach ($history as $index => $item): ?>
                    <div class="timeline-item <?= $index == 0 ? 'timeline-item-active' : '' ?>">
                        <div class="timeline-marker 
                            <?= $item->status == 'approved' ? 'bg-success' : '' ?>
                            <?= $item->status == 'rejected' ? 'bg-danger' : '' ?>
                            <?= $item->status == 'submitted' ? 'bg-warning' : '' ?>
                            <?= $item->status == 'draft' ? 'bg-secondary' : '' ?>
                        "></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <strong class="text-uppercase"><?= $item->status ?></strong>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($item->created_at)) ?></small>
                            </div>
                            <p class="mb-1"><?= $item->catatan ?></p>
                            <small class="text-muted">Oleh: <?= $item->nip ?> - <?= $item->nama ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-muted text-center">Belum ada riwayat perubahan</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Delete File Modal -->
<div class="modal fade" id="deleteFileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus file <strong id="fileName"></strong>?</p>
                <p class="text-danger"><small>File yang dihapus tidak dapat dikembalikan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Hapus File</a>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline-item {
    position: relative;
    margin-bottom: 20px;
}
.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 3px solid #6c757d;
}
.timeline-item-active .timeline-content {
    background: #e3f2fd;
    border-left-color: #2196f3;
}
.file-info {
    line-height: 1.2;
}
</style>

<script>
// File deletion confirmation
document.querySelectorAll('.delete-file-btn').forEach(button => {
    button.addEventListener('click', function() {
        const fileId = this.getAttribute('data-file-id');
        const fileName = this.getAttribute('data-file-name');
        
        document.getElementById('fileName').textContent = fileName;
        document.getElementById('confirmDelete').href = 
            '<?= base_url('berkas/delete_file/' . $submission->id) ?>/' + fileId;
        
        new bootstrap.Modal(document.getElementById('deleteFileModal')).show();
    });
});

// Form submission confirmation
document.getElementById('editForm').addEventListener('submit', function(e) {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    let hasFileSelected = false;
    
    fileInputs.forEach(input => {
        if (input.files.length > 0) {
            hasFileSelected = true;
        }
    });
    
    if (!hasFileSelected) {
        if (!confirm('Tidak ada file baru yang dipilih. Lanjutkan menyimpan?')) {
            e.preventDefault();
        }
    }
});

// Show file size validation
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const maxSize = this.nextElementSibling.textContent.includes('1MB') ? 1 : 10;
            const fileSizeMB = file.size / 1024 / 1024;
            
            if (fileSizeMB > maxSize) {
                alert(`File terlalu besar! Maksimal ${maxSize}MB. File Anda: ${fileSizeMB.toFixed(2)}MB`);
                this.value = '';
            }
        }
    });
});
</script>