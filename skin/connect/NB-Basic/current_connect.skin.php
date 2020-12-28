<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$connect_skin_url.'/style.css">', 0);

// 스킨 설정값
$wset = na_skin_config('connect');

// 목록헤드
$head_color = ($wset['head_color']) ? $wset['head_color'] : 'primary';
if($wset['head_skin']) {
	add_stylesheet('<link rel="stylesheet" href="'.NA_URL.'/skin/head/'.$wset['head_skin'].'.css">', 0);
	$head_class = 'list-head';
} else {
	$head_class = 'na-table-head border-'.$head_color;
}

?>

<section id="connect_list" class="mb-4">

	<h2 class="sr-only">현재 접속자 목록</h2>

	<div class="na-table d-table w-100 mb-0">
		<div class="<?php echo $head_class ?> d-table-row">
			<div class="d-table-cell nw-6">번호</div>
			<div class="d-table-cell text-left text-sm-center">
				<?php if($is_admin == 'super' ||IS_DEMO) { ?>
					<?php if(is_file($connect_skin_path.'/setup.skin.php')) { ?>
						<a class="btn_b01 btn-setup float-right mr-3" href="<?php echo na_setup_href('connect') ?>" title="스킨 설정">
							<i class="fa fa-cogs fa-md" aria-hidden="true"></i>
							<span class="sr-only">스킨 설정</span>
						</a>
					<?php } ?>
				<?php } ?>
				접속자 위치
			</div>
		</div>
	</div>

	<ul class="na-table d-table w-100">
    <?php
    for ($i=0; $i < count($list); $i++) {
        //$location = conv_content($list[$i]['lo_location'], 0);
        $location = $list[$i]['lo_location'];
        // 최고관리자에게만 허용
        // 이 조건문은 가능한 변경하지 마십시오.
        if ($list[$i]['lo_url'] && $is_admin == 'super') $display_location = "<a href=\"".$list[$i]['lo_url']."\">".$location."</a>";
        else $display_location = $location;
    ?>
		<li class="d-table-row border-bottom">
			<div class="d-table-cell text-center nw-6 py-2 py-md-2 f-sm">
				<span class="sr-only">번호</span>
				<?php echo $list[$i]['num'] ?>
			</div>
			<div class="d-table-cell py-2 py-md-2 pr-3">
				<div class="float-sm-left nw-10 nw-auto f-sm">
					<span class="sr-only">접속자</span>
					<?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']) ?>
				</div>
				<div class="na-title">
					<div class="na-item">
						<div class="na-subject">
							<?php echo $display_location ?>
						</div>
					</div>
				</div>
			</div>
        </li>
    <?php } ?>
    </ul>
</section>
