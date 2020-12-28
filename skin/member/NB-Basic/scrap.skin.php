<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 스크랩 목록 시작 { -->
<div id="scrap" class="f-de mb-4">

	<div id="topNav" class="bg-primary text-white">
		<div class="p-3">
			<button type="button" class="close" aria-label="Close" onclick="window.close();">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<h5><?php echo $g5['title'] ?></h5>
		</div>
	</div>

	<div id="topHeight"></div>

	<div id="scrap_info" class="font-weight-normal px-3 pb-2 pt-4">
		전체 <?php echo number_format($total_count) ?>건 / <?php echo $page ?>페이지
	</div>

	<div class="w-100 mb-0 bg-primary" style="height:4px;"></div>

	<ul class="list-group">
        <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li class="list-group-item border-left-0 border-right-0">
			<a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;">
				<?php echo $list[$i]['subject'] ?>
			</a>
			<div class="clearfix text-black-50 f-sm">
				<div class="float-left">
					<?php echo $list[$i]['ms_datetime'] ?>
					<span class="na-bar"></span>
					<a href="<?php echo $list[$i]['opener_href'] ?>" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;" class="text-black-50"><?php echo $list[$i]['bo_subject'] ?></a>
				</div>
				<div class="float-right">
		            <a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;" class="win-del text-black-50" title="삭제">
						<i class="fa fa-trash-o fa-md" aria-hidden="true"></i>
						<span class="sr-only">삭제</span>
					</a>
				</div>
			</div>
        </li>
        <?php }  ?>
    </ul>

	<?php if ($i == 0) { ?>
		<div class="f-de px-3 py-5 text-center text-muted border-bottom">
			자료가 없습니다.
		</div>
	<?php } ?>

	<div class="font-weight-normal px-3 mt-4">
		<ul class="pagination justify-content-center en mb-0">
			<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?$qstr&amp;page="); ?>
		</ul>
	</div>
</div>

<script>
$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});
</script>
<!-- } 스크랩 목록 끝 -->