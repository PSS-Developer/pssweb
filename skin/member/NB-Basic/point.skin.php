<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="point" class="mb-4">

	<div id="topNav" class="bg-primary text-white">
		<div class="p-3">
			<button type="button" class="close" aria-label="Close" onclick="window.close();">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<h5><?php echo $g5['title'] ?></h5>
		</div>
	</div>

	<div id="topHeight"></div>

	<nav id="point_cate" class="sly-tab font-weight-normal mt-3 mb-2">
		<div id="noti_cate_list" class="sly-wrap px-3">
			<ul id="noti_cate_ul" class="clearfix sly-list text-nowrap border-left">
				<li class="float-left active"><a class="py-2 px-3">보유 포인트</a></li>
				<li class="float-left"><a class="py-2 px-3"><strong class="orangered"><?php echo number_format($member['mb_point']) ?></strong> 점</a></li>
			</ul>
		</div>
		<hr/>
	</nav>

	<div id="point_info" class="f-de font-weight-normal mb-2 px-3">
		전체 <?php echo $total_count ?>건 / <?php echo $page ?>페이지
	</div>

	<div class="w-100 mb-0 bg-primary" style="height:4px;"></div>

	<ul class="list-group mb-4">
		<?php
		$sum_point1 = $sum_point2 = $sum_point3 = 0;

		$result = sql_query(" select * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ");
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$point1 = $point2 = 0;
			$point_use_class = '';
			if ($row['po_point'] > 0) {
				$point1 = '+' .number_format($row['po_point']);
				$sum_point1 += $row['po_point'];
			} else {
				$point2 = number_format($row['po_point']);
				$sum_point2 += $row['po_point'];
				$point_use_class = ' bg-light';
			}

			$po_content = $row['po_content'];

			$expr = '';
			if($row['po_expired'] == 1)
				$expr = ' class="orangered"';
		?>
		<li class="list-group-item border-left-0 border-right-0 clearfix<?php echo $point_use_class ?>">
			<div class="f-de ellipsis">
				<?php if ($row['po_expired'] == 1) { ?>
					<span<?php echo $expr ?>>만료 <?php echo substr(str_replace('-', '', $row['po_expire_date']), 2) ?></span>
					<span class="na-bar"></span>
				<?php } else if($row['po_expire_date'] != '9999-12-31') { ?>
					<span<?php echo $expr ?>><?php echo $row['po_expire_date'] ?></span>
					<span class="na-bar"></span>
				<?php } ?>
				<?php echo $po_content ?>
			</div>
			<div class="clearfix f-sm">
				<div class="float-right text-black-50">
					<?php echo $row['po_datetime']; ?>
				</div>
				<div class="float-left en">
					<b><?php echo ($point1) ? $point1 : '<span class="orangered">'.$point2.'</span>'; ?></b>
				</div>
			</div>
		</li>
		<?php
		}

		if ($i == 0)
			echo '<li class="list-group-item border-left-0 border-right-0 f-de font-weight-normal py-5 text-muted text-center">자료가 없습니다.</li>';
		else {
			if ($sum_point1 > 0)
				$sum_point1 = "+" . number_format($sum_point1);
			$sum_point2 = number_format($sum_point2);
		}
		?>
		<li class="clearfix list-group-item border-left-0 border-right-0 bg-light">
			<b class="float-right">
				포인트 소계
			</b>
			<strong class="float-left en">
				<?php if($sum_point1) { ?>
					<span class="orangered mr-4"><?php echo $sum_point1 ?></span>
				<?php } ?>
				<?php if($sum_point2) { ?>
					<?php echo $sum_point2 ?></span>
				<?php } ?>
			</strong>
		</li>
	</ul>

	<div class="font-weight-normal px-3">
		<ul class="pagination justify-content-center en mb-0">
			<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
		</ul>
	</div>

</div>
<script>
$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});
</script>