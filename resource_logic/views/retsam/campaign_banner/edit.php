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
							<label>Title</label>
							<input value="<?php echo $detail->title;?>" name="title" class="form-control" type="text" onKeyPress="return textsonly(this, event)" data-validation="required">
						</div>
						
						<div class="form-group">
							<label for="UploadFile">Image</label>
							<?php
							echo '<p><img width="200px" class="img-responsive" src="'.base_url('storage/campaign_banner/'.$detail->cover).'"></p>';
							echo form_upload('cover', '','data-validation="dimension mime size" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-dimension="min150x150"');?>
							<p class="help-block">Max. 2MB (.jpg, .jpeg, .png)</p>
							<p class="help-block">Dimension min 150x150 pixel</p>
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