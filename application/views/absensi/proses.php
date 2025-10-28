<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $judul; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('absensi'); ?>">Rekap Absensi</a></li>
                    <li class="breadcrumb-item active">Proses Absensi</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Pengecualian Absensi</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo site_url('absensi/proses'); ?>" method="get" class="form-inline mb-3">
                            <div class="form-group mr-2">
                                <label for="tahun" class="mr-2">Tahun:</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    <?php foreach ($tahun_options as $tahun_opt): ?>
                                        <option value="<?php echo $tahun_opt; ?>" <?php echo ($selected_tahun == $tahun_opt) ? 'selected' : ''; ?>><?php echo $tahun_opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label for="bulan" class="mr-2">Bulan:</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    <?php foreach ($bulan_options as $key => $bulan_opt): ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($selected_bulan == $key) ? 'selected' : ''; ?>><?php echo $bulan_opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Akhir</th>
                                    <th>Kode</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($exceptions)):
                                    foreach ($exceptions as $exc):
                                ?>
                                        <tr>
                                            <td><?php echo $exc->nip; ?></td>
                                            <td><?php echo $exc->nama_pegawai; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($exc->tgl_mulai)); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($exc->tgl_akhir)); ?></td>
                                            <td><?php echo $exc->kode; ?></td>
                                            <td><?php echo $exc->keterangan; ?></td>
                                        </tr>
                                    <?php 
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pengecualian untuk periode ini.</td>
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