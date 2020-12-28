<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert_close('접근권한이 없습니다.');
}

$wname = na_fid($wname);
$wid = na_fid($wid);

if(!$wname || !$wid)
    alert_close('값이 제대로 넘어오지 않았습니다.');

// 경로
if($wdir) {
    $wdir = preg_replace('/[^-A-Za-z0-9_\/]/i', '', trim(str_replace(G5_PATH, '', $wdir)));
	$widget_path = G5_PATH.$wdir.'/'.$wname;
	$widget_url = str_replace(G5_PATH, G5_URL, $widget_path);
} else {
	$widget_path = G5_THEME_PATH.'/widget/'.$wname;
	$widget_url = G5_THEME_URL.'/widget/'.$wname;
}

if(!file_exists($widget_path.'/widget.setup.php'))
    alert_close('위젯 설정을 할 수 없는 위젯입니다.');

include_once(NA_PATH.'/lib/option.lib.php');

// 설정값아이디
$id = $wname.'-'.$wid;

// 기본 설정값
$wset = array();
if(!is_file(G5_THEME_PATH.'/storage/widget/widget-'.$id.'-pc.php') && isset($optp) && $optp) {
	$wset = na_query($optp);
} else {
	$wset = na_file_var_load(G5_THEME_PATH.'/storage/widget/widget-'.$id.'-pc.php');
}

// 모바일 설정값
$mo = array();
if(!is_file(G5_THEME_PATH.'/storage/widget/widget-'.$id.'-mo.php') && isset($optm) && $optm) {
	$mo = na_query($optm);
} else {
	$mo = na_file_var_load(G5_THEME_PATH.'/storage/widget/widget-'.$id.'-mo.php');
}

$g5['title'] = '위젯 설정';
include_once(G5_THEME_PATH.'/head.sub.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.NA_URL.'/css/modal.css">', 0);

// 모달 내 모달
$is_modal_win = true;

// 아이디 넘버링용
$idn = 1;

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
		<h5>ID : <?php echo $id;?></h5>
	</div>
</div>

<div id="topHeight"></div>

<form id="fsetup" name="fsetup" action="./widget_update.php" method="post" onsubmit="return fsetup_submit(this);">
<input type="hidden" name="wname" value="<?php echo urlencode($wname) ?>">
<input type="hidden" name="wid" value="<?php echo urlencode($wid) ?>">
<input type="hidden" name="wdir" value="<?php echo urlencode($wdir) ?>">
<input type="hidden" name="opt" value="<?php echo urlencode($opt) ?>">
<input type="hidden" name="optp" value="<?php echo urlencode($optp) ?>">
<input type="hidden" name="optm" value="<?php echo urlencode($optm) ?>">
<input type="hidden" name="freset" value="">

<ul class="list-group f-de font-weight-normal">
	<li class="list-group-item border-bottom-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">위젯 경로</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					<?php echo str_replace(G5_PATH, "", $widget_path) ?> 
				</p>
			</div>
		</div>
	</li>
</ul>

<div class="f-de font-weight-normal">
	<?php @include_once($widget_path.'/widget.setup.php'); ?>
</div>

<div id="bottomHeight"></div>

<div id="bottomNav" class="p-0">
	<div class="btn-group btn-group-lg w-100" role="group">
		<button type="submit" class="btn btn-primary rounded-0 en order-2">Save</button>
		<button type="submit" class="btn btn-primary rounded-0 en order-1" onclick="document.pressed='reset'">Reset</button>
	</div>
</div>

</form>
<script>
function fsetup_submit(f) {
	if(document.pressed == "reset") {
		if (confirm("정말 초기화 하시겠습니까?\n\n초기화시 이전 설정값으로 복구할 수 없습니다.")) {
			f.freset.value = 1;
		} else {
			return false;
		}

	}
	return true;
}

$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
	na_nav('bottomNav', 'bottomHeight', 'fixed-bottom');
});

$(document).ready(function() {
	$('.close-setup').click(function() {
		window.parent.closeSetupModal();
	});
});
</script>
<?php 
include_once(NA_PATH.'/theme/setup.php');
include_once(G5_THEME_PATH.'/tail.sub.php');
?>