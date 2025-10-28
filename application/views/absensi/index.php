    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Rekap Absensi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Rekap Absensi</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Rekap Absensi</h3>
                        </div>
                        <div class="card-body">
                            <form class="form-inline mb-3">
                                <div class="form-group mr-2">
                                    <label for="unit_id" class="mr-2">Unit Kerja:</label>
                                    <select name="unit_id" id="unit_id" class="form-control" onchange="filterChanged()">
                                        <option value="">-- Pilih Unit Kerja --</option>
                                        <?php foreach ($unit_all as $unit): ?>
                                            <option value="<?php echo $unit->unit_id; ?>" <?php echo ($selected_unit_id == $unit->unit_id) ? 'selected' : ''; ?>><?php echo $unit->unit_nama; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mr-2">
                                    <label for="tahun" class="mr-2">Tahun:</label>
                                    <select name="tahun" id="tahun" class="form-control" onchange="filterChanged()">
                                        <?php foreach ($tahun_options as $tahun_opt): ?>
                                            <option value="<?php echo $tahun_opt; ?>" <?php echo ($selected_tahun == $tahun_opt) ? 'selected' : ''; ?>><?php echo $tahun_opt; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mr-2">
                                    <label for="bulan" class="mr-2">Bulan:</label>
                                    <select name="bulan" id="bulan" class="form-control" onchange="filterChanged()">
                                        <?php foreach ($bulan_options as $key => $bulan_opt): ?>
                                            <option value="<?php echo $key; ?>" <?php echo ($selected_bulan == $key) ? 'selected' : ''; ?>><?php echo $bulan_opt; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </form>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama Pegawai</th>
                                        <!-- <th>Unit Kerja</th> -->
<!--                                         <th>Hadir</th>
                                        <th>Terlambat</th>
                                        <th>Pulang Cepat</th>
                                        <th>Tidak Hadir</th>
                                        <th>Cuti</th>
                                        <th>Sakit</th>
                                        <th>Izin</th> -->
                                        <th>Bobot</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rekap_absen)): ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($rekap_absen as $absen): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $absen->nip; ?></td>
                                                <td><?php echo $absen->nama_pegawai; ?></td>
                                                <!-- <td><?php echo $absen->unit_nama; ?></td> -->
<!--                                                 <td><?php echo $absen->hadir; ?></td>
                                                <td><?php echo $absen->terlambat; ?></td>
                                                <td><?php echo $absen->pulang_cepat; ?></td>
                                                <td><?php echo $absen->tidak_hadir; ?></td>
                                                <td><?php echo $absen->cuti; ?></td>
                                                <td><?php echo $absen->sakit; ?></td>
                                                <td><?php echo $absen->izin; ?></td> -->
                                                <td class="text-right"><?php echo number_format($absen->bobot,2); ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-sm">
                                                        <a href="<?php echo site_url('absensi/bulanan/' . $absen->nip . '/' . $selected_tahun . '/' . $selected_bulan); ?>" class="btn btn-info" title="Detail">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                        <a href="<?php echo site_url('absensi/log_absen/' . $absen->nip . '/' . $selected_tahun . '/' . $selected_bulan); ?>" class="btn btn-primary" title="Log Absen">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="11" class="text-center">Tidak ada data rekap absensi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
function filterChanged() {
    var unit_id = document.getElementById('unit_id').value;
    var tahun = document.getElementById('tahun').value;
    var bulan = document.getElementById('bulan').value;
    window.location.href = "<?php echo site_url('absensi/index'); ?>/" + unit_id + "/" + tahun + "/" + bulan;
}
</script>