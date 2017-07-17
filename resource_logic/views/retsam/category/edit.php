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
										<option value="unfeatured"<?php echo ($detail->is_featured == 'unfeatured' ? ' selected="selected"':'');?>>No, don't show in homepage</option>
										<option value="featured"<?php echo ($detail->is_featured == 'featured' ? ' selected="selected"':'');?>>Yes, show in homepage</option>
									</select>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group clearfix">
									<label>Publish</label>
									<select name="published" class="form-control" data-validation="required">
										<option value="publish"<?php echo ($detail->published == 'publish' ? ' selected="selected"':'');?>>Publish</option>
										<option value="unpublish"<?php echo ($detail->published == 'unpublish' ? ' selected="selected"':'');?>>Unpublish</option>
									</select>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group clearfix">
									<label>Sort Number</label>
									<input value="<?php echo $detail->ordered;?>" name="ordered" class="form-control" type="number" onKeyPress="return numbersonly(this, event)" data-validation="required">
								</div>
							</div>
						</div>
						
						<?php
						foreach($language AS $red){
							echo form_hidden('translate_id_'.$red->language_slug, $translate[$red->language_slug]['translate_id']);
							
							echo '<div class="well well-sm">';
								echo '<p class="well well-sm bg-orange">'.$red->title.' Language</p>';
								echo '<div class="form-group">
									<label>Title</label>
									<input value="'.(isset($translate[$red->language_slug]) ? $translate[$red->language_slug]['title'] : '').'" name="title_'.$red->language_slug.'" class="form-control" type="text" onKeyPress="return textsonly(this, event)" data-validation="required">
								</div>
								<div class="form-group">
									<label>Description</label>
									<textarea name="description_'.$red->language_slug.'" class="form-control editor" type="text" onKeyPress="return textsonly(this, event)" data-validation="required">'.(isset($translate[$red->language_slug]) ? $translate[$red->language_slug]['description'] : '').'</textarea> 
								</div>';
							echo '</div>';
						}
						?>
						
						<div class="form-group">
							<label for="UploadFile">Image</label>
							<?php
							echo '<p><img width="200px" class="img-responsive" src="'.base_url('storage/category/'.$detail->cover).'"></p>';
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