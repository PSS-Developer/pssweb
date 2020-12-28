<?php
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('접근권한이 없습니다.');

if(!$board['bo_table'])
   alert('값이 제대로 넘어오지 않았습니다.');

$_POST['chk_bo_table'] = (is_array($_POST['chk_bo_table'])) ? $_POST['chk_bo_table'] : array();

if(!count($_POST['chk_bo_table']))
    alert('설정을 복사해 줄 게시판을 한개 이상 선택해 주십시오.');

include_once(G5_THEME_PATH.'/head.sub.php');

$org_pc = G5_THEME_PATH.'/storage/board/board-'.$bo_table.'-pc.php';
$org_mo = G5_THEME_PATH.'/storage/board/board-'.$bo_table.'-mo.php';

$is_pc = (is_file($org_pc)) ? true : false;
$is_mo = (is_file($org_mo)) ? true : false;

for ($i=0; $i<count($_POST['chk_bo_table']); $i++) {
	$copy_bo_table = preg_replace('/[^a-z0-9_]/i', '', $_POST['chk_bo_table'][$i]);

	if($is_pc && ($both || !G5_IS_MOBILE)) {
		$dst_pc = G5_THEME_PATH.'/storage/board/board-'.$copy_bo_table.'-pc.php';
		@copy($org_pc, $dst_pc);
		@chmod($dst_pc, G5_FILE_PERMISSION);
	}

	if($is_mo && ($both || G5_IS_MOBILE)) {
		$dst_mo = G5_THEME_PATH.'/storage/board/board-'.$copy_bo_table.'-mo.php';
		@copy($org_mo, $dst_mo);
		@chmod($dst_mo, G5_FILE_PERMISSION);
	}
}

if($both) {
	$msg = 'PC/모바일 스킨 설정파일 복사 완료';
} else if(G5_IS_MOBILE) {
	$msg = '모바일 스킨 설정파일 복사 완료';
} else {
	$msg = 'PC 스킨 설정파일 복사 완료';
}

?>
<script>
alert("<?php echo $msg; ?>");
window.parent.closeSetupModal();
</script>
<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>