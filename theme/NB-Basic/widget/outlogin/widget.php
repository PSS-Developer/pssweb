<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

/* 로그인 위젯 */

//필요한 전역변수 선언
global $config, $member, $is_member, $urlencode, $is_admin;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

?>

<div class="f-de font-weight-normal">

	<?php if($is_member) { //Login ?>

		<div class="d-flex align-items-center mb-3">
			<div class="pr-3">
				<img src="<?php echo na_member_photo($member['mb_id']) ?>" class="rounded-circle">
			</div>
			<div class="flex-grow-1 pt-2">
				<h5 class="hide-photo mb-2">
					<b style="letter-spacing:-1px;"><?php echo str_replace('sv_member', 'sv_member en', $member['sideview']); ?></b>
				</h5>
				<p class="f-sm">
				<?php echo ($member['mb_grade']) ? $member['mb_grade'] : $member['mb_level'].'등급'; ?>
				<?php if ($is_admin == 'super' || $member['is_auth']) { ?>
					<span class="na-bar"></span>
					<a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
						관리자
					</a>
				<?php } ?>
				</p>
			</div>
		</div>

		<div class="btn-group w-100" role="group" aria-label="Member Menu">
			<a href="javascript:;" onclick="sidebar('user')" class="btn btn-primary text-white" role="button">
				내정보
			</a>
			<a href="javascript:;" onclick="sidebar('noti')" class="btn btn-primary text-white" role="button">
				<i class="fa fa-bell" aria-hidden="true"></i>
				<span class="sr-only">알림</span>
				<span class="nt-noti-label<?php echo ($member['noti_cnt']) ? '' : ' d-none';?>">
					<b class="nt-noti-cnt"><?php echo number_format($member['noti_cnt']) ?></b>
				</span>
			</a>
			<a href="<?php echo G5_BBS_URL ?>/logout.php" class="btn btn-primary text-white" role="button">
				로그아웃
			</a>
		</div>

	<?php } else { //Logout ?>

		<form id="basic_outlogin" name="basic_outlogin" method="post" action="<?php echo G5_HTTPS_BBS_URL ?>/login_check.php" autocomplete="off">
		<input type="hidden" name="url" value="<?php echo $urlencode; ?>">
			<div class="form-group">
				<label for="outlogin_mb_id" class="sr-only">아이디<strong class="sr-only"> 필수</strong></label>						
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-user text-muted"></i></span>
					</div>
					<input type="text" name="mb_id" id="outlogin_mb_id" class="form-control required" placeholder="아이디">
				</div>
			</div>
			<div class="form-group">
				<label for="outlogin_mb_password" class="sr-only">비밀번호<strong class="sr-only"> 필수</strong></label>									
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-lock text-muted"></i></span>
					</div>
					<input type="password" name="mb_password" id="outlogin_mb_password" class="form-control required" placeholder="비밀번호">
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block btn-lg en">
					로그인
				</button>    
			</div>	

			<div class="clearfix f-sm">
				<div class="float-left">
					<div class="form-group mb-0">
						<div class="custom-control custom-switch">
						  <input type="checkbox" name="auto_login" class="custom-control-input remember-me" id="outlogin_remember_me">
						  <label class="custom-control-label float-left" for="outlogin_remember_me">자동로그인</label>
						</div>
					</div>
				</div>
				<div class="float-right">
					<a href="<?php echo G5_BBS_URL ?>/register.php">
						회원가입
					</a>
					<span class="na-bar"></span>
					<a href="<?php echo G5_BBS_URL ?>/password_lost.php" class="win_password_lost">
						정보찾기
					</a>
				</div>
			</div>
		</form>

        <?php
        // 소셜로그인 사용시 소셜로그인 버튼
        @include(get_social_skin_path().'/social_outlogin.skin.1.php');
        ?>

	<?php } //End ?>
</div>