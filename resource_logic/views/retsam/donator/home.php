<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
$(document).ready(function() {
	$('#datatablemaster').DataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sServerMethod": "GET",
		"bDeferRender": true,
		"sPaginationType": "full_numbers",
		"order": [[ 5, "desc" ]],
		'sAjaxSource': "<?php echo base_url(DIRADMIN.'/donator/ajax_master_datatable'); ?>",
		"columns": [
			{ "data": "first_name" },
			{ "data": "email" },
			{ "data": "phone" },
			{ "data": "status" },
			{ "data": "total" },
			{ "data": "created" },
			{ "data": "agent" }
		]
	});
});
</script>

<!-- Content Wrapper -->
<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header clearfix">
		<h1 class="clearfix"><i class="fa fa-database"></i> <?php echo $meta_title;?></h1>
	</section>

	<!-- Main content -->
	<section class="content clearfix">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-sm-12">
				<!-- general form elements disabled -->
				<div class="box box-success">
					
					<div class="box-body">
						<table class="table table-striped table-hover table-condosed table-bordered dt-responsive display" id="datatablemaster">
							<thead>
								<tr>
									<th>Fullname</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Status</th>
									<th>Total</th>
									<th>Created</th>
									<th>Agent</th>
								</tr>
							</thead>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->