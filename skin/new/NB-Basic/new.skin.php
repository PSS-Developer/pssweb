<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$new_skin_url.'/style.css">', 0);

// 스킨 설정값
$wset = na_skin_config('new');

// 목록 헤드
$head_color = ($wset['head_color']) ? $wset['head_color'] : 'primary';
if($wset['head_skin']) {
	add_stylesheet('<link rel="stylesheet" href="'.NA_URL.'/skin/head/'.$wset['head_skin'].'.css">', 0);
	$head_class = 'list-head';
} else {
	$head_class = 'na-table-head border-'.$head_color;
}

// 번호 체크
$page_rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];

?>

<!-- 전체게시물 검색 시작 { -->
<div id="new_search" class="collapse<?php echo ($wset['search_open'] || $mb_id) ? ' show' : ''; ?>">
	<div class="alert bg-light border p-2 p-sm-3 mb-3 mx-3 mx-sm-0">
		<form id="fsearch" name="fnew" method="get" class="m-auto" style="max-width:500px;">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<div class="form-row mx-n1 mx-sm-n2">
				<div class="col-6 col-sm-3 px-1">
					<label for="sfl" class="sr-only">게시판그룹</label>
					<?php echo $group_select ?>
				</div>
				<div class="col-6 col-sm-3 px-1">
					<label for="view" class="sr-only">검색대상</label>
					<select name="view" id="view" class="custom-select">
						<option value="">전체 게시물
						<option value="w">원글만
						<option value="c">댓글만
					</select>
				</div>
				<div class="col-12 col-sm-6 pt-2 pt-sm-0 px-1">
					<label for="new_mb_id" class="sr-only">검색어<strong class="sr-only"> 필수</strong></label>
					<div class="input-group">
						<input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="new_mb_id" class="form-control" placeholder="회원아이디 검색만 가능">
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
			$("#gr_id").hide().addClass("custom-select").show().val('<?php echo $gr_id ?>');
			$("#view").val('<?php echo $view ?>');
		</script>
	</div>
</div>
<!-- } 전체게시물 검색 끝 -->

<!-- 전체게시물 그룹 시작 { -->
<nav id="new_group" class="sly-tab font-weight-normal mb-2">
	<h3 class="sr-only">전체게시물 그룹 목록</h3>
	<div class="px-3 px-sm-0">
		<div class="d-flex">
			<div id="faq_cate_list" class="sly-wrap flex-grow-1">
				<ul id="faq_cate_ul" class="sly-list d-flex border-left-0 text-nowrap">
				<?php
					//분류 정리
					na_script('sly');
					$gn = $gr_select = 0;
					$gr_start = ($gr_id) ? '' : ' class="active"';
				?>
				<li<?php echo $gr_start ?>>
					<a class="py-2 px-3" href="<?php echo G5_BBS_URL ?>/new.php<?php echo ($view) ? '?view='.$view : '';?>">전체</a>
				</li>
				<?php
					$gn++;
					$gr_qstr = ($view) ? '&amp;view='.$view : '';
					$result = sql_query(" select gr_id, gr_subject from {$g5['group_table']} order by gr_id ");
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$gr_active = $gr_msg = '';
						if($row['gr_id'] == $gr_id){ // 현재 선택된 그룹이라면
							$gr_active = ' class="active"';
							$gr_msg = '<span class="sr-only">현재 그룹</span>';
							$gr_select = $gn; // 현재 위치 표시
						}
				?>
					<li<?php echo $gr_active ?>>
						<a class="py-2 px-3" href="<?php echo G5_BBS_URL ?>/new.php?gr_id=<?php echo $row['gr_id'].$gr_qstr ?>">
							<?php echo $gr_msg.get_text($row['gr_subject']); ?>
						</a>
					</li>
				<?php $gn++; } ?>
				</ul>				
			</div>
			<div>
				<a href="javascript:;" class="sly-btn sly-prev ca-prev py-2 px-3">
					<i class="fa fa-angle-left" aria-hidden="true"></i>
					<span class="sr-only">이전 그룹</span>
				</a>
			</div>
			<div>
				<a href="javascript:;" class="sly-btn sly-next ca-next py-2 px-3">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
					<span class="sr-only">다음 그룹</span>
				</a>				
			</div>
		</div>
	</div>
	<hr/>

	<script>
		$(document).ready(function() {
			$('#new_group .sly-wrap').sly({
				horizontal: 1,
				itemNav: 'basic',
				smart: 1,
				mouseDragging: 1,
				touchDragging: 1,
				releaseSwing: 1,
				startAt: <?php echo $gr_select ?>,
				speed: 300,
				prevPage: '#new_group .ca-prev',
				nextPage: '#new_group .ca-next'
			});

			// Sly Tab
			var group_id = 'new_group';
			var group_size = na_sly_size(group_id);

			na_sly(group_id, group_size);

			$(window).resize(function(e) {
				na_sly(group_id, group_size);
			});
		});
	</script>
</nav>
<!-- } 전체게시물 그룹 끝 -->

<!-- 전체게시물 목록 시작 { -->
<form name="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
<input type="hidden" name="sw"       value="move">
<input type="hidden" name="view"     value="<?php echo $view; ?>">
<input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
<input type="hidden" name="stx"      value="<?php echo $stx; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<input type="hidden" name="page"     value="<?php echo $page; ?>">
<input type="hidden" name="pressed"  value="">

	<!-- 페이지 정보 및 버튼 시작 { -->
	<div id="new_btn_top" class="clearfix f-de font-weight-normal mb-2 pl-3 pr-2 px-sm-0">
		<div class="d-flex align-items-center">
			<div id="bo_list_total" class="flex-grow-1">
				Total <b><?php echo number_format($total_count) ?></b> / <?php echo $page ?> Page
			</div>
			<div class="btn-group" role="group">
				<?php if($is_admin || IS_DEMO) { ?>
					<?php if(is_file($new_skin_path.'/setup.skin.php')) { ?>
						<a href="<?php echo na_setup_href('new') ?>" title="스킨 설정" class="btn btn_b01 btn-setup nofocus py-1">
							<i class="fa fa-cogs fa-md" aria-hidden="true"></i></a>
							<span class="sr-only">스킨 설정</span>
						</a>
					<?php } ?>
				<?php } ?>
				<?php if($is_admin) { ?>
					<button type="submit" onclick="document.pressed=this.value" value="선택삭제" title="선택 삭제" class="btn btn_b01 nofocus py-1">
						<i class="fa fa-trash-o fa-md" aria-hidden="true"></i>				
						<span class="sr-only">선택 삭제</span>
					</button>
				<?php } ?>
				<button type="button" class="btn btn_b01 nofocus py-1" title="새 글 검색" data-toggle="collapse" data-target="#new_search" aria-expanded="false" aria-controls="new_search">
					<i class="fa fa-search fa-md" aria-hidden="true"></i>
					<span class="sr-only">새글 검색</span>
				</button>
			</div>
		</div>
	</div>
	<!-- } 페이지 정보 및 버튼 끝 -->

	<!-- 전체게시물 목록 시작 { -->
	<div id="new_list" class="mb-4">

		<!-- 목록 헤드 -->
		<div class="d-block d-md-none w-100 mb-0 bg-<?php echo $head_color ?>" style="height:4px;"></div>

		<div class="na-table d-none d-md-table w-100 mb-0">
			<div class="<?php echo $head_class ?> d-md-table-row">
				<div class="d-md-table-cell nw-5 px-md-1">번호</div>
				<div class="d-md-table-cell pr-md-1">
					<?php if ($is_admin) { ?>
					<label class="float-left mb-0">
						<span class="sr-only">목록 전체 선택</span>
						<input type="checkbox" id="all_chk">
					</label>
					<?php } ?>
					제목
				</div>
				<div class="d-md-table-cell nw-10 pl-2 pr-md-1">이름</div>
				<div class="d-md-table-cell nw-6 pr-md-1">날짜</a></div>
				<div class="d-md-table-cell nw-8 pr-md-1">게시판</a></div>
			</div>
		</div>

		<ul class="na-table d-md-table w-100">
		<?php
			$list_cnt = count($list);
			for ($i=0; $i < $list_cnt; $i++) {

				// 번호
				$num = $total_count - ($page - 1) * $page_rows - $i;

				// 글 구분
				$list[$i]['wr_subject'] = na_get_text($list[$i]['wr_subject']);
				if($list[$i]['comment']) {
					$list[$i]['wr_subject'] = '댓글 <span class="na-bar"></span> '.$list[$i]['wr_subject'];
				}

				// 아이콘
				if (strstr($list[$i]['wr_option'], 'secret')) {
					$wr_icon = '<span class="na-icon na-secret"></span>';
				} else if ((strtotime($list[$i]['wr_datetime']) + 86400) >= G5_SERVER_TIME) {
					$wr_icon = '<span class="na-icon na-new"></span>';
				} else {
					$wr_icon = '';
				}
			?>
			<li class="d-md-table-row px-3 py-2 p-md-0 text-md-center text-muted border-bottom">
				<div class="d-none d-md-table-cell nw-5 f-sm font-weight-normal py-md-2 px-md-1">
					<span class="sr-only">번호</span>
					<?php echo $num ?>
				</div>
				<div class="d-md-table-cell text-left py-md-2 pr-md-1">
					<div class="na-title float-md-left">
						<div class="na-item">
							<?php if ($is_admin) { ?>
								<input type="checkbox" class="mb-0 mr-2" name="chk_bn_id[]" value="<?php echo $i ?>" id="chk_bn_id_<?php echo $i ?>">
								<input type="hidden" name="bo_table[<?php echo $i ?>]" value="<?php echo $list[$i]['bo_table'] ?>">
								<input type="hidden" name="wr_id[<?php echo $i ?>]" value="<?php echo $list[$i]['wr_id'] ?>">
							<?php } ?>
							<a href="<?php echo $list[$i]['href'] ?>" class="na-subject">
								<?php echo $wr_icon ?>
								<?php echo $list[$i]['wr_subject'] ?>
							</a>
							<?php if(!$list[$i]['comment'] && $list[$i]['wr_comment']) { ?>
								<div class="na-info">
									<span class="sr-only">댓글</span>
									<span class="count-plus orangered">
										<?php echo $list[$i]['wr_comment']; ?>
									</span>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="float-right float-md-none d-md-table-cell nw-10 nw-md-auto text-left f-sm font-weight-normal pl-2 py-md-2 pr-md-1">
					<span class="sr-only">등록자</span>
					<?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']); ?>
				</div>
				<div class="float-left float-md-none d-md-table-cell nw-6 nw-md-auto f-sm font-weight-normal py-md-2 pr-3 pr-md-1">
					<span class="sr-only">등록일</span>
					<?php echo $list[$i]['datetime2'] ?>
				</div>
				<div class="float-left float-md-none d-md-table-cell nw-8 nw-md-auto f-sm font-weight-normal py-md-2 pr-md-1">
					<a href="<?php echo get_pretty_url($list[$i]['bo_table']) ?>" class="text-muted"><?php echo na_cut_text($list[$i]['bo_subject'], 20) ?></a>
				</div>
				<div class="clearfix d-block d-md-none"></div>
			</li>
		<?php }  ?>
		</ul>
		<?php if (!$list_cnt) { ?>
			<div class="f-de font-weight-normal px-3 py-5 text-muted text-center border-bottom">게시물이 없습니다.</div>
		<?php } ?>
	</div>
	<!-- } 전체게시물 목록 끝 -->
</form>

<!-- 전체게시물 페이지네이션 시작 { -->
<div class="font-weight-normal px-3 px-sm-0 mb-4">
	<ul class="pagination justify-content-center en mb-0">
		<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id=$gr_id&amp;view=$view&amp;mb_id=$mb_id&amp;page="); ?>
	</ul>
</div>
<!-- } 전체게시물 페이지네이션 끝 -->

<?php if ($is_admin) { ?>
	<script>
	$(function(){
		$('#all_chk').click(function(){
			$('[name="chk_bn_id[]"]').attr('checked', this.checked);
		});
	});

	function fnew_submit(f)
	{
		f.pressed.value = document.pressed;

		var cnt = 0;
		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
				cnt++;
		}

		if (!cnt) {
			alert(document.pressed+"할 게시물을 하나 이상 선택하세요.");
			return false;
		}

		if (!confirm("선택한 게시물을 정말 "+document.pressed+" 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
			return false;
		}

		f.action = "./new_delete.php";

		return true;
	}
	</script>
<?php } ?>
