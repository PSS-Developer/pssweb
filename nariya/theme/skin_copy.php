<?php
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert_close('접근권한이 없습니다.');

if(!$board['bo_table'])
   alert_close('값이 제대로 넘어오지 않았습니다.');

$g5['title'] = $board['bo_subject'].' 게시판 스킨 설정값 복사해 주기';
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
		<h5><?php echo $g5['title'] ?></h5>
	</div>
</div>

<div id="topHeight"></div>

<form id="fsetup" name="fsetup" action="./skin_copy_update.php" method="post" onsubmit="return fsetup_submit(this);">
<input type="hidden" name="bo_table" value="<?php echo urlencode($bo_table) ?>">

<ul class="list-group f-de font-weight-normal">
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">복사 옵션</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de pt-1 pb-0 float-left">
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" name="freset" value="1" class="custom-control-input" id="fbothCheck">
						<label class="custom-control-label" for="fbothCheck"><span>PC/모바일 설정값 모두 복사해 주기</span></label>
					</p>
				</div>
			</div>
		</div>
	</li>
	<?php
		$result = sql_query(" select gr_id, gr_subject from {$g5['group_table']} order by gr_id ");
		for ($i=0; $row=sql_fetch_array($result); $i++) {
	?>
		<li class="list-group-item bg-light">
			<b><?php echo get_text($row['gr_subject']) ?></b>
		</li>
		<li class="list-group-item">
			<div class="form-group mb-0">
				<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4">
					<?php
						$result1 = sql_query("select bo_table, bo_subject from {$g5['board_table']} where gr_id = '{$row['gr_id']}' order by bo_table ");
						for ($j=0; $row1=sql_fetch_array($result1); $j++) {
					?>
						<div class="col">
							<p class="my-2">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="chk_bo_table[]" value="<?php echo $row1['bo_table'] ?>"<?php echo ($bo_table === $row1['bo_table']) ? ' disabled' : '';?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
									<label class="custom-control-label" for="idCheck<?php echo $idn; ?>"><span><?php echo get_text($row1['bo_subject']) ?></span></label>
								</div>
							</p>
						</div>
					<?php $idn++; } ?>
				</div>
			</div>
		</li>
	<?php } ?>
</ul>

<div id="bottomHeight"></div>

<div id="bottomNav" class="p-0">
	<button type="submit" class="btn btn-primary btn-block btn-lg rounded-0 en">Copy to</button>
</div>

</form>

<script>
function all_checked(sw) {
	var f = document.fboardmoveall;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_bo_table[]")
			f.elements[i].checked = sw;
	}
}

function fsetup_submit(f) {
	var check = false;

	if (typeof(f.elements['chk_bo_table[]']) == 'undefined')
		;
	else {
		if (typeof(f.elements['chk_bo_table[]'].length) == 'undefined') {
			if (f.elements['chk_bo_table[]'].checked)
				check = true;
		} else {
			for (i=0; i<f.elements['chk_bo_table[]'].length; i++) {
				if (f.elements['chk_bo_table[]'][i].checked) {
					check = true;
					break;
				}
			}
		}
	}

	if (!check) {
		alert('게시판을 한개 이상 선택해 주십시오.');
		return false;
	}

	if (confirm("정말 스킨 설정을 복사해 주시겠습니까?\n\n복사해 줄 경우 각 게시판은 이전 설정값으로 복구할 수 없습니다.")) {
		return true;
	} else {
		return false;
	}

	return false;
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
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
