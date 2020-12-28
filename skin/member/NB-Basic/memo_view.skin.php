<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$nick = na_name_photo($mb['mb_id'], get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']));

if($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
}
else {
    $kind_str = "받는";
    $kind_date = "보낸";
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<div id="memo_view" class="mb-4">

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

	<div class="clearfix f-sm px-3 py-2 bg-light border-bottom">
		<ul class="d-flex align-items-center">
			<li class="pr-3">
				<?php echo $nick ?>
			</li>
			<li id="bo_v_btn" class="flex-grow-1 text-right text-black-50">
				<span class="sr-only">답변일</span>
				<?php echo $memo['me_send_datetime'] ?>
			</li>
		</ul>
	</div>

	<div class="clearfix px-3 py-4">
		<?php echo na_content(conv_content($memo['me_memo'], 0)) ?>
	</div>

	<div class="px-3 pt-4 border-top">
		<div class="na-table d-table w-100">
			<div class="d-table-row">
				<div class="d-table-cell nw-3 text-left">
					<?php if($prev_link) {  ?>
						<a href="<?php echo $prev_link ?>" class="btn btn_b01 nofocus" title="이전 쪽지">
							<i class="fa fa-chevron-left fa-md" aria-hidden="true"></i>
							<span class="sr-only">이전 쪽지</span>
						</a>
					<?php } ?>
				</div>
				<div class="d-table-cell text-center">
					<div class="btn-group">
						<a href="<?php echo $del_link; ?>" onclick="del(this.href); return false;" class="btn btn-primary memo_del" title="삭제" role="button">
							<i class="fa fa-trash-o fa-md" aria-hidden="true"></i>
							<span class="sr-only">삭제</span>
						</a>
						<?php if ($kind == 'recv') {  ?>
							<a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="btn btn-primary" role="button">
								답장하기
							</a>  
						<?php } ?>
						<a href="./memo.php?kind=<?php echo $kind ?><?php echo $qstr;?>" class="btn btn-primary" title="목록" role="button">
							<i class="fa fa-list fa-md" aria-hidden="true"></i>
							<span class="sr-only">목록</span>
						</a>
					</div>
				</div>
				<div class="d-table-cell nw-3 text-right">
					<?php if ($next_link) { ?>
						<a href="<?php echo $next_link ?>" class="btn btn_b01 nofocus float-right" title="다음 쪽지">
							<i class="fa fa-chevron-right fa-md" aria-hidden="true"></i>
							<span class="sr-only">다음 쪽지</span>
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});
</script>
