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
						
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group clearfix">
									<label>Is Featured</label>
									<select name="is_featured" class="form-control" data-validation="required">
										<option value="unfeatured">UnFeatured</option>
										<option value="featured">Featured</option>
									</select>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group clearfix">
									<label>Publish</label>
									<select name="published" class="form-control" data-validation="required">
										<option value="publish">Publish</option>
										<option value="unpublish">Unpublish</option>
									</select>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group clearfix">
									<label>Type Media</label>
									<select name="type" class="form-control" data-validation="required" onChange="return changetype(this, event);">
										<option value="image">Image</option>
										<option value="video">Youtube</option>
									</select>
								</div>
							</div>
						</div>
						
						<?php
						foreach($language AS $red){
							echo '<div class="well well-sm">';
								echo '<p class="well well-sm bg-orange">'.$red->title.' Language</p>';
								echo '<div class="form-group">
									<label>Title</label>
									<input name="title_'.$red->language_slug.'" class="form-control" type="text" onKeyPress="return textsonly(this, event)" data-validation="required">
								</div>
								<div class="form-group">
									<label>Teaser</label>
									<textarea name="teaser_'.$red->language_slug.'" class="form-control" type="text" onKeyPress="return textsonly(this, event)" data-validation="required"></textarea> 
								</div>
								<div class="form-group">
									<label>Description</label>
									<textarea name="description_'.$red->language_slug.'" class="form-control editor" type="text" data-validation="required"></textarea> 
								</div>';
							echo '</div>';
						}
						?>
						
						<div class="form-group">
							<label for="UploadFile">Image Cover</label>
							<?php
							echo form_upload('cover', '','data-validation="required dimension mime size" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-dimension="min150x150"');?>
							<p class="help-block">Max. 2MB (.jpg, .jpeg, .png)</p>
							<p class="help-block">Dimension min 150x150 pixel</p>
						</div>
						<div class="form-group" id="video" style="display: none;">
							<label>ID Youtube (Misal: https://www.youtube.com/watch?v=<span style="color: red">xYT2XXXXX</span>)</label>
							<input name="video" class="form-control" type="text" placeholder="xYT2XXXXX" onChange="return youtubegetid(this, event);">
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


<script>
function changetype(identifier){
	var type = $(identifier).val();
	if(type !== 'image'){
		$('#video').show();
		$('input[name=video]').attr('data-validation','required');
	}else{
		$('#video').hide();
		$('input[name=video]').removeAttr('data-validation');
	}
}
</script>