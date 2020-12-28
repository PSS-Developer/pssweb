<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Page Loader 때문에 먼저 실행함
include_once(G5_THEME_PATH.'/head.sub.php');

$is_index = true;
$is_wing = false;

include_once(G5_THEME_PATH.'/_loader.php');

// 팝업레이어는 index에서만 실행
if(G5_IS_MOBILE) {
	include G5_MOBILE_PATH.'/newwin.inc.php';
} else {
	include G5_BBS_PATH.'/newwin.inc.php';
}

include_once(G5_THEME_PATH.'/head.php');

// 인덱스 파일경로
$nt_index_path = G5_THEME_PATH.'/index'; 
$nt_index_url = G5_THEME_URL.'/index';

// 데모용 인덱스
if(IS_DEMO && isset($demo) && $demo) {
	$tset['index'] = na_fid($demo);
}

//인덱스
if(is_file($nt_index_path.'/'.$tset['index'].'.php')) {
	include_once($nt_index_path.'/'.$tset['index'].'.php');
} else {
?>
	<div class="text-muted text-center" style="padding:300px 0px;">
		<?php if($is_admin == 'super') { ?>
			<a href="<?php echo NA_THEME_ADMIN_URL ?>/site_setup.php#index_setup">
				테마 설정 > 사이트 설정에서 인덱스 파일을 설정해 주세요.
			</a>
		<?php } else { ?>
			인덱스 파일을 찾을 수 없습니다.
			<p>관리자에게 알려주시면 감사하겠습니다.</p>
		<?php } ?>
	</div>
<?php
}

include_once(G5_THEME_PATH.'/tail.php');
?>