<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- wrapper content -->
<div class="wrap-all-content">
	<div class="wrap-section-1">
		<div class="container">
			<!-- slider -->
			<div class="slider-header slider-header-f2">
				<?php
				if($active_homeslider){
					foreach($active_homeslider AS $red){
						echo '<div class="item">
							<div class="item-slide-h">
								<img src="'.base_url('storage/homeslider/'.$red->cover).'" alt="'.$red->title.'">
								<div class="overlay-item-slide-table">
									<div class="overlay-item-slide">
										<div class="con-width-overlay-slide">
											<h2>'.$red->title.'</h2>
											'.($red->location ? '<h4><i class="fa fa-map-marker"></i> '.$red->location.'</h4>':'').'
											<p>
												'.clean_html($red->description).'
											</p>
											<div class="bt-readmore">
												<a href="'.prep_url($red->url).'">'.translation('readmore').'</a>
											</div>
											<div style="position: absolute;bottom: 15px;left: 15px;">
											@'.$red->copyright.'
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
					}
				}
				?>
			</div>
			
			<!-- box -->
			<div class="wrap-content-box-home">
				<!-- heading -->
				<?php
				if($featured_program){
					foreach($featured_program AS $ft){
						if($ft->program_list){
							echo '<div class="content-box-heading-top">
								<h1>'.$ft->title.'</h1>
							</div>
							<div class="row">';
								foreach($ft->program_list AS $red){
									echo '<div class="col-sm-4">
										<div class="item-box-content-home">
											<div class="i-box-c-home-img">
												<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
											</div>
											<div class="i-box-c-home-info i-box-c-home-info-f2">
												<h3>'.$red->title.'</h3>
												<p>'.clean_html($red->teaser).'</p>
												<div class="bt-readmore2">
													<a href="'.base_lang('program/'.$red->slug).'">'.translation('readmore').'</a>
												</div>
											</div>
										</div>
									</div>';
								}
							echo '</div>';
						}
					}
				}
				?>
			</div>
		</div>
	</div>
</div>

<!-- content big full -->
<div class="wrap-featured-post-big" id="artikel-sec">
	<!-- big image 3 -->
	<?php if($featured_stories){ ?>
	<div class="wrap-f-big-image">
		<!-- big 1 -->
		<div class="item-big-img">
			<div class="slide-item-big-img">
				<!-- item 1 -->
				<?php
				foreach($featured_stories AS $no => $red){
					if(!in_array($no, array(0,1))){
						echo '<div class="item">
							<div class="i-big-images">
								<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
							</div>
							<div class="meta-item-big-images">
								<div class="meta-author">
									<div class="m-author-ava">
										<img src="'.base_url('storage/avatar/'.$red->avatar).'" alt="'.$red->fullname.'">
									</div>
									<div class="m-author-name">'.$red->fullname.'</div>
									<div class="clear"></div>
								</div>
								<h1><a href="'.base_lang('artikel/'.$red->slug).'">'.$red->title.'</a></h1>
							</div>
						</div>';
					}
				}
				?>
			</div>
			<div class="text-featured">
				<?php echo translation('featured_stories_title');?>
			</div>
			<div class="nav-slide-item-big">
				<div class="nav-slide-i-big-left">
					<i class="fa fa-angle-left"></i>
				</div>
				<div class="nav-slide-i-big-right">
					<i class="fa fa-angle-right"></i>
				</div>
			</div>
		</div>
		<!-- small 2 -->
		<div class="item-small-img">
			<!-- img small top -->
			<?php
			foreach($featured_stories AS $no => $red){
				if(in_array($no, array(0,1))){
					echo '<div class="wrap-item-small-img">
						<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
						<div class="meta-item-big-images">
							<div class="meta-author">
								<div class="m-author-ava">
									<img src="'.base_url('storage/avatar/'.$red->avatar).'" alt="'.$red->fullname.'">
								</div>
								<div class="m-author-name">'.$red->fullname.'</div>
								<div class="clear"></div>
							</div>
							<h1><a href="'.base_lang('artikel/'.$red->slug).'">'.$red->title.'</a></h1>
						</div>
					</div>';
				}
			}
			?>
		</div>
		<div class="clear"></div>
	</div>
	<?php } ?>
	
	<div class="container">
		<div class="wrap-sec-post">
			<!-- post top -->
			<div class="sec-post-top">
				<div class="row">
					<?php
					foreach($featured_article AS $red){
						echo '<div class="col-sm-4">
							<div class="wrap-post-top-meta-left">
								<h4>'.date('d F Y', strtotime($red->created)).'</h4>
								<h1><a href="'.base_lang('artikel/'.$red->slug).'">'.$red->title.'</a></h1>
								<hr class="line-text-post">
								<p>'.clean_html($red->teaser).'</p>
								<div class="post-top-author">
									by '.$red->fullname.'
								</div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="post-top-img">
								<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
							</div>
						</div>';
					}
					?>
				</div>
			</div>
			<!-- post small two column -->
			<div class="sec-post-2-col">
				<div class="row">
					<div class="col-sm-8">
						<div class="wrap-sec-post-2-left">
							<div class="sec-post-2-left-heading">
								<?php echo translation('latest_news_title');?>
							</div>
							<!-- item 1 -->
							<?php
							foreach($latest_article AS $red){
								echo '<div class="wrap-post-left-list">
									<div class="post-left-list-img">
										<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
									</div>
									<div class="post-left-list-meta">
										<h4>'.date('d F Y', strtotime($red->created)).'</h4>
										<h2><a href="'.base_lang('artikel/'.$red->slug).'">'.$red->title.'</a></h2>
										<h3>by '.$red->fullname.'</h3>
										<p>'.clean_html($red->teaser).'</p>
									</div>
									<div class="clear"></div>
								</div>';
							}
							?>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="wrap-sec-post-2-right">
							<div class="sec-post-2-right-heading">
								<?php echo translation('most_viewed_title');?>
							</div>
							<!-- item 1 -->
							<?php
							foreach($mostview_article AS $red){
								echo '<div class="wrap-post-2-right">
									<div class="post-2-right-img">
										<img src="'.base_url('storage/content/'.$red->cover).'" alt="'.$red->title.'">
									</div>
									<div class="post-2-right-meta">
										<h3>'.date('d F Y', strtotime($red->created)).'</h3>
										<h2><a href="'.base_lang('artikel/'.$red->slug).'">'.$red->title.'</a></h2>
									</div>
									<div class="clear"></div>
								</div>';
							}
							?>
						</div>
					</div>
				</div>
				<div class="bt-show-all">
					<a href="<?php echo base_lang('artikel');?>"><?php echo translation('readmore');?></a>
				</div>
			</div>
		</div>
	</div>
</div>