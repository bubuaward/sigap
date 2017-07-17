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
		"order": [[ 2, "desc" ]],
		'sAjaxSource': "<?php echo base_url(DIRADMIN.'/location/ajax_master_datatable'); ?>",
		"columns": [
			{ "data": "title" },
			{ "data": "slug" },
			{ "data": "created" },
			{ "data": "actions" },
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
				<div class="box box-success">
					<div class="box-body">
					<?php
					echo (validation_errors() ? '<div class="well well-sm">'.validation_errors().'</div>' : '');
					echo form_open(current_url(),'class="inp"');
					?>
						<!-- text input -->
						<div class="form-group">
							<label>Location Name</label>
							<div class="input-group">
								<input name="title" class="form-control" type="text" onKeyPress="return textsonly(this, event)" data-validation="required">
								<div class="input-group-btn">
									<button type="submit" name="form_submit" value="save" class="btn btn-success nextinp">Validate & Save AS</button>
								</div> 
							</div>
						</div>
					<?php echo form_close();?>
						
					</div><!-- /.box-body -->
				</div><!-- /.box -->
				
				<div class="box box-success">
					
					<div class="box-body">
						<table class="table table-striped table-hover table-condosed table-bordered dt-responsive display" id="datatablemaster">
							<thead>
								<tr>
									<th>Title</th>
									<th>Slug</th>
									<th>Created</th>
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