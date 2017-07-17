<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- wrapper content -->
	<div class="wrap-all-content">
		<div class="wrap-about-sec-1">
			<div class="container">
				<div class="row">
					<?php if($video){ ?>
					<div class="col-md-6">
						<div class="about-vid-top">
							<a href="https://www.youtube.com/watch?v=<?php echo $video->url;?>" data-toggle="lightbox"><i class="fa fa-youtube-play"></i></a>
							<img src="<?php echo base_url('storage/content/'.$video->cover);?>" alt="">
						</div>
					</div>
					<?php } ?>
					
					<div class="col-md-6">
						<div class="about-desc-info">
							<?php echo translation('page_about_teaser');?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wrap-about-sec-2">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="a-sec-2-text">
							<?php echo translation('page_about_description');?>
						</div>
					</div>
					<?php 
					$image = '';
					$count_image = 0;
					foreach($gallery AS $red){
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
											<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->copyright.'">
										</div>
										<p>&#169; '.$red->copyright.'</p>
									</div>
								</div>';
							}else{
								$image .= '<div class="col-xs-4">
									<div class="wrap-item-post-gal-sm">
										<div class="item-post-gal-sm">
											<a href="'.base_url('storage/content/'.$red->cover).'" data-lightbox="roadtrip" data-title="&#169; '.$red->copyright.'"></a>
											<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->copyright.'">
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
						echo '<div class="col-md-6">
							<div class="wrap-gal-content-slide">
								<div class="gal-content-slide">
									'.$image.'
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
	</div>