<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>
<div id="scrap_do" class="mb-4">
	<div id="topNav" class="bg-primary text-white">
		<div class="p-3">
			<button type="button" class="close" aria-label="Close" onclick="window.close();">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<h5>스크랩하기</h5>
		</div>
	</div>

	<div id="topHeight"></div>

	<form name="f_scrap_popin" action="./scrap_popin_update.php" method="post" class="px-3">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">

		<div class="pb-2 pt-4">
			<strong><?php echo get_text(cut_str($write['wr_subject'], 255)) ?></strong>
		</div>

		<div class="pb-3">
			<textarea name="wr_content" id="wr_content" rows="5" class="form-control" placeholder="감사 혹은 격려의 댓글을 남겨 주세요."></textarea>
		</div>
		<p class="text-center">
			<button type="submit" class="btn btn-primary">스크랩 확인</button>
		</p>
	</form>
</div>

<script>
$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});
</script>
