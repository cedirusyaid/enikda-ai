<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $judul; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('pegawai'); ?>">Data Pegawai</a></li>
                    <li class="breadcrumb-item active"><?php echo ucfirst($action); ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Pegawai</h3>
                    </div>
                    <form action="<?php echo site_url('pegawai/crud/' . $action . '/' . ($pegawai->nip ?? '')); ?>" method="post">
                        <div class="card-body">
                            <?php echo validation_errors('<div class="alert alert-danger">' , '</div>'); ?>
                            
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" name="nip" id="nip" value="<?php echo set_value('nip', $pegawai->nip ?? ''); ?>" <?php echo ($action == 'edit') ? 'readonly' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label for="nip_lama">NIP Lama</label>
                                <input type="text" class="form-control" name="nip_lama" id="nip_lama" value="<?php echo set_value('nip_lama', $pegawai->nip_lama ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo set_value('nama', $pegawai->nama ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="nomor_hp">Nomor HP</label>
                                <input type="text" class="form-control" name="nomor_hp" id="nomor_hp" value="<?php echo set_value('nomor_hp', $pegawai->nomor_hp ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            </div>
                            <div class="form-group">
                                <label for="unit_id_">Unit ID</label>
                                <input type="text" class="form-control" name="unit_id_" id="unit_id_" value="<?php echo set_value('unit_id_', $pegawai->unit_id_ ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="pangkat_id">Pangkat ID</label>
                                <input type="text" class="form-control" name="pangkat_id" id="pangkat_id" value="<?php echo set_value('pangkat_id', $pegawai->pangkat_id ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="pangkat_tmt">Pangkat TMT</label>
                                <input type="date" class="form-control" name="pangkat_tmt" id="pangkat_tmt" value="<?php echo set_value('pangkat_tmt', $pegawai->pangkat_tmt ?? ''); ?>">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="pangkat_mk_thn">Masa Kerja (Tahun)</label>
                                    <input type="number" class="form-control" name="pangkat_mk_thn" id="pangkat_mk_thn" value="<?php echo set_value('pangkat_mk_thn', $pegawai->pangkat_mk_thn ?? ''); ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pangkat_mk_bln">Masa Kerja (Bulan)</label>
                                    <input type="number" class="form-control" name="pangkat_mk_bln" id="pangkat_mk_bln" value="<?php echo set_value('pangkat_mk_bln', $pegawai->pangkat_mk_bln ?? ''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="npwp">NPWP</label>
                                <input type="text" class="form-control" name="npwp" id="npwp" value="<?php echo set_value('npwp', $pegawai->npwp ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="rekening">Rekening</label>
                                <input type="text" class="form-control" name="rekening" id="rekening" value="<?php echo set_value('rekening', $pegawai->rekening ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="status_pns">Status PNS</label>
                                <select name="status_pns" id="status_pns" class="form-control">
                                    <option value="1" <?php echo set_select('status_pns', '1', ($pegawai->status_pns ?? '1') == '1'); ?>>Aktif</option>
                                    <option value="0" <?php echo set_select('status_pns', '0', ($pegawai->status_pns ?? '') == '0'); ?>>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?php echo site_url('pegawai'); ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>