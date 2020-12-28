<?php
include_once('./_common.php');

// 클립모달
$is_clip_modal = false;

// 클립보드
$is_clip = ($clip) ? true : false;

// 아이콘 불러오기
@include_once(NA_PATH.'/lib/icon.lib.php');

$g5['title'] = '폰트어썸 아이콘';
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
		<h5><i class="fa fa-font-awesome" aria-hidden="true"></i> FONTAWESOME</h5>
	</div>
</div>

<div id="topHeight"></div>

<ul id="fa_icon" class="list-group f-de font-weight-normal en">
	<li class="list-group-item bg-light" id="web-application">
		<b>Web Application Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['web']); $i++) { ?>
			<a href="#" title="<?php echo $fas['web'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['web'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="accessibility">
		<b>Accessibility Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['access']); $i++) { ?>
			<a href="#" title="<?php echo $fas['access'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['access'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="hand">
		<b>Hand Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['hand']); $i++) { ?>
			<a href="#" title="<?php echo $fas['hand'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['hand'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="transportation">
		<b>Transportation Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['trans']); $i++) { ?>
			<a href="#" title="<?php echo $fas['trans'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['trans'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="gender">
		<b>Gender Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['gender']); $i++) { ?>
			<a href="#" title="<?php echo $fas['gender'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['gender'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="filetype">
		<b>File Type Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['file']); $i++) { ?>
			<a href="#" title="<?php echo $fas['file'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['file'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="spinner">
		<b>Spinner Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['spin']); $i++) { ?>
			<a href="#" title="<?php echo $fas['spin'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['spin'][$i] ?> fa-2x fa-spin" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="form-control">
		<b>Form Control Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['form']); $i++) { ?>
			<a href="#" title="<?php echo $fas['form'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['form'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="payment">
		<b>Payment Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['pay']); $i++) { ?>
			<a href="#" title="<?php echo $fas['pay'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['pay'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="chart">
		<b>Chart Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['chart']); $i++) { ?>
			<a href="#" title="<?php echo $fas['chart'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['chart'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="currency">
		<b>Currency Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['cur']); $i++) { ?>
			<a href="#" title="<?php echo $fas['cur'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['cur'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="editor">
		<b>Text Editor Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['edit']); $i++) { ?>
			<a href="#" title="<?php echo $fas['edit'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['edit'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="directional">
		<b>Directional Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['direct']); $i++) { ?>
			<a href="#" title="<?php echo $fas['direct'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['direct'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="video">
		<b>Video Player Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['video']); $i++) { ?>
			<a href="#" title="<?php echo $fas['video'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['video'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="brand">
		<b>Brand Icons</b>
	</li>
	<li class="list-group-item">
		<?php for($i=0; $i < count($fas['brand']); $i++) { ?>
			<a href="#" title="<?php echo $fas['brand'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['brand'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
	<li class="list-group-item bg-light" id="medical">
		<b>Medical Icons</b>
	</li>
	<li class="list-group-item" style="border-bottom:0">
		<?php for($i=0; $i < count($fas['medical']); $i++) { ?>
			<a href="#" title="<?php echo $fas['medical'][$i] ?>" class="clip-icon">
				<i class="fa fa-<?php echo $fas['medical'][$i] ?> fa-2x" aria-hidden="true"></i>
			</a>
		<?php } ?>
	</li>
</ul>

<script>
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
		$('.clip-icon').click(function() {
			var clip = "{icon:" + this.title + " fa-4x}";
			$("#txtClip").val(clip);
			$('#clipModal').modal('show');
		});
	<?php } else { ?>
		$('.clip-icon').click(function() {
			var clip = "{icon:" + this.title + " fa-4x}";
			parent.document.getElementById("wr_content").value += clip;
			window.parent.closeClipModal();
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
