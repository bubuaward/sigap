<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="no-js ie6 oldie" lang="<?php echo $this->session->userdata('current_lang');?>"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 oldie" lang="<?php echo $this->session->userdata('current_lang');?>"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8 oldie" lang="<?php echo $this->session->userdata('current_lang');?>"> <![endif]-->
<!--[if IE 9 ]>    <html class="no-js ie9" lang="<?php echo $this->session->userdata('current_lang');?>"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--> <html class="no-js" lang="<?php echo $this->session->userdata('current_lang');?>"> <!--<![endif]-->
<head>
	<title><?php echo ($meta_title ? $meta_title.' | '.WEBTITLE : WEBTITLE);?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimal-ui"/>
	<meta http-equiv="X-UA-Compatible" content="ie=edge, chrome=1">
	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="title" content="<?php echo ($meta_title ? $meta_title.' | '.WEBTITLE : WEBTITLE);?>">
	<meta name="description" content="<?php echo ($meta_description ? clean_html($meta_description): WEBDESC);?>" />
	<meta name="keywords" content="<?php echo ($meta_tags ? $meta_tags: WEBTAGS); ?>" />

	<meta http-equiv="copyright" content="<?php echo $_SERVER['HTTP_HOST'];?>" />
	<meta name="publisher" content="<?php echo $_SERVER['HTTP_HOST'];?>" />
	<meta name="author" content="<?php echo $_SERVER['HTTP_HOST'];?>" />
	<meta name="language" content="Indonesia" />
	<meta http-equiv="content-language" content="<?php echo $this->session->userdata('current_lang');?>">

	<?php
	//no index google bot
	if(in_array($this->router->fetch_class(), array('program', 'artikel', 'cari'))){
		echo '<meta name="robots" content="noindex" />
		<meta name="googlebot" content="noindex"/>';
	}else{
		echo '<meta name="robots" content="all" />
		<meta name="googlebot-news" content="index,follow" />
		<meta name="googlebot" content="all" />
		<meta name="spiders" content="all" />
		<meta name="webcrawlers" content="all" />';
	}

	//canonical
	if($meta_tags != '404'){
		echo '<link rel="canonical" href="'.current_url().'"/>';
	}

	//multilanguage
	foreach($masterlanguage AS $red){
		if($red == 'id'){
			echo '<link rel="alternate" href="'.base_url().'" hreflang="x-default" />';
		}else{
			echo '<link rel="alternate" href="'.base_url($red).'" hreflang="'.$red.'" />';
		}
	}
	?>

	<link href="<?php echo base_url('favicon.png');?>" rel="icon" type="image/x-png" />
	<link rel="image_src" href="<?php echo ($meta_picture ? $meta_picture: base_url('sharer_default.png'));?>" />
	<base href="<?php echo base_url();?>">

	<meta property='fb:admins' content="1813571056"/>
	<meta property='fb:app_id' content="<?php echo FBAPPID;?>"/>
	<meta property='og:type' content="website" />
	<meta property='og:image' content="<?php echo ($meta_picture ? $meta_picture: base_url('sharer_default.png'));?>" />
	<meta property='og:title' content="<?php echo ($meta_title ? clean_html($meta_title):WEBTITLE);?>" />
	<meta property='og:site_name' content="<?php echo $_SERVER['HTTP_HOST'];?>" />
	<meta property='og:description' content="<?php echo ($meta_description ? clean_html($meta_description):WEBDESC);?>" />
	<meta property='og:url' content="<?php echo current_url();?>" />
	<meta property='og:image:width' content="527" />
	<meta property='og:image:height' content="527" />

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@ID_Nature">
	<meta name="twitter:creator" content="@ID_Nature">
	<meta name="twitter:title" content="<?php echo ($meta_title ? clean_html($meta_title):WEBTITLE);?>">
	<meta name="twitter:description" content="<?php echo ($meta_description ? clean_html($meta_description):WEBDESC);?>">
	<meta name="twitter:image" content="<?php echo ($meta_picture ? $meta_picture: base_url('sharer_default.png'));?>">
	<meta name='twitter:url' content="<?php echo current_url();?>" />
	<meta name='twitter:image:width' content='527'>
	<meta name='twitter:image:height' content='527'>

	<script type="text/javascript">
	if( (self.parent && !(self.parent===self) ) && (self.parent.frames.length !=0)){
		self.parent.location=document.location;
	}
	</script>

	<style type="text/stylesheet">
		@-webkit-viewport   { width: device-width; }
		@-moz-viewport      { width: device-width; }
		@-ms-viewport       { width: device-width; }
		@-o-viewport        { width: device-width; }
		@viewport           { width: device-width; }
	</style>
	
	
	<script type="text/javascript">
	if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
		var msViewportStyle = document.createElement("style");
		msViewportStyle.appendChild(
			document.createTextNode("@-ms-viewport{width:auto!important}")
		);
		document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
	}
	</script>
	<meta name="HandheldFriendly" content="true"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<script>
	var hashlink = window.location.hash;
	if(hashlink === ''){
		addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }
	}
	</script>
	
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo asset('web');?>/css/bootstrap.min.css">
	<!-- owl carousel 2 -->
	<link rel="stylesheet" href="<?php echo asset('web');?>/css/owl.carousel.css">
	<!-- animate -->
	<link rel="stylesheet" href="<?php echo asset('web');?>/css/animate.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="<?php echo asset('web');?>/css/font-awesome.css">
	<!-- jquery lightbox -->
	<link rel="stylesheet" href="<?php echo asset('web');?>/css/lightbox.css">
	<!-- Main Style -->
	<link rel="stylesheet" href="<?php echo asset('web');?>/css/style.css">
	<link rel="stylesheet" href="<?php echo asset('web');?>/css/responsive.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<script>
  		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  		ga('create', 'UA-88346825-1', 'auto');
  		ga('send', 'pageview');

	</script>


</head>
<body class="body-cus-fixed">
<!--[if lt IE 9]>
<div class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</div>
<![endif]-->

	<!-- menu top -->
	<div class="wrap-menu-logo-top wrap-menu-logo-top-fixed">
		<div class="container-menu">
			<!-- logo -->
			<div class="logo-top">
				<a href="<?php echo base_lang();?>"><img src="<?php echo base_url('logo.png');?>" alt="Yayasan Konservasi Alam Nusantara"></a>
			</div>
			<!-- menu normal-->
			<div class="nav-menu-normal nav-menu-normal2">
				<ul>
					<?php
					echo '<li'.($this->router->fetch_class() == 'program' ? ' class="menu-item-has-children nav-menu-active"':' class="menu-item-has-children"').'><a href="#">'.translation('page_program_title').'</a>
						<ul>';
							foreach($menu_category AS $red){
								echo '<li><a href="'.base_lang('program/'.$red->slug).'">'.$red->title.'</a></li>';
							}
						echo '</ul>
					</li>';
					echo '<li'.($this->router->fetch_class() == 'article' ? ' class="nav-menu-active"':'').'>
						<a href="'.base_lang('artikel').'">'.translation('page_article_title').'</a>
					</li>';
					echo '<li class="linkmedsos">
						<a href="'.base_lang().'#media-soc-sec">'.translation('page_media_social_title').'</a>
					</li>';
					echo '<li'.($this->router->fetch_class() == 'contact' ? ' class="nav-menu-active"':'').'>
						<a href="'.base_lang('kontak-kami').'">'.translation('page_contact_title').'</a>
					</li>';
					echo '|';
					echo '<li'.($this->router->fetch_method() == 'mitraalam' ? ' class="nav-menu-active"':'').'>
						<a href="'.base_lang('mitra-alam').'">'.translation('page_mitra_alam_title').'</a>
					</li>';
					echo '<li'.($this->router->fetch_method() == 'about' ? ' class="nav-menu-active"':'').'>
						<a href="'.base_lang('tentang-kami').'">'.translation('page_about_title').'</a>
					</li>';
					echo '<li'.($this->router->fetch_method() == 'donate' ? ' class="bt-donasi nav-menu-active"':' class="bt-donasi"').'>
						<a href="'.base_lang('donasi').'">'.translation('page_donate_title').'</a>
					</li>';
					?>
				</ul>
				<ul class="mn-normal-part2">
					<li>
						<a href="<?php echo base_lang('setlang/to/id?ref='.uri_string());?>" <?php echo ( $this->session->userdata('current_lang') == 'id' ? 'class="boldt"' : '');?>>id</a><!-- |
						<a href="<?php echo base_lang('setlang/to/en?ref='.uri_string());?>" <?php echo ( $this->session->userdata('current_lang') == 'en' ? 'class="boldt"' : '');?>>en</a>-->
					</li>
					<li class="social-m-top">
						<a href="<?php echo ACCOUNT_FB;?>" target="_blank"><i class="fa fa-facebook-square"></i></a>
						<a href="<?php echo ACCOUNT_TW;?>" target="_blank"><i class="fa fa-twitter"></i></a>
						<a href="<?php echo ACCOUNT_INS;?>" target="_blank"><i class="fa fa-instagram"></i></a>
						<a href="<?php echo ACCOUNT_YTB;?>" target="_blank"><i class="fa fa-youtube"></i></a>
					</li>
					<li>
						<div class="logo-top-right2">
							<a href="http://www.nature.or.id/" target="_blank">
								<img src="<?php echo asset('web');?>/images/logotr.png" alt="">
							</a>
						</div>
					</li>
				</ul>
			</div>


			<!-- responsive -->
			<div class="bt-menu-responsive">
				<i class="fa fa-bars bt-mn-res-click"></i>
			</div>
			<ul class="mn-normal-part2-res">
				<li <?php echo ($this->router->fetch_method() == 'donate' ? 'class="bt-donasi nav-menu-active"':' class="bt-donasi"');?>>
					<a href="<?php echo base_lang('donasi');?>"><?php echo translation('page_donate_title');?></a>
				</li>
				<li>
					<a href="<?php echo base_lang('setlang/to/id?ref='.uri_string());?>" <?php echo ( $this->session->userdata('current_lang') == 'id' ? 'class="boldt"' : '');?>>id</a><!-- |
					<a href="<?php echo base_lang('setlang/to/en?ref='.uri_string());?>" <?php echo ( $this->session->userdata('current_lang') == 'en' ? 'class="boldt"' : '');?>>en</a>-->
				</li>
				<li class="social-m-top">
					<a href="<?php echo ACCOUNT_FB;?>" target="_blank"><i class="fa fa-facebook-square"></i></a>
					<a href="<?php echo ACCOUNT_TW;?>" target="_blank"><i class="fa fa-twitter"></i></a>
					<a href="<?php echo ACCOUNT_INS;?>" target="_blank"><i class="fa fa-instagram"></i></a>
					<a href="<?php echo ACCOUNT_YTB;?>" target="_blank"><i class="fa fa-youtube"></i></a>
				</li>
			</ul>
			<div class="menu-nav-responsive">
				<ul>
					<?php
					echo '<li'.($this->router->fetch_class() == 'program' ? ' class="menu-item-has-children nav-menu-active"':' class="menu-item-has-children"').'><a href="#">'.translation('page_program_title').'</a>
						<ul>';
							foreach($menu_category AS $red){
								echo '<li><a href="'.base_lang('program/'.$red->slug).'">'.$red->title.'</a></li>';
							}
						echo '</ul>
					</li>';
					echo '<li'.($this->router->fetch_class() == 'article' ? ' class="nav-menu-active"':'').'>
						<a href="'.base_lang('artikel').'">'.translation('page_article_title').'</a>
					</li>';
					echo '<li class="linkmedsos">
						<a href="'.base_lang().'#media-soc-sec">'.translation('page_media_social_title').'</a>
					</li>';
					echo '<li'.($this->router->fetch_class() == 'contact' ? ' class="nav-menu-active"':'').'>
						<a href="'.base_lang('kontak-kami').'">'.translation('page_contact_title').'</a>
					</li>';
					echo '<li'.($this->router->fetch_method() == 'mitraalam' ? ' class="nav-menu-active"':'').'>
						<a href="'.base_lang('mitra-alam').'">'.translation('page_mitra_alam_title').'</a>
					</li>';
					echo '<li'.($this->router->fetch_method() == 'about' ? ' class="nav-menu-active"':'').'>
						<a href="'.base_lang('tentang-kami').'">'.translation('page_about_title').'</a>
					</li>';
					?>
				</ul>
			</div>
		</div>
	</div>
