<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- section bottom info -->
<div class="wrap-sec-bottom-info">
	<div class="container">
		<div class="sec-logo-info">
			<?php
				if($partnership){
					foreach($partnership AS $no => $red){
						$no += 1;
						echo '<div class="item-logo-info'.$no.'">
							<a href="'.prep_url($red->url).'" target="_blank"><img src="'.base_url('storage/partnership/'.$red->cover).'" alt="'.$red->url.'"></a>
						</div>';
						
						if($no == 2){
							$no = 1;
						}
					}
				}
			?>
			<div class="clear"></div>
		</div>
		<div class="s-bottom-info-text">
			<h4><?php echo translation('contact_about');?></h4>
		</div>
		<div class="wrap-news-letter">
			<h2><?php echo translation('inbox_title_form');?></h2>
			
			<?php echo form_open('contact/add', 'class="news-letter" data-parsley-validate=""');?>
				<div class="row">
					<div class="col-lg-12">
						<input name="fullname" type="text" class="i-text-form-f" placeholder="<?php echo translation('contact_field_fullname');?>*" required="" data-parsley-required="true" data-parsley-length="[3, 100]" data-parsley-trigger="keyup" data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-errors-messages-disabled>
						<input name="email" type="email" class="i-text-form-f" placeholder="Email*" required="" data-parsley-required="true" data-parsley-length="[4, 255]" data-parsley-trigger="keyup" data-parsley-type="email" data-parsley-errors-messages-disabled>
						<input name="phone" type="text" class="i-text-form-f" placeholder="<?php echo translation('contact_field_phone');?>*" required="" data-parsley-required="true" data-parsley-length="[6, 20]" data-parsley-trigger="keyup" data-parsley-type="number" data-parsley-pattern="[0-9]+$" data-parsley-errors-messages-disabled>
						<input name="city" type="text" class="i-text-form-f" placeholder="<?php echo translation('contact_field_city');?>*" required="" data-parsley-required="true" data-parsley-length="[3, 100]" data-parsley-trigger="keyup" data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-errors-messages-disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h4 class="newsletter-req">
							* <?php echo translation('inbox_required_alert');?>
						</h4>
						<div class="input-checkbox-nl">
							<input type="checkbox" name="subscribe" value="true"> <span><?php echo translation('contact_field_subscribe');?></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<textarea name="message" id="" class="i-textarea-form" placeholder="<?php echo translation('contact_field_message');?>"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="input-checkbox-nl">
							<input type="checkbox" name="tnc" value="true" required="" data-parsley-required="true" data-parsley-mincheck="1" data-parsley-errors-container="#error_tnc"> <span><a href="<?php echo base_lang('syarat-dan-ketentuan');?>" target="_blank"><?php echo translation('contact_field_term_and_condition');?></a></span><br/><label id="error_tnc"></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<input name="submit_form" type="submit" value="<?php echo translation('contact_field_submit');?>" class="s-input-form">
					</div>
				</div>
			<?php echo form_close();?>
			
		</div>
		<div class="social-net-icon">
			<h4><?php echo translation('sosmed_title_follow');?></h4>
			<ul>
				<li><a href="<?php echo ACCOUNT_FB;?>" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
				<li><a href="<?php echo ACCOUNT_TW;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
				<li><a href="<?php echo ACCOUNT_INS;?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
				<li><a href="<?php echo ACCOUNT_YTB;?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
			</ul>
		</div>
	</div>
</div>