<?php
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('접근권한이 없습니다.');

$wname = na_fid($wname);
$wid = na_fid($wid);

if(!$wname || !$wid)
    alert('값이 제대로 넘어오지 않았습니다.');

// 설정값아이디
$id = $wname.'-'.$wid;

// 파일
$pc_file = G5_THEME_PATH.'/storage/widget/widget-'.$id.'-pc.php';
$mo_file = G5_THEME_PATH.'/storage/widget/widget-'.$id.'-mo.php';

// 이동주소
$goto_url = './widget_form.php?wname='.urlencode($wname).'&amp;wid='.urlencode($wid).'&amp;optp='.urlencode($optp).'&amp;optm='.urlencode($optm);
if($wdir) {
    $wdir = preg_replace('/[^-A-Za-z0-9_\/]/i', '', trim(str_replace(G5_PATH, '', $wdir)));
	$goto_url .= '&amp;wdir='.urlencode($wdir);
}
if($opt) {
	$goto_url .= '&amp;opt=1';
}

// 초기화 - 캐시 삭제는 안함
if($freset) {
	na_file_delete($pc_file);
	na_file_delete($mo_file);
	goto_url($goto_url);
}

// 기본 위젯 설정
$pc = array();
$pc = $_POST['wset'];

// 기본 설정 저장
na_file_var_save($pc_file, $pc, 1); //폴더 퍼미션 체크

// 모바일 위젯 설정
$mo = array();
if(isset($_POST['mo'])) {
	$mo = $_POST['mo'];
	$mo = array_merge($pc, $mo);
} else {
	$mo = $pc;
}

// 모바일 설정 저장
na_file_var_save($mo_file, $mo);

// 위젯 파일 캐시 삭제
na_file_delete(G5_THEME_PATH.'/storage/cache/widget-'.$id.'-pc-cache.php');
na_file_delete(G5_THEME_PATH.'/storage/cache/widget-'.$id.'-mo-cache.php');

// 위젯 캐시 초기화
$c_id = $g5['ms_id'].'|'.$config['cf_theme'];
if($opt) {
	// 기본 애드온 캐시
	$c_name = $c_id.'|pa|'.$wid;
	sql_query(" update {$g5['na_cache']} set c_datetime = '0' where c_name = '$c_name' ", false);

	// 모바일 애드온 캐시
	$c_name = $c_id.'|ma|'.$wid;
	sql_query(" update {$g5['na_cache']} set c_datetime = '0' where c_name = '$c_name' ", false);
} else {
	// 기본 위젯 캐시
	$c_name = $c_id.'|pw|'.$wid;
	sql_query(" update {$g5['na_cache']} set c_datetime = '0' where c_name = '$c_name' ", false);

	// 모바일 위젯 캐시
	$c_name = $c_id.'|mw|'.$wid;
	sql_query(" update {$g5['na_cache']} set c_datetime = '0' where c_name = '$c_name' ", false);
}

goto_url($goto_url);
?>