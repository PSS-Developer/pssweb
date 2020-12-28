<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<div id="find_info" class="f-de">
	<div id="topNav" class="bg-primary text-white">
		<div class="p-3">
			<button type="button" class="close" aria-label="Close" onclick="window.close();">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<h5><?php echo $g5['title'] ?></h5>
		</div>
	</div>

	<div id="topHeight"></div>

	<form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
		<div class="p-3">

			회원가입 시 등록하신 이메일 주소를 입력해 주세요. 해당 이메일로 아이디와 비밀번호 정보를 보내드립니다.

			<label class="sr-only" for="mb_email">이메일<strong class="sr-only"> 필수</strong></label>
			<div class="input-group my-3">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
				</div>
				<input type="text" name="mb_email" id="mb_email" required class="form-control required email" maxlength="100">
				<div class="input-group-append">
					<button type="submit" id="btn_sumbit" class="btn btn-primary">확인하기</button>
				</div>
			</div>
			<div class="text-center">
				<?php echo captcha_html(); ?>
			</div>
		</div>
	</form>
</div>

<script>
function fpasswordlost_submit(f) {
    <?php echo chk_captcha_js();  ?>

    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});

$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});
</script>
<!-- } 회원정보 찾기 끝 -->