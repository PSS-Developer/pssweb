<?php
include_once('./_common.php');

if (!IS_DEMO) {
    alert('데모 사이트에서만 가능합니다.');
}

$mode = na_fid($mode);

if(!$mode)
    alert('값이 정상적으로 넘어오지 않았습니다.');

// 초기화
$pv_name = $config['cf_theme'].'_'.$mode; //세션명
if($freset) {
	set_session($pv_name, '');
	goto_url('./preview.php?mode='.urlencode($mode));
}

// PC 설정
if (isset($_POST['pc']) && is_array($_POST['pc'])) {
	$pc = array();
	$pc = (isset($_POST['co']) && is_array($_POST['co'])) ? array_merge($_POST['co'], $_POST['pc']) : $_POST['pc'];
	$pv = na_pack($pc);
} else {
	$pv = '';
}

set_session($pv_name, $pv);

goto_url('./preview.php?mode='.urlencode($mode));

?>