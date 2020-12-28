<?php
include_once('./_common.php');

// 클립보드
$is_clip = ($clip) ? true : false;

// 클립모달
$is_clip_modal = false;

$g5['title'] = '동영상 코드';
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
		<h5><i class="fa fa-youtube-play" aria-hidden="true"></i> VIDEO</h5>
	</div>
</div>

<div id="topHeight"></div>

<ul class="list-group f-de">
	<li class="list-group-item bg-light">
		<b>동영상 공유주소 입력</b>
	</li>
	<li class="list-group-item">
		<div class="input-group">
			<input type="text" id="txtCode" class="form-control" placeholder="http://...">
			<div class="input-group-append">
				<button type="button" class="btn btn-primary clip-txt">
					<i class="fa fa-code" aria-hidden="true"></i>
					코드 생성
				</button>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		공유주소 등록이 가능한 사이트 목록
	</li>
	<li class="list-group-item border-0">
		<ol>
			<li><a href="https://youtu.be" target="_blank">youtu.be</a></li>
			<li><a href="https://vimeo.com" target="_blank">vimeo.com</a></li>
			<li><a href="https://ted.com" target="_blank">ted.com</a></li>
			<li><a href="https://tv.kakao.com" target="_blank">tv.kakao.com</a></li>
			<li><a href="https://pandora.tv" target="_blank">pandora.tv</a></li>
			<li><a href="https://pandora.tv" target="_blank">pandora.tv</a></li>
			<?php if($nariya['fb_key']) { ?>
			<li><a href="https://facebook.com" target="_blank">facebook.com</a></li>
			<?php } ?>
			<li><a href="https://tv.naver.com" target="_blank">tv.naver.com</a></li>
			<li><a href="https://slideshare.net" target="_blank">slideshare.net</a></li>
			<li><a href="https://vid.me" target="_blank">vid.me</a></li>
			<li><a href="https://sendvid.com" target="_blank">sendvid.com</a></li>
			<li><a href="https://vine.co" target="_blank">vine.co</a></li>
			<li><a href="https://yinyuetai.com" target="_blank">yinyuetai.com</a></li>
			<li><a href="https://vlive.tv" target="_blank">vlive.tv</a></li>
			<li><a href="https://srook.net" target="_blank">srook.net</a></li>
			<li><a href="https://twitch.tv" target="_blank">twitch.tv</a></li>
			<li><a href="https://openload.co" target="_blank">openload.co</a></li>
			<li><a href="https://soundcloud.com" target="_blank">soundcloud.com</a></li>
			<li>mp4 동영상파일 URL</li>
		</ol>
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

		$('.clip-txt').click(function() {
			var txt = $('#txtCode').val();
			if(!txt) {
				alert('동영상의 공유주소(url)을 입력해 주세요.');
				$('#txtCode').focus();
				return false;
			}
			var clip = "{video: " + txt + " }";
			$("#txtClip").val(clip);
			$('#clipModal').modal('show');
		});
	<?php } else { ?>
		$('.clip-txt').click(function() {
			var txt = $('#txtCode').val();
			if(!txt) {
				alert('동영상의 공유주소(url)을 입력해 주세요.');
				$('#txtCode').focus();
				return false;
			}
			var clip = "{video: " + txt + " }";
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
