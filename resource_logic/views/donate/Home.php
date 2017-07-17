<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- donate -->
<div class="wrap-donate-form">
	<div class="container">
		<div class="slide-donate-formx">
		
			<?php echo form_open('donasi/simpan', 'id="payment-form"');?>
			<div class="item form-section">
				<div class="img-seperator-donate">
					<img src="<?php echo asset('web');?>/images/isd1.png" alt="form donate">
				</div>
				<div class="sec-donate-form sec-donate-form-bor">
					<div class="row">
						<div class="col-sm-6">
							<!-- input 1 -->
							<div class="item-form-donate item-form-donate-input">
								<p><?php echo translation('firstname_title');?> <span>*</span></p>
								<input type="text" id="first_name" name="first_name" required="" data-parsley-required="true" data-parsley-length="[3, 50]" data-parsley-trigger="keyup" data-parsley-pattern="^[a-zA-Z ]+$">
							</div>
							<!-- input 2 -->
							<div class="item-form-donate item-form-donate-input">
								<p><?php echo translation('lastname_title');?> <span>*</span></p>
								<input type="text" id="last_name" name="last_name" required="" data-parsley-required="true" data-parsley-length="[3, 50]" data-parsley-trigger="keyup" data-parsley-pattern="^[a-zA-Z ]+$">
							</div>
							<!-- input 3 -->
							<div class="item-form-donate item-form-donate-input">
								<p>Email <span>*</span></p>
								<input type="email" id="email" name="email" required="" data-parsley-required="true" data-parsley-length="[4, 255]" data-parsley-trigger="keyup" data-parsley-type="email">
							</div>
							<!-- input 4 -->
							<div class="item-form-donate item-form-donate-input">
								<p><?php echo translation('contact_field_phone');?> <span>*</span></p>
								<input type="text" id="phone" name="phone" required="" data-parsley-required="true" data-parsley-length="[6, 20]" data-parsley-trigger="keyup" data-parsley-type="number" data-parsley-pattern="[0-9]+$">
							</div>
							<!-- input 5 -->
							<div class="item-form-donate item-form-donate-input2">
								<p><input type="checkbox" id="subscribe" name="subscribe" value="true" checked> <?php echo translation('contact_field_subscribe');?></p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="donate-form-right">
								<!-- input 1 -->
								<div class="item-form-donate item-form-donate-input">
									<p><?php echo translation('donate_select_amount');?></p>
									<div class="wrap-bt-donate-nom">
										<div class="bt-don-nom selectamount" data-amount="150000">
											Rp 150,000
										</div>
										<div class="bt-don-nom selectamount" data-amount="200000">
											Rp 200,000
										</div>
										<div class="bt-don-nom selectamount" data-amount="300000">
											Rp 300,000
										</div>
										<div class="bt-don-nom selectamount" data-amount="other">
											<?php echo translation('donate_other_amount');?>
										</div>
										<div class="clear"></div>
									</div>
								</div>
								<div class="item-form-donate item-form-donate-input-2">
									<p id="label_gross_amount"><?php echo translation('donate_your');?></p>
									<div class="input-donate-choose">
										<div class="row">
											<div class="col-sm-7">
												<span class="ifd-rp">Rp.</span>
												<input id="gross_amount" name="gross_amount" type="number" class="i-form-don" required="" data-parsley-required="true" data-parsley-length="[6, 11]" data-parsley-trigger="keyup" data-parsley-type="integer" data-parsley-pattern="(^[1-9])[0-9]+$">
											</div>
											<div class="col-sm-12">
												<input type="checkbox" class="i-form-radio" name="monthly" value="true">
												<span class="i-form-radio-text">Monthly Donation</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="item form-section">
				<div class="img-seperator-donate">
					<img src="<?php echo asset('web');?>/images/isd2.png" alt="form donate term">
				</div>
				<div class="sec-donate-form sec-donate-form-bor sec-donate-form-bor-don2">
					<div class="sec-donate-text-ket">
						
						<?php echo translation('page_donate_term_and_condition');?>
						
					</div>
					<div class="check-setuju-donate">
						<input type="checkbox" id="termapproved" name="termapproved" value="true" required="" data-parsley-required="true" data-parsley-mincheck="1"> <span>Saya mengerti dan setuju</span>
					</div>
				</div>
			</div>
			
			<div class="item form-navigation">
				<!-- nav -->
				<div class="wrap-sec-nav-donate1">
					<div class="bt-next-donate1 previous">
						Back
					</div>
					<div class="bt-next-donate1 next">
						Next
					</div>
					<div class="ajax-loader">
						<div id="ballsWaveG">
							<div id="ballsWaveG_1" class="ballsWaveG"></div>
							<div id="ballsWaveG_2" class="ballsWaveG"></div>
							<div id="ballsWaveG_3" class="ballsWaveG"></div>
							<div id="ballsWaveG_4" class="ballsWaveG"></div>
							<div id="ballsWaveG_5" class="ballsWaveG"></div>
							<div id="ballsWaveG_6" class="ballsWaveG"></div>
							<div id="ballsWaveG_7" class="ballsWaveG"></div>
							<div id="ballsWaveG_8" class="ballsWaveG"></div>
						</div>
					</div>
					<div class="bt-next-donate1" id="finish">
						<?php echo translation('page_donate_title');?>
					</div>
					

				</div>
			</div>
			
			<input type="hidden" name="order_id" id="result-orderid" value="">
			<input type="hidden" name="user_id" id="result-userid" value="">
			<input type="hidden" name="result_type" id="result-type" value="">
			<input type="hidden" name="result_data" id="result-data" value="">
			<?php echo form_close();?>
			
		</div>
	</div>
</div>