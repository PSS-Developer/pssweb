<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 버전
define('NA_VERSION', '1.1.0.2');

// DB 테이블
$g5['na_cache'] = G5_TABLE_PREFIX.'na_cache';
$g5['na_noti'] = G5_TABLE_PREFIX.'na_noti';

// YC
if(!defined('IS_YC')) {
	(defined('G5_USE_SHOP') && G5_USE_SHOP) ? define('IS_YC', true) : define('IS_YC', false);
}

// DEMO
$dset = array();
if(!defined('IS_DEMO')) {
	(is_dir(G5_PATH.'/DEMO')) ? define('IS_DEMO', true) : define('IS_DEMO', false);
}

// Plugin
define('NA_DIR', 'nariya');
define('NA_URL', G5_URL.'/'.NA_DIR);
define('NA_PATH', G5_PATH.'/'.NA_DIR);

// Theme Admin
define('NA_THEME_ADMIN_URL', G5_THEME_URL.'/adm');
define('NA_THEME_ADMIN_PATH', G5_THEME_PATH.'/adm');

// 쿼리 확장 변수
$na_sql_where = '';
$na_sql_orderby = '';

// 클립용
$is_clip_modal = true;

// 기본 함수
include_once(NA_PATH.'/lib/core.lib.php');

// 기본 설정
$nariya = array();
$nariya = na_config('nariya');

// 알림
define('IS_NA_NOTI', $nariya['noti']);

// 게시판 플러그인
define('IS_NA_BBS', $nariya['bbs']);
if(IS_NA_BBS) {
	$g5['na_tag_log'] = G5_TABLE_PREFIX.'na_tag_log';
	$g5['na_tag'] = G5_TABLE_PREFIX.'na_tag';
	$g5['na_shingo'] = G5_TABLE_PREFIX.'na_shingo';
}

// 멤버쉽 플러그인
define('IS_NA_XP', $nariya['xp']);
if(IS_NA_XP) {
	$g5['na_xp'] = G5_TABLE_PREFIX.'na_xp';
}

if($is_member)
	na_admin();

// 관리자페이지에서는 사용 안함
if(defined('G5_IS_ADMIN') && !defined('_THEME_PREVIEW_')){
	// 관리자 페이지용
	include_once(NA_PATH.'/admin_hooks.php');
	return;
}

// 썸네일 함수
if(!IS_YC)
	include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 컨텐츠 함수
include_once(NA_PATH.'/lib/content.lib.php');

// 테마 함수
include_once(NA_PATH.'/lib/theme.lib.php');

// 게시판 스킨설정
$boset = array();

// 공통 후크
include_once(NA_PATH.'/hooks.php');

?>