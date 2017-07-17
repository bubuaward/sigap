<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
#twittersection {
	overflow: hidden;
	margin-top: -300px;
	height: 200px;
	clear: both;
}

#twittersection ul {
	list-style: none;
	width: 99999px;
	height: auto;
}

#twittersection ul li {
	width: 300px;
	height: 100%;
	float: left;
	margin: 0px 60px 0 -40px;
}
</style>

<!-- media social box -->
<div class="wrap-social-media-square" id="media-soc-sec">
	<!-- box 1 facebook -->
	<div class="item-media-soc-box item-media-soc-box-fb">
		<div class="overlay-wrap-text">
			<div class="overlay-text-in overlay-text-in-fb">
				<?php echo translation('facebook_like_me_title');?>
			</div>
		</div>
		<div class="media-soc-logo">
			<a href="<?php echo ACCOUNT_FB;?>" target="_blank"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
	<!-- box 2 twitter -->
	<div class="item-media-soc-box item-media-soc-box-twitter">
		<div class="overlay-wrap-text-twitter">
			<div id="twittersection"></div>
			<h2 style="width: 150px !important;"><?php echo translation('twitter_follow_title');?></h2>
		</div>
		<div class="media-soc-logo">
			<a href="<?php echo ACCOUNT_TW;?>" target="_blank"><i class="fa fa-twitter"></i></a>
		</div>
	</div>
	<!-- box 3 instagram -->
	
	<div id="instagramwraaper"></div>
	
	<div class="clear"></div>
</div>