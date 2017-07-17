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
						echo form_open_multipart(current_url(),'class="inp"');
						?>
						<!-- text input -->
						<div class="form-group">
							<label>Fullname</label>
							<input name="fullname" class="form-control" type="text" onKeyPress="return alpaonly(this, event)" data-validation="required custom length" data-validation-regexp="^([a-zA-Z -]+)$" data-validation-length="3-100">
						</div>
						
						<div class="row">
							<div class="col-sm-3">
								<!-- text input -->
								<div class="form-group">
									<label>Phone</label>
									<input name="phone" class="form-control" type="text" onKeyPress="return alpaonly(this, event)" data-validation="required custom length" data-validation-regexp="^([0-9\- -]+)$" data-validation-length="6-15">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Status Access</label>
									<select name="status" class="form-control" data-validation="required">
										<option value="active">Active</option>
										<option value="banned">Banned</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label>Level Access</label>
									<select name="level" class="form-control" data-validation="required">
										<option value="admin">Superadmin</option>
										<option value="moderator">Moderator</option>
									</select>
								</div>
							</div>
							<div class="col-sm-4">
								<!-- file -->
								<div class="form-group">
									<label for="UploadFile">Photo Profile</label>
									<?php
									echo form_upload('avatar', '','data-validation="dimension mime size" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-dimension="min30x30"');
									?>
									<p class="help-block">Max. 2MB (.jpg, .jpeg, .png), Dimension min 30x30 pixel</p>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-4">
								<!-- text input -->
								<div class="form-group">
									<label>Password</label>
									<input id="password_confirmation" name="password_confirmation" class="form-control" type="password" data-validation="required length" data-validation-length="12">
								</div>
							</div>
							<div class="col-sm-4">
								<!-- text input -->
								<div class="form-group">
									<label>Re-Type Password</label>
									<input id="password" name="password" class="form-control" type="password" data-validation="required confirmation length" data-validation-length="12">
								</div>
							</div>
							<div class="col-sm-4">
								<!-- text input -->
								<div class="form-group">
									<label>Email</label>
									<input name="email" class="form-control" type="text" data-validation="required email length" data-validation-length="3-100">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								Password Checker 12 Character: <span id="matchpassword"></span>
							</div>
							<div class="col-sm-4">
								<ul>
									<li id="validpassword">Invalid</li>
									<li id="lower">lower</li>
									<li id="upper">UPPER</li>
								</ul>
							</div>
							<div class="col-sm-4">
								<ul>
									<li id="special">Special Character</li>
									<li id="numerals">Numerals</li>
									<li id="free">Free text</li>
								</ul>
							</div>
						</div>
						
						<div class="box-footer text-center" id="passwordchanger" style="display: none;">
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
$('#password_confirmation').keyup(function(e) {
	e.preventDefault();
	var lower = new RegExp("[a-z]{1}", "g");
	var upper = new RegExp("[A-Z]{1}", "g");
	var special = new RegExp("[@#%$]{1}", "g");
	var numerals = new RegExp("[0-9]{1}", "g");
	var free = new RegExp("[a-zA-Z0-9@#%$]{6}", "g");
	var string = $(this).val();
	
	if(lower.test(string)){
		$('#lower').css("color", "green");
	}else{
		$('#lower').css("color", "red");
	}
	
	if(upper.test(string)){
		$('#upper').css("color", "green");
	}else{
		$('#upper').css("color", "red");
	}
	
	if(special.test(string)){
		$('#special').css("color", "green");
	}else{
		$('#special').css("color", "red");
	}
	
	if(numerals.test(string)){
		$('#numerals').css("color", "green");
	}else{
		$('#numerals').css("color", "red");
	}
	
	if(free.test(string)){
		$('#free').css("color", "green");
	}else{
		$('#free').css("color", "red");
	}
	
	fullmatch(string);
	return true;
});

function fullmatch(string){
	var valid = new RegExp("^(?=.*?[a-z])(?=.*?[A-Z]){2}(?=.*?[0-9]){2}(?=.*?[@#%$])[a-zA-Z0-9@#%$]{12}$", "g");
	if (valid.test(string)) {
		$('#validpassword').html('Valid!');
		$('#validpassword').css("color", "green");
	} else {
		$('#validpassword').html('inValid!');
		$('#validpassword').css("color", "red");
	}
}

$(document).ready(function(){
	$('#password').focusout(function(){
		var password_confirmation = $('#password_confirmation').val();
		var password = $('#password').val();
		if(password != ''){
			if(password_confirmation != password){
				$('#matchpassword').html('The passwords didn\'t match!!');
				$('#matchpassword').css("color", "red");
				$('#passwordchanger').hide();
			}else{
				$('#matchpassword').html('The passwords match!');
				$('#matchpassword').css("color", "green");
				$('#passwordchanger').show();
			}
		}else{
			$('#matchpassword').html('The passwords didn\'t match!!');
			$('#matchpassword').css("color", "red");
			$('#passwordchanger').hide();
		}
	});
});
</script>