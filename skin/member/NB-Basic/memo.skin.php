<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지 목록 시작 { -->
<div id="memo_list" class="mb-4">

	<div id="topNav" class="bg-primary text-white">
		<div class="p-3">
			<button type="button" class="close" aria-label="Close" onclick="window.close();">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<h5><?php echo $g5['title'] ?></h5>
		</div>
	</div>

	<div id="topHeight"></div>

	<nav id="memo_cate" class="sly-tab font-weight-normal mt-3 mb-2">
		<div id="noti_cate_list" class="sly-wrap px-3">
			<ul id="noti_cate_ul" class="clearfix sly-list text-nowrap border-left">
				<li class="float-left<?php echo ($kind == "recv") ? ' active' : '';?>"><a href="./memo.php?kind=recv" class="py-2 px-3">받은쪽지</a></li>
				<li class="float-left<?php echo ($kind == "send") ? ' active' : '';?>"><a href="./memo.php?kind=send" class="py-2 px-3">보낸쪽지</a></li>
				<li class="float-left<?php echo ($kind == "") ? ' active' : '';?>"><a href="./memo_form.php" class="py-2 px-3">쪽지쓰기</a></li>
			</ul>
		</div>
		<hr/>
	</nav>

	<div id="memo_info" class="f-de font-weight-normal mb-2 px-3">
		전체 <?php echo $kind_title ?>쪽지 <b><?php echo $total_count ?></b>통 / <?php echo $page ?>페이지
	</div>

	<div class="w-100 mb-0 bg-primary" style="height:4px;"></div>

	<?php if($config['cf_memo_del']){ ?>	
		<div class="na-table border-bottom">
			<div class="f-sm font-weight-normal px-3 py-2 py-md-2 bg-light">
				쪽지 보관일수는 최장 <strong><?php echo $config['cf_memo_del'] ?></strong>일 입니다.
			</div>
		</div>
	<?php } ?>

	<ul class="na-table d-table w-100 f-sm">
	<?php
	$list_cnt = count($list);
	for ($i=0; $i < $list_cnt; $i++) {
		$readed = (substr($list[$i]['me_read_datetime'],0,1) == 0) ? '' : 'read';
		$memo_preview = utf8_strcut(strip_tags($list[$i]['me_memo']), 30, '..');
	?>
		<li class="d-table-row border-bottom">
			<div class="d-table-cell text-center nw-6 py-2 py-md-2">
				<?php echo ($readed) ? '<span class="text-muted">읽음</span>' : '<span class="orangered">읽기 전</span>';?>
			</div>
			<div class="d-table-cell py-2 py-md-2">
				<a href="<?php echo $list[$i]['view_href']; ?>" class="ellipsis f-de">
					<?php echo $memo_preview; ?>
				</a>
				<div class="clearfix text-black-50">
					<div class="float-left">
						<?php echo $list[$i]['send_datetime']; ?>
					</div>
					<div class="float-right">
						<?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']) ?>
					</div>
				</div>
			</div>
			<div class="d-table-cell text-center nw-4 py-2 py-md-2">
				<a href="<?php echo $list[$i]['del_href'] ?>" onclick="del(this.href); return false;" class="win-del" title="삭제">
					<i class="fa fa-trash-o text-muted fa-lg" aria-hidden="true"></i>
					<span class="sound_only">삭제</span>
				</a>
			</div>
		</li>
    <?php } ?>
	</ul>
	<?php if ($i == 0) { ?>
		<div class="f-sm font-weight-normal px-3 py-5 text-center text-muted border-bottom">
			자료가 없습니다.
		</div>
	<?php } ?>

	<div class="font-weight-normal px-3 mt-4">
		<ul class="pagination justify-content-center en mb-0">
			<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "./memo.php?kind=$kind".$qstr."&amp;page=") ?>
		</ul>
	</div>

</div>
<script>
$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});
</script>
<!-- } 쪽지 목록 끝 -->