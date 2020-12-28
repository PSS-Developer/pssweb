<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert('접근권한이 없습니다.');
}

if( function_exists('social_check_login_before') ){
    $social_login_html = social_check_login_before();
}

// 페이지 주소 지정
$phref = G5_BBS_URL.'/login.php';

$g5['title'] = '로그인';
include_once('../head.sub.php');

$url = '';
$login_url = '#';
$login_action_url = '';

// 로그인 스킨이 없는 경우 관리자 페이지 접속이 안되는 것을 막기 위하여 기본 스킨으로 대체
$login_file = $member_skin_path.'/login.skin.php';
if (!file_exists($login_file))
    $member_skin_path   = G5_SKIN_PATH.'/member/basic';

include_once($member_skin_path.'/login.skin.php');

run_event('member_login_tail', $login_url, $login_action_url, $member_skin_path, $url);

include_once(NA_THEME_ADMIN_PATH.'/theme_admin_menu.php');
include_once('../tail.sub.php');
?>
