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
						<table class="table table-striped table-hover table-condosed table-bordered dt-responsive display" id="datatablemaster">
							<tbody>
								<?php
								foreach($result AS $no => $red){
									if($no % 2 == 0){
										echo '<tr>';
									}
									
									echo '<td width="50px">'.strtoupper($red->language_slug).'</td><td>
									<p>'.ucwords(str_replace('_',' ', $red->variable_sitemap)).'</p>
									<textarea name="'.$red->sitemap_id.'" class="form-control" type="text" data-validation="required">'.$red->word.'</textarea></td>';
									
									if(($no+1) % 2 == 0){
										echo '</tr>';
									}
								}
								?>
							</tbody>
						</table>
						
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