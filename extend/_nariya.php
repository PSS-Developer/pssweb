<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 나리야 빌더에서만 작동
if (!defined('NA_URL'))
	return;

// 모바일 스킨 경로 조정
if(G5_IS_MOBILE) {
	if(isset($board['bo_mobile_skin']) && $board['bo_mobile_skin'] === 'PC-Skin') {
		$board_skin_path    = na_skin_path('board', $board['bo_skin']);
		$board_skin_url     = na_skin_url('board', $board['bo_skin']);
	}
	if($config['cf_mobile_member_skin'] === 'PC-Skin') {
		$member_skin_path   = na_skin_path('member', $config['cf_member_skin']);
		$member_skin_url    = na_skin_url('member', $config['cf_member_skin']);
	}
	if($config['cf_mobile_new_skin'] === 'PC-Skin') {
		$new_skin_path      = na_skin_path('new', $config['cf_new_skin']);
		$new_skin_url       = na_skin_url('new', $config['cf_new_skin']);
	}
	if($config['cf_mobile_search_skin'] === 'PC-Skin') {
		$search_skin_path   = na_skin_path('search', $config['cf_search_skin']);
		$search_skin_url    = na_skin_url('search', $config['cf_search_skin']);
	}
	if($config['cf_mobile_connect_skin'] === 'PC-Skin') {
		$connect_skin_path  = na_skin_path('connect', $config['cf_connect_skin']);
		$connect_skin_url   = na_skin_url('connect', $config['cf_connect_skin']);
	}
	if($config['cf_mobile_faq_skin'] === 'PC-Skin') {
		$faq_skin_path      = na_skin_path('faq', $config['cf_faq_skin']);
		$faq_skin_url       = na_skin_url('faq', $config['cf_faq_skin']);
	}
}

// 로그인 경험치
if(IS_NA_XP && isset($nariya['xp_login']) && $nariya['xp_login']) {
	if(substr($member['mb_today_login'], 0, 10) != G5_TIME_YMD) {
		na_insert_xp($member['mb_id'], $nariya['xp_login'], G5_TIME_YMD.' 로그인', '@login', $member['mb_id'], G5_TIME_YMD);
	}
}

// 게시판 설정
if(isset($board['bo_table']) && $board['bo_table']) {
	$boset = na_skin_config('board', $board['bo_table']);
	if($is_member && !$is_admin && isset($boset['bo_admin']) && $boset['bo_admin'])
		na_admin($boset['bo_admin'], 1);

	// board.php 에서만 실행
	if(basename($_SERVER['SCRIPT_FILENAME']) == 'board.php')
		@include_once($board_skin_path.'/_extend.php');
}

?>