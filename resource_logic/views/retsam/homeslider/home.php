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
		"order": [[ 3, "desc" ]],
		'sAjaxSource': "<?php echo base_url(DIRADMIN.'/homeslider/ajax_master_datatable'); ?>",
		"columns": [
			{ "data": "image" },
			{ "data": "title" },
			{ "data": "ordered" },
			{ "data": "created" },
			{ "data": "published" },
			{ "data": "actions" },
		]
	});
});
</script>

<!-- Content Wrapper -->
<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header clearfix">
		<h1 class="clearfix"><i class="fa fa-database"></i> <?php echo $meta_title;?>
		<a href="<?php echo base_url(DIRADMIN.'/homeslider/plus');?>" class="btn btn-success btn-sm pull-right" target="_self"><i class="fa fa-plus-circle"></i> Add Data</a></h1>
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
									<th>Image</th>
									<th>Title</th>
									<th>Ordered</th>
									<th>Created</th>
									<th>Publish</th>
									<th width="72px">Action</th>
								</tr>
							</thead>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->