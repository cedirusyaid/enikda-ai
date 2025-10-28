<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Berkas TPP
        </h5>
    </div>
    <div class="card-body">
        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label">Tahun</label>
                <select class="form-select" id="yearFilter" onchange="filterDashboard()">
                    <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                        <option value="<?= $y ?>" <?= $selected_year == $y ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <?php if ($this->session->userdata('admin_kabupaten') == 1): ?>
            <div class="col-md-4">
                <label class="form-label">Unit Kerja</label>
                <select class="form-select" id="unitFilter" onchange="filterDashboard()">
                    <option value="">Semua Unit</option>
                    <?php foreach ($units as $unit): ?>
                        <option value="<?= $unit->unit_id ?>" 
                            <?= $selected_unit == $unit->unit_id ? 'selected' : '' ?>>
                            <?= $unit->unit_nama ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-4 d-flex align-items-end">
                <button type="button" class="btn btn-outline-secondary" onclick="resetFilter()">
                    <i class="fas fa-refresh me-1"></i> Reset
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0"><?= $stats['total'] ?? 0 ?></h4>
                                <p class="mb-0">Total Berkas</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-folder fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0"><?= $stats['approved'] ?? 0 ?></h4>
                                <p class="mb-0">Disetujui</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0"><?= $stats['submitted'] ?? 0 ?></h4>
                                <p class="mb-0">Menunggu Review</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0"><?= $stats['rejected'] ?? 0 ?></h4>
                                <p class="mb-0">Ditolak</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Chart -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Progress Berkas per Bulan (<?= $selected_year ?>)
                </h6>
            </div>
            <div class="card-body">
                <canvas id="progressChart" height="100"></canvas>
            </div>
        </div>

        <!-- Monthly Progress Table -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="fas fa-table me-2"></i>Detail Progress per Bulan
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Bulan</th>
                                <th>Total Berkas</th>
                                <th>Disetujui</th>
                                <th>Ditolak</th>
                                <th>Menunggu</th>
                                <th>Draft</th>
                                <th>Progress</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($monthly_progress)): ?>
                                <?php foreach ($monthly_progress as $progress): ?>
                                    <tr>
                                        <td><strong><?= $progress->bulan ?></strong></td>
                                        <td><?= $progress->total_submissions ?></td>
                                        <td>
                                            <span class="badge bg-success"><?= $progress->approved ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger"><?= $progress->rejected ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark"><?= $progress->submitted ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $progress->draft ?></span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <?php
                                                $total = $progress->total_submissions;
                                                $approved = $progress->approved;
                                                $progress_percent = $total > 0 ? round(($approved / $total) * 100, 2) : 0;
                                                ?>
                                                <div class="progress-bar bg-success" 
                                                     style="width: <?= $progress_percent ?>%"
                                                     title="<?= $progress_percent ?>%">
                                                    <?= $progress_percent ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('berkas?bulan=' . urlencode($progress->bulan) . '&tahun=' . $selected_year) ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Tidak ada data untuk tahun <?= $selected_year ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        <?php if (!empty($recent_submissions)): ?>
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="fas fa-clock me-2"></i>Berkas Terbaru
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($recent_submissions as $submission): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1">
                                            <?php //print_r($submission); die();?>  
                                            <?= $submission->unit_nama ?>
                                        </h6>
                                        <p class="card-text mb-1">
                                            <small class="text-muted">
                                                <?= $submission->bulan ?> <?= $submission->tahun ?>
                                            </small>
                                        </p>
                                        <span class="badge 
                                            <?= $submission->status == 'approved' ? 'bg-success' : '' ?>
                                            <?= $submission->status == 'rejected' ? 'bg-danger' : '' ?>
                                            <?= $submission->status == 'submitted' ? 'bg-warning text-dark' : '' ?>
                                            <?= $submission->status == 'draft' ? 'bg-secondary' : '' ?>
                                        ">
                                            <?= strtoupper($submission->status) ?>
                                        </span>
                                    </div>
                                    <a href="<?= base_url('berkas/detail/' . $submission->id) ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Filter function
function filterDashboard() {
    const tahun = document.getElementById('yearFilter').value;
    const unit = document.getElementById('unitFilter') ? document.getElementById('unitFilter').value : '';
    
    let url = '<?= base_url('berkas/dashboard') ?>?tahun=' + tahun;
    if (unit) {
        url += '&unit_id=' + unit;
    }
    
    window.location.href = url;
}

function resetFilter() {
    window.location.href = '<?= base_url('berkas/dashboard') ?>';
}

// Initialize chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('progressChart').getContext('2d');
    const chartData = <?= json_encode($chart_data) ?>;
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Total Berkas',
                    data: chartData.total,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Disetujui',
                    data: chartData.approved,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Berkas'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        }
    });
});
</script>

<style>
.progress {
    min-width: 100px;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
</style>