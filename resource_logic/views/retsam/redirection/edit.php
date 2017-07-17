<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header clearfix">
		<h1><i class="fa fa-ellipsis-h"></i> <?php echo $meta_title;?></h1>
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
						echo form_open_multipart(current_url(),'class="inp"');
						?>
						
						<div class="form-group">
							<label>From URL</label>
							<div class="input-group">
								<span class="input-group-addon" style="background-color: #eee;"><?php echo base_url('r/');?></span>
								<input value="<?php echo $detail->from_url;?>" name="from_url" class="form-control" type="text" data-validation="required custom length" data-validation-regexp="^([a-zA-Z0-9_\-]+)$" data-validation-length="2-100">
							</div>
						</div>
						
						<div class="form-group">
							<label>Redirect to URL</label>
							<input value="<?php echo $detail->to_url;?>" name="to_url" class="form-control" type="text" data-validation="required length" data-validation-length="max255">
						</div>
						
						<div class="box-footer text-center">
							<button type="submit" name="form_submit" value="save" class="btn btn-success nextinp">Validate & Save AS</button>
							<a href="<?php echo base_url(DIRADMIN.'/'.$this->router->fetch_class().'/home');?>" class="btn btn-warning">Back to Home</a>
						</div><!-- /.box-footer -->
						<?php echo form_close();?>
						
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->