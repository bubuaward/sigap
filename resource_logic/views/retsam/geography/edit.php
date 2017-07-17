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
				<!-- general form elements disabled -->
				<div class="box box-success">
					<div class="box-body">
					<?php
					echo (validation_errors() ? '<div class="well well-sm">'.validation_errors().'</div>' : '');
					echo form_open(current_url(),'class="inp"');
					?>
						<!-- text input -->
						<div class="form-group">
							<label>Geography Name</label>
							<div class="input-group">
								<input value="<?php echo $detail->geography_name;?>" name="title" class="form-control" type="text" onKeyPress="return textsonly(this, event)" data-validation="required">
								<div class="input-group-btn">
									<button type="submit" name="form_submit" value="save" class="btn btn-success nextinp">Validate & Save AS</button>
								</div> 
							</div>
						</div>
					<?php echo form_close();?>
						
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->