<?php
// print_r($pegawai_all);
// echo br();
// echo $jabatan_id;
$user_data = $this -> session -> userdata();
$nip_user = $user_data['nip'];
$jabatan_id_user = $user_data['jabatan_id'];
$dropdown_bulan = $this -> Absen_model -> dropdown_bulan();
// print_r($dropdown_bulan);
// print_r($jabatan_bawahan);
?>
<div class="col-1"></div>
<div class="col-10">
  
  <div class=" row hidden-print">
    <div class="col-md-1 col-sm-1">
        <label class="form-control" for="">Bulan</label>
    </div>
    <div class="col-md-3 col-sm-5">
      <select  class="form-control" onchange="window.open(this.options[this.selectedIndex].value,'_top')">
      <?php
      foreach ($dropdown_bulan as $drb) {
      ?>
        <option 
              value="<?php 
                  echo base_url('/'. $this -> uri -> segment(1) . '/'. $this -> uri -> segment(2) . '/' . $this -> uri -> segment(3) . '/'. $drb['tahun'] . '/'. $drb['bulan']);
              ?>"
              <?php if ($drb['bulan']==$bulan AND $drb['tahun']==$tahun) { echo "selected";}?>
              >
                <?php echo $drb['lengkap'];?>
        </option>
      <?php
      }

      ?>

      </select>
      <!--  -->
    </div>
  </div>
   <div class=" row hidden-print">
    <div class="col-md-1 col-sm-1">
      <label class="form-control" for="">ASN</label> 
    </div>
    <div class="col-md-7 col-sm-10">
      <select class="form-control" onchange="window.open(this.options[this.selectedIndex].value,'_top')">
        <optgroup label="user">
              <option 
              value="<?php 
                  echo base_url('/'. $this -> uri -> segment(1) . '/'. $this -> uri -> segment(2) . '/' . $user_data['nip']. '/' . $this -> uri -> segment(4). '/'. $this -> uri -> segment(5).'/');
              ?>"
              <?php if ($user_data["nip"]==$nip) { echo "selected ";}?>
              >
                <?php echo $user_data["nama"];?> (<?php echo $user_data["nip"];?>)
              </option>
            

        </optgroup>

      <?php
      // if ($user_data['admin_kabupaten']>0 ) {
      if ($user_data['admin_unit']>0 ) {
      ?>
        <optgroup label="lainnya">
        <?php
          foreach ($pegawai_all as $pegall)
          {
            if ($user_data['admin_unit'] > 0 AND $pegall->nip != $nip_user) {
            ?>
              <option 
              value="<?php 
                  echo base_url('/'. $this -> uri -> segment(1) . '/'. $this -> uri -> segment(2) . '/' . $pegall->nip. '/' . $this -> uri -> segment(4). '/'. $this -> uri -> segment(5).'/');
              ?>"
              <?php if ($pegall->nip==$nip) { echo "selected ";}?>
              >
                <?php echo $pegall->nama;?> (<?php echo $pegall->nip;?>)
              </option>
            <?php
          }
          }
        ?>
        </optgroup>
      <?php
      }
      ?>

      </select>
    </div>
  </div>
   <div class="row hidden-print">
    <div class="col-xs-12 col-md-12 text-right">
                          <button type="button" class='btn <?php  if($update==1){echo "btn-default";} else {echo "btn-primary";} ?>  btn-xs' data-toggle="modal" data-target="#update_" title="update">UPDATE DATA ABSEN</button>


                          <div class="modal fade" id="update_" tabindex="-1" role="dialog" aria-lebelledby="update_">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <?php
                                // if ($kbll -> jml == 0) {
                                ?>
                                <div class="modal-header bg-success-800">
                                <h6 class="modal-title" id="update_">Update data absen</h6>
                                </div>
                                <div class="modal-body text-left">
                                <!-- <h6> -->
                                  Update data absen untuk melakukan perhitungan data dari mesin absen dan bila telah melakukan update data izin, sakit, dinas luar dsb. <br/>
                                  Proses ini membutuhkan waktu yang agak lama, mohon bersabar.
                                  <!-- Yakin melakukan update data? -->
                                <!-- </h6> -->
                                </div>
                                <div class="modal-footer">        
                                <a class="btn  btn-success  btn-xs" href="<?php
                                echo base_url('absensi/proses_sppd/').$nip.'/'.$tahun.'/'.$bulan;
                                // echo current_url().'?update=1';
                                ?>" role="botton">Update</a>
                                <button type="button" class="btn btn-success  btn-xs" data-dismiss="modal">Batal</button>
                                </div>
                                </div>
                            </div>
                          </div>          
    </div>

</div>
</div>
<div class="col-1"></div>
