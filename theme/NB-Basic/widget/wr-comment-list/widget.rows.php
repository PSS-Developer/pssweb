<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 추출하기
$wset['comment'] = 1; //댓글
$list = na_board_rows($wset);
$list_cnt = count($list);

// 아이콘
$icon = ($wset['icon']) ? '<i class="fa '.$wset['icon'].'" aria-hidden="true"></i>' : '';

// 보드명, 분류명
$is_bo_name = ($wset['bo_name'] == '') ? false : true;
$bo_name = ((int)$wset['bo_name'] > 0) ? $wset['bo_name'] : 0;

// 리스트
for ($i=0; $i < $list_cnt; $i++) { 

	// 아이콘 체크
	if ($list[$i]['icon_secret']) {
		$is_lock = true;
		$wr_icon = '<span class="na-icon na-secret"></span>';
	} else if($list[$i]['icon_new']) {
		$wr_icon = '<span class="na-icon na-new"></span>';
	} else {
		$wr_icon = $icon;
	}

	// 보드명, 분류명
	if($is_bo_name) {
		$ca_name = '';
		if(isset($list[$i]['bo_subject']) && $list[$i]['bo_subject']) {
			$ca_name = ($bo_name) ? cut_str($list[$i]['bo_subject'], $bo_name, '') : $list[$i]['bo_subject'];
		} else if($list[$i]['ca_name']) {
			$ca_name = ($bo_name) ? cut_str($list[$i]['ca_name'], $bo_name, '') : $list[$i]['ca_name'];
		}

		if($ca_name) {
			$list[$i]['subject'] = $ca_name.' <span class="na-bar"></span> '.$list[$i]['subject'];
		}
	}

?>
	<li class="px-3 px-sm-0">
		<div class="na-title">
			<div class="float-right text-muted f-sm font-weight-normal ml-2">
				<span class="sr-only">등록자</span>
				<?php echo $list[$i]['name'] ?>

				<span class="sr-only">등록일</span>
				<span class="ml-2"><?php echo na_date($list[$i]['wr_datetime'], 'orangered', 'H:i', 'm.d', 'm.d') ?></span>
			</div>
			<div class="na-item">
				<a href="<?php echo $list[$i]['href'] ?>" class="na-subject">
					<?php echo $wr_icon ?>
					<?php echo $list[$i]['subject'] ?>
				</a>
			</div>
		</div>
	</li>
<?php } ?>

<?php if(!$list_cnt) { ?>
	<li class="f-de px-4 py-5 text-muted text-center">
		댓글이 없습니다.
	</li>
<?php } ?>