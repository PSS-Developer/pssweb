<?php
include_once ('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
	die('접근권한이 없습니다.');
}

if(!$board['bo_table'])
	die('존재하지 않는 게시판입니다.');

include_once(NA_PATH.'/lib/option.lib.php');

// 아이디 넘버링용
$idn = 1;

$is_skin = $board_skin_path.'/'.$type.'/'.$skin.'/setup.skin.php';
if(is_file($is_skin)) {
	@include_once($is_skin);
}
?>