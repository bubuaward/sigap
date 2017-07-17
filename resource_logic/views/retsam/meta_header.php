<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo ($meta_title ? $meta_title.' | '.WEBTITLE : WEBTITLE.' | Dashboard');?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="Content-Language" content="en" />
	<meta name="title" content="<?php echo ($meta_title ? $meta_title.' | '.WEBTITLE : WEBTITLE.' | Dashboard');?>">
	<meta name="description" content="<?php echo ($meta_description ? strip_tags(clean_html($meta_description)): WEBTITLE);?>" />
	<meta name="keywords" content="<?php echo ($meta_tags ? $meta_tags: WEBTITLE); ?>" />
	<meta http-equiv="Copyright" content="<?php echo $_SERVER['HTTP_HOST'];?>" /> 
	<meta name="author" content="<?php echo $_SERVER['HTTP_HOST'];?>" /> 
	<meta http-equiv="imagetoolbar" content="no" /> 
	<meta name="language" content="Indonesia" /> 
	<meta name="robots" content="none">
	<meta name="googlebot" content="none">
	<meta name="googlebot-news" content="none" />
	<base href="<?php echo base_url();?>">
	
	<link href="<?php echo base_url('favicon.png');?>" rel="icon" type="image/x-png" />
	
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
	
	<script>
  		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  		ga('create', 'UA-88346825-1', 'auto');
  		ga('send', 'pageview');

	</script>


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
	<script>addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	
	<link href="<?php echo asset('bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('bootstrap/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('master/css/AdminDashboard.min.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('master/css/skins/skin-green.min.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('plugins/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('plugins/datepicker/daterangepicker.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('plugins/datetimepicker/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css" />
	
	<script src="<?php echo asset('plugins/jQuery/jQuery-2.1.4.min.js');?>"></script>
	<script src="<?php echo asset('bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
	<script src="<?php echo asset('plugins/fastclick/fastclick.min.js');?>"></script>
	<script src="<?php echo asset('plugins/slimScroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
	<script src="<?php echo asset('plugins/select2/select2.full.min.js');?>" type="text/javascript"></script>
	<script src="<?php echo asset('plugins/jquery-validation/jquery.form-validator.min.js');?>"></script>
	<script src="<?php echo asset('plugins/tinymce/tinymce.min.js');?>"></script>
	<script src="<?php echo asset('plugins/datepicker/bootstrap-datepicker.js');?>"></script>
	<script src="<?php echo asset('plugins/datepicker/moment.min.js');?>"></script>
	<script src="<?php echo asset('plugins/datepicker/jquery.daterangepicker.js');?>"></script>
	<script src="<?php echo asset('plugins/datetimepicker/bootstrap-datetimepicker.min.js');?>"></script>
	<script src="<?php echo asset('master/js/dashboard.min.js');?>" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$(".form-control").attr("autocomplete", "off");
		$('.subroot').closest('.treeview').addClass('active');
		
		$.validate({
			modules : 'date, security, file',
			showErrorDialogs : true
		});
		
		tinymce.init({
			selector: "textarea.editor",
			theme: "modern",
			plugins: [
					"advlist autolink lists link image charmap print preview hr anchor pagebreak autoresize autosave",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table contextmenu directionality",
					"emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager"
			],
			toolbar1: "responsivefilemanager undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent blockquote | image media | link unlink anchor | print preview | forecolor backcolor emoticons | code fullscreen",
			image_advtab: true,
			inline_style: true,
			relative_urls: false,
			browser_spellcheck : true,
			external_filemanager_path: "./storage/filemanager/",
			filemanager_title: "File Management" ,
			external_plugins: { "filemanager" : "<?php echo asset('plugins/tinymce/plugins/responsivefilemanager/plugin.min.js');?>"}
		});
	});
	</script>
	
	<script>
		var monthNames = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni","Juli", "Augustus", "September", "Oktober", "November", "Desember" ];
		setInterval(function() {
		var date = new Date();
		$('#clock-wrapper').html(<?php echo date('d');?> + " " + monthNames[<?php echo date('n')-1;?>] + " "+ <?php echo date('Y');?> + "&nbsp; <i class='fa fa-clock-o'></i>&nbsp; " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds() )}, 500);
	</script>
	
	<link rel="stylesheet" href="<?php echo asset('plugins/datatable/dataTables.bootstrap.css');?>">
	<link rel="stylesheet" href="<?php echo asset('plugins/datatable/dataTables.responsive.css');?>">

	<script src="<?php echo asset('plugins/datatable/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo asset('plugins/datatable/dataTables.bootstrap.js');?>"></script>
	<script src="<?php echo asset('plugins/datatable/dataTables.responsive.min.js');?>"></script>

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="<?php echo ($this->router->fetch_class() == 'auth' ? 'login-page':'sidebar-mini fixed sidebar-open skin-green');?>">