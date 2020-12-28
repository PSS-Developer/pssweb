<?php
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert_close('접근권한이 없습니다.');

$mode = na_fid($mode);
$fid = na_fid($fid);

if(!$mode || !$fid) {
    alert_close('값이 제대로 넘어오지 않았습니다.');
}

if(!$_FILES['img_file']['tmp_name']) 
	alert("파일을 등록해 주세요.");

$upload_max_filesize = ini_get('upload_max_filesize');

if($_FILES['img_file']['error'][$i] == 1) {
	alert('파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.');
} else if ($_FILES['img_file']['error'][$i] != 0) {
	alert('파일이 정상적으로 업로드 되지 않았습니다.');
}

if(!preg_match("/(\.(jpg|jpeg|gif|png))$/i", $_FILES['img_file']['name']))
	alert('JPG, JPEG, GIF, PNG 파일만 등록이 가능합니다.');

if(strlen($_FILES['img_file']['name']) > 40)
	alert('확장자 포함해서 파일명을 40자 이내로 등록할 수 있습니다.'); 

if(!preg_match("/([-A-Za-z0-9_])$/", $_FILES['img_file']['name']))
	alert('파일명은 공백없이 영문자, 숫자, -, _ 만 사용 가능합니다.'); 

list($thumb) = explode('-', $_FILES['img_file']['name']);

if($thumb == 'thumb')
	alert('파일명이 thumb- 일 경우 썸네일 파일로 인식되기 때문에 등록할 수 없습니다.'); 

$spot = '';
if(is_uploaded_file($_FILES['img_file']['tmp_name'])) {

	$filename = $mode.'-'.$_FILES['img_file']['name'];

	$dest_file = G5_THEME_PATH.'/storage/image/'.$filename;

	// 기존파일 삭제
	@unlink($dest_file);

	// 파일등록
	@move_uploaded_file($_FILES['img_file']['tmp_name'], $dest_file);

	// 퍼미션변경
	@chmod($dest_file, G5_FILE_PERMISSION);

	$spot = '#'.urlencode(substr($filename, 0, strrpos($filename, '.')));
}

// 페이지 이동
$goto_url = './image_form.php?mode='.urlencode($mode);

if($fid)
	$goto_url .= '&amp;fid='.urlencode($fid);

if($win)
	$goto_url .= '&amp;win='.urlencode($win);

goto_url($goto_url.$spot);

?>