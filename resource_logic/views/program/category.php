<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- wrapper content -->
<div class="wrap-all-content wrap-all-content-page-info">
	<div class="wrap-section-1">
		<div class="content-post-info-desc">
			<img src="<?php echo $meta_picture;?>" alt="<?php echo $meta_title;?>">
			<div class="overlay-page-info-desc">
				<div class="container">
					<div class="c-post-meta-desc">
						<h2><?php echo $detail->title;?></h2>
						<p><?php echo $detail->description;?></p>
						<div class="bt-c-post-donate">
							<a href="<?php echo base_lang('donasi?ref='.$detail->slug);?>">donasi</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
			<!-- box -->
			<div class="wrap-content-box-home">
				<!-- heading -->
				<div class="content-box-heading-top">
					<h1><?php echo $meta_title;?></h1>
				</div>
				<div class="row">
					<?php
					if($alldata){
						foreach($alldata AS $red){
							echo '<div class="col-sm-4">
								<div class="item-box-content-home">
									<div class="i-box-c-home-img">
										<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
									</div>
									<div class="i-box-c-home-info">
										<h3>'.$red->title.'</h3>
										<p>
										'.clean_html($red->teaser).'
										</p>
										<div class="bt-readmore2">
											<a href="'.base_lang('program/'.$red->slug).'">'.translation('readmore').'</a>
										</div>
									</div>
								</div>
							</div>';
						}
					}else{
						echo '<h1>'.translation('title_404').'</h1>';
					}
					?>
				</div>
				
				<!-- pagination -->
				<div class="wrap-pagination-post">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
	</div>
</div>