<?php
$detail_url = site_url('absensi/harian/' . $pegawai->nip . '/' . $selected_tahun . '/' . $selected_bulan);
$log_url = site_url('absensi/log_absen/' . $pegawai->nip . '/' . $selected_tahun . '/' . $selected_bulan);
?>

<div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?php echo ($active_tab == 'harian') ? 'active' : ''; ?>" href="<?php echo $detail_url; ?>">Detail Absensi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($active_tab == 'log') ? 'active' : ''; ?>" href="<?php echo $log_url; ?>">Log Absensi</a>
        </li>
    </ul>
</div>
