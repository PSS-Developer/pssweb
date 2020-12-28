<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert('접근권한이 없습니다.');
}

// 페이지 주소 지정
$phref = G5_BBS_URL.'/password.php';

$g5['title'] = '비밀번호 입력';
include_once('../head.sub.php');

$action = '';
$return_url = '';
$w = 'u';

include_once($member_skin_path.'/password.skin.php');

include_once(NA_THEME_ADMIN_PATH.'/theme_admin_menu.php');
include_once('../tail.sub.php');
?>
