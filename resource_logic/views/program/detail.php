<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- wrapper content -->
<div class="wrap-all-content">
	<div class="wrap-section-1">
		<div class="container">
			<!-- post -->
			<div class="wrap-news-content">
				<div class="n-post-top">
					<div class="row">
						<div class="col-md-4">
							<div class="n-post-top-left">
								<h2><?php echo $detail->title;?></h2>
								<div class="meta-post-place-1"><i class="fa fa-map-marker"></i><?php echo $detail->location_name;?></div>
								<div class="meta-post-place-1"><i class="fa fa-globe"></i><?php echo $detail->geography_name;?></div>
								<h4><?php echo translation('detail_program_sosmed_share');?></h4>
								<div class="social-share-post">
									<div class="item-soc-post">
										<a href="javascript:;" onClick="return fbShare(this, event)" data-title="<?php echo $detail->title;?>" data-describe="<?php echo clean_html($detail->description);?>" data-cover="<?php echo base_url('storage/content/'.$detail->cover);?>" data-slug="<?php echo base_lang('program/'.$detail->slug);?>">
											<div class="item-soc-post1 i-soc-fb">
												<i class="fa fa-facebook"></i>
											</div>
											<div class="clear"></div>
										</a>
									</div>
									<div class="item-soc-post">
										<a href="javascript:;" onClick="return twShare(this, event)" data-title="<?php echo $detail->title;?>" data-describe="<?php echo clean_html($detail->description);?>" data-cover="<?php echo base_url('storage/content/'.$detail->cover);?>" data-slug="<?php echo base_lang('program/'.$detail->slug);?>">
											<div class="item-soc-post1 i-soc-tw">
												<i class="fa fa-twitter"></i>
											</div>
											<div class="clear"></div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="n-post-top-right">
								<?php
								if($detail->video){
									echo '<a href="https://www.youtube.com/watch?v='.$detail->video.'" data-toggle="lightbox"><i class="fa fa-play"></i></a>';
								}
								?>
								<img src="<?php echo base_url('storage/content/'.$detail->cover);?>" alt="">
							</div>
						</div>
					</div>
				</div>
				<div class="n-post-top-desc">
					<?php echo $detail->description;?>
					
					<div class="n-post-gallery">
						<div class="row">
							<?php
							$video = FALSE;
							$image = '';
							$count_image = 0;
							foreach($gallery AS $red){
								//video
								if($red->video){
									if(!$video){
										echo '<div class="col-sm-6">
											<div class="item-post-gal">
												<a href="https://www.youtube.com/watch?v='.$red->video.'" data-toggle="lightbox"><i class="fa fa-play"></i></a>
												<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$detail->title.'">
											</div>
										</div>';
									}
									
									$video = TRUE;
								}
								
								//image
								if($red->cover){
									if($count_image % 6 == 0){
										$image .= '<div class="item">
										<div class="row">';
									}
									
									if($red->video){
										$image .= '<div class="col-xs-4">
											<div class="wrap-item-post-gal-sm">
												<div class="item-post-gal-sm">
													<a href="https://www.youtube.com/watch?v='.$red->video.'" data-toggle="lightbox"><i class="fa fa-play"></i></a>
													<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$detail->title.'">
												</div>
												<p>&#169; '.$red->copyright.'</p>
											</div>
										</div>';
									}else{
										$image .= '<div class="col-xs-4">
											<div class="wrap-item-post-gal-sm">
												<div class="item-post-gal-sm">
													<a href="'.base_url('storage/content/'.$red->cover).'" data-lightbox="roadtrip" data-title="&#169; '.$red->copyright.'"></a>
													<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$detail->title.'">
												</div>
												<p>&#169; '.$red->copyright.'</p>
											</div>
										</div>';
									}
									
									$count_image += 1;
									if($count_image % 6 == 0 || $count_image == count($gallery)){
										$image .= '</div>
											</div>';
									}
								}
							}
							
							//slider gallery
							if($image){
								echo '<div class="'.($video ? 'col-sm-6':'col-sm-12').'">
									<div class="wrap-gal-content-slide">
										<div class="gal-content-slide">
											'.($video ? $image : str_replace('col-xs-4','col-xs-4 col-sm-4', $image)).'
										</div>
										<div class="gal-content-slide-left">
											<i class="fa fa-angle-left"></i>
										</div>
										<div class="gal-content-slide-right">
											<i class="fa fa-angle-right"></i>
										</div>
									</div>
								</div>';
							}
							?>
						</div>
					</div>
					
					<div class="wrap-content-box-post">
						<div class="row">
							<?php
							if($related){
								foreach($related AS $red){
									echo '<div class="col-sm-4">
										<div class="item-box-content-home">
											<div class="i-box-c-home-img">
												<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
											</div>
											<div class="i-box-c-home-info i-box-c-home-info-post">
												<a href="'.base_lang('program/'.$red->slug).'"><h3>'.$red->title.'</h3></a>
											</div>
										</div>
									</div>';
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>