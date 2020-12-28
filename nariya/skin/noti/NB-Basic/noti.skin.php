<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$noti_skin_url.'/style.css">', 0);

// 스킨 설정값
$wset = na_skin_config('noti');

$head_color = ($wset['head_color']) ? $wset['head_color'] : 'primary';

?>

<nav id="noti_cate" class="sly-tab font-weight-normal mb-2">
	<div id="noti_cate_list" class="sly-wrap px-3 px-sm-0">
		<ul id="noti_cate_ul" class="clearfix sly-list text-nowrap border-left">
			<li class="float-left<?php echo ($is_read == "all") ? ' active' : '';?>"><a href="<?php echo G5_BBS_URL ?>/noti.php" class="py-2 px-3">전체보기</a></li>
			<li class="float-left<?php echo ($is_read == 'y') ? ' active' : '';?>"><a href="<?php echo G5_BBS_URL ?>/noti.php?read=y" class="py-2 px-3">읽은알림</a></li>
			<li class="float-left<?php echo ($is_read == 'n') ? ' active' : '';?>"><a href="<?php echo G5_BBS_URL ?>/noti.php?read=n" class="py-2 px-3">안읽은알림</a></li>
		</ul>
	</div>
	<hr/>
</nav>

<form id="fnotilist" name="fnotilist" method="post" action="#" onsubmit="return fnoti_submit(this);" class="mb-4">
<input type="hidden" name="read"    value="<?php echo $read; ?>">
<input type="hidden" name="page"    value="<?php echo (int)$page; ?>">
<input type="hidden" name="token"    value="<?php echo $token; ?>">
<input type="hidden" name="pressed" value="">
<input type="hidden" name="p_type"	value="" id="p_type">
	<!-- 페이지 정보 및 버튼 시작 { -->
	<div id="noti_btn_top" class="clearfix f-de font-weight-normal mb-2 pl-3 pr-2 px-sm-0">
		<div class="d-flex align-items-center">
			<div id="faq_list_total" class="flex-grow-1">
				Total <b><?php echo number_format($total_count) ?></b> / <?php echo $page ?> Page
			</div>
			<div class="btn-group" role="group">
				<?php if($is_admin || IS_DEMO) { ?>
					<?php if(is_file($noti_skin_path.'/setup.skin.php')) { ?>
						<a href="<?php echo na_setup_href('noti') ?>" title="스킨 설정" class="btn btn_b01 btn-setup nofocus py-1">
							<i class="fa fa-cogs fa-md" aria-hidden="true"></i>
							<span class="sr-only">스킨 설정</span>
						</a>
					<?php } ?>
				<?php } ?>
				<button type="button" class="btn btn_b01 nofocus dropdown-toggle dropdown-toggle-split py-1" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" title="알림 리스트 옵션">
					<span class="sr-only">알림 리스트 옵션</span>
				</button>
				<div class="dropdown-menu dropdown-menu-right p-0 border-0 bg-transparent text-right">
					<div class="btn-group-vertical">
						<a href="javascript:;" class="btn btn-primary py-2" role="button">
							<label class="p-0 m-0" for="allCheck">
								<i class="fa fa-check-square-o fa-fw" aria-hidden="true"></i> 
								전체선택						
							</label>
						</a>
						<button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-primary py-2">
							<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> 
							선택삭제
						</button>
						<button type="submit" name="btn_submit" value="읽음표시" onclick="document.pressed=this.value" class="btn btn-primary py-2">
							<i class="fa fa-eye fa-fw" aria-hidden="true"></i> 
							읽음표시
						</button>
						<button type="submit" name="btn_submit" value="전체삭제" onclick="document.pressed=this.value" class="btn btn-primary py-2">
							<i class="fa fa-times fa-fw" aria-hidden="true"></i>
							전체삭제
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- 목록 헤드 -->
	<div class="w-100 mb-0 bg-<?php echo $head_color ?>" style="height:4px;"></div>
	<?php if($nariya['noti_days']){ ?>	
		<div class="na-table border-bottom">
			<div class="f-sm px-3 py-2 py-md-2 bg-light font-weight-normal">
				알림 내역은 <b><?php echo $nariya['noti_days'] ?></b>일 동안만 보관 됩니다.
			</div>
		</div>
	<?php } ?>
	<ul class="na-table d-table w-100 f-de">
	<?php for($i=0; $i < $list_cnt; $i++) { ?>
		<li class="d-table-row border-bottom">
			<div class="d-table-cell text-center nw-6 py-2 py-md-2">
				<?php echo ($list[$i]['ph_readed'] == "Y") ? '<span class="text-muted">읽음</span>' : '<span class="orangered">읽기 전</span>';?>
			</div>
			<div class="d-table-cell py-2 py-md-2">
				<a href="<?php echo $list[$i]['href'] ?>">
					<?php echo $list[$i]['wtime'] ?>
					<span class="na-bar"></span>
					<?php echo $list[$i]['msg'] ?>
					<?php if($list[$i]['subject']) { ?>
						<span class="text-muted">
							<i class="fa fa-caret-right" aria-hidden="true"></i>
							<?php echo $list[$i]['parent_subject'] ?>
						</span>
					<?php } ?>
				</a>
			</div>
			<div class="d-table-cell text-center nw-3 py-2 py-md-2">
				<label for="chk_bn_id_<?php echo $i ?>" class="sr-only"><?php echo $i ?>번</label>
				<input type="checkbox" name="chk_bn_id[]" value="<?php echo $i ?>" id="chk_bn_id_<?php echo $i ?>">
				<input type="hidden" name="chk_g_ids[<?php echo $i ?>]" value="<?php echo $list[$i]['g_ids'] ?>" >
				<input type="hidden" name="chk_read_yn[<?php echo $i ?>]" value="<?php echo $list[$i]['ph_readed'] ?>" >
			</div>
		</li>
    <?php } ?>
	</ul>
	<?php if ($i == 0) { ?>
		<div class="f-de px-3 py-5 text-center text-muted border-bottom mb-4 font-weight-normal">
			알림이 없습니다.
		</div>
	<?php } ?>
</form>

<div class="font-weight-normal px-3 px-sm-0 mb-4">
	<ul class="pagination justify-content-center en mb-0">
		<?php echo na_paging($page_rows, $page, $total_page,"{$_SERVER['PHP_SELF']}?$query_string&amp;page="); ?>
	</ul>
</div>

<!-- 전체 선택 -->
<div class="sr-only">
	<input type="checkbox" id="allCheck" onclick="if (this.checked) all_checked(true); else all_checked(false);">
</div>

<script>
function all_checked(sw) {
	var f = document.fnotilist;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_bn_id[]")
			f.elements[i].checked = sw;
	}
}

function fnoti_submit(f) {

	if(document.pressed == "전체삭제") {
		if (!confirm("모든 알림을 정말 삭제 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
			return false;
		}

		$("#p_type").val("alldelete");
	} else {
		var chk_count = 0;

		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
			chk_count++;
		}

		if (!chk_count) {
			alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
			return false;
		}

		if(document.pressed == "읽음표시") {
			$("#p_type").val("read");
		}

		if(document.pressed == "선택삭제") {
			if (!confirm("선택한 알림을 정말 삭제 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
				return false;
			}

			$("#p_type").val("del");
		}
	}

    f.action = "./noti_delete.php";

    return true;
}
</script>