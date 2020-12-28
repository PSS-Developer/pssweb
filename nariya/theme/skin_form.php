<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert_close('접근권한이 없습니다.');
}

$skin = na_fid($skin);

$is_board_skin = false;
if($skin == 'board' && $board['bo_table']) { //게시판
	$is_board_skin = true;
	$skin_path = $board_skin_path;
	$skin_url = $board_skin_url;
	$title = $board['bo_subject'].' 게시판 스킨 설정';
} else if($skin == 'connect') { //현재접속자
	$skin_path = $connect_skin_path;
	$skin_url = $connect_skin_url;
	$title = '현재 접속자 스킨 설정';
} else if($skin == 'faq') { //faq
	$skin_path = $faq_skin_path;
	$skin_url = $faq_skin_url;
	$title = 'FAQ 스킨 설정';
} else if($skin == 'member') { //회원스킨
	$skin_path = $member_skin_path;
	$skin_url = $member_skin_url;
	$title = '회원 스킨 설정';
} else if($skin == 'new') { //새글
	$skin_path = $new_skin_path;
	$skin_url = $new_skin_url;
	$title = '새글 스킨 설정';
} else if($skin == 'search') { //게시물검색
	$skin_path = $search_skin_path;
	$skin_url = $search_skin_url;
	$title = '게시물 검색 스킨 설정';
} else if($skin == 'qa') { //1:1문의
	$qaconfig = get_qa_config();
	$skin_path = get_skin_path('qa', (G5_IS_MOBILE ? $qaconfig['qa_mobile_skin'] : $qaconfig['qa_skin']));
	$skin_url = get_skin_url('qa', (G5_IS_MOBILE ? $qaconfig['qa_mobile_skin'] : $qaconfig['qa_skin']));
	$title = '1:1 문의 스킨 설정';
} else if($skin == 'noti') { //알림
	$skin_path = NA_PATH.'/skin/noti/'.$nariya['noti'];
	$skin_url = NA_URL.'/skin/noti/'.$nariya['noti'];
	$title = '알림 스킨 설정';
} else if($skin == 'shingo') { //신고모음
	$skin_path = NA_PATH.'/skin/shingo/'.$nariya['shingo_skin'];
	$skin_url = NA_URL.'/skin/shingo/'.$nariya['shingo_skin'];
	$title = '신고 스킨 설정';
} else if($skin == 'tag') { //태그모음
	$skin_path = NA_PATH.'/skin/tag/'.$nariya['tag_skin'];
	$skin_url = NA_URL.'/skin/tag/'.$nariya['tag_skin'];
	$title = '태그 스킨 설정';
} else {
   alert_close('값이 제대로 넘어오지 않았습니다.');
}

if(!is_file($skin_path.'/setup.skin.php'))
    alert_close('스킨 설정이 없는 스킨입니다.');

include_once(NA_PATH.'/lib/option.lib.php');

// 설정값
$type = (G5_IS_MOBILE) ? 'mo' : 'pc';
if($is_board_skin) {
	$boset = na_file_var_load(G5_THEME_PATH.'/storage/board/board-'.$bo_table.'-'.$type.'.php');
} else {
	$wset = na_file_var_load(G5_THEME_PATH.'/storage/skin/skin-'.$skin.'-'.$type.'.php');
}

$g5['title'] = $title;
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

<form id="fsetup" name="fsetup" action="./skin_update.php" method="post" onsubmit="return fsetup_submit(this);">
<input type="hidden" name="skin" value="<?php echo urlencode($skin) ?>">
<input type="hidden" name="bo_table" value="<?php echo urlencode($bo_table) ?>">
<input type="hidden" name="both" value="">
<input type="hidden" name="freset" value="">

<div class="f-de font-weight-normal">
	<?php 
		@include_once($skin_path.'/setup.skin.php');
		if($skin == 'board') {
			@include_once(NA_PATH.'/theme/skin_board.php');
		}
	?>
</div>

<div id="bottomHeight"></div>

<div id="bottomNav" class="p-0">
	<div class="btn-group btn-group-lg w-100" role="group">
		<button type="submit" class="btn btn-primary rounded-0 en order-3" onclick="document.pressed='save'">Save</button>
		<button type="submit" class="btn btn-primary rounded-0 en order-2" onclick="document.pressed='reset'">Reset</button>
		<?php if($skin == 'board') { 
			if(IS_DEMO && !$is_admin){
				$copy_href = "javascript:alert('데모화면에서는 하실 수 없는 작업입니다.');"; 
				$copy_css = '';
			} else {
				$copy_href = NA_URL.'/theme/skin_copy.php?bo_table='.$bo_table; 
				$copy_css = ' btn-setup';
			}
		?>
			<a role="button" href="<?php echo $copy_href ?>" class="btn btn-primary rounded-0 en order-1<?php echo $copy_css ?>">Copy to</a>
		<?php } ?>
	</div>
</div>

</form>

<script>
function fsetup_submit(f) {

	if(document.pressed == "save") {
		if (confirm("PC/모바일 동일 설정값을 적용하시겠습니까?\n\n취소시 현재 모드의 설정값만 저장됩니다.")) {
			f.both.value = 1;
		}
	}

	if(document.pressed == "reset") {
		if (confirm("정말 초기화 하시겠습니까?\n\nPC/모바일 설정 모두 초기화 되며, 이전 설정값으로 복구할 수 없습니다.")) {
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