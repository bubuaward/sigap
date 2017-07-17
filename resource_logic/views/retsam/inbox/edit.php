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
						echo '<div class="well well-sm">
							From: '.$detail->email.' | Fullname: '.$detail->fullname.' | Phone: '.$detail->phone.' | City: '.$detail->city.'<br/>
							Body Message: <br/>
							<blockquote style="font-size: 14px !important;">'.$detail->message.'</blockquote>
						</div>';
						
						echo (validation_errors() ? '<div class="well well-sm">'.validation_errors().'</div>' : '');
						echo form_open(current_url(),'class="inp"');
						echo form_hidden('post_id', enc_dec('e', $detail->inbox_id));
						?>
						<div class="form-group">
							<label>Answer Message</label>
							<textarea name="answer" class="form-control editor" type="text" onKeyPress="return textsonly(this, event)" data-validation="required"><?php echo $detail->answer;?></textarea> 
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
		$('#covermedia, #uploadimage').hide();
		$('input[name=url_media]').attr('data-validation','required');
		$('#covermedia').removeAttr('data-validation');
	}else{
		$('#video').hide();
		$('#covermedia, #uploadimage').show();
		$('input[name=url_media]').removeAttr('data-validation');
		$('#covermedia').attr('data-validation','required dimension mime size');
	}
}
</script>