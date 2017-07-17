<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!-- section bottom info -->
<div class="wrap-sec-bottom-info">
	<div class="container">
		<div class="wrap-news-letter">
			<h2>404<br/><?php echo translation('translation_404');?></h2>
		</div>
		<div class="s-bottom-info-text">
			<a href="<?php echo base_url();?>"><img src="<?php echo asset('web');?>/images/ilogo2.png" alt=""></a>
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