    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo isset($dataform['jabatan_id']) && $dataform['jabatan_id'] != '' ? 'Edit' : 'Tambah'; ?> Jabatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('jabatan'); ?>">Daftar Jabatan</a></li>
              <li class="breadcrumb-item active"><?php echo isset($dataform['jabatan_id']) && $dataform['jabatan_id'] != '' ? 'Edit' : 'Tambah'; ?></li>
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
                            <h3 class="card-title"><?php echo isset($dataform['jabatan_id']) && $dataform['jabatan_id'] != '' ? 'Edit' : 'Tambah'; ?> Data Jabatan</h3>
                        </div>
                        <div class="card-body">
                            <?php 
                            $ti = 1; // Tab index counter 

                            // Menentukan URL action form berdasarkan $act
                            if ($act == 'edit') {
                                $action_url = base_url('jabatan/crud/edit/' . $dataform['unit_id'] . '/' . $dataform['jabatan_id']);
                            } else {
                                $action_url = base_url('jabatan/crud/tambah/' . $dataform['unit_id']);
                            }
                            ?>
                            <form action="<?php echo $action_url; ?>" method="post" accept-charset="utf-8">
                                <?php if (!empty($errordata)): ?>
                                    <div class="alert alert-danger">
                                        * error : <?php echo $errordata[0]; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group row">
                                    <label for="opd" class="col-sm-2 col-form-label">OPD</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static"><strong><?php echo isset($unit_info['unit_nama']) ? $unit_info['unit_nama'] : ''; ?></strong></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jabatan_nama" class="col-sm-2 col-form-label">Nama Jabatan</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="jabatan_nama" class="form-control" tabindex="<?php echo $ti++; ?>" value="<?php echo htmlspecialchars($dataform['jabatan_nama']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jabatan_status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="jabatan_status" id="jabatan_status" class="form-control">
                                        <?php 
                                        $status_options = ['Definitif', 'Pjb', 'Plt', 'Plh']; 
                                        $status_sekarang = $dataform['jabatan_status'] ?? 'Definitif';

                                        foreach ($status_options as $status) : ?>
                                            <option value="<?= $status ?>" <?= ($status == $status_sekarang) ? 'selected' : '' ?>>
                                                <?= $status ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jabatan_grup" class="col-sm-2 col-form-label">Nama Grup</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="jabatan_grup" class="form-control" tabindex="<?php echo $ti++; ?>" value="<?php echo htmlspecialchars($dataform['jabatan_grup']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jabatan_jenis_id" class="col-sm-2 col-form-label">Jenis Jabatan</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" tabindex="<?php echo $ti++; ?>" name="jabatan_jenis_id">
                                            <option value="0">-- Pilih Jenis Jabatan --</option>
                                            <?php foreach($kode_jabatan_all as $kjll): ?>
                                                <option value="<?php echo $kjll->jabatan_jenis_id; ?>" <?php if ($dataform['jabatan_jenis_id'] == $kjll->jabatan_jenis_id) echo "selected"; ?>>
                                                    <?php echo $kjll->jabatan_jenis_nama; ?>
                                                    <?php if(isset($kjll->jabatan_jenis_eselon)) { echo " / " . $kjll->jabatan_jenis_eselon; } ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pejabat" class="col-sm-2 col-form-label">Pejabat</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input rad" type="radio" name="definitif" id="definitif1" value="1" checked="checked">
                                            <label class="form-check-label" for="definitif1">Pilih Non Jabatan</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input rad" type="radio" name="definitif" id="definitif2" value="2">
                                            <label class="form-check-label" for="definitif2">Input NIP</label>
                                        </div>
                                        
                                        <div id="inputnip" style="display:none; margin-top:10px;">
                                            <input type="text" name="plt_nip" class="form-control" placeholder="MASUKKAN NIP">
                                        </div>

                                        <div id="pilpejabat" style="margin-top:10px;">
                                            <select class="form-control" tabindex="<?php echo $ti++; ?>" name="jabatan_nip">
                                                <option value="0">-- Tanpa Pejabat --</option>
                                                <?php foreach($pegawai_all as $p): ?>
                                                    <?php if (empty($p->jabatan_nama) || $dataform['jabatan_nip'] == $p->nip): ?>
                                                        <option value="<?php echo $p->nip; ?>" <?php if ($dataform['jabatan_nip'] == $p->nip) echo "selected"; ?>>
                                                            <?php echo $p->nama . " - " . $p->nip; ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                
                                                <optgroup label="Pegawai Tanpa Jabatan">
                                                    <?php foreach($pegawai_tanpa_jabatan as $ptj): ?>
                                                        <option value="<?php echo $ptj->nip; ?>">
                                                            <?php echo $ptj->nama . " - " . $ptj->nip; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jabatan_nilai" class="col-sm-2 col-form-label">Nilai Jabatan</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="jabatan_nilai" class="form-control" tabindex="<?php echo $ti++; ?>" value="<?php echo htmlspecialchars($dataform['jabatan_nilai']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jabatan_atasan_id" class="col-sm-2 col-form-label">Atasan Langsung</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" tabindex="<?php echo $ti++; ?>" name="jabatan_atasan_id">
                                            <option value="0">-- Pilih Atasan --</option>
                                            <option value="1000001" <?php if ($dataform['jabatan_atasan_id'] == 1000001) echo "selected"; ?>>Sekretaris Daerah</option>
                                            <?php foreach($jabatan_all as $ja): ?>
                                                <?php if ($ja->jabatan_id != '1000001'): ?>
                                                <option value="<?php echo $ja->jabatan_id; ?>" <?php if ($dataform['jabatan_atasan_id'] == $ja->jabatan_id) echo "selected"; ?> title="<?php echo htmlspecialchars($ja->jabatan_nama); ?>">
                                                    <?php echo htmlspecialchars($ja->jabatan_nama); ?>
                                                    (<?php echo htmlspecialchars($ja->nama_pegawai); ?>)
                                                </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <?php if (isset($user_data['admin_kabupaten']) && $user_data['admin_kabupaten'] > 0): ?>
                                <div class="form-group row">
                                    <label for="tpp" class="col-sm-2 col-form-label">Pembayaran TPP</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tpp" id="tpp1" value="1" <?php if($dataform['tpp'] == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="tpp1">100 %</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tpp" id="tpp2" value="2" <?php if($dataform['tpp'] == 2) echo 'checked'; ?>>
                                            <label class="form-check-label" for="tpp2">20 %</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tpp" id="tpp0" value="0" <?php if($dataform['tpp'] == 0) echo 'checked'; ?>>
                                            <label class="form-check-label" for="tpp0">0 %</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="hak_akses" class="col-sm-2 col-form-label">Hak Akses</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="admin_unit" id="admin_unit" value="1" <?php if(!empty($dataform['admin_unit'])) echo 'checked'; ?>>
                                            <label class="form-check-label" for="admin_unit">Admin OPD</label>
                                        </div>
                                        <?php if (isset($user_data['admin_kabupaten']) && $user_data['admin_kabupaten'] > 1): ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="admin_kabupaten" id="admin_kabupaten" value="1" <?php if(!empty($dataform['admin_kabupaten'])) echo 'checked'; ?>>
                                            <label class="form-check-label" for="admin_kabupaten">Admin Kabupaten</label>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <input type="hidden" name="jabatan_id" value="<?php echo $dataform['jabatan_id']; ?>">
                                        <input type="hidden" name="unit_id" value="<?php echo $dataform['unit_id']; ?>">
                                        
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo ($act == 'edit') ? 'Update Data' : 'Simpan Data Baru'; ?>
                                        </button>
                                        <a href="<?php echo base_url('jabatan/index/' . $dataform['unit_id']); ?>" class="btn btn-default">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script src="<?php echo base_url('assets/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Initial check for radio button state on page load
    var selectedDefinitif = $('input[type=radio][name=definitif]:checked').val();
    if (selectedDefinitif == '1') { // Definitif
        $('#pilpejabat').show();
        $('#inputnip').hide();
    } else if (selectedDefinitif == '2') { // PLT/PLS
        $('#pilpejabat').hide();
        $('#inputnip').show();
    }

    $('input[type=radio][name=definitif]').change(function() {
        if (this.value == '1') { // Definitif
            $('#pilpejabat').show();
            $('#inputnip').hide();
            // Kosongkan NIP PLT agar tidak terkirim
            $('#inputnip input[name="plt_nip"]').val('');
        } else if (this.value == '2') { // PLT/PLS
            $('#pilpejabat').hide();
            $('#inputnip').show();
            // Kosongkan pilihan dropdown agar tidak terkirim
            $('#pilpejabat select[name="jabatan_nip"]').val('0');
        }
    });
});
</script>