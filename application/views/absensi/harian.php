<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $judul; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Absensi Harian</li>
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
                        <h3 class="card-title">
                            Absensi Harian untuk <?php echo $pegawai_info['nama']; ?> - <?php echo $this->Absensi_model->nama_bulan($bulan) . " " . $tahun; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php $this->load->view('absensi/absensi_harian', get_defined_vars()); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
