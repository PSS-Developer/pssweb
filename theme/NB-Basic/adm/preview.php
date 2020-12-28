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

$g5['title'] = ($mode == 'shop') ? '쇼핑몰 미리보기' : '사이트 미리보기';
include_once('../head.sub.php');

// 페이지 설정
if($mode == 'shop') {
	$tset['page_title'] = '쇼핑몰 미리보기';
	$tset['page_desc'] = '데모 사이트의 쇼핑몰 기본 레이아웃 및 스타일을 설정합니다.';
} else {
	$tset['page_title'] = '사이트 미리보기';
	$tset['page_desc'] = '데모 사이트의 사이트 기본 레이아웃 및 스타일을 설정합니다.';
}

// 1단
define('IS_ONECOLUMN', true);

include_once('../head.php');

// 미리보기 설정값 불러오기
$pv_name = $config['cf_theme'].'_'.$mode;
$pv = get_session($pv_name);
if($pv) {
	$pc = na_unpack(stripslashes($pv));
} else {
	$pc = na_file_var_load(G5_THEME_PATH.'/adm/theme-'.$mode.'-setting.php');
}

// 모달 내 모달 체크
$is_modal_win = false;
$is_preview = true;

// 좌우 페딩값 설정
$px_css = ' px-3 px-sm-0';
$sel_option = '';
?>

<div class="alert alert-warning mx-3 mx-sm-0" role="alert">
	데모 사이트의 테마 레이아웃, 스타일 등에 대한 미리보기 설정 페이지로 <b class="font-weight-bold">PC 설정값만 적용</b>됩니다.
</div>

<style>
	#fsetup .list-group-item {
		padding-left:0;
		padding-right:0;
	}
</style>
<form id="fsetup" name="fsetup" method="post" action="./preview_update.php" class="f-de font-weight-normal">
<input type="hidden" name="mode" value="<?php echo $mode ?>">
<?php include_once(NA_THEME_ADMIN_PATH.'/setup_form.php') ?>
</form>
<?php include_once('../tail.php') ?>