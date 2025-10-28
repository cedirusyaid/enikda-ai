<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Form Unggah Berkas TPP</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('berkas/store') ?>" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Unit Kerja *</label>
                    <select name="unit_id" class="form-select" required>
                        <option value="">Pilih Unit Kerja</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?= $unit->unit_id ?>" 
                                <?= $unit->unit_id == $this->session->userdata('unit_id') ? 'selected' : '' ?>>
                                <?= $unit->unit_nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Bulan *</label>
                    <select name="bulan" class="form-select" required>
                        <option value="">Pilih Bulan</option>
                        <?php
                        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        foreach ($bulan as $index => $b) {
                            echo "<option value='$b'>$b</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun *</label>
                    <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>" required>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">#</th>
                            <th width="40%">Jenis Dokumen</th>
                            <th width="15%">Wajib</th>
                            <th width="40%">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($document_types as $index => $type): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <strong><?= $type->nama ?></strong>
                                <?php if ($type->deskripsi): ?>
                                    <br><small class="text-muted"><?= $type->deskripsi ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $type->required ? '<span class="badge bg-danger">WAJIB</span>' : 
                                                      '<span class="badge bg-secondary">OPTIONAL</span>' ?>
                            </td>
                            <td>
                                <input type="file" name="document_<?= $type->id ?>" class="form-control" 
                                       accept=".pdf,.doc,.docx" 
                                       <?= $type->required ? 'required' : '' ?>>
                                <small class="text-muted">
                                    Max: <?= $type->id == 1 ? '1MB' : '10MB' ?> (PDF, DOC, DOCX)
                                </small>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Berkas
                </button>
                <a href="<?= base_url('berkas') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>