<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 데모
na_list_demo($demo);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$boset['list_skin'] = ($boset['list_skin']) ? $boset['list_skin'] : 'basic';
$list_skin_url = $board_skin_url.'/list/'.$boset['list_skin'];
$list_skin_path = $board_skin_path.'/list/'.$boset['list_skin'];

// 스킨설정
$is_skin_setup = (($is_admin == 'super' || IS_DEMO) && is_file($board_skin_path.'/setup.skin.php')) ? true : false;

// 리스트 헤드
@include_once($list_skin_path.'/list.head.skin.php');

?>

<!-- 게시판 목록 시작 { -->
<div id="bo_list_wrap" class="mb-4">

	<!-- 검색창 시작 { -->
	<div id="bo_search" class="collapse<?php echo ($boset['search_open'] || $stx) ? ' show' : ''; ?>">
		<div class="alert bg-light border p-2 p-sm-3 mb-3 mx-3 mx-sm-0">
			<form id="fsearch" name="fsearch" method="get" class="m-auto" style="max-width:600px;">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="sca" value="<?php echo $sca ?>">
				<div class="form-row mx-n1">
					<div class="col-6 col-sm-3 px-1">
						<label for="sfl" class="sr-only">검색대상</label>
						<select name="sfl" class="custom-select">
							<?php echo get_board_sfl_select_options($sfl); ?>
						</select>
					</div>
					<div class="col-6 col-sm-3 px-1">
						<select name="sop" class="custom-select">
							<option value="and"<?php echo get_selected($sop, "and") ?>>그리고</option>
							<option value="or"<?php echo get_selected($sop, "or") ?>>또는</option>
						</select>	
					</div>
					<div class="col-12 col-sm-6 pt-2 pt-sm-0 px-1">
						<label for="stx" class="sr-only">검색어</label>
						<div class="input-group">
							<input type="text" id="bo_stx" name="stx" value="<?php echo stripslashes($stx) ?>" required class="form-control" placeholder="검색어를 입력해 주세요.">
							<div class="input-group-append">
								<button type="submit" class="btn btn-primary" title="검색하기">
									<i class="fa fa-search" aria-hidden="true"></i>
									<span class="sr-only">검색하기</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- } 검색창 끝 -->

    <?php 
	// 게시판 카테고리
	if ($is_category) 
		include_once($board_skin_path.'/category.skin.php'); 
	?>

	<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="spt" value="<?php echo $spt ?>">
		<input type="hidden" name="sca" value="<?php echo $sca ?>">
		<input type="hidden" name="sst" value="<?php echo $sst ?>">
		<input type="hidden" name="sod" value="<?php echo $sod ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="sw" value="">

		<!-- 게시판 페이지 정보 및 버튼 시작 { -->
		<div id="bo_btn_top" class="clearfix f-de font-weight-normal mb-2 pl-3 pr-2 px-sm-0">
			<div class="d-flex align-items-center">
				<div id="bo_list_total" class="flex-grow-1">
					Total <b><?php echo number_format($total_count) ?></b> / <?php echo $page ?> Page
				</div>
				<div class="btn-group" role="group">
					<?php if ($admin_href) { ?>
						<a href="<?php echo $admin_href ?>" class="btn btn_admin nofocus py-1" title="관리자" role="button">
							<i class="fa fa-cog fa-spin fa-md" aria-hidden="true"></i>
							<span class="sr-only">관리자</span>
						</a>
					<?php } ?>
					<?php if ($rss_href) { ?>
						<a href="<?php echo $rss_href ?>" class="btn btn_b01 nofocus py-1" title="RSS">
							<i class="fa fa-rss fa-md" aria-hidden="true"></i>
							<span class="sr-only">RSS</span>
						</a>
					<?php } ?>
					<button type="button" class="btn btn_b01 nofocus py-1" title="게시판 검색" data-toggle="collapse" data-target="#bo_search" aria-expanded="false" aria-controls="bo_search">
						<i class="fa fa-search fa-md" aria-hidden="true"></i>
						<span class="sr-only">게시판 검색</span>
					</button>
					<?php if ($write_href) { ?>
						<a href="<?php echo $write_href ?>" class="btn btn_b01 nofocus py-1" title="글쓰기" role="button">
							<i class="fa fa-pencil fa-md" aria-hidden="true"></i>
							<span class="sr-only">글쓰기</span>
						</a>
					<?php } ?>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn_b01 nofocus dropdown-toggle dropdown-toggle-empty dropdown-toggle-split py-1" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" title="게시물 정렬">
							<?php
								switch($sst) {
									case 'wr_datetime'	: $sst_icon = 'history'; $sst_txt = '날짜순 정렬'; break;
									case 'wr_hit'		: $sst_icon = 'eye'; $sst_txt = '조회순 정렬'; break;
									case 'wr_good'		: $sst_icon = 'thumbs-o-up'; $sst_txt = '추천순 정렬'; break;
									case 'wr_nogood'	: $sst_icon = 'thumbs-o-down'; $sst_txt = '비추천순 정렬'; break;
									default				: $sst_icon = 'sort-numeric-desc'; $sst_txt = '게시물 정렬'; break;
								}
							?>
							<i class="fa fa-<?php echo $sst_icon ?> fa-md" aria-hidden="true"></i>
							<span class="sr-only"><?php echo $sst_txt ?></span>
						</button>
						<div class="dropdown-menu dropdown-menu-right p-0 border-0 bg-transparent text-right">
							<div class="btn-group-vertical bg-white border rounded py-1">
								<?php echo str_replace('>', ' class="btn px-3 py-1 text-left" role="button">', subject_sort_link('wr_datetime', $qstr2, 1)) ?>
									날짜순
								</a>
								<?php echo str_replace('>', ' class="btn px-3 py-1 text-left" role="button">', subject_sort_link('wr_hit', $qstr2, 1)) ?>
									조회순
								</a>
								<?php if($is_good) { ?>
									<?php echo str_replace('>', ' class="btn px-3 py-1 text-left" role="button">', subject_sort_link('wr_good', $qstr2, 1)) ?>
										추천순
									</a>
								<?php } ?>
								<?php if($is_nogood) { ?>
									<?php echo str_replace('>', ' class="btn px-3 py-1 text-left" role="button">', subject_sort_link('wr_nogood', $qstr2, 1)) ?>
										비추천순
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php if ($is_admin == 'super' || $is_auth || IS_DEMO) {  ?>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn_b01 nofocus dropdown-toggle dropdown-toggle-split py-1" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" title="게시판 리스트 옵션">
								<span class="sr-only">게시판 리스트 옵션</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right p-0 border-0 bg-transparent text-right">
								<div class="btn-group-vertical">
									<?php if($is_skin_setup) { ?>
										<a href="<?php echo na_setup_href('board', $bo_table) ?>" class="btn btn-primary btn-setup py-2" role="button">
											<i class="fa fa-cogs fa-fw" aria-hidden="true"></i> 스킨설정
										</a>
									<?php } ?>
									<?php if ($is_checkbox) { ?>
										<a href="javascript:;" class="btn btn-primary py-2" role="button">
											<label class="p-0 m-0" for="allCheck">
												<i class="fa fa-check-square-o fa-fw" aria-hidden="true"></i> 
												전체선택						
											</label>
											<div class="sr-only">
												<input type="checkbox" id="allCheck" onclick="if (this.checked) all_checked(true); else all_checked(false);">
											</div>
										</a>
										<button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-primary py-2">
											<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> 
											선택삭제
										</button>
										<button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn-primary py-2">
											<i class="fa fa-files-o fa-fw" aria-hidden="true"></i> 
											선택복사
										</button>
										<button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn-primary py-2">
											<i class="fa fa-arrows fa-fw" aria-hidden="true"></i>
											선택이동
										</button>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php }  ?>
				</div>
			</div>
		</div>
		<!-- } 게시판 페이지 정보 및 버튼 끝 -->

		<!-- 게시물 목록 시작 { -->
		<?php 
			// 목록스킨
			if(is_file($list_skin_path.'/list.skin.php')) {
				include_once($list_skin_path.'/list.skin.php');
			} else {
				echo '<div class="alert alert-warning text-center" role="alert">'.$boset['list_skin'].' 목록 스킨이 존재하지 않습니다.</div>'.PHP_EOL;
			}
		?>
		<!-- } 게시물 목록 끝 -->

		<!-- 페이지 시작 { -->
		<div class="font-weight-normal px-3 px-sm-0">
			<ul class="pagination justify-content-center en mb-0">
				<?php if($prev_part_href) { ?>
					<li class="page-item"><a class="page-link" href="<?php echo $prev_part_href;?>">Prev</a></li>
				<?php } ?>
				<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, get_pretty_url($bo_table, '', $qstr.'&amp;page='));?>
				<?php if($next_part_href) { ?>
					<li class="page-item"><a  class="page-link" href="<?php echo $next_part_href;?>">Next</a></li>
				<?php } ?>
			</ul>
		</div>
		<!-- } 페이지 끝 -->
	</form>

</div>

<?php if ($is_checkbox) { ?>
<noscript>
<p align="center">자바스크립트를 사용하지 않는 경우 별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>

<script>
function all_checked(sw) {
	var f = document.fboardlist;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]")
			f.elements[i].checked = sw;
	}
}
function fboardlist_submit(f) {
	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
			chk_count++;
	}

	if (!chk_count) {
		alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택복사") {
		select_copy("copy");
		return;
	}

	if(document.pressed == "선택이동") {
		select_copy("move");
		return;
	}

	if(document.pressed == "선택삭제") {
		if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다.\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
			return false;

		f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
	}

	return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
	var f = document.fboardlist;

	if (sw == "copy")
		str = "복사";
	else
		str = "이동";

	var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

	f.sw.value = sw;
	f.target = "move";
    f.action = g5_bbs_url+"/move.php";
	f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
