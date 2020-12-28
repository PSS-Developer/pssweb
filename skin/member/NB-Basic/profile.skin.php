<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

// 회원등급명
$mb_grade = na_grade($mb['mb_level']);

?>
<div id="profile" class="mb-4 f-de">
	<div id="topNav" class="bg-primary text-white">
		<div class="p-3">
			<button type="button" class="close" aria-label="Close" onclick="window.close();">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<h5><?php echo $g5['title'] ?></h5>
		</div>
	</div>

	<div id="topHeight"></div>

	<ul class="list-group">
		<li class="list-group-item text-center py-3 border-left-0 border-right-0 border-top-0">
			<?php echo str_replace('<img', '<img class="rounded-circle" ', get_member_profile_img($mb['mb_id'])) ?>
		</li>
		<li class="list-group-item clearfix border-left-0 border-right-0">
			<b class="float-left">회원권한</b>
			<span class="float-right">
				<?php echo ($mb_grade) ? $mb_grade : $mb['mb_level'].'등급'; ?>
			</span>
		</li>

		<?php if(IS_NA_XP) { // 회원레벨 플러그인	
			$member['as_max'] = (isset($member['as_max']) && $member['as_max'] > 0) ? $member['as_max'] : 1;
		?>
			<li class="list-group-item clearfix border-left-0 border-right-0">
				<b class="float-left">회원레벨</b>
				<span class="float-right">
					<?php echo $mb['as_level'] ?>레벨
				</span>
			</li>
			<li class="list-group-item clearfix border-left-0 border-right-0">
				<b class="float-left">누적경험치</b>
				<span class="float-right">
					Exp <?php echo $mb['as_exp'] ?>(<?php echo (int)(($member['as_exp'] / $member['as_max']) * 100) ?>%)
				</span>
			</li>
		<?php } ?>

		<li class="list-group-item clearfix border-left-0 border-right-0">
			<b class="float-left">보유포인트</b>
			<span class="float-right">
				<?php echo number_format($mb['mb_point']) ?>점
			</span>
		</li>
		<?php if ($mb_homepage) {  ?>
			<li class="list-group-item clearfix border-left-0 border-right-0">
				<b class="float-left">홈페이지</b>
				<span class="float-right">
					<a href="<?php echo $mb_homepage ?>" target="_blank"><?php echo $mb_homepage ?></a>
				</span>
			</li>
		<?php }  ?>
		<li class="list-group-item clearfix border-left-0 border-right-0">
			<b class="float-left">회원가입일</b>
			<span class="float-right">
				<?php echo ($member['mb_level'] >= $mb['mb_level']) ?  substr($mb['mb_datetime'],0,10) ." (".number_format($mb_reg_after)."일)" : "비공개";  ?>
			</span>
		</li>
		<li class="list-group-item clearfix border-left-0 border-right-0">
			<b class="float-left">최종접속일</b>
			<span class="float-right">
				<?php echo ($member['mb_level'] >= $mb['mb_level']) ? $mb['mb_today_login'] : "비공개"; ?>
			</span>
		</li>
		<li class="list-group-item border-left-0 border-right-0">
			<h3 class="sr-only">인사말</h3>
			<?php echo $mb_profile ?>
		</li>
	</ul>
</div>

<script>
	window.resizeTo(320, 600);
	$(window).on('load', function () {
		na_nav('topNav', 'topHeight', 'fixed-top');
	});
</script>