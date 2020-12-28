<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// WING
if($is_wing)
	@include_once (G5_THEME_PATH.'/_wing.php');
?>

<div class="nt-container px-0 px-sm-4 px-xl-0 pt-0 pt-sm-4">
	<div class="mb-3 mb-sm-4">
		<?php echo na_widget('data-carousel', 'title-1', 'xl=27%', 'auto=0'); //타이틀 ?>
	</div>

	<div class="row na-row">
		<!-- 메인 영역 -->
		<div class="col-md-9 order-md-2 na-col">

			<div class="row na-row">
				<div class="col-md-4 na-col">

					<!-- 위젯 시작 { -->
					<h3 class="h3 f-lg en">
						<a href="<?php echo get_pretty_url('video'); ?>">
							<span class="float-right more-plus"></span>
							게시판
						</a>
					</h3>
					<hr class="hr"/>
					<div class="mt-3 mb-4">
						<?php echo na_widget('wr-list', 'tlist-1', 'bo_list=video ca_list=게임 rank=red'); ?>
					</div>
					<!-- } 위젯 끝-->

				</div>
				<div class="col-md-4 na-col">

					<!-- 위젯 시작 { -->
					<h3 class="h3 f-lg en">
						<a href="<?php echo get_pretty_url('video'); ?>">
							<span class="float-right more-plus"></span>	
							게시판
						</a>
					</h3>
					<hr class="hr"/>
					<div class="mt-3 mb-4">
						<?php echo na_widget('wr-list', 'tlist-2', 'bo_list=video ca_list=게임 rank=green'); ?>
					</div>
					<!-- } 위젯 끝-->

				</div>
				<div class="col-md-4 na-col">

					<!-- 위젯 시작 { -->
					<h3 class="h3 f-lg en">
						<a href="<?php echo get_pretty_url('video'); ?>">
							<span class="float-right more-plus"></span>
							게시판
						</a>
					</h3>
					<hr class="hr"/>
					<div class="mt-3 mb-4">
						<?php echo na_widget('wr-list', 'tlist-3', 'bo_list=video ca_list=게임 rank=blue'); ?>
					</div>
					<!-- } 위젯 끝-->

				</div>
			</div>

			<!-- 위젯 시작 { -->
			<h3 class="h3 f-lg en">
				<a href="<?php echo get_pretty_url('video'); ?>">
					<span class="float-right more-plus"></span>
					갤러리
				</a>
			</h3>
			<hr class="hr"/>
			<div class="px-3 px-sm-0 my-3">
				<?php echo na_widget('wr-gallery', 'gallery-1', 'bo_list=video ca_list=게임 rows=8'); ?>
			</div>
			<!-- } 위젯 끝-->


			<div class="row na-row">
				<div class="col-md-4 na-col">

					<!-- 위젯 시작 { -->
					<h3 class="h3 f-lg en">
						<a href="<?php echo get_pretty_url('video'); ?>">
							<span class="float-right more-plus"></span>
							게시판
						</a>
					</h3>
					<hr class="hr"/>
					<div class="mt-3 mb-4">
						<?php echo na_widget('wr-list', 'blist-1', 'bo_list=video ca_list=게임'); ?>
					</div>
					<!-- } 위젯 끝-->

				</div>
				<div class="col-md-4 na-col">

					<!-- 위젯 시작 { -->
					<h3 class="h3 f-lg en">
						<a href="<?php echo get_pretty_url('video'); ?>">
							<span class="float-right more-plus"></span>
							게시판
						</a>
					</h3>
					<hr class="hr"/>
					<div class="mt-3 mb-4">
						<?php echo na_widget('wr-list', 'blist-2', 'bo_list=video ca_list=게임'); ?>
					</div>
					<!-- } 위젯 끝-->

				</div>
				<div class="col-md-4 na-col">

					<!-- 위젯 시작 { -->
					<h3 class="h3 f-lg en">
						<a href="<?php echo get_pretty_url('video'); ?>">
							<span class="float-right more-plus"></span>
							게시판
						</a>
					</h3>
					<hr class="hr"/>
					<div class="mt-3 mb-4">
						<?php echo na_widget('wr-list', 'blist-3', 'bo_list=video ca_list=게임'); ?>
					</div>
					<!-- } 위젯 끝-->

				</div>
			</div>

			<!-- 위젯 시작 { -->
			<h3 class="h3 f-lg en">
				<a href="<?php echo get_pretty_url('video'); ?>">
					<span class="float-right more-plus"></span>
					배너
				</a>
			</h3>
			<hr class="hr"/>
			<div class="px-3 px-sm-0 mt-3 mb-4">
				<?php echo na_widget('data-slider', 'banner-1'); ?>
			</div>
			<!-- } 위젯 끝-->

		</div>

		<!-- 사이드 영역 -->
		<div class="col-md-3 order-md-1 na-col">
			<?php @include_once(G5_THEME_PATH.'/side/side-index.php') ?>
		</div>
	</div>
</div>
