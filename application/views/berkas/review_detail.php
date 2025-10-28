<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-clipboard-list me-2"></i>Review Detail Berkas
        </h5>
        <a href="<?= base_url('berkas/review') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Review
        </a>
    </div>
    <div class="card-body">
        <!-- Submission Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Informasi Berkas</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Unit Kerja</th>
                                <td><?= $submission->unit_nama ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= $submission->unit_alamat ?></td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td><?= $submission->unit_telepon ?: '-' ?></td>
                            </tr>
                            <tr>
                                <th>Periode</th>
                                <td><strong><?= strtoupper($submission->bulan) ?> <?= $submission->tahun ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Status & Timeline</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Status Saat Ini</th>
                                <td>
                                    <span class="badge 
                                        <?= $submission->status == 'approved' ? 'bg-success' : '' ?>
                                        <?= $submission->status == 'rejected' ? 'bg-danger' : '' ?>
                                        <?= $submission->status == 'submitted' ? 'bg-warning text-dark' : '' ?>
                                    ">
                                        <?= strtoupper($submission->status) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Upload</th>
                                <td><?= date('d/m/Y H:i', strtotime($submission->created_at)) ?></td>
                            </tr>
                            <tr>
                                <th>Lama Menunggu</th>
                                <td>
                                    <?php
                                    $waiting_hours = floor((time() - strtotime($submission->created_at)) / (60 * 60));
                                    echo $waiting_hours . ' jam';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Diupload Oleh</th>
                                <td><?= $submission->uploader_nama ?: 'Unknown' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Validation -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="fas fa-task-list me-2"></i>Validasi Kelengkapan Dokumen
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Jenis Dokumen</th>
                                <th width="10%">Status</th>
                                <th width="15%">Keterangan</th>
                                <th width="25%">File</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php //print_r($files); die();?>
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
                                        <span class="badge bg-success"><i class="fas fa-check"></i> Ada</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="fas fa-times"></i> Missing</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($file->is_uploaded): ?>
                                        <small>Size: <?= number_format($file->size / 1024 / 1024, 2) ?> MB</small>
                                    <?php elseif ($file->required): ?>
                                        <small class="text-danger">Dokumen wajib</small>
                                    <?php else: ?>
                                        <small class="text-muted">Opsional</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($file->is_uploaded): ?>
                                        <small><?= $file->nama_file ?></small>
                                    <?php else: ?>
                                        <small class="text-muted">-</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($file->is_uploaded): ?>
                                        <a href="<?= base_url('uploads/berkas/' . $file->nama_file) ?>" 
                                           target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
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
                $missing_required = $this->Berkas_model->check_missing_required_files($submission->id);
                $total_required = count(array_filter($files, function($f) { return $f->required; }));
                $uploaded_required = $total_required - count($missing_required);
                ?>
                <div class="alert <?= empty($missing_required) ? 'alert-success' : 'alert-danger' ?> mt-3">
                    <strong>Ringkasan Validasi:</strong><br>
                    Dokumen wajib: <?= $uploaded_required ?>/<?= $total_required ?> terupload
                    <?php if (!empty($missing_required)): ?>
                        <br>Dokumen yang belum lengkap: <?= implode(', ', $missing_required) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Review Actions -->
        <?php if ($submission->status == 'submitted'): ?>
        <div class="row" id="reviewActions">
            <!-- Approve Form -->
            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-check-circle me-2"></i>Setujui Berkas</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('berkas/process_approve/' . $submission->id) ?>">
                            <div class="mb-3">
                                <label class="form-label">Catatan Persetujuan</label>
                                <textarea name="catatan" class="form-control" rows="4" 
                                          placeholder="Berikan catatan persetujuan..." required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success" 
                                    <?= !empty($missing_required) ? 'disabled title="Dokumen wajib belum lengkap"' : '' ?>>
                                    <i class="fas fa-check me-1"></i> Setujui Berkas
                                </button>
                            </div>
                            <?php if (!empty($missing_required)): ?>
                            <small class="text-danger mt-2 d-block">
                                <i class="fas fa-exclamation-triangle"></i> 
                                Tidak dapat menyetujui karena dokumen wajib belum lengkap
                            </small>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reject Form -->
            <div class="col-md-6">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="fas fa-times-circle me-2"></i>Tolak Berkas</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('berkas/process_reject/' . $submission->id) ?>">
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan</label>
                                <select name="alasan" class="form-select" required>
                                    <option value="">Pilih Alasan</option>
                                    <option value="dokumen_tidak_lengkap">Dokumen tidak lengkap</option>
                                    <option value="format_tidak_sesuai">Format dokumen tidak sesuai</option>
                                    <option value="data_tidak_valid">Data tidak valid</option>
                                    <option value="tidak_tepat_waktu">Tidak tepat waktu</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Penolakan</label>
                                <textarea name="catatan" class="form-control" rows="4" 
                                          placeholder="Jelaskan alasan penolakan secara detail..." required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times me-1"></i> Tolak Berkas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Current Status Info -->
        <div class="alert 
            <?= $submission->status == 'approved' ? 'alert-success' : 'alert-danger' ">
            <h6>
                <i class="fas fa-<?php echo $submission->status == 'approved' ? 'check' : 'times'; ?>-circle me-2"></i>
                Berkas telah di-<?= $submission->status == 'approved' ? 'setujui' : 'tolak' ?>
            </h6>
            <p class="mb-1"><strong>Catatan:</strong> <?= $submission->catatan ?: '-' ?></p>
            <?php if ($submission->status == 'rejected' && $submission->alasan_penolakan): ?>
                <p class="mb-1"><strong>Alasan:</strong> <?= $submission->alasan_penolakan ?></p>
            <?php endif; ?>
            <p class="mb-0"><strong>Direview pada:</strong> 
                <?= $submission->reviewed_at ? date('d/m/Y H:i', strtotime($submission->reviewed_at)) : '-' ?>
            </p>
            
            <div class="mt-3">
                <a href="<?= base_url('berkas/return_to_submitted/' . $submission->id) ?>" 
                   class="btn btn-warning btn-sm"
                   onclick="return confirm('Kembalikan berkas ke status submitted?')">
                    <i class="fas fa-undo me-1"></i> Kembalikan ke Submitted
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Review History -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Review</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($history)): ?>
                <div class="timeline">
                    <?php foreach ($history as $index => $item): ?>
                    <div class="timeline-item <?= $index == 0 ? 'timeline-item-active' : '' ?>">
                        <div class="timeline-marker 
                            <?= $item->action == 'approved' ? 'bg-success' : '' ?>
                            <?= $item->action == 'rejected' ? 'bg-danger' : '' ?>
                            <?= $item->action == 'returned' ? 'bg-warning' : '' ?>
                        "></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <strong class="text-uppercase"><?= $item->action ?></strong>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($item->created_at)) ?></small>
                            </div>
                            <p class="mb-1"><?= $item->catatan ?></p>
                            <?php if ($item->alasan): ?>
                                <p class="mb-1"><small><strong>Alasan:</strong> <?= $item->alasan ?></small></p>
                            <?php endif; ?>
                            <small class="text-muted">Oleh: <?= $item->reviewer_nama ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-muted text-center">Belum ada riwayat review</p>
                <?php endif; ?>
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
</style>