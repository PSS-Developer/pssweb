<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

@include_once(G5_THEME_PATH.'/head.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<div id="mb_confirm" class="m-auto" style="max-width:400px">
	<div class="f-de px-3 my-5">
		<form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
		<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
		<input type="hidden" name="w" value="u">
		<ul class="list-group mb-4">
			<li class="list-group-item bg-primary border-primary text-white">
				<h5><?php echo $g5['title'] ?></h5>
			</li>
			<li class="list-group-item py-3">
				<p><strong>비밀번호를 한번 더 입력해주세요.</strong></p>
				<?php if ($url == 'member_leave.php') { ?>
					<p>비밀번호를 입력하시면 회원탈퇴가 완료됩니다.</p>
				<?php }else{ ?>
					<p>회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.</p>
				<?php }  ?>

				<div class="input-group mt-3 mb-0">
					<div class="input-group-prepend">
						<span class="input-group-text">비밀번호</span>
					</div>
					<input type="password" name="mb_password" id="confirm_mb_password" required class="form-control required" maxLength="255">
					<div class="input-group-append">
						<button type="submit" id="btn_sumbit" class="btn btn-primary">확인</button>
					</div>
				</div>
			</li>
		</ul>

		<p class="text-center px-3">
			<a href="<?php echo G5_URL ?>">홈으로 돌아가기</a>
		</p>

		</form>
	</div>
</div>

<script>
function fmemberconfirm_submit(f) {
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->

<?php
// 헤더, 테일 사용설정
if(!$tset['page_sub'])
	include_once(G5_THEME_PATH.'/tail.php');
?>