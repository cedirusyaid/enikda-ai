<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>LOGIN</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login untuk masuk aplikasi</p>
    <?= form_open() ?>

    <!-- <form action="../../index2.html" method="post"> -->
      <div class="form-group has-feedback">
        <!-- <input type="NIP" class="form-control" placeholder="Email"> -->
          <label for="nip">NIP</label>
          <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP Anda"  required="required">
        <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
      </div>
      <div class="form-group has-feedback">
          <label for="password">Password</label><input type="password" class="form-control" id="password" name="password" placeholder="Password Anda" required="required">
        <!-- <input type="password" class="form-control" placeholder="Password"> -->
        <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
      </div>
      <div class="form-group has-feedback">
          <label for="aplikasi">Aplikasi</label>
          <select name="aplikasi" id="aplikasi" class="form-control" required="required">
            <option value="">-Pilih Aplikasi-</option>
            <option value="simpeg">Simpeg</option>
            <option value="enikda">Enikda</option>
          </select>

      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>


  </div>
  <!-- /.login-box-body -->
</div>