<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// PC 상단 메뉴타입
$menu_ul = 'clearfix'; 
$menu_li = 'float-left';
$menu_baebun = $menu_flex = $menu_grow = $menu_head = $menu_tail = '';
switch($tset['menu']) {
	// 좌측형
	case '2' :  $menu_flex = ' justify-content-start'; 
				$menu_tail = ' ml-auto'; 
				break; 
	// 배분-일반
	default	 :  $menu_baebun = '1'; 
				$menu_grow = 'flex-grow-1 '; 
				$menu_ul = 'row'; 
				$menu_li = 'col'; 
				break;
}

// 서브메뉴 너비
$is_sub_w = (int)$tset['sub_w'];
?>

<style>
	#nt_menu .me-sw { width:<?php echo $is_sub_w ?>px; }
</style>

<!-- PC 상단 메뉴 -->
<nav id="nt_menu" class="nt-menu bg-primary d-none d-md-block font-weight-normal">
	<h3 class="sr-only">메인 메뉴</h3>
	<div class="nt-container">
		<div class="d-flex<?php echo $menu_flex ?>">
			<div class="<?php echo $menu_grow ?>order-2 me-list">
				<ul class="<?php echo $menu_ul ?> m-0 me-ul nav-slide">
				<?php for ($i=0; $i < $menu_cnt; $i++) { 
					$me = $menu[$i]; 
				?>
					<li class="<?php echo $menu_li ?> p-0 me-li<?php echo ($me['on']) ? ' on' : ''; ?>">
						<a class="d-block bg-primary" href="<?php echo $me['href'];?>" target="<?php echo $me['target'];?>">
							<span class="me-a px-4 text-nowrap f-md en">
								<i class="fa <?php echo $me['icon'] ?>" aria-hidden="true"></i>
								<?php echo $me['text'];?>
							</span>
						</a>
						<?php if(!$tset['sub_pc'] && isset($me['s'])) { //Is Sub Menu ?>
							<div class="clearfix sub-slide sub-1div<?php echo ($menu_baebun) ? ' w-100' : '';?>">
								<ul class="sub-1dul<?php echo ($menu_baebun) ? '' : ' me-sw float-left';?>">
								<?php 
									$me_sw1 = 0; //나눔 체크
									for($j=0; $j < count($me['s']); $j++) { 
										$me1 = $me['s'][$j]; 
								?>
									<?php if($menu_flex && $me1['sp']) { //나눔 ?>
										</ul>
										<ul class="sub-1dul me-sw float-left">
									<?php $me_sw1++; } // 나눔 카운트 ?>

									<?php if($me1['line']) { //구분라인 ?>
										<li class="sub-1line"><a class="me-sh sub-1da"><?php echo $me1['line'];?></a></li>
									<?php } ?>

									<li class="sub-1dli<?php echo ($me1['on']) ? ' on' : ''; ?>">
										<a href="<?php echo $me1['href'];?>" class="me-sh sub-1da<?php echo (isset($me1['s'])) ? ' sub-icon' : '';?>" target="<?php echo $me1['target'];?>">
											<i class="fa <?php echo $me1['icon'] ?> fa-fw" aria-hidden="true"></i>
											<?php echo $me1['text'];?>
										</a>
										<?php if(isset($me1['s'])) { // Is Sub Menu ?>
											<div class="clearfix sub-slide sub-2div">
												<ul class="sub-2dul me-sw float-left">					
												<?php 
													$me_sw2 = 0; //나눔 체크
													for($k=0; $k < count($me1['s']); $k++) { 
														$me2 = $me1['s'][$k];
												?>
													<?php if($me2['sp']) { //나눔 ?>
														</ul>
														<ul class="sub-2dul me-sw float-left">
													<?php $me_sw2++; } // 나눔 카운트 ?>

													<?php if($me2['line']) { //구분라인 ?>
														<li class="sub-2line"><a class="me-sh sub-2da"><?php echo $me2['line'];?></a></li>
													<?php } ?>

													<li class="sub-2dli<?php echo ($me2['on']) ? ' on' : ''; ?>">
														<a href="<?php echo $me2['href'] ?>" class="me-sh sub-2da" target="<?php echo $me2['target'] ?>">
															<i class="fa <?php echo $me2['icon'] ?> fa-fw" aria-hidden="true"></i>
															<?php echo $me2['text'];?>
														</a>
													</li>
												<?php } ?>
												</ul>
												<?php $me_sw2 = $is_sub_w * ($me_sw2 + 1); //서브메뉴 너비 ?>
												<div class="clearfix" style="width:<?php echo $me_sw2 ?>px;"></div>
											</div>
										<?php } ?>
									</li>
								<?php } //for ?>
								</ul>
								<?php 
									if(!$menu_baebun) { // 배분형이 아닐 경우에만
										$me_sw1 = $is_sub_w * ($me_sw1 + 1); //서브메뉴 너비
								?>
									<div class="clearfix" style="width:<?php echo $me_sw1 ?>px;"></div>
								<?php } ?>
							</div>
						<?php } ?>
					</li>
				<?php } //for ?>
				<?php if(!$menu_cnt) { ?>
					<li class="flex-grow-1 order-2 me-li">
						<a class="me-a f-md" href="javascript:;">테마설정 > 메뉴설정에서 메뉴를 등록해 주세요.</a>
					</li>
				<?php } ?>
				</ul>							
			</div>
			<div class="me-icon order-1 me-li<?php echo $menu_head ?><?php echo ($is_index) ? ' on' : ' on'; ?>">
				<a href="<?php echo G5_URL ?>" class="me-a f-md" title="메인으로">
					<i class="fa fa-home" aria-hidden="true"></i>
				</a>
			</div>
			<div class="me-icon order-3 me-li<?php echo $menu_tail ?>">
				<a href="javascript:;" onclick="sidebar('menu'); return false;" class="me-a f-md" title="사이드바">
					<i class="fa fa-bars" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#nt_menu .nav-slide').nariya_menu(); // 주메뉴
		});
	</script>
</nav>

<?php if($tset['sticky']) { // 메뉴 상단 고정 ?>
	<script>
	function sticky_menu (e) {

		e.preventDefault();

		var scroll_n = window.scrollY || document.documentElement.scrollTop;
		var sticky_h = $("#nt_sticky").height();
		var menu_h = $("#nt_sticky_wrap").height();

		if (scroll_n > (sticky_h - menu_h)) {
			$("#nt_sticky_wrap").addClass("me-sticky");
			$("#nt_sticky").css('height', sticky_h + 'px');
		} else {
			$("#nt_sticky").css('height', 'auto');
			$("#nt_sticky_wrap").removeClass("me-sticky");
		}
	}
	$(window).on('load', function () {
		$(window).scroll(sticky_menu);
		$(window).resize(sticky_menu);
	});
	</script>
<?php } ?>
