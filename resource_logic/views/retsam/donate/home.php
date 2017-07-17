<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
$(document).ready(function() {
	$('#datatablemaster').DataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sServerMethod": "GET",
		"bDeferRender": true,
		"sPaginationType": "full_numbers",
		"order": [[ 2, "desc" ]],
		'sAjaxSource': "<?php echo base_url(DIRADMIN.'/donate/ajax_master_datatable'); ?>",
		"columns": [
			{ "data": "order_id" },
			{ "data": "first_name" },
			{ "data": "created" },
			{ "data": "result_data" },
			{ "data": "agent" }
		]
	});
});
</script>

<!-- Content Wrapper -->
<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header clearfix">
		<h1 class="clearfix"><i class="fa fa-database"></i> <?php echo $meta_title;?></h1>
	</section>

	<!-- Main content -->
	<section class="content clearfix">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-sm-12">
				<!-- general form elements disabled -->
				<div class="box box-success">
					
					<div class="box-body">
						<table class="table table-striped table-hover table-condosed table-bordered dt-responsive display" id="datatablemaster">
							<thead>
								<tr>
									<th>Donate</th>
									<th>User</th>
									<th>Created</th>
									<th>Track Payment</th>
									<th>Track Agent</th>
								</tr>
							</thead>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>
function checkdonate(link){
	var answer = confirm('Hai <?php echo ($this->session->userdata('isloginaccount')? $this->session->userdata['isloginaccount']['fullname']:'Admin');?>, Are you sure want to perform this action?');
	if (answer){
		$('#preloading').show();
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: link,
		}).done(function( data ) {
			$('#preloading').hide();
			$('body').append('<div class="notifpopx" id="notifpop-blank" style="display:block; display: block;position: fixed;right: 15px;z-index: 99999;top: 65px;">\
				<div class="notifpop-blockx" style="width: 320px; background-color: #222d32; color: #fff; text-align: left;word-wrap: break-word;padding: 18px 19px 10px 19px;">\
					<a href="javascript:;" class="notifpop-closed" style="float: right;margin:-15px 0px;color: rgb(255, 0, 0);font-size: 21px;"><i class="fa fa-times"></i></a>\
					<p style="border-bottom:1px solid #ccc;">Information System</p>\
					<p>'+ data.message +'</p>\
				</div>\
			</div>');
			
			$('.notifpop-closed').click(function(){
				$('.notifpopx').fadeOut(300);
			});
		}).fail(function(error) {
			$('#preloading').hide();
			alert('Something error!');
		});
	}
	return false; 
}
</script>