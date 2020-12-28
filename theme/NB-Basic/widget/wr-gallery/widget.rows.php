<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 이미지 영역 및 썸네일 크기 설정
$wset['thumb_w'] = ($wset['thumb_w'] == "") ? 400 : (int)$wset['thumb_w'];
$wset['thumb_h'] = ($wset['thumb_h'] == "") ? 225 : (int)$wset['thumb_h'];

if($wset['thumb_w'] && $wset['thumb_h']) {
	$img_height = ($wset['thumb_h'] / $wset['thumb_w']) * 100;
} else {
	$img_height = ($wset['thumb_d']) ? $wset['thumb_d'] : '56.25';
}

// 추출하기
$wset['sideview'] = 1; // 이름 레이어 출력

$list = na_board_rows($wset);
$list_cnt = count($list);

// 랭킹
$rank = na_rank_start($wset['rows'], $wset['page']);

// 새글
$cap_new = ($wset['new']) ? $wset['new'] : 'primary';

// 보드명, 분류명
$is_bo_name = ($wset['bo_name'] == '') ? false : true;
$bo_name = ((int)$wset['bo_name'] > 0) ? $wset['bo_name'] : 0;

// 글 이동
$is_link = false;
switch($wset['target']) {
	case '1' : $target = ' target="_blank"'; break;
	case '2' : $is_link = true; break;
	case '3' : $target = ' target="_blank"'; $is_link = true; break;
	default	 : $target = ''; break; 
}

// 리스트
for ($i=0; $i < $list_cnt; $i++) { 

	// 아이콘 체크
	$wr_icon = $wr_tack = $wr_cap = '';
	if ($list[$i]['icon_secret']) {
		$is_lock = true;
		$wr_icon = '<span class="na-icon na-secret"></span>';
	}

	if ($wset['rank']) {
		$wr_tack = '<span class="label-tack rank-icon en bg-'.$wset['rank'].'">'.$rank.'</span>';
		$rank++;
	}

	if($list[$i]['icon_new']) {
		$wr_cap = '<span class="label-cap en bg-'.$cap_new.'">New</span>';
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

	// 링크 이동
	if($is_link && $list[$i]['wr_link1']) {
		$list[$i]['href'] = $list[$i]['link_href'][1];
	}

	// 이미지 추출
	$img = na_wr_img($list[$i]['bo_table'], $list[$i]);

	// 썸네일 생성
	$thumb = ($wset['thumb_w']) ? na_thumb($img, $wset['thumb_w'], $wset['thumb_h']) : $img;

?>
	<li class="col px-2 pb-4">
		<div class="img-wrap bg-light na-round mb-2" style="padding-bottom:<?php echo $img_height ?>%;">
			<div class="img-item">
				<a href="<?php echo $list[$i]['href'] ?>"<?php echo $target ?>>
					<?php echo $wr_tack ?>
					<?php echo $wr_cap ?>
					<?php if($thumb) { ?>
						<img src="<?php echo $thumb ?>" alt="Image <?php echo $list[$i]['wr_id'] ?>">
					<?php } ?>
				</a>
			</div>
		</div>

		<div class="na-title">
			<div class="na-item">
				<a href="<?php echo $list[$i]['href'] ?>" class="na-subject"<?php echo $target ?>>
					<?php echo $wr_icon ?>
					<?php echo $list[$i]['subject'] ?>
				</a>
				<?php if($list[$i]['wr_comment']) { ?>
					<div class="na-info">
						<span class="count-plus orangered">
							<span class="sr-only">댓글</span>
							<?php echo $list[$i]['wr_comment']; ?>
						</span>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="clearfix f-sm font-weight-normal">
			<span class="float-right ml-2">
				<span class="sr-only">등록자</span>
				<?php echo $list[$i]['name'];?>
			</span>
			<span class="float-left text-muted">
				<span class="sr-only">등록일</span>
				<?php echo na_date($list[$i]['wr_datetime'], 'orangered', 'H:i', 'm.d', 'm.d'); ?>
			</span>
		</div>
	</li>
<?php } ?>

<?php if(!$list_cnt) { ?>
	<li class="w-100 f-de text-muted text-center px-2 py-5">
		글이 없습니다.
	</li>
<?php } ?>