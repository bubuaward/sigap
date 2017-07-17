<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header clearfix">
		<h1><i class="fa fa-ellipsis-h"></i> <?php echo $meta_title.': '.$translate['id']['title'];?></h1>
	</section>

	<!-- Main content -->
	<section class="content clearfix">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-sm-6">
				<!-- general form elements disabled -->
				<div class="box box-success">
					<div class="box-body">
						<?php
						echo (validation_errors() ? '<div class="well well-sm">'.validation_errors().'</div>' : '');
						echo form_open_multipart(current_url(),'class="inp"');
						?>
						<div class="form-group">
							<label>Copyright</label>
							<input name="copyright" class="form-control" type="text" data-validation="required">
						</div>
						<div class="form-group">
							<label>ID Youtube (Misal: https://www.youtube.com/watch?v=<span style="color: red">xYT2XXXXX</span>)</label>
							<input name="video" class="form-control" type="text" placeholder="xYT2XXXXX">
						</div>
						<div class="form-group">
							<label for="UploadFile">Upload Image <small>Max. 2MB (.jpg, .jpeg, .png) & Dimension min 150x150 pixel</small></label>
							<?php
							echo form_upload('cover', '','data-validation="required dimension mime size" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-dimension="min150x150"');?>
						</div>
						
						<div class="box-footer text-center">
							<button type="submit" name="form_submit" value="save" class="btn btn-success nextinp">Save AS</button>
						</div><!-- /.box-footer -->
						<?php echo form_close();?>
						
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
			
			<?php
			if($list){
				foreach($list AS $no => $red){
					echo '<div class="col-sm-3">
						<div class="box box-success">
							<div class="box-body">
								<h5><a href="'.base_url(DIRADMIN.'/article/media_delete/'.auto_url($red->media_id)).'" class="label label-danger pull-right">delete</a>'.($no+1).'] '.($red->video ? 'Video':'Image').($red->copyright ? '<br/> &#169; '.$red->copyright : '').'</h5>
								<img class="img-responsive" src="'.base_url('storage/content/'.$red->cover).'">
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>';
				}
			}
			?>
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->