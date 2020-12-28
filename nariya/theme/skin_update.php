<?php
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('접근권한이 없습니다.');

$skin = na_fid($skin);

$skin_arr = array('board', 'connect', 'faq', 'member', 'new', 'search', 'qa', 'tag', 'shingo', 'noti');
if($skin && in_array($skin, $skin_arr)) { 
	; //통과
	if($skin == 'board' && !$board['bo_table']) {
	   alert('존재하지 않는 게시판입니다.');
	}
} else {
	alert('값이 제대로 넘어오지 않았습니다.');
}

// 파일 및 이동주소
$goto_url = './skin_form.php?skin='.urlencode($skin);
if($skin == 'board') {
	$pc_file = G5_THEME_PATH.'/storage/board/board-'.$bo_table.'-pc.php';
	$mo_file = G5_THEME_PATH.'/storage/board/board-'.$bo_table.'-mo.php';
	$goto_url .= '&amp;bo_table='.urlencode($bo_table);
	$vars = $_POST['boset'];
} else {
	$pc_file = G5_THEME_PATH.'/storage/skin/skin-'.$skin.'-pc.php';
	$mo_file = G5_THEME_PATH.'/storage/skin/skin-'.$skin.'-mo.php';
	$vars = $_POST['wset'];
}

// 초기화 - 캐시 삭제는 안함
if($freset) {
	na_file_delete($pc_file);
	na_file_delete($mo_file);

	goto_url($goto_url);
}

// 값저장
if($both) {
	na_file_var_save($pc_file, $vars, 1); //폴더 퍼미션 체크
	na_file_var_save($mo_file, $vars); //폴더 퍼미션 체크
} else if(G5_IS_MOBILE) {
	na_file_var_save($mo_file, $vars, 1); //폴더 퍼미션 체크
} else {
	na_file_var_save($pc_file, $vars, 1); //폴더 퍼미션 체크
}

if($skin == 'board') {
	@include_once($board_skin_path.'/setup.update.skin.php');
}

goto_url($goto_url);
?>