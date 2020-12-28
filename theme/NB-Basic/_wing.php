<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 상단 여백
$wing_top = ($tset['layout'] == 'w') ? ' pt-4 mt-1' : '';

?>
<div id="nt_wing" class="d-none d-xl-block">
	<div class="nt-container text-center">
		<div class="wing-left<?php echo $wing_top ?>">
			<!-- 좌측 날개 시작 { 아래 코드는 필요없으니 다 지우셔야 합니다. -->

				<div class="w-100 bg-light py-5">
					좌측 날개
				</div>

			<!-- } 좌측 날개 끝 -->
		</div>
		<div class="wing-right<?php echo $wing_top ?>">
			<!-- 우측 날개 시작 { 아래 코드는 필요없으니 다 지우셔야 합니다. -->

				<div class="w-100 bg-light py-5">
					우측 날개
				</div>

			<!-- } 우측 날개 끝 -->
		</div>
	</div>
</div>