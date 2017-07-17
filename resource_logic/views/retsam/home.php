<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!-- Content Wrapper -->
<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header clearfix">
		<h1 class="clearfix"><i class="fa fa-database"></i> Dashboard</h1>
	</section>

	<!-- Main content -->
	<section class="content clearfix">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1>Welcome,  <?php echo $this->session->userdata['isloginaccount']['fullname'];?></h1>
			</div>
		</div><!-- /.row -->	
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->