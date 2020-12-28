<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert('접근권한이 없습니다.');
}

// 페이지 주소 지정
$phref = G5_BBS_URL.'/register.php';

$g5['title'] = '회원가입약관';
include_once('../head.php');

$register_action_url = '';
include_once($member_skin_path.'/register.skin.php');

include_once('../tail.php');
?>