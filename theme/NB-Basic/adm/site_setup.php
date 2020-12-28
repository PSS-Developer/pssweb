<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert('접근권한이 없습니다.');
}

$mode = na_fid($mode);

if(!$mode)
    alert('값이 정상적으로 넘어오지 않았습니다.');

$g5['title'] = ($mode == 'shop') ? '쇼핑몰 설정' : '사이트 설정';
include_once('../head.sub.php');

// 페이지 설정
if($mode == 'shop') {
	$tset['page_title'] = '쇼핑몰 설정';
	$tset['page_desc'] = '쇼핑몰 기본 레이아웃 및 스타일을 설정합니다.';
} else {
	$tset['page_title'] = '사이트 설정';
	$tset['page_desc'] = '사이트 기본 레이아웃 및 스타일을 설정합니다.';
}
$tset['side_lw'] = '0';
$tset['side_rw'] = '0';

// 1단
define('IS_ONECOLUMN', true);

include_once('../head.php');

if(is_file(G5_THEME_PATH.'/storage/theme-'.$mode.'-pc.php')) {
	$pc = na_file_var_load(G5_THEME_PATH.'/storage/theme-'.$mode.'-pc.php');
	$mo = na_file_var_load(G5_THEME_PATH.'/storage/theme-'.$mode.'-mo.php');
} else {
	$pc = na_file_var_load(G5_THEME_PATH.'/adm/theme-'.$mode.'-setting.php');
	$mo = $pc;
}

// 모달 내 모달 체크
$is_modal_win = false;
$is_preview = false;

// 좌우 페딩값 설정
$px_css = ' px-3 px-sm-0';
$sel_option = '';
?>
<?php if(IS_DEMO) { ?>
	<div class="alert alert-warning mx-3 mx-sm-0" role="alert">
		본 페이지는 테마 적용 후 사이트 좌측상단의 테마 설정(<i class="fa fa-desktop"></i> 아이콘)에서 볼 수 있습니다.
	</div>
<?php } ?>
<style>
	#fsetup .list-group-item {
		padding-left:0;
		padding-right:0;
	}
</style>
<form id="fsetup" name="fsetup" method="post" action="./site_update.php" class="f-de font-weight-normal">
<input type="hidden" name="mode" value="<?php echo $mode ?>">
<?php include_once(NA_THEME_ADMIN_PATH.'/setup_form.php') ?>
</form>
<?php include_once('../tail.php') ?>