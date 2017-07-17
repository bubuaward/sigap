	<div class="wrapper">

		<header class="main-header">
			
			<a href="<?php echo base_url();?>" class="logo">
			  <span class="logo-mini">CMS</span>
			  <span class="logo-lg"><img src="<?php echo base_url('logo.png');?>"></span>
			</a>
				
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li><a href="<?php echo base_url(DIRADMIN.'/member/edit/'.auto_url($this->session->userdata['isloginaccount']['member_id']));?>" title="Edit Profile"><i class="fa fa-cogs"></i> Profile</a></li>
						<li><a href="<?php echo base_url(DIRADMIN.'/auth/logout');?>" title="Logout"><i class="fa fa-power-off"></i> Logout</a></li>
						<li><a href="<?php echo base_url();?>" target="_blank" title="View Web"><i class="fa fa-globe"></i> Web</a></li>
					</ul>
				</div>
			</nav>
		</header>
	  
		<!-- Left side column -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image"><img src="<?php echo base_url('favicon.png');?>" class="img-circle" alt="User Image" /></div>
					<div class="pull-left info"><p><?php echo $this->session->userdata['isloginaccount']['fullname'];?></p>
					<span style="font-size: 10px;">
						<?php
						function GregorianToHijriah($GYear, $GMonth, $GDay) {
							$y = $GYear;
							$m = $GMonth;
							$d = $GDay;
							$jd = GregoriantoJD($m, $d, $y);
							$l = $jd - 1948440 + 10632;
							$n = (int) (( $l - 1 ) / 10631);
							$l = $l - 10631 * $n + 354;
							$j = ( (int) (( 10985 - $l ) / 5316)) * ( (int) (( 50 * $l) / 17719)) + (
							(int) ( $l / 5670 )) * ( (int) (( 43 * $l ) / 15238 ));
							$l = $l - ( (int) (( 30 - $j ) / 15 )) * ( (int) (( 17719 * $j ) / 50)) - (
							(int) ( $j / 16 )) * ( (int) (( 15238 * $j ) / 43 )) + 29;
							$m = (int) (( 24 * $l ) / 709 );
							$d = $l - (int) (( 709 * $m ) / 24);
							$y = 30 * $n + $j - 30;
							 
							$Hijriah['year'] = $y;
							$Hijriah['month'] = $m;
							$Hijriah['day'] = $d;
							 
							return $Hijriah;
						}
						
						$GYear = date("Y");
						$GMonth = date("m");
						$GDay = date("d");
						 
						$bulanHijriah = array(1 => "Muharram", "Shofar", "Robi'ul Awwal", "Robi'uts Tsani",
						"Jumadil Ula", "Jumadil Akhiroh", "Rojab", "Sya'ban",
						"Romadhon", "Syawwal", "Dzulqo'dah", "Dzulhijjah");
						 
						$Hijriah = GregorianToHijriah($GYear, $GMonth, $GDay);
						 
						$tgl = $Hijriah['day'];
						$bln = $bulanHijriah[$Hijriah['month']];
						$thn = $Hijriah['year'];
						 
						echo '<small><span class="fa fa-calendar"></span>&nbsp; <span>'. $tgl.' '.$bln.' '.$thn.' Hijriah</span></small><br/>
						<small><span class="fa fa-calendar"></span>&nbsp; <span id="clock-wrapper"></span></small>';
						?>
					</span></div>
				</div>

				<!-- sidebar menu -->
				<ul class="sidebar-menu">
					<li class="header">MAIN NAVIGATION</li>
					<?php
					echo '<li'.($current_class == 'home' ? ' class="active"':'').'><a href="'.base_url(DIRADMIN).'"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>';
					foreach($sidemenu AS $mn){
						$classmn = explode('/', $mn->menu_slug);
						//if root menu
						if($mn->rootmenu == 'T'){
							//print the child
							if($mn->menu_slug === 'FALSE'){
								echo '<li class="treeview">
								<a href="javascript:;">
									<i class="'.$mn->icon.'"></i> <span>'.$mn->menu_name.'</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">';
								
								foreach($sidemenu AS $sbmn){
									$subclassmn = explode('/', $sbmn->menu_slug);
									if($mn->idmenu === $sbmn->idroot){
										echo '<li '.($current_class == $subclassmn[0] ? 'class="subroot"':'').'><a href="'.base_url(DIRADMIN.'/'.$sbmn->menu_slug).'"><i class="'.$sbmn->icon.'"></i>'.$sbmn->menu_name.'</a></li>';
									}
								}
								
								echo '</ul>
								</li>';
							}else{
								echo '<li'.($current_class == $classmn[0] ? ' class="active"':'').'><a href="'.base_url(DIRADMIN.'/'.$mn->menu_slug).'"><i class="'.$mn->icon.'"></i> <span>'.$mn->menu_name.'</span></a></li>';
							}
						}
					}
					?>
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>