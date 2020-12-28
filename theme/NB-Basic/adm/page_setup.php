<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert_close('접근권한이 없습니다.');
}

$pid = na_fid($pid);

if(!$pid)
    alert_close('값이 제대로 넘어오지 않았습니다.');

$g5['title'] = '페이지 설정';
include_once('../head.sub.php');

// PC 설정값
$pc = na_file_var_load(G5_THEME_PATH.'/storage/page/page-'.$pid.'-pc.php');

// 모바일 설정값
$mo = na_file_var_load(G5_THEME_PATH.'/storage/page/page-'.$pid.'-mo.php');

// 모드
$mode = 'page';

// 모달 내 모달 체크
$is_modal_win = true;
$is_preview = false;

// 좌우 페딩값 설정
$px_css = '';
$sel_option = '<option value="">기본 설정</option>'.PHP_EOL;

// Loader
if(is_file(G5_THEME_PATH.'/_loader.php')) {
	include_once(G5_THEME_PATH.'/_loader.php');
} else {
	include_once(NA_PATH.'/theme/loader.php');
}
?>

<div id="topNav" class="bg-primary text-white">
	<div class="p-3">
		<button type="button" class="close close-setup" aria-label="Close">
			<span aria-hidden="true" class="text-white">&times;</span>
		</button>
		<h5>$page_id = <?php echo $pid ?></h5>
	</div>
</div>

<div id="topHeight"></div>

<?php if(IS_DEMO) { ?>
	<div class="alert alert-warning" role="alert">
		본 페이지는 테마 적용 후 사이트의 각 페이지 좌측상단에 있는 페이지 설정(<i class="fa fa-sticky-note-o"></i> 아이콘)에서 볼 수 있습니다.
	</div>
<?php } ?>

<form id="fsetup" name="fsetup" method="post" action="./page_update.php" class="f-sm font-weight-normal">
<input type="hidden" name="pid" value="<?php echo $pid ?>">
<?php include_once (NA_THEME_ADMIN_PATH.'/setup_form.php') ?>
</form>

<script>
$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});

$(document).ready(function() {
	$('.close-setup').click(function() {
		window.parent.closeSetupModal();
	});
});
</script>

<?php
// Setup Modal
include_once (NA_PATH.'/theme/setup.php');
include_once('../tail.sub.php');
?>