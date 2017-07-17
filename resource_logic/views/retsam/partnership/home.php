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
		"order": [[ 4, "desc" ]],
		'sAjaxSource': "<?php echo base_url(DIRADMIN.'/partnership/ajax_master_datatable'); ?>",
		"columns": [
			{ "data": "image" },
			{ "data": "url" },
			{ "data": "contact_view" },
			{ "data": "ordered" },
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
				<!-- general form elements disabled -->
				<div class="box box-success">
					<div class="box-body">
						<?php
						echo (validation_errors() ? '<div class="well well-sm">'.validation_errors().'</div>' : '');
						echo form_open_multipart(current_url(),'class="inp"');
						?>
						
						<div class="row">
							<div class="col-sm-7">
								<div class="form-group">
									<label>URL Link</label>
									<input name="url" class="form-control" type="text" data-validation="required">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Ordered</label>
									<input name="ordered" class="form-control" type="text" onKeyPress="return numbersonly(this, event)" data-validation="required">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Show in Contact</label>
									<select name="contact_view" class="form-control" data-validation="required">
										<option value="false">No</option>
										<option value="true">Yes</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="UploadFile">Upload Image <small>Max. 2MB (.jpg, .jpeg, .png) & Dimension min 50x10 pixel</small></label>
							<?php
							echo form_upload('cover', '','data-validation="required dimension mime size" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-dimension="min50x10"');?>
						</div>
						
						<div class="box-footer text-center">
							<button type="submit" name="form_submit" value="save" class="btn btn-success nextinp">Save AS</button>
						</div><!-- /.box-footer -->
						<?php echo form_close();?>
						
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
			
			<div class="col-sm-12">
				<!-- general form elements disabled -->
				<div class="box box-success">
					
					<div class="box-body">
						<table class="table table-striped table-hover table-condosed table-bordered dt-responsive display" id="datatablemaster">
							<thead>
								<tr>
									<th>Cover</th>
									<th>URL</th>
									<th>Contact View</th>
									<th>Ordered</th>
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