<?php
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('접근권한이 없습니다.');

$pid = na_fid($pid);

if(!$pid)
    alert('값이 제대로 넘어오지 않았습니다.');

// 파일
$pc_file = G5_THEME_PATH.'/storage/page/page-'.$pid.'-pc.php';
$mo_file = G5_THEME_PATH.'/storage/page/page-'.$pid.'-mo.php';

// 초기화
if($freset) {
	na_file_delete($pc_file);
	na_file_delete($mo_file);

	goto_url('./page_setup.php?pid='.urlencode($pid));
}

// 페이지 아이콘 재가공
if(isset($_POST['co']['page_icon']) && $_POST['co']['page_icon'] == 'fa-') {
	$_POST['co']['page_icon'] = '';
}

// 공통설정
$co = (isset($_POST['co']) && is_array($_POST['co'])) ? na_repack($_POST['co']) : array();


// PC 설정
$pc = (isset($_POST['pc']) && is_array($_POST['pc'])) ? na_repack($_POST['pc']) : array();
na_file_var_save($pc_file, array_merge($co, $pc), 1); //폴더 퍼미션 체크

// 모바일 설정
$mo = (isset($_POST['mo']) && is_array($_POST['mo'])) ? na_repack($_POST['mo']) : array();
na_file_var_save($mo_file, array_merge($co, $mo));

goto_url('./page_setup.php?pid='.urlencode($pid));

?>