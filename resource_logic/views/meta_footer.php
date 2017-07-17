<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	
	<!-- footer -->
	<div class="wrap-footer wrap-footer-f2">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="footer-link">
						<a href="<?php echo base_lang('kebijakan-privasi');?>"><?php echo translation('page_privacy_title');?></a>
						<a href="<?php echo base_lang('syarat-dan-ketentuan');?>"><?php echo translation('page_term_and_condition_title');?></a>
					</div>
				</div>
				<div class="col-md-8">
					<div class="link-program-footer">
						<div class="item-link-pro-foo u-score">
							<a href="<?php echo base_lang('program');?>"><?php echo translation('page_program_title');?></a>
						</div>
						<div class="item-link-pro-foo u-score">
							<a href="<?php echo base_lang('artikel');?>"><?php echo translation('page_article_title');?></a>
						</div>
						<div class="item-link-pro-foo u-score">
							<a href="<?php echo base_lang().'#media-soc-sec';?>"><?php echo translation('page_media_social_title');?></a>
						</div>
						<div class="item-link-pro-foo">
							<a href="<?php echo base_lang('kontak-kami');?>"><?php echo translation('page_contact_title');?></a>
						</div>
						<div class="item-link-pro-foo">
							<a href="<?php echo base_lang('tentang-kami');?>"><?php echo translation('page_about_title');?></a>
						</div>
						<div class="item-link-pro-foo">
							<a href="<?php echo base_lang('mitra-alam');?>"><?php echo translation('page_mitra_alam_title');?></a>
						</div>
						<div class="clear"></div>
					</div>
					<div class="soc-copy">
						<ul class="social-m-footer">
							<li><a href="<?php echo ACCOUNT_FB;?>" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
							<li><a href="<?php echo ACCOUNT_TW;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="<?php echo ACCOUNT_INS;?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
							<li><a href="<?php echo ACCOUNT_YTB;?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
						</ul>
						<div class="copyright-b-foo">
							Copyright © 2016 YAYASAN KONSERVASI ALAM NUSANTARA
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php if($this->session->flashdata('msg')){ ?>
	<!-- Modal -->
	<div class="modal fade" id="mymodalalert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><?php echo translation('modal_popup_title');?></h4>
		  </div>
		  <div class="modal-body">
			<?php echo translation($this->session->flashdata('msg'));?>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>
<?php } ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo asset('web');?>/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo asset('web');?>/js/owl.carousel.js"></script>
<script src="<?php echo asset('web');?>/js/wow.min.js"></script>
<script src="<?php echo asset('web');?>/js/jquery.fitvids.js"></script>
<script src="<?php echo asset('web');?>/js/lightbox.js"></script>
<script src="<?php echo asset('web');?>/js/ekko-lightbox.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo asset('web');?>/js/main.js"></script>
<script src="<?php echo asset('web');?>/js/bootstrap.min.js"></script>
<script src="<?php echo asset('plugins');?>/instafeed/instafeed.js"></script>
<script src="<?php echo asset('plugins');?>/twittie/twittie.js"></script>

<link rel="stylesheet" href="<?php echo asset('plugins');?>/parsley/parsley.css">
<script src="<?php echo asset('plugins');?>/parsley/parsley.min.js"></script>

<?php
if($this->session->userdata('current_lang') == 'id'){
	echo '<script src="'.asset('plugins').'/parsley/i18n/id.js"></script>';
	echo '<script src="'.asset('plugins').'/parsley/i18n/id.extra.js"></script>';
}else{
	echo '<script src="'.asset('plugins').'/parsley/i18n/en.js"></script>';
	echo '<script src="'.asset('plugins').'/parsley/i18n/en.extra.js"></script>';
}
?>

<?php if($this->router->fetch_class() == 'donate'){ ?>
<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?php echo MIDTRANS_CLIENTKEY;?>"></script>
<script type="text/javascript">

$('.ajax-loader').css("visibility", "hidden");
$('#finish').css("visibility", "visible");

$('#finish').click(function (event) {
	event.preventDefault();
	$(this).attr("disabled", "disabled");
	$('#finish').css("visibility", "hidden");
	
	var gross_amount = parseInt($('#gross_amount').val());
	var first_name = $('#first_name').val();
	var last_name = $('#last_name').val();
	var email = $('#email').val();
	var phone = $('#phone').val();
	var subscribe = $('#subscribe:checked').val();
	var termapproved = $('#termapproved:checked').val();
	
	if(gross_amount === '' || gross_amount === undefined){ $('#gross_amount').css('border', '1px solid #f69494').focus(); return false; } else { $('#gross_amount').css('border', 'none') }
	if(first_name === '' || first_name === undefined){ $('#first_name').css('border', '1px solid #f69494').focus(); return false; } else { $('#first_name').css('border', 'none') }
	if(last_name === '' || last_name === undefined){ $('#last_name').css('border', '1px solid #f69494').focus(); return false; } else { $('#last_name').css('border', 'none') }
	if(email === '' || email === undefined){ $('#email').css('border', '1px solid #f69494').focus(); return false; } else { $('#email').css('border', 'none') }
	if(phone === '' || phone === undefined){ $('#phone').css('border', '1px solid #f69494').focus(); return false; } else { $('#phone').css('border', 'none') }
	if(termapproved === '' || termapproved === undefined){ $('.check-setuju-donate span').css('color', '#ff0000').focus(); return false; } else { $('.check-setuju-donate span').css('color', '#000000') }
	
	if(gross_amount <= 10000){ $('#gross_amount').val('').css('border', '1px solid #f69494').focus(); return false;}
	
	
	$.ajax({
		url: '<?php echo base_lang('donate/token')?>',
		method: 'POST',
		beforeSend: function(){			
    			$('.ajax-loader').css("visibility", "visible");			
 		},
		data: {
			'gross_amount' : gross_amount,
			'first_name' : first_name,
			'last_name' : last_name,
			'email' : email,
			'phone' : phone,
			'subscribe' : subscribe,
			'<?php echo $this->security->get_csrf_token_name();?>' : '<?php echo $this->security->get_csrf_hash();?>'
		},
		cache: false,
		success: function(output) {
			if(output.success){
				var data = output.token;
				$("#result-orderid").val(output.orderid);
				$("#result-userid").val(output.userid);
				
				var resultType = document.getElementById('result-type');
				var resultData = document.getElementById('result-data');
				
				function changeResult(type,data){
					$("#result-type").val(type);
					$("#result-data").val(JSON.stringify(data));
				}
				
				snap.pay(data, {
					onSuccess: function(result){
						changeResult('success', result);
						$("#payment-form").submit();
					},
					onPending: function(result){
						changeResult('pending', result);
						$("#payment-form").submit();
					},
					onError: function(result){
						changeResult('error', result);
						$("#payment-form").submit();
					}
				});
				$('.ajax-loader').css("visibility", "hidden");
				$('#finish').css("visibility", "visible");
			}
		},
	});
});
</script>

<style>
.form-section { display: none; }
.form-section.current { display: block; }
</style>
<script type="text/javascript">
$(function () {
	var $sections = $('.form-section');
	function navigateTo(index) {
		$sections.removeClass('current').eq(index).addClass('current');
		$('.form-navigation .previous').toggle(index > 0);
		var atTheEnd = index >= $sections.length - 1;
		$('.form-navigation .next').toggle(!atTheEnd);
		$('.form-navigation #finish').toggle(atTheEnd);
	}

	function curIndex() {
		return $sections.index($sections.filter('.current'));
	}

	$('.form-navigation .previous').click(function() {
		navigateTo(curIndex() - 1);
	});

	$('.form-navigation .next').click(function() {
		if ($('#payment-form').parsley().validate({group: 'block-' + curIndex()}))
		navigateTo(curIndex() + 1);
	});

	$sections.each(function(index, section) {
		$(section).find(':input').attr('data-parsley-group', 'block-' + index);
		});
	navigateTo(0);
});
</script>
<?php } ?>

<script>
	$(document).ready(function() {
		$("input").attr("autocomplete", "off");
		
		<?php if($this->session->flashdata('msg')){ ?>
		$('#mymodalalert').modal('show'); 
		<?php } ?>
		
		$('.selectamount').click(function (event) {
			var amount = $(this).data('amount');
			if(amount === 'other'){
				$('#gross_amount').val('').focus();
				$('#label_gross_amount').empty().text('<?php echo translation('donate_your_amount');?>');
			}else{
				$('#gross_amount').val(amount);
				$('#label_gross_amount').empty().text('<?php echo translation('donate_your');?>');
			}
		});
		
		
		if($("#instagramwraaper").length != 0) {
			var feed = new Instafeed({
				get: 'user',
				userId: <?php echo INSTAGRAM_USERID;?>,
				accessToken: '<?php echo INSTAGRAM_ACCESSTOKEN;?>',
				target: 'instagramwraaper',
				resolution: 'standard_resolution',
				limit: 10,
				template: '<div class="item-media-soc-box item-media-soc-box-instagram">\
					<img src="{{image}}" alt="" style="object-fit: none;object-position: center;">\
					<div class="overlay-wrap-text-instagram-bg"></div>\
					<div class="overlay-wrap-text overlay-wrap-text-instagram">\
						<div class="overlay-text-in overlay-text-in-instagram">{{caption}}</div>\
					</div>\
					<div class="insta-love-com">\
						<a target="_blank" href="{{link}}"><i class="fa fa-heart"></i> {{likes}}</a> <a target="_blank" href="{{link}}"><i class="fa fa-comment"></i> {{comments}}</a>\
					</div>\
					<div class="media-soc-logo">\
						<a href="<?php echo ACCOUNT_INS;?>" target="_blank"><i class="fa fa-instagram"></i></a>\
					</div>\
				</div>',
				after: function() {
					var hashlink = window.location.hash;
					if(hashlink === '#media-soc-sec'){
						window.scrollTo(0,1);
						$('.linkmedsos').addClass('nav-menu-active');
						$('html, body').animate({
							scrollTop: $("#media-soc-sec").offset().top
						}, 2000);
					}
				}
			});
			
			feed.run();
			
			$('#twittersection').twittie({
				apiPath: '<?php echo base_url('ajax/tweetfeed');?>',
				username: 'ID_Nature',
				hashtag: '',
				hideReplies: false,
				dateFormat: '%d %B %Y',
				template: '<p>{{date}}<br/>{{tweet}}</p><h4>by <a href="{{url}}" target="_blank">{{screen_name}}</a></h4>',
				count: 10
			}, function () {
				setInterval(function() {
					var item = $('#twittersection ul').find('li:first');
					item.animate( {marginLeft: '-220px', 'opacity': '0'}, 500, function() {
						$(this).detach().appendTo('#twittersection ul').removeAttr('style');
					});
				}, 5000);
			});
		}

		
		window.fbAsyncInit = function() {
			FB.init({
				appId   : '<?php echo FBAPPID;?>',
				status	: true,
				cookie	: true,
				xfbml	: true,
				version	: 'v2.6'
			});
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

	});
	
	function fbLogin() {
		FB.login(function(response){
			if (response.authResponse) {
				FB.api('/me?fields=id,name,email,picture,gender', function(response) {
					var sosid = response.id;
					var fullname = response.name;
					var email = response.email;
					var avatar = 'http://graph.facebook.com/'+ sosid +'/picture?type=normal';
					var gender = response.gender;

					if(sosid === undefined || sosid == '' || sosid == null){ return false; }
					if(fullname === undefined || fullname == '' || fullname == null){ return false; }
					if(email === undefined || email == '' || email == null){ return false; }
					
					$.ajax({
						type: "POST",
						dataType: 'json',
						data: 'sosid='+ sosid + '&fullname='+ fullname + '&email='+ email + '&avatar='+ avatar + '&gender='+ gender + '&provider=facebook&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash();?>',
						url: '<?php echo base_url("auth/facebook"); ?>',
					}).done(function( data ) {
						window.location.href = '<?php echo base_url(); ?>';
					}).fail(function(error) {
					});
				});
			}
		}, {
			scope: 'public_profile,email,user_friends',
			return_scopes: true
		});
	}
	
	var winTop = (screen.height / 2) - 200;
	var winLeft = (screen.width / 2) - 325;
	
	function fbShare(identifier, e) {
		var title = $(identifier).data('title');
		var describe = $(identifier).data('describe');
		var cover = $(identifier).data('cover');
		var slug = $(identifier).data('slug');

		FB.ui( {
			method: 'feed',
			name: title,
			link: slug,
			picture: cover,
			caption: '<?php echo $_SERVER['HTTP_HOST'];?>',
			description: describe,
			redirect_uri: slug
		}, function( response ) {
		});
	}
	
	function twShare(identifier, e) {
		var title = $(identifier).data('title');
		var describe = $(identifier).data('describe');
		var cover = $(identifier).data('cover');
		var slug = $(identifier).data('slug');
		
		window.open('https://twitter.com/intent/tweet?url='+ slug +'&text='+ title +'&hashtags=sayasigap&via=ID_Nature','Twitter Share','top=' + winTop + ',left=' + winLeft + ',height=400,width=650');
	}
</script>
	
</body>
</html>