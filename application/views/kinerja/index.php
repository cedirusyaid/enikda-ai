    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Rekap Kinerja</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Rekap Kinerja</li>
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
                            <h3 class="card-title">Data Rekap Kinerja</h3>
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
                                        <th>Bobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rekap_kinerja)): ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($rekap_kinerja as $kinerja): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $kinerja->nip; ?></td>
                                                <td><?php echo $kinerja->nama_pegawai; ?></td>
                                                <td><?php echo $kinerja->bobot; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data rekap kinerja.</td>
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
