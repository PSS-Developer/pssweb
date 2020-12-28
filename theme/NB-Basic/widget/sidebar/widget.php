<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

global $config, $member, $tset, $pset, $stats, $menu, $menu_cnt;
global $is_admin, $is_member, $is_index, $urlencode;

?>

<script>
var sidebar_url = "<?php echo $widget_url ?>";
var sidebar_noti_check = <?php echo (int)$tset['noti'] ?>;
</script>
<script src="<?php echo $widget_url ?>/widget.js"></script>

<aside id="nt_sidebar" class="bg-light font-weight-normal">

	<!-- Top Head -->
	<div id="nt_sidebar_header" class="sidebar-head na-shadow bg-primary px-3 mb-0">
		<h3 class="clearfix f-mo font-weight-bold en">
			<a href="<?php echo NT_HOME_URL ?>" class="text-white">
				<?php echo get_text($tset['logo_text']) ?>
			</a>
			<a href="javascript:;" class="float-right sidebar-close" title="닫기">
				<i class="fa fa-times text-white" aria-hidden="true"></i>
				<span class="sr-only">닫기</span>
			</a>
		</h3>
	</div>

	<!-- sidebar-content : 스크롤바 생성을 위해서 -->
	<div  id="nt_sidebar_body" class="sidebar-content pb-5">

		<!-- Icon -->
		<ul class="row row-cols-4 no-gutters f-sm text-center bg-white sidebar-icon mr-n1">
			<li class="col border-right border-bottom py-2">
				<a href="javascript:;" onclick="sidebar('menu')">
					<i class="ion-android-menu" aria-hidden="true"></i>
					<span class="d-block">메뉴</span>
				</a>			
			</li>
			<li class="col border-right border-bottom py-2">
				<a href="<?php echo G5_BBS_URL;?>/new.php">
					<i class="ion-ios-reload" aria-hidden="true"></i>
					<span class="d-block">새글</span>
				</a>			
			</li>
			<li class="col border-right border-bottom py-2">
				<a href="<?php echo G5_BBS_URL;?>/search.php">
					<i class="ion-ios-search" aria-hidden="true"></i>
					<span class="d-block">검색</span>
				</a>
			</li>
			<li class="col border-right border-bottom py-2">
				<a data-toggle="collapse" href="#sidebar_more_icon" role="button" aria-expanded="false" aria-controls="sidebar_more_icon">
					<i class="ion-ios-more" aria-hidden="true"></i>
					<span class="d-block">더보기</span>
				</a>
			</li>
		</ul>

		<div class="collapse" id="sidebar_more_icon">
			<ul class="row row-cols-4 no-gutters f-sm text-center bg-white sidebar-icon mr-n1">
				<?php if ($is_admin == 'super' || $member['is_auth']) { ?>
					<li class="col border-right border-bottom py-2">
						<a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
							<i class="ion-ios-world-outline" aria-hidden="true"></i>
							<span class="d-block">관리자</span>
						</a>
					</li>
				<?php } ?>
				<?php if($is_admin == 'super' || IS_DEMO) { ?>
					<li class="col border-right border-bottom py-2">
						<a href="javascript:;" data-toggle="modal" data-target="#theme_menu">
							<i class="ion-ios-color-wand-outline" aria-hidden="true"></i>
							<span class="d-block">테마설정</span>
						</a>
					</li>
					<li class="col border-right border-bottom py-2">
						<a href="javascript:;" class="widget-setup">
							<i class="ion-ios-gear-outline" aria-hidden="true"></i>
							<span class="d-block">위젯설정</span>
						</a>
					</li>
					<?php if(!$is_index) { // 인덱스가 아닌 경우 ?>
					<li class="col border-right border-bottom py-2">
							<a href="<?php echo NA_THEME_ADMIN_URL ?>/page_setup.php?pid=<?php echo urlencode($pset['pid']) ?>" class="btn-setup">
								<i class="ion-ios-list-outline" aria-hidden="true"></i>
								<span class="d-block">문서설정</span>
							</a>
						</li>
					<?php } ?>
				<?php } ?>
				<li class="col border-right border-bottom py-2">
					<a href="<?php echo G5_BBS_URL;?>/qalist.php">
						<i class="ion-ios-chatboxes-outline" aria-hidden="true"></i>
						<span class="d-block">1:1 문의</span>
					</a>
				</li>
				<li class="col border-right border-bottom py-2">
					<a href="<?php echo G5_BBS_URL;?>/faq.php">
						<i class="ion-ios-information-outline" aria-hidden="true"></i>
						<span class="d-block">FAQ</span>
					</a>
				</li>
				<li class="col border-right border-bottom py-2">
					<a href="<?php echo G5_BBS_URL;?>/tag.php">
						<i class="ion-ios-pricetags-outline" aria-hidden="true"></i>
						<span class="d-block">태그모음</span>
					</a>			
				</li>
				<li class="col border-right border-bottom py-2">
					<a href="<?php echo G5_BBS_URL;?>/shingo.php">
						<i class="ion-ios-locked-outline" aria-hidden="true"></i>
						<span class="d-block">신고모음</span>
					</a>
				</li>				
				<li class="col border-right border-bottom py-2">
					<a href="<?php echo G5_BBS_URL;?>/current_connect.php">
						<i class="ion-ios-location-outline" aria-hidden="true"></i>
						<span class="d-block">접속자</span>
					</a>
				</li>
				<li class="col border-right border-bottom py-2">
					<a data-toggle="collapse" href="#sidebar_more_icon" role="button" aria-expanded="false" aria-controls="sidebar_more_icon">
						<i class="ion-ios-close-outline" aria-hidden="true"></i>
						<span class="d-block">닫기</span>
					</a>
				</li>
			</ul>
		</div>
		<div class="mt-n1">
			<?php if($is_member) { // 로그인시 ?>
				<div class="btn-group w-100" role="group" aria-label="Member Menu">
					<a href="javascript:;" onclick="sidebar('user')" class="btn btn-primary text-white rounded-0" role="button">
						내정보
					</a>
					<a href="javascript:;" onclick="sidebar('noti')" class="btn btn-primary text-white" role="button" title="알림">
						<i class="fa fa-bell" aria-hidden="true"></i>
						<span class="sr-only">알림</span>
						<span class="nt-noti-label<?php echo (!$member['as_noti']) ? ' d-none' : '';?>">
							<b class="nt-noti-cnt"><?php echo number_format($member['as_noti']) ?></b>
						</span>
					</a>
					<a href="<?php echo G5_BBS_URL ?>/logout.php" class="btn btn-primary text-white rounded-0" role="button">
						로그아웃
					</a>
				</div>
				<!-- User -->
				<div id="sidebar-user" class="sidebar-item">
					<?php @include_once($widget_path.'/user.php') ?>
				</div>
			<?php } else { ?>
				<div class="btn-group w-100" role="group" aria-label="Member Menu">
					<a href="<?php echo G5_BBS_URL ?>/login.php?url=<?php echo $urlencode ?>" class="btn btn-primary text-white rounded-0" onclick="sidebar('login'); return false;" role="button">
						로그인
					</a>
					<a href="<?php echo G5_BBS_URL ?>/register.php" class="btn btn-primary text-white win" role="button">
						회원가입
					</a>
					<a href="<?php echo G5_BBS_URL ?>/password_lost.php" class="win_password_lost btn btn-primary text-white rounded-0" role="button">
						정보찾기
					</a>
				</div>
				<!-- Login -->
				<div id="sidebar-login" class="sidebar-item">
					<?php @include_once($widget_path.'/login.php') ?>
				</div>
			<?php } ?>
		</div>

		<!-- Menu -->
		<div id="sidebar-menu" class="sidebar-item">
			<?php @include_once($widget_path.'/menu.php') ?>
		</div>

		<!-- Noti -->
		<div id="sidebar-noti" class="sidebar-item">
			<div id="sidebar-noti-list"></div>
		</div>

	</div>

	<div id="nt_sidebar_footer"></div>
</aside>

<div id="nt_sidebar_mask" class="sidebar-close"></div>

<!-- 알림 안내 -->
<div id="nt_sidebar_noti" class="nt-noti-label bg-primary px-3 py-2<?php echo ($member['noti_cnt']) ? '' : ' d-none';?>">
	<a href="javascript:;" onclick="sidebar('noti')" title="알림">
		<i class="fa fa-bell text-white" aria-hidden="true"></i>
		<span class="sr-only">알림</span>
		<b class="nt-noti-cnt text-white f-de"><?php echo number_format($member['noti_cnt']) ?></b>
	</a>
</div>

<!-- 상단이동 버튼 -->
<div id="nt_sidebar_move">
	<span class="sidebar-move-top cursor"><i class="fa fa-chevron-up"></i></span>
	<span class="sidebar-move-bottom cursor"><i class="fa fa-chevron-down"></i></span>
</div>