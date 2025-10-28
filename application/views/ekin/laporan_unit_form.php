<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Penilaian per Unit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">E-Kinerja</a></li>
                    <li class="breadcrumb-item active">Laporan per Unit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Filter Form -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Filter Laporan</h3>
                <div class="card-tools">
                    <a href="<?php echo site_url('ekin/sinkron_penilaian_unit_aksi?unit_id=' . $selected_unit . '&tahun=' . $selected_tahun . '&bulan=' . $selected_bulan); ?>" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin sinkronisasi semua penilaian untuk unit ini pada periode yang dipilih? Proses ini mungkin memakan waktu.')"><i class="fas fa-sync-alt"></i> Sinkronisasi Unit</a>
                </div>
            </div>
            <form id="filter-form" action="<?php echo site_url('ekin/laporan_per_unit'); ?>" method="get">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit_id">Unit Kerja</label>
                                <select name="unit_id" id="unit_id" class="form-control" required>
                                    <option value="">-- Pilih Unit Kerja --</option>
                                    <?php foreach($units as $unit): ?>
                                        <option value="<?php echo $unit->unit_id; ?>" <?php echo ($selected_unit == $unit->unit_id) ? 'selected' : ''; ?> >
                                            <?php echo $unit->unit_nama; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control" value="<?php echo $selected_tahun; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    <?php
                                    $bulan_array = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    foreach($bulan_array as $num => $name): ?>
                                        <option value="<?php echo $num; ?>" <?php echo ($selected_bulan == $num) ? 'selected' : ''; ?> >
                                            <?php echo $name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <?php if (isset($laporan_data)): ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hasil Laporan Penilaian</h3>
                <?php if (isset($last_update) && $last_update): ?>
                    <div class="card-tools">
                        <span class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Update Terakhir: <?php echo date('d-m-Y H:i:s', strtotime($last_update)); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (empty($laporan_data)): ?>
                    <div class="alert alert-warning">Data tidak ditemukan untuk filter yang dipilih.</div>
                <?php else: ?>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Hasil Akhir</th>
                                <th>Waktu Dinilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($laporan_data as $row): ?>
                                <tr>
                                    <td class="text-right"><?php echo $no++; ?></td>
                                    <td><?php echo $row->nip; ?></td>
                                    <td><a href="<?php echo base_url('jabatan/detail/' . $row->jabatan_id); ?>"><?php echo $row->nama_pegawai; ?></a></td>
                                    <td><?php echo $row->jabatan; ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($row->hasil_akhir)): ?>
                                            <span class="badge badge-info"><?php echo $row->hasil_akhir; ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Kosong</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $row->waktu_dinilai; ?></td>
                                    <td class="text-center">
                                        <?php if (empty($row->hasil_akhir)):
                                            $sync_url = site_url('ekin/sinkron_per_pegawai?nip=' . $row->nip . '&periode_id=' . $selected_periode_id . '&unit_id=' . $selected_unit . '&tahun=' . $selected_tahun . '&bulan=' . $selected_bulan);
                                            echo '<a href="' . $sync_url . '" class="btn btn-xs btn-success"><i class="fas fa-sync-alt"></i></a>';
                                        endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
    <?php
        // echo "selected_periode_id: ";
        // var_dump($selected_periode_id);
        // echo "laporan_data count: " . count($laporan_data);
    ?>    
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filter-form');
    const inputs = form.querySelectorAll('select, input');

    inputs.forEach(input => {
        input.addEventListener('change', function() {
            // Check if all required fields have a value
            const unitId = document.getElementById('unit_id').value;
            const tahun = document.getElementById('tahun').value;
            const bulan = document.getElementById('bulan').value;

            if (unitId && tahun && bulan) {
                form.submit();
            }
        });
    });
});
</script>