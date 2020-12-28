<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);

// 스킨 설정값
$wset = na_skin_config('search');

$head_color = ($wset['head_color']) ? $wset['head_color'] : 'primary';

// 검색게시판 탭처리 부분
if ($stx && $board_count) {

	na_script('sly');

	$bo_start = ($onetable) ? '' : ' class="active"';
	$str_board_list = '<li'.$bo_start.'><a class="py-2 px-3" href="?'.$search_query.'&amp;gr_id='.$gr_id.'">전체게시판</a></li>';

	$bn = $bo_select = 0;
	$search_table_cnt = count($search_table);
    for ($i=0; $i < $search_table_cnt; $i++) {

		$bn++; // 카운트 증가

		// 게시판명
		$row = sql_fetch(" select bo_subject, bo_mobile_subject from {$g5['board_table']} where bo_table = '{$search_table[$i]}' ");
		$bo_name = (G5_IS_MOBILE && $row['bo_mobile_subject']) ? $row['bo_mobile_subject'] : $row['bo_subject'];

		// 검색결과수
		$n = $i - 1;
		$bo_name .= ($i > 0) ? '('.($search_table_count[$i] - $search_table_count[$n]).')' : '('.$search_table_count[$i].')';

		$bo_active = $bo_msg = '';
		if($onetable == $search_table[$i]) { // 현재 선택된 게시판이라면
			$bo_active = ' class="active"';
			$bo_msg = '<span class="sr-only">현재 게시판</span>';
			$bo_select = $bn; // 현재 위치 표시
		}
		$str_board_list .= '<li'.$bo_active.'><a class="py-2 px-3" href="'.$_SERVER['SCRIPT_NAME'].'?'.$search_query.'&amp;gr_id='.$gr_id.'&amp;onetable='.$search_table[$i].'">'.$bo_msg.$bo_name.'</a></li>';
	}
}

?>

<div id="sch_res_detail" class="mb-4">
	<div class="alert bg-light border p-2 p-sm-3 mb-3 mx-3 mx-sm-0">
		<form name="fsearch" onsubmit="return fsearch_submit(this);" method="get" class="m-auto" style="max-width:600px;">
		<input type="hidden" name="srows" value="<?php echo $srows ?>">
		<legend class="sound_only">상세검색</legend>
		<div class="form-row mx-n1">
			<div class="col-12 col-sm-3 pb-2 pb-sm-0 px-1">
				<label for="gr_id" class="sr-only">그룹</label>
				<?php echo $group_select ?>
				<script>
					$("#gr_id").hide().addClass("custom-select").show().val('<?php echo $gr_id ?>');
				</script>
			</div>
			<div class="col-6 col-sm-3 px-1">
				<label for="sfl" class="sr-only">검색조건</label>
				<select name="sfl" id="sfl" class="custom-select">
					<option value="wr_subject||wr_content"<?php echo get_selected($_GET['sfl'], "wr_subject||wr_content") ?>>제목+내용</option>
					<option value="wr_subject"<?php echo get_selected($_GET['sfl'], "wr_subject") ?>>제목</option>
					<option value="wr_content"<?php echo get_selected($_GET['sfl'], "wr_content") ?>>내용</option>
					<option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id") ?>>회원아이디</option>
					<option value="wr_name"<?php echo get_selected($_GET['sfl'], "wr_name") ?>>이름</option>
				</select>
			</div>
			<div class="col-6 col-sm-2 px-1">
				<label for="sop" class="sr-only">검색방법</label>
				<select name="sop" id="sop" class="custom-select">
					<option value="or"<?php echo get_selected($sop, "or") ?>>또는</option>
					<option value="and"<?php echo get_selected($sop, "and") ?>>그리고</option>
				</select>	
			</div>
			<div class="col-12 col-sm-4 pt-2 pt-sm-0 px-1">
				<label for="stx" class="sr-only">검색어</label>
				<div class="input-group">
					<input type="text" id="stx" name="stx" value="<?php echo $text_stx ?>" required class="form-control" placeholder="검색어를 입력해 주세요.">
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
		<script>
		function fsearch_submit(f) {

			if (f.stx.value.length < 2) {
				alert("검색어는 두글자 이상 입력하십시오.");
				f.stx.select();
				f.stx.focus();
				return false;
			}

			// 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
			var cnt = 0;
			for (var i=0; i<f.stx.value.length; i++) {
				if (f.stx.value.charAt(i) == ' ')
					cnt++;
			}

			if (cnt > 1) {
				alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
				f.stx.select();
				f.stx.focus();
				return false;
			}

			f.action = "";
			return true;
		}
		</script>
	</div>
</div>

<?php
if ($stx) {
	if ($board_count) {
?>
<nav id="sch_res_board" class="sly-tab font-weight-normal mb-2">
	<h3 class="sr-only">검색 게시판 목록</h3>
	<div class="px-3 px-sm-0">
		<div class="d-flex">
			<div id="sch_res_board_list" class="sly-wrap flex-grow-1">
				<ul id="sch_res_board_ul" class="sly-list d-flex border-left-0 text-nowrap">
					<?php echo $str_board_list ?>
				</ul>
			</div>
			<div>
				<a href="javascript:;" class="sly-btn sly-prev ca-prev py-2 px-3">
					<i class="fa fa-angle-left" aria-hidden="true"></i>
					<span class="sr-only">이전 게시판</span>
				</a>
			</div>
			<div>
				<a href="javascript:;" class="sly-btn sly-next ca-next py-2 px-3">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
					<span class="sr-only">다음 게시판</span>
				</a>				
			</div>
		</div>
	</div>
	<hr/>
	<script>
		$(document).ready(function() {
			$('#sch_res_board .sly-wrap').sly({
				horizontal: 1,
				itemNav: 'basic',
				smart: 1,
				mouseDragging: 1,
				touchDragging: 1,
				releaseSwing: 1,
				startAt: <?php echo $bo_select ?>,
				speed: 300,
				prevPage: '#sch_res_board .ca-prev',
				nextPage: '#sch_res_board .ca-next'
			});

			// Sly Tab
			var cate_id = 'sch_res_board';
			var cate_size = na_sly_size(cate_id);

			na_sly(cate_id, cate_size);

			$(window).resize(function(e) {
				na_sly(cate_id, cate_size);
			});
		});
	</script>
</nav>
<section id="sch_res_ov" class="clearfix f-de font-weight-normal mb-2 px-3 px-sm-0">
	<strong>"<?php echo $stx ?>"</strong> 검색 결과 : 게시판 <b><?php echo $board_count ?></b>개 / 게시물 <b><?php echo number_format($total_count) ?></b>건 / <?php echo number_format($total_page) ?> 페이지
</section>

<?php
	} else {
 ?>
<div class="f-de px-3 pt-4 pb-5 text-muted text-center border-bottom mb-4">
	검색된 자료가 하나도 없습니다.
</div>
<?php } }  ?>

<?php if ($stx && $board_count) { ?>
	<section id="sch_res_list" class="na-table mb-4">
		<div class="w-100 mb-0 bg-<?php echo $head_color ?>" style="height:4px;"></div>
<?php }  ?>
<?php
$k=0;
for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
 ?>
	<div class="bg-light px-3 py-2 py-md-2">
		<a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>">
			<strong><?php echo $bo_subject[$idx] ?></strong> 게시판 내 결과
			<div class="float-right f-sm text-black-50 ml-3">
				<i class="fa fa-chevron-right" aria-hidden="true" title="게시판에서 더보기"></i>
				<span class="sr-only">게시판에서 더보기</span>
			</div>
		</a>
	</div>
	<ul class="list-group">
	<?php
	for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {
		if ($list[$idx][$i]['wr_is_comment']) {
			$comment_def = '댓글 <span class="na-bar"></span> ';
			$comment_href = '#c_'.$list[$idx][$i]['wr_id'];
		} else {
			$comment_def = '';
			$comment_href = '';
		}
	 ?>

		<li class="list-group-item border-left-0 border-right-0 px-3 py-2 py-md-2">
			<div class="clearfix">
				<a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" class="float-left">
					<strong>
					<?php echo $comment_def ?>
					<?php echo $list[$idx][$i]['subject'] ?>
					</strong>
				</a>
				<a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" target="_blank" class="float-left text-black-50 ml-2" title="새창으로 보기">
					<i class="fa fa-window-restore" aria-hidden="true"></i>
					<span class="sr-only">새창으로 보기</span>
				</a>
			</div>

			<div class="clearfix f-de text-muted">
				<?php echo $list[$idx][$i]['content'] ?>
			</div>

			<div class="clearfix f-sm text-muted">
				<div class="float-right">
					<?php echo na_name_photo($list[$idx][$i]['mb_id'], $list[$idx][$i]['name']) ?>
				</div>
				<div class="float-left">
					<?php echo na_date($list[$idx][$i]['wr_datetime'], 'orangered', 'Y.m.d H:i', 'Y.m.d H:i', 'Y.m.d H:i') ?> 
				</div>
			</div>
		</li>
	<?php }  ?>
	</ul>
<?php }  ?>
<?php if ($stx && $board_count) {  ?></section><?php }  ?>

<?php if($stx && $board_count) { ?>
	<div class="font-weight-normal px-3 px-sm-0 mb-4">
		<ul class="pagination justify-content-center en mb-0">
			<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$search_query.'&amp;gr_id='.$gr_id.'&amp;srows='.$srows.'&amp;onetable='.$onetable.'&amp;page='); ?>
		</ul>
	</div>
<?php } ?>

<?php if($is_admin || IS_DEMO) { ?>
	<?php if(is_file($search_skin_path.'/setup.skin.php')) { ?>
		<div class="mb-4 text-center">
			<a href="<?php echo na_setup_href('search') ?>" title="스킨 설정" class="btn btn_b01 btn-setup nofocus py-1" role="button">
				<i class="fa fa-cogs fa-md" aria-hidden="true"></i>
				<span class="sr-only">스킨 설정</span>
			</a>
		</div>
	<?php } ?>
<?php } ?>
