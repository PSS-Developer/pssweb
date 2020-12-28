<?php
include_once('./_common.php');

$edir = na_file_path_check($edir);

// 클립모달
$is_clip_modal = false;

$emo = array();

if($edir && is_dir(NA_PATH.'/skin/emo/'.$edir)) {
	$is_emo = true;
	$emo_path = NA_PATH.'/skin/emo/'.$edir;
	$emo_skin = $edir.'/';
} else {
	$is_emo = false;
	$emo_path = NA_PATH.'/skin/emo';
	$emo_skin = '';
}

$handle = opendir($emo_path);
while ($file = readdir($handle)) {
	if(preg_match("/\.(jpg|jpeg|gif|png)$/i", $file)) {
		$emo[] = $file;
	}
}
closedir($handle);
sort($emo);

$emoticon = array();
for($i=0; $i < count($emo); $i++) {
	$emoticon[$i]['name'] = $emo_skin.$emo[$i];
	$emoticon[$i]['url'] = NA_URL.'/skin/emo/'.$emo_skin.$emo[$i];
}

// Emo Skin
$eskin = array();
$ehandle = opendir(NA_PATH.'/skin/emo');
while ($efile = readdir($ehandle)) {

	if($efile == "." || $efile == ".." || preg_match("/\.(jpg|jpeg|gif|png)$/i", $efile)) continue;

	if (is_dir(NA_PATH.'/skin/emo/'.$efile)) 
		$eskin[] = $efile;
}
closedir($ehandle);
sort($eskin);
$eskin_cnt = count($eskin);

// 클립보드
$is_clip = ($clip) ? true : false;

$g5['title'] = '이모티콘';

include_once(G5_THEME_PATH.'/head.sub.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.NA_URL.'/css/modal.css">', 0);

// 모달 내 모달
$is_modal_win = true;

// Loader
if(is_file(G5_THEME_PATH.'/_loader.php')) {
	include_once(G5_THEME_PATH.'/_loader.php');
} else {
	include_once(NA_PATH.'/theme/loader.php');
}

?>

<?php if($is_clip) { ?>
<!-- 클립보드 복사 시작 { -->
<script src="<?php echo NA_URL ?>/js/clipboard.min.js"></script>
<div class="modal fade" id="clipModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-white"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> <b>Clipboard</b></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="text-white" aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="text" id="txtClip" class="form-control">
				<div class="text-center pt-3">
					<button type="button" class="btn btn-primary btn-lg btn-clip en" data-clipboard-target="#txtClip">
						Copy Code
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 클립보드 복사 끝 { -->
<?php } ?>

<div id="topNav" class="bg-primary text-white">
	<div class="p-3">
		<button type="button" class="close clip-close" aria-label="Close">
			<span aria-hidden="true" class="text-white">&times;</span>
		</button>
		<h5><i class="fa fa-smile-o" aria-hidden="true"></i> EMOTICON</h5>
	</div>
</div>

<div id="topHeight"></div>

<?php if($eskin_cnt) { 
	$clip_change = ($is_clip) ? "+'&clip=1'" : "";	
?>
	<form name="fclip" method="get">
		<select class="custom-select" name="eskin" onchange="location='<?php echo NA_URL ?>/theme/clip_emo.php?edir='+encodeURIComponent(this.value)<?php echo $clip_change ?>;">
			<option value="">Basic</option>
			<?php for($i=0; $i < $eskin_cnt; $i++) { ?>
				<option value="<?php echo $eskin[$i] ?>"<?php echo get_selected($edir,$eskin[$i]) ?>><?php echo ucfirst($eskin[$i]) ?></option>
			<?php } ?>
		</select>
	</form>
<?php } ?>

<div id="emo_icon">
	<?php for($i=0; $i < count($emoticon); $i++) { ?>
		<img src="<?php echo $emoticon[$i]['url'] ?>" onclick="emo_insert('<?php echo $emoticon[$i]['name'] ?>');" class="emo-img" alt="">
	<?php } ?>
</div>

<script>
<?php if($is_clip) { ?>
	function emo_insert(txt){
		var clip = "{emo:" + txt + ":50}";
		$("#txtClip").val(clip);
		$('#clipModal').modal('show');
	}
<?php } else { ?>
	function emo_insert(txt){
		var clip = "{emo:" + txt + ":50}";
		parent.document.getElementById("wr_content").value += clip;
		window.parent.closeClipModal();
	}
<?php } ?>
$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});

$(document).ready(function() {
	<?php if($is_clip) { ?>
		var clipboard = new ClipboardJS('.btn-clip');
		clipboard.on('success', function(e) {
			alert("복사가 되었으니 Ctrl + V 를 눌러 붙여넣기해 주세요.");
			$('#clipModal').modal('hide');
			window.parent.closeClipModal();
		});
		clipboard.on('error', function(e) {
			alert("복사가 안되었으니 Ctrl + C 를 눌러 복사해 주세요.");
		});
	<?php } ?>
	$('.clip-close').click(function() {
		window.parent.closeClipModal();
	});
});
</script>

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>