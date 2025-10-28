<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Detail Berkas TPP</h5>
        <a href="<?= base_url('berkas/management') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Unit Kerja</th>
                        <td><?= $submission->unit_nama ?></td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td><?= strtoupper($submission->bulan) ?> <?= $submission->tahun ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
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
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Tanggal Upload</th>
                        <td><?= date('d/m/Y H:i', strtotime($submission->created_at)) ?></td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td><?= date('d/m/Y H:i', strtotime($submission->updated_at)) ?></td>
                    </tr>
                    <tr>
                        <th>Diupload Oleh</th>
                        <td><?= $submission->uploader_nama ?? 'Unknown' ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <h6 class="border-bottom pb-2">Dokumen Terlampir</h6>

        <div class="table-responsive mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis Dokumen</th>
                        <th>File</th>
                        <th>Ukuran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Kelompokkan file berdasarkan type_id untuk akses mudah
                    $file_by_type_id = [];
                    foreach ($files as $file) {
                        $file_by_type_id[$file->type_id] = $file;
                    }
                    ?>
                    <?php $no = 1; ?>
                    <?php foreach ($document_types as $type) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= $type->nama ?></strong>
                                <?php if (in_array($type->id, [2, 3, 4, 5, 6, 7, 8, 9])) : ?>
                                    <span class="badge bg-danger ms-1">WAJIB</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($file_by_type_id[$type->id])) : ?>
                                    <a href="<?= base_url('/uploads/berkas/' . $file_by_type_id[$type->id]->nama_file) ?>" target='_blank' title="<?= $file_by_type_id[$type->id]->nama_file ?>">
                                        <i class="fas fa-external-link-alt me-1"></i> Lihat File
                                    </a>
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($file_by_type_id[$type->id])) : ?>
                                    <?= number_format($file_by_type_id[$type->id]->size / 1024 / 1024, 2) ?> MB
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($file_by_type_id[$type->id])) : ?>
                                    <span class="badge bg-success">Sudah Diupload</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">Belum Diupload</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#fileActionModal-<?= $type->id ?>">
                                    <i class="fas fa-tasks me-1"></i> Kelola File
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($document_types)) : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada jenis dokumen yang terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php foreach ($document_types as $type) : ?>
            <div class="modal fade" id="fileActionModal-<?= $type->id ?>" tabindex="-1" aria-labelledby="fileActionModalLabel-<?= $type->id ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fileActionModalLabel-<?= $type->id ?>">Kelola: <?= $type->nama ?></h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('berkas/upload_single_file/' . $submission->id . '/' . $type->id) ?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="document_file_<?= $type->id ?>" class="form-label">
                                        <?php if (isset($file_by_type_id[$type->id])) : ?>
                                            Pilih file baru untuk menggantikan yang lama:
                                        <?php else : ?>
                                            Pilih file untuk diupload:
                                        <?php endif; ?>
                                    </label>
                                    <input type="file" name="document_file" id="document_file_<?= $type->id ?>" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <?php if (isset($file_by_type_id[$type->id])) : ?>
                                        <i class="fas fa-sync-alt me-1"></i> Ganti File
                                    <?php else : ?>
                                        <i class="fas fa-upload me-1"></i> Upload File
                                    <?php endif; ?>
                                </button>
                            </form>

                            <?php if (isset($file_by_type_id[$type->id])) : ?>
                                <hr>
                                <p class="text-center text-muted small my-2">Atau</p>
                                <a href="<?= base_url('berkas/delete_file/' . $submission->id . '/' . $file_by_type_id[$type->id]->id) ?>" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?')">
                                    <i class="fas fa-trash me-1"></i> Hapus File yang Sudah Ada
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if ($this->session->userdata('admin_kabupaten') > 0 && $submission->status == 'submitted') : ?>
            <h6 class="border-bottom pb-2">Update Status</h6>
            <form method="post" action="<?= base_url('berkas/update_status/' . $submission->id) ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Status Baru</label>
                        <select name="status" class="form-select" required>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catatan <span class="text-danger">*</span></label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Berikan catatan untuk perubahan status..." required></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i> Update Status
                        </button>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <h6 class="border-bottom pb-2 mt-4">Riwayat Status</h6>
        <div class="timeline">
            <?php foreach ($history as $index => $item) : ?>
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
                        <small class="text-muted">Oleh: <?= $item->nama ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
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
        background: #6c757d;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -25px;
        top: 10px;
        width: 1px;
        height: 100%;
        background: #dee2e6;
    }
    
    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-item-active .timeline-content {
        border-color: #0d6efd;
    }

    .timeline-item-active .timeline-marker {
        transform: scale(1.5);
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.3);
    }
</style>