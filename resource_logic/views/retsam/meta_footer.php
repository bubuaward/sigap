<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- preloader markup default: display-none -->
<div class="preloader" id="preloading">
	<div class="preloader__body">
		<div class="preloader4"></div>
	</div>
</div>
<style>
.preloader{display:none;position:fixed;top:0;left:0;width:100%;height:100%;overflow:hidden;background:rgba(255,255,255,0.8);z-index:999}.preloader__body{position:absolute;left:50%;top:50%;-moz-transform:translate(-50%, -50%);-ms-transform:translate(-50%, -50%);-webkit-transform:translate(-50%, -50%);transform:translate(-50%, -50%)}.preloader4{width:50px;height:50px;display:inline-block;padding:0px;border-radius:100%;border:5px solid;border-top-color:#ffae00;border-bottom-color:#1d9f58;border-left-color:#ffae00;border-right-color:#1d9f58;-webkit-animation:preloader4 0.8s linear infinite;animation:preloader4 0.8s linear infinite}@keyframes preloader4{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}@-webkit-keyframes preloader4{from{-webkit-transform:rotate(0deg)}to{-webkit-transform:rotate(360deg)}}.preloader-gallery{position:absolute;display:none;width:100%;height:100%;top:0;left:0;background:rgba(255,255,255,0.8)}
</style>

	<script>
	$(document).ready(function() {	
		<?php if($this->session->flashdata('msg')){ ?>
			$('body').append('<div class="notifpopx" id="notifpop-blank" style="display:block; display: block;position: fixed;right: 15px;z-index: 99999;top: 65px;">\
				<div class="notifpop-blockx" style="width: 320px; background-color: #222d32; color: #fff; text-align: center;padding: 18px 19px 10px 19px;">\
					<a href="javascript:;" class="notifpop-closed" style="float: right;margin:-15px 0px;color: rgb(255, 0, 0);font-size: 21px;"><i class="fa fa-times"></i></a>\
					<p style="border-bottom:1px solid #ccc;">Information System</p>\
					<p><?php echo $this->session->flashdata('msg');?></p>\
				</div>\
			</div>');
		<?php } ?>
		
		$('.notifpop-closed').click(function()
		{
			$('.notifpopx').fadeOut(300);
		});
		
		$('.date').datepicker({
			todayBtn: "linked",
			autoclose: true,
			format: 'yyyy-mm-dd',
			todayHighlight: true
		});
		
		$('.datetime').datetimepicker({	
			weekStart: 1,
			todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
			showMeridian: 0
		});
		
		$('.inp').on('change keyup keydown', 'input, textarea, select', function () {
			$(this).addClass('changed-input');
		});

		$(".nextinp").click(function() {
			$('.inp input, .inp textarea, .inp select').removeClass('changed-input');
			$(this).submit();
		});

		$(window).on('beforeunload', function () {
			if ($('.changed-input').length) {
				return 'You haven\'t saved your changes.';
			}
		});
	});
	
	function checkedbutton(link){
		var answer = confirm('Hai <?php echo ($this->session->userdata('isloginaccount')? $this->session->userdata['isloginaccount']['fullname']:'Admin');?>, Are you sure want to perform this action?');
		if (answer){
			window.location = link;
		}
		return false;  
	}
	
	function youtubegetid(identity){
		var url = $(identity).val();
		var ID = '';
		url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
		if(url[2] !== undefined) {
			ID = url[2].split(/[^0-9a-z_\-]/i);
			ID = ID[0];
		}
		else {
			ID = url;
		}
		
		$(identity).empty().val(ID);
		return true;
	}
	</script>
</body>
</html>