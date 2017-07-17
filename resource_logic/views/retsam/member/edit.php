<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!-- Content Wrapper -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header clearfix">
		<h1 class="clearfix"><i class="fa fa-database"></i> Profile</h1>
	</section>
	
	<!-- Main content -->
	<section class="content clearfix">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-success">
					<div class="box-header">
						<h3 class="box-title"><i class="fa fa-pencil-square-o"></i> Personal Information</h3>
					</div>
					
					<div class="box-body">
						<?php echo form_open_multipart(current_url(),'class="inp"'); ?>
						
						<div class="col-sm-12">
							<!-- text input -->
							<div class="form-group">
								<label>Fullname</label>
								<input value="<?php echo $detail->fullname;?>" name="fullname" class="form-control" type="text" onKeyPress="return alpaonly(this, event)" data-validation="required custom length" data-validation-regexp="^([a-zA-Z -]+)$" data-validation-length="3-100">
							</div>
							
							<!-- text input -->
							<div class="form-group">
								<label>Phone</label>
								<input value="<?php echo $detail->phone;?>" name="phone" class="form-control" type="text" onKeyPress="return alpaonly(this, event)" data-validation="required custom length" data-validation-regexp="^([0-9\- -]+)$" data-validation-length="6-15">
							</div>
							
							<?php if($this->session->userdata['isloginaccount']['level'] == 'admin'){ ?>
							<div class="form-group">
								<label>Level Access User</label>
								<select name="level" class="form-control" data-validation="required">
									<option value="admin"<?php echo ($detail->level == 'admin' ? ' selected="selected"':'');?>>Superadmin</option>
									<option value="moderator"<?php echo ($detail->level == 'moderator' ? ' selected="selected"':'');?>>Moderator</option>
								</select>
							</div>
							<?php } ?>
							
							<div class="form-group">
								<label for="UploadFile">Upload Avatar <small>Max. 2MB (.jpg, .jpeg, .png) & min 50x50 pixel</small></label>
								<?php
								if($detail->avatar){
									echo '<p><img width="80px" class="img-responsive" src="'.base_url('storage/avatar/'.$detail->avatar).'"></p>';
								}
								
								echo form_upload('avatar', '','data-validation="dimension mime size" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-dimension="min50x50"');?>
							</div>
							
							<div class="box-footer text-center">
								<button type="submit" name="form_submit" value="save" class="btn btn-success nextinp">Validate & Save AS</button>
							</div><!-- /.box-footer -->
						</div>
					<?php echo form_close();?>
						
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
			
			<div class="col-sm-6">
				<div class="box box-success">
					<div class="box-header">
						<h3 class="box-title"><i class="fa fa-pencil-square-o"></i> Change Password</h3>
					</div>
					<div class="box-body">
					<?php echo form_open(current_url(),'class="inp"'); ?>
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-6">
									<!-- text input -->
									<div class="form-group">
										<label>New Password</label>
										<input id="password_confirmation" name="password_confirmation" class="form-control" type="password" data-validation="required length" data-validation-length="12">
									</div>
								</div>
								<div class="col-sm-6">
									<!-- text input -->
									<div class="form-group">
										<label>Re-Type Password</label>
										<input id="password" name="password" class="form-control" type="password" data-validation="required confirmation length" data-validation-length="12">
									</div>
								</div>
								<div class="col-sm-12">
									Password Checker 12 Character: <span id="matchpassword"></span>
								</div>
								<div class="col-sm-6">
									<ul>
										<li id="validpassword">Invalid</li>
										<li id="lower">lower</li>
										<li id="upper">UPPER</li>
									</ul>
								</div>
								<div class="col-sm-6">
									<ul>
										<li id="special">Special Character</li>
										<li id="numerals">Numerals</li>
										<li id="free">Free text</li>
									</ul>
								</div>
							</div>
						
							<div id="passwordchanger" class="box-footer text-center" style="display: none;">
								<button type="submit" name="form_submit_password" value="save" class="btn btn-success nextinp">Validate & Save AS</button>
							</div><!-- /.box-footer -->
						</div>
					<?php echo form_close();?>
						
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
			
			<div class="col-sm-6">
				<div class="box box-success">
					<div class="box-header">
						<h3 class="box-title"><i class="fa fa-pencil-square-o"></i> Change Email</h3>
					</div>
					<div class="box-body">
					<?php echo form_open(current_url(),'class="inp"'); ?>
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-6">
									<!-- text input -->
									<div class="form-group">
										<label>Old Email</label>
										<input value="<?php echo $detail->email;?>" name="old_mail" class="form-control" type="text" data-validation="required email length" data-validation-length="3-100" disabled>
									</div>
								</div>
								<div class="col-sm-6">
									<!-- text input -->
									<div class="form-group">
										<label>New Email</label>
										<input name="email" class="form-control" type="text" data-validation="required email length" data-validation-length="3-100">
									</div>
								</div>
							</div>
							
							<div class="box-footer text-center">
								<button type="submit" name="form_submit_email" value="save" class="btn btn-success nextinp">Validate & Save AS</button>
							</div><!-- /.box-footer -->
						</div>
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