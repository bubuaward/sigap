<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- wrapper content -->
<div class="wrap-all-content">
	<div class="wrap-section-1">
		<div class="container">
			<!-- post -->
			<div class="wrap-news-content">
				<div class="n-post-article">
					<h4><?php echo date('d F Y', strtotime($detail->created));?></h4>
					<h2><?php echo $detail->title;?></h2>
				</div>
				<div class="n-post-top-desc">
					<?php echo $detail->description;?>
					
					<div class="n-post-gallery n-post-gallery-cus">
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
				</div>
				<div class="meta-article-b">
					<div class="sec1-meta-article-b">
						<div class="sec1-m-a-ava">
							<img src="<?php echo base_url('storage/avatar/'.$detail->avatar);?>" alt="<?php echo $detail->fullname;?>">
						</div>
						<div class="sec1-m-a-info">
							<h3><?php echo translation('author');?></h3>
							<h2><?php echo $detail->fullname;?></h2>
						</div>
						<div class="clear"></div>
					</div>
					
					<div class="social-share-post social-share-post-art">
						<div class="social-share-post">
							<div class="item-soc-post">
								<a href="javascript:;" onClick="return fbShare(this, event)" data-title="<?php echo $detail->title;?>" data-describe="<?php echo clean_html($detail->description);?>" data-cover="<?php echo base_url('storage/content/'.$detail->cover);?>" data-slug="<?php echo base_lang('artikel/'.$detail->slug);?>">
									<div class="item-soc-post1 i-soc-fb">
										<i class="fa fa-facebook"></i>
									</div>
									<div class="clear"></div>
								</a>
							</div>
							<div class="item-soc-post">
								<a href="javascript:;" onClick="return twShare(this, event)" data-title="<?php echo $detail->title;?>" data-describe="<?php echo clean_html($detail->description);?>" data-cover="<?php echo base_url('storage/content/'.$detail->cover);?>" data-slug="<?php echo base_lang('artikel/'.$detail->slug);?>">
									<div class="item-soc-post1 i-soc-tw">
										<i class="fa fa-twitter"></i>
									</div>
									<div class="clear"></div>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="meta-article-post-latest">
					<?php
					if($related){
						echo '<h2>'.translation('related_title').'</h2>';
						foreach($related AS $red){
							echo '<div class="item-m-a-post-latest">
								<div class="item-sec-m-a-pl-img">
									<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
								</div>
								<div class="item-sec-m-a-pl-info">
									<h3>'.date('d F Y', strtotime($red->created)).'</h3>
									<h2><a href="'.base_lang('artikel/'.$red->slug).'">'.$red->title.'</a></h2>
								</div>
								<div class="clear"></div>
							</div>';
						}
					}
					?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
</div>