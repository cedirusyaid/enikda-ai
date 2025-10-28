<div class="row">
	<div class="col-sm-3"></div>	
	<div class="col-sm-6">
		<h3 class="text-center">TABEL USER</h3>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>NO</th>
					<th>USERNAME</th>
					<th>EMAIL</th>
					<th>STATUS</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
				// print_r($user_all);
				foreach ($user_all as $usall) {
				?>
				<tr>
						<td align="right"><?php echo $i.".";?></td>
						<td><?php echo $usall->username;?></td>
						<td><?php echo $usall->email;?></td>
						<td align="center">
							<?php

							if($usall->is_admin>0) {echo "admin";} else {echo "user";} 
							?>
						</td>
				</tr>
				<?php
				$i++;
				}
				?>
			</tbody>
			



		</table>



	</div>
</div>