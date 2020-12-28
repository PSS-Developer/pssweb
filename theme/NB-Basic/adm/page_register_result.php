<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert('접근권한이 없습니다.');
}

$mb['mb_name'] = '게스트';
$mb['mb_id'] = 'guest';
$mb['mb_email'] = 'guest@e-mail.com';
$default['de_member_reg_coupon_price'] = 10000;
$default['de_member_reg_coupon_minimum'] = 50000;

// 페이지 주소 지정
$phref = G5_BBS_URL.'/register_result.php';

$g5['title'] = '회원가입 완료';
include_once('../head.php');
include_once($member_skin_path.'/register_result.skin.php');
include_once('../tail.php');
?>