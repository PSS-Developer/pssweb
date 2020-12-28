<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 페이지에서는 사이드 메뉴 출력
echo na_widget('sidemenu');
?>

<!-- 위젯 시작 { -->
<div class="px-3 px-sm-0 mb-4">
	<?php echo na_widget('data-youtube', 'youtube-1'); ?>
</div>

<!-- } 위젯 끝-->

<!-- 위젯 시작 { -->
<h3 class="h3 f-lg en mb-1">
	<a href="<?php echo G5_BBS_URL ?>/new.php?view=w">
		<span class="float-right more-plus"></span>
		최근글
	</a>
</h3>
<hr class="hr"/>
<div class="mt-3 mb-4">
	<?php echo na_widget('wr-list', 'new-wr', 'bo_list=video ca_list=게임'); ?>
</div>
<!-- } 위젯 끝-->

<!-- 위젯 시작 { -->
<h3 class="h3 f-lg en mb-1">
	<a href="<?php echo G5_BBS_URL ?>/new.php?view=c">
		<span class="float-right more-plus"></span>
		새댓글
	</a>
</h3>
<hr class="hr"/>
<div class="mt-3 mb-4">
	<?php echo na_widget('wr-comment-list', 'new-co', 'bo_list=video ca_list=게임'); ?>
</div>
<!-- } 위젯 끝-->
