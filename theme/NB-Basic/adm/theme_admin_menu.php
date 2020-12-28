<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Setup Modal
include_once (NA_PATH.'/theme/setup.php');

?>
<aside id="theme-controller" class="d-none d-md-block">
	<div class="fixed-top mx-n1" style="width:40px; margin-top:30px;">
		<div class="btn-group-vertical">
			<a href="javascript:;" class="btn btn-primary" title="테마 설정" data-toggle="modal" data-target="#theme_menu" role="button">
				<i class="fa fa-desktop" aria-hidden="true"></i>
				<span class="sr-only">테마 설정</span>
			</a>
			<a href="javascript:;" class="btn btn-primary widget-setup" title="위젯 설정" role="button">
				<i class="fa fa-cube" aria-hidden="true"></i>
				<span class="sr-only">위젯 설정</span>
			</a>
			<?php if(!$is_index) { // 인덱스가 아닌 경우 ?>
				<a href="<?php echo NA_THEME_ADMIN_URL ?>/page_setup.php?pid=<?php echo urlencode($pset['pid']) ?>" class="btn btn-primary btn-setup" title="페이지 설정" role="button">
					<i class="fa fa-sticky-note-o" aria-hidden="true"></i>
					<span class="sr-only">페이지 설정</span>
				</a>
			<?php } ?>
		</div>	
	</div>
</aside>

<div id="theme_menu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myThemeAdminMenu" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
	<div class="modal-content">
		<ul class="list-group f-de">
			<li class="list-group-item bg-primary text-white border-left-0 border-right-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white">&times;</span>
				</button>
				<h5><b>테마 설정</b></h5>
			</li>
			<li class="list-group-item  border-left-0 border-right-0 ">
				<a href="<?php echo NA_THEME_ADMIN_URL ?>/site_setup.php?mode=bbs">
					사이트 설정
				</a>
			</li>
			<li class="list-group-item border-left-0 border-right-0">
				<a href="<?php echo NA_THEME_ADMIN_URL ?>/menu_form.php?mode=bbs">
					메뉴 설정
				</a>
			</li>
			<li class="list-group-item border-left-0 border-right-0">
				<a href="<?php echo NA_THEME_ADMIN_URL ?>/guide.php">
					사용 가이드
				</a>
			</li>
			<li class="list-group-item border-left-0 border-right-0">
				<a href="<?php echo NA_THEME_ADMIN_URL ?>/notice.php">
					테마 안내
				</a>
			</li>
			<li class="list-group-item bg-light border-left-0 border-right-0">
				<b>비회원 페이지 설정</b>
			</a>
			</li>
			<?php
				$parr = array();
				$parr[] = array('login.php', '로그인');
				$parr[] = array('register.php', '회원약관');
				$parr[] = array('register_form.php', '회원가입');
				$parr[] = array('register_result.php', '회원가입완료');
				$parr[] = array('register_email.php', '인증메일변경');
				$parr[] = array('member_confirm.php', '회원비번확인');
				$parr[] = array('password.php', '비밀번호입력');

				for($i=0; $i < count($parr); $i++) {
			?>
			<li class="list-group-item border-left-0 border-right-0">
				<a href="<?php echo NA_THEME_ADMIN_URL ?>/page_<?php echo $parr[$i][0] ?>">
					<?php echo $parr[$i][1] ?> 페이지
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
  </div>
</div>
