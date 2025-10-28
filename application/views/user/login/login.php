<?php defined('BASEPATH') OR exit('No direct script access allowed'); 



?>
	<div class="row mt-5 mb-5">
		<div class="col-md-3"></div>
			
		<div class="col-md-6 mt-5">
		<div class="card card-body" style="border-radius: 30px 30px 30px 30px;">
			<div class="page-header text-center">
				<h1 style="color: #449165; font-family:Century-gothic;">Login</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="nip" style="color:#449165; font-family: Century-gothic;">NIP</label><input type="text" class="form-control" id="nip" name="nip" placeholder="NIP Anda">
				</div>
				<div class="form-group">
					<label for="password" style="color:#449165; font-family: Century-gothic; ">Password</label><input type="password" class="form-control" id="password" name="password" placeholder="Password Anda">
				</div>
				<?php if (validation_errors()) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert">
							<?= validation_errors() ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if (isset($error)) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert">
							<?= $error ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="form-group">
					<input type="submit" class="btn btn-success text-center" value="Login">
				</div>
			<?php form_close();?>
		</div>
		</div>
		<div class="col-md-3"></div>
		</div>
		<?php
		// echo  SITE_API.'user_auth/?username='.'&password=';

		?>
	<!--</div>--><!-- .row -->
<!--</div>--><!-- .container -->