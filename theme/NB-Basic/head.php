<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');

// 헤더,테일 사용안함
if(isset($tset['page_sub']) && $tset['page_sub']) {
	return;
}

// 그누 최근글, 투표 스킨 외의 것을 사용하려면 아래 주석을 풀어 주세요.
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
//include_once(G5_LIB_PATH.'/outlogin.lib.php');
//include_once(G5_LIB_PATH.'/visit.lib.php');
//include_once(G5_LIB_PATH.'/connect.lib.php');
//include_once(G5_LIB_PATH.'/popular.lib.php');

// 메뉴, 메뉴수, 현재위치 정보 불러오기 - 전역변수로 사용
list($menu, $tnav) = na_menu('bbs', $pset['mid'], 1);
$menu_cnt = is_array($menu) ? count($menu) : 0;

// 회원정보 재가공
$member = na_member($member);

// 사이트 통계 - 전역변수로 사용
$stats = ($tset['stats']) ? na_stats($tset['stats']) : array();

// 로고 이미지
$tset['logo_img'] = ($tset['logo_img']) ? na_url($tset['logo_img']) : na_url('../img/logo.png');

// 로고 텍스트
$tset['logo_text'] = ($tset['logo_text']) ? $tset['logo_text'] : $config['cf_title'];

// 사이트 너비
$tset['size'] = (int)$tset['size'];
if(!$tset['size']) {
	$tset['size'] = 1100;
}

// 페이지 최대 너비
$tset['pmax'] = (int)$tset['pmax'];
if(!$tset['pmax']) {
	$tset['pmax'] = 1980;
}

// 레이아웃
switch($tset['layout']) {
	case 'ac' : $is_layout = ' boxed boxed-a m-lg-auto'; break;
	case 'bc' : $is_layout = ' boxed boxed-b m-lg-auto'; break;
	default	  : $is_layout = ''; break;
}

// 와이드일 때 배경이미지 미적용
if(!$is_layout) {
	$tset['bg_img'] = '';
}

// 페이지 레이아웃
$tset['scol'] = (int)$tset['scol'];
if(defined('IS_ONECOLUMN') && IS_ONECOLUMN) {
	$tset['scol'] = 0; // 1단 고정일 때
}

// 페이지 타이틀
$page_title = ($is_index || $tset['ptitle']) ? '' : na_page_title($tset);

// 날개
$is_wing = ($tset['wing']) ? true : false;

?>

<style>
.nt-container { max-width:<?php echo $tset['size'] ?>px; }
.nt-container-wide { max-width:<?php echo $tset['pmax'] ?>px; }
.boxed.wrapper, .boxed.wrapper #nt_menu_wrap.me-sticky nav { max-width:<?php echo $tset['size'] ?>px; }
.no-responsive .wrapper { min-width:<?php echo $tset['size'] ?>px; }
</style>

<div class="<?php echo (_RESPONSIVE_) ? 'overflow-hidden' : 'overflow-scroll'; ?>">
	<div class="wrapper <?php echo ($is_layout) ? $is_layout : 'wided'; ?>">
		<div id="nt_header">

			<!-- 상단 고정 체크 시작 { -->
			<div id="nt_sticky">

				<!-- LNB 시작 { -->
				<aside id="nt_lnb" class="d-none d-md-block f-sm font-weight-normal">
					<h3 class="sr-only">상단 네비</h3>
					<div class="nt-container clearfix pt-3 px-3 px-sm-4 px-xl-0">
						<!-- LNB Left -->
						<ul class="float-left">
							<li><a href="javascript:;" id="favorite">즐겨찾기</a></li>
							<li><a href="<?php echo G5_BBS_URL ?>/new.php">새글</a></li>
							<li><a><?php echo date('m월 d일') ?>(<?php $tweek = array("일", "월", "화", "수", "목", "금", "토"); echo $tweek[date("w")] ?>)</a></li>
						</ul>
						<!-- LNB Right -->
						<ul class="float-right">
						<?php if($is_member) { // 로그인 상태 ?>
							<li class="dropdown">
								<a href="javascript:;" onclick="sidebar('user')">
									내정보
								</a>
							</li>
							<?php if ($is_admin == 'super' || $member['is_auth']) { ?>
								<li>
									<a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
										관리자
									</a>
								</li>
							<?php } ?>
							<li>
								<a href="javascript:;" onclick="sidebar('noti')">
									알림 
									<span class="nt-noti-label<?php echo ($member['noti_cnt']) ? '' : ' d-none';?>">
										<b class="nt-noti-cnt orangered"><?php echo number_format($member['noti_cnt']) ?></b>
									</span>
								</a>
							</li>
						<?php } else { // 로그아웃 상태 ?>
							<li><a href="<?php echo G5_BBS_URL ?>/login.php?url=<?php echo $urlencode ?>" onclick="sidebar('login'); return false;">로그인</a></li>
							<li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>
							<li><a href="<?php echo G5_BBS_URL ?>/password_lost.php" class="win_password_lost">정보찾기</a></li>
						<?php } ?>
							<li><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a></li>
							<li><a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1문의</a></li>
							<?php if(IS_NA_BBS) { // 게시판 플러그인 ?>
								<li><a href="<?php echo G5_BBS_URL ?>/shingo.php">신고글</a></li>
							<?php } ?>
							<li>
							<?php if(isset($stats['now_total']) && $stats['now_total']) { ?>
								<a href="<?php echo G5_BBS_URL ?>/current_connect.php">접속자 <?php echo number_format($stats['now_total']) ?><?php echo ($stats['now_mb']) ? ' (<b class="orangered">'.number_format($stats['now_mb']).'</b>)' : ''; ?></a>
							<?php } else { ?>
								<a href="<?php echo G5_BBS_URL ?>/current_connect.php">접속자</a>
							<?php } ?>
							</li>
						<?php if($is_member) { ?>
							<li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
						<?php } ?>
						</ul>
					</div>
				</aside>
				<!-- } LNB 끝 -->

				<!-- PC 헤더 시작 { -->
				<header id="header_pc" class="d-none d-md-block">
					<div class="nt-container py-4 px-3 px-sm-4 px-xl-0">
						<div class="d-flex">
							<div class="align-self-center">
								<div class="header-logo">
									<a href="<?php echo NT_HOME_URL ?>">
										<img id="logo_img" src="<?php echo $tset['logo_img'] ?>" alt="<?php echo get_text($config['cf_title']) ?>">
									</a>
								</div>		  
							</div>
							<div class="align-self-center px-4">
								<div class="header-search">
									<form name="tsearch" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return tsearch_submit(this);" class="border-primary">
										<input type="hidden" name="sfl" value="wr_subject||wr_content">
										<input type="hidden" name="sop" value="and">
										<div class="input-group input-group-lg">
											<input type="text" name="stx" class="form-control en" value="<?php echo $stx ?>">
											<div class="input-group-append">
												<button type="submit" class="btn"><i class="fa fa-search fa-lg text-primary"></i></button>
											</div>
										</div>
									</form>
									<div class="header-keyword mt-2">
										<?php echo na_widget('data-keyword', 'popular', 'q=아미나,나리야,플러그인,그누보드5.4,부트스트랩4,테마,스킨,위젯,애드온'); ?>
									</div>
								</div>		  
							</div>
							<div class="align-self-center ml-auto">
								<!-- 배너 등 우측 영역 컨텐츠 -->



								&nbsp;
							</div>
						</div>
					</div>
				</header>
				<!-- } PC 헤더 끝 -->

				<!-- 상단고정 시작 { -->
				<div id="nt_sticky_wrap">
					<!-- 모바일 헤더 { -->
					<header id="header_mo" class="d-block d-md-none">
						<div class="bg-primary px-3 px-sm-4">
							<h3 class="clearfix text-center f-mo font-weight-bold en">
								<a href="javascript:;" onclick="sidebar('menu');" class="float-left">
									<i class="fa fa-bars text-white" aria-hidden="true"></i>
									<span class="sr-only">메뉴</span>
								</a>
								<div class="float-right">
									<a data-toggle="collapse" href="#search_mo" aria-expanded="false" aria-controls="search_mo" class="ml-3">
										<i class="fa fa-search text-white" aria-hidden="true"></i>
										<span class="sr-only">검색</span>
									</a>
								</div>
								<!-- Mobile Logo -->
								<a href="<?php echo NT_HOME_URL ?>" class="text-white">
									<?php echo $tset['logo_text'] ?>
								</a>
							</h3>
						</div>
						<div id="search_mo" class="collapse">
							<div class="mb-0 p-3 px-sm-4 d-block d-lg-none border-bottom">
								<form name="mosearch" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return tsearch_submit(this);" class="mb-0">
								<input type="hidden" name="sfl" value="wr_subject||wr_content">
								<input type="hidden" name="sop" value="and">
									<div class="input-group">
										<input id="mo_top_search" type="text" name="stx" class="form-control" value="<?php echo $stx ?>" placeholder="검색어">
										<span class="input-group-append">
											<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
										</span>
									</div>
								</form>
							</div>
						</div>
					</header>
					<!-- } 모바일 헤더 끝 -->

					<!-- 상단 메뉴 시작 { -->
					<?php include_once(G5_THEME_PATH.'/_menu.php') ?>
					<!-- } 상단 메뉴 끝 -->
				</div>
				<!-- } 상단 고정 끝 끝 -->
			</div>
			<!-- } 상단 고정 체크 끝 -->

			<?php if($page_title) { // 페이지 타이틀 시작 ?>
				<div id="nt_title" class="font-weight-normal">
					<div class="nt-container px-3 px-sm-4 px-xl-0">
						<div class="d-flex align-items-end h-100 pb-2">
							<div class="page-title en text-nowrap">
								<?php if($tset['page_icon']) { ?>
									<i class="fa <?php echo $tset['page_icon'] ?>" aria-hidden="true"></i>
								<?php } ?>
								<?php echo $page_title ?>
							</div>
							<div class="ml-auto d-none d-sm-block">
								<nav aria-label="breadcrumb" class="f-sm">
									<ol class="breadcrumb bg-transparent p-0 m-0">
										<?php
											// 페이지 설명글 없으면 현재 위치 출력
											$tnav_cnt = 0;
											$tnav_txt = $tset['page_desc'];
											if(!$tnav_txt) {
												$tnav_cnt = count($tnav);
												if(!$tnav_cnt) {
													$tnav_txt = $page_title;
												}
											}
										?>
										<?php if($tnav_txt) { ?>
											<li class="breadcrumb-item active mb-0" aria-current="page">
												<a href="#"><?php echo $tnav_txt ?></a>
											</li>
										<?php } ?>
										<?php if($tnav_cnt) { ?>
											<li class="breadcrumb-item mb-0">
												<a href="<?php echo NT_HOME_URL ?>"><i class="fa fa-home"></i></a>
											</li>
											<?php for($i=0; $i < $tnav_cnt; $i++) { ?>
												<li class="breadcrumb-item mb-0<?php echo (($i + 1) == $tnav_cnt) ? ' active" aria-current="page' : ''; ?>">
													<a href="<?php echo $tnav[$i]['href'] ?>" target="<?php echo $tnav[$i]['target'] ?>"><?php echo $tnav[$i]['text'] ?></a>
												</li>
											<?php } ?>
										<?php } ?>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			<?php } // 페이지 타이틀 끝 ?>

		</div><!-- #nt_header -->

		<?php
		// 날개 - 인덱스 및 와이드 페이지가 아닐 경우 출력
		if(!$is_index && $is_wing && !$tset['pwide'])
			@include_once (G5_THEME_PATH.'/_wing.php');
		?>

		<div id="nt_body" class="nt-body">
		<?php if(!$is_index) { // 인덱스가 아닌 경우 ?>
			<div class="<?php echo ($tset['pwide'] && !$is_layout) ? 'nt-container-wide my-3 my-sm-4 px-0 px-sm-4' : 'nt-container my-3 my-sm-4 px-0 px-sm-4 px-xl-0';?>">
			<?php if($tset['scol']) { ?>
				<div class="row na-row">
					<div class="col-md-<?php echo (12 - $tset['scol']) ?><?php echo ($tset['sloc'] == 'left') ? ' order-md-2' : '';?> na-col">
			<?php } ?>
		<?php } ?>
