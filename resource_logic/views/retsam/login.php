	<div class="login-box">
		<div class="login-logo">
			<a href="<?php echo base_url();?>"><img src="<?php echo base_url('logo.png');?>"></a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">Sign in to start your session</p>
			
			<?php
			echo form_open(DIRADMIN.'/auth/login');
			echo '<div class="form-group has-feedback">
				<input type="email" class="form-control" placeholder="Email" name="umail" data-validation="custom length email required" data-validation-regexp="^([a-zA-Z0-9_.@\-]+)$" data-validation-length="4-100"/>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>';
			
			echo '<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="Password" name="upass" data-validation="length required" data-validation-length="6-20"/>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>';
			
			echo '<div class="form-group has-feedback">
			<div class="input-group">
				<input name="captcha" type="text" placeholder="Captcha" class="form-control" maxlength="6" onKeyPress="return alpaonly(this, event)"  data-validation="length alphanumeric custom required" data-validation-length="6" data-validation-regexp="^([0-9]+)$">
				<span class="input-group-btn">
					'.$captcha.'
				</span>
			</div>
			</div>';
					
			echo '<div class="row">
				<div class="col-xs-8">    
					<a href="javascript:;" data-toggle="modal" data-target="#forgotpassword">Forgot password</a>
				</div><!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" name="form-submit" value="login" class="btn btn-warning btn-block btn-flat">Sign In</button>
				</div><!-- /.col -->
			</div>';
			echo form_close();
			?>
			<div class="errorinfo" style="margin-top: 20px; clear: both; color: red;"></div>
		</div><!-- /.login-box-body -->
	</div><!-- /.login-box -->
	
	<!-- Modal -->
	<div class="modal fade" id="forgotpassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<b>Please contact administrator by phone</b>
				</div>
			</div>
		</div>
	</div>