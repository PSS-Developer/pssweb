<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/* 리스트형 게시판 목록 */

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$list_skin_url.'/list.css">', 0);

// 목록 헤드
$head_color = ($boset['head_color']) ? $boset['head_color'] : 'primary';
if($boset['head_skin']) {
	add_stylesheet('<link rel="stylesheet" href="'.NA_URL.'/skin/head/'.$boset['head_skin'].'.css">', 0);
	$head_class = 'list-head';
} else {
	$head_class = 'na-table-head border-'.$head_color;
}

// 글 이동
$is_list_link = false;
switch($boset['target']) {
	case '1' : $target = ' target="_blank"'; break;
	case '2' : $is_list_link = true; break;
	case '3' : $target = ' target="_blank"'; $is_list_link = true; break;
	default	 : $target = ''; break; 
}

// 글 수
$list_cnt = count($list);

?>

<section id="bo_list" class="mb-4">

	<!-- 목록 헤드 -->
	<div class="d-block d-md-none w-100 mb-0 bg-<?php echo $head_color ?>" style="height:4px;"></div>

	<div class="na-table d-none d-md-table w-100 mb-0">
		<div class="<?php echo $head_class ?> d-md-table-row">
			<div class="d-md-table-cell nw-5 px-md-1">번호</div>
			<div class="d-md-table-cell pr-md-1">
				<?php if ($is_checkbox) { ?>
					<label class="float-left mb-0">
						<input type="checkbox" onclick="if (this.checked) all_checked(true); else all_checked(false);">
					</label>
				<?php } ?>
				제목
			</div>
			<div class="d-md-table-cell nw-10 pl-2 pr-md-1">이름</div>
			<div class="d-md-table-cell nw-6 pr-md-1"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</a></div>
			<div class="d-md-table-cell nw-4 pr-md-1"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회</a></div>
			<?php if($is_good) { ?>
				<div class="d-md-table-cell nw-3 pr-md-1"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></div>
			<?php } ?>
			<?php if($is_nogood) { ?>
				<div class="d-md-table-cell nw-3 pr-md-1"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추</a></div>
			<?php } ?>
		</div>
	</div>

	<ul class="na-table d-md-table w-100">
	<?php
	for ($i=0; $i < $list_cnt; $i++) { 

		//아이콘 체크
		$wr_icon = '';
		$is_lock = false;
		if ($list[$i]['icon_secret']) {
			$wr_icon = '<span class="na-icon na-secret"></span>';
			$is_lock = true;
		} else if ($list[$i]['icon_hot']) {
			$wr_icon = '<span class="na-icon na-hot"></span>';
		} else if ($list[$i]['icon_new']) {
			$wr_icon = '<span class="na-icon na-new"></span>';
		}

		// 링크 이동
		if($is_list_link && $list[$i]['wr_link1']) {
			$list[$i]['href'] = $list[$i]['link_href'][1];
		}

		// 전체 보기에서 분류 출력하기
		if(!$sca && $is_category && $list[$i]['ca_name']) {
			$list[$i]['subject'] = $list[$i]['ca_name'].' <span class="na-bar"></span> '.$list[$i]['subject'];
		}

		// 공지, 현재글 스타일 체크
		$li_css = '';
		if ($list[$i]['is_notice']) { // 공지사항
			$li_css = ' bg-light';
			$list[$i]['num'] = '<span class="na-notice bg-'.$head_color.'"></span><span class="sr-only">공지사항</span>';
			$list[$i]['subject'] = '<strong>'.$list[$i]['subject'].'</strong>';
		} else if ($wr_id == $list[$i]['wr_id']) {
			$li_css = ' bg-light';
			$list[$i]['num'] = '<span class="na-text text-primary">열람</span>';
			$list[$i]['subject'] = '<b class="text-primary">'.$list[$i]['subject'].'</b>';
		} else {
			$list[$i]['num'] = '<span class="sr-only">번호</span>'.$list[$i]['num'];
		}
	?>
		<li class="d-md-table-row px-3 py-2 p-md-0 text-md-center text-muted border-bottom<?php echo $li_css;?>">
			<div class="d-none d-md-table-cell nw-5 f-sm font-weight-normal py-md-2 px-md-1">
				<?php echo $list[$i]['num'] ?>
			</div>
			<div class="d-md-table-cell text-left py-md-2 pr-md-1">
				<div class="na-title float-md-left">
					<div class="na-item">
						<?php if ($is_checkbox) { ?>
							<input type="checkbox" class="mb-0 mr-2" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
						<?php } ?>
						<a href="<?php echo $list[$i]['href'] ?>" class="na-subject"<?php echo $target ?>>
							<?php
								if($list[$i]['icon_reply'])
									echo '<span class="na-hicon na-reply"></span>'.PHP_EOL;

								echo $wr_icon;
							?>
							<?php echo $list[$i]['subject'] ?>
						</a>
						<?php
							if(isset($list[$i]['icon_file']))
								echo '<span class="na-ticon na-file"></span>'.PHP_EOL;

							//if(isset($list[$i]['icon_link']) && $list[$i]['icon_link'])
								//echo '<span class="na-ticon na-link"></span>'.PHP_EOL;
						?>
						<?php if($list[$i]['wr_comment']) { ?>
							<div class="na-info">
								<span class="sr-only">댓글</span>
								<span class="count-plus orangered">
									<?php echo $list[$i]['wr_comment'] ?>
								</span>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="float-right float-md-none d-md-table-cell nw-10 nw-md-auto text-left f-sm font-weight-normal pl-2 py-md-2 pr-md-1">
				<span class="sr-only">등록자</span>
				<?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']) ?>
			</div>
			<div class="float-left float-md-none d-md-table-cell nw-6 nw-md-auto f-sm font-weight-normal py-md-2 pr-md-1">
				<span class="sr-only">등록일</span>
				<?php echo na_date($list[$i]['wr_datetime'], 'orangered', 'H:i', 'm.d', 'Y.m.d') ?>
			</div>
			<div class="float-left float-md-none d-md-table-cell nw-4 nw-md-auto f-sm font-weight-normal py-md-2 pr-md-1">
				<i class="fa fa-eye d-md-none" aria-hidden="true"></i>
				<span class="sr-only">조회</span>
				<?php echo $list[$i]['wr_hit'] ?>
			</div>
			<?php if($is_good) { ?>
				<div class="float-left float-md-none d-md-table-cell nw-3 nw-md-auto f-sm font-weight-normal py-md-2 pr-md-1">
					<i class="fa fa-thumbs-o-up d-md-none" aria-hidden="true"></i>
					<span class="sr-only">추천</span>
					<?php echo $list[$i]['wr_good'] ?>
				</div>
			<?php } ?>
			<?php if($is_nogood) { ?>
				<div class="float-left float-md-none d-md-table-cell nw-3 nw-md-auto f-sm font-weight-normal py-md-2 pr-md-1">
					<i class="fa fa-thumbs-o-down d-md-none" aria-hidden="true"></i>
					<span class="sr-only">비추천</span>
					<?php echo $list[$i]['wr_nogood'] ?>
				</div>
			<?php } ?>
			<div class="clearfix d-block d-md-none"></div>
		</li>
	<?php } ?>
	</ul>
	<?php if (!$list_cnt) { ?>
		<div class="f-de font-weight-normal px-3 py-5 text-muted text-center border-bottom">게시물이 없습니다.</div>
	<?php } ?>
</section>