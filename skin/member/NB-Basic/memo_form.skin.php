<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<div id="memo_write" class="mb-4">

	<div id="topNav" class="bg-primary text-white">
		<div class="p-3">
			<button type="button" class="close" aria-label="Close" onclick="window.close();">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<h5><?php echo $g5['title'] ?></h5>
		</div>
	</div>

	<div id="topHeight"></div>

	<nav id="memo_cate" class="sly-tab font-weight-normal mt-3">
		<div id="noti_cate_list" class="sly-wrap px-3">
			<ul id="noti_cate_ul" class="clearfix sly-list text-nowrap border-left">
				<li class="float-left<?php echo ($kind == "recv") ? ' active' : '';?>"><a href="./memo.php?kind=recv" class="py-2 px-3">받은쪽지</a></li>
				<li class="float-left<?php echo ($kind == "send") ? ' active' : '';?>"><a href="./memo.php?kind=send" class="py-2 px-3">보낸쪽지</a></li>
				<li class="float-left<?php echo ($kind == "") ? ' active' : '';?>"><a href="./memo_form.php" class="py-2 px-3">쪽지쓰기</a></li>
			</ul>
		</div>
	</nav>
	
	<div class="w-100 mb-0 bg-primary" style="height:4px;"></div>

	<?php if ($config['cf_memo_send_point']) { ?>
		<div class="na-table border-bottom">
			<div class="f-sm px-3 py-2 py-md-2 bg-light font-weight-normal">
				쪽지 보낼때 회원당 <b><?php echo number_format($config['cf_memo_send_point']); ?></b> 포인트를 차감합니다.
			</div>
		</div>
	<?php } ?>
	
	<form name="fmemoform" action="<?php echo $memo_action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
	<ul class="list-group f-de mb-4">
		<li class="list-group-item border-top-0 border-left-0 border-right-0">
			<div class="form-group row mx-n2">
				<label class="col-sm-2 col-form-label px-2" for="me_recv_mb_id">받는 회원<strong class="sr-only"> 필수</strong></label>
				<div class="col-sm-10 px-2">
					<input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" required class="form-control">
					<p class="form-text f-sm font-weight-normal text-muted mb-0 pb-0">
						여러 회원에게 보낼때는 회원아이디를 컴마(,)로 구분해 주세요.
					</p>
				</div>
			</div>

			<div class="form-group row mx-n2">
				<label class="col-sm-2 col-form-label px-2" for="me_memo">쪽지 내용<strong class="sr-only"> 필수</strong></label>
				<div class="col-sm-10 px-2">
					<textarea name="me_memo" id="me_memo" rows="5" required class="form-control"><?php echo $content ?></textarea>
				</div>
			</div>

			<div class="form-group row mb-0 mx-n2">
				<label class="col-sm-2 col-form-label px-2">자동등록방지<strong class="sr-only"> 필수</strong></label>
				<div class="col-sm-10 px-2">
					<?php echo captcha_html(); ?>
				</div>
			</div>
		</li>
	</ul>

	<p class="text-center">
		<button type="submit" id="btn_submit" class="btn btn-primary">쪽지 보내기</button>
	</p>

	</form>
</div>

<script>
function fmemoform_submit(f) {

    <?php echo chk_captcha_js();  ?>

    return true;
}
$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});
</script>
