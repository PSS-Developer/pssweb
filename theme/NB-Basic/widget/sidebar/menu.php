<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가
?>

<div id="nt_sidebar_menu" class="sidebar-list">
	<h5 class="f-de">메뉴</h5>
	<ul class="me-ul border-top f-de">
	<?php for ($i=0; $i < $menu_cnt; $i++) { 
		$me = $menu[$i]; 
	?>
	<li class="me-li<?php echo ($me['on']) ? ' active' : ''; ?>">
		<?php if(isset($me['s'])) { //Is Sub Menu ?>
			<i class="fa fa-caret-right tree-toggle me-i"></i>
		<?php } ?>
		<a class="me-a" href="<?php echo $me['href'];?>" target="<?php echo $me['target'];?>">
			<i class="fa <?php echo $me['icon'] ?> fa-fw" aria-hidden="true"></i>
			<?php echo $me['text'];?>
		</a>

		<?php if(isset($me['s'])) { //Is Sub Menu ?>
			<ul class="me-ul1 tree <?php echo ($me['on']) ? 'on' : 'off'; ?>">
			<?php for($j=0; $j < count($me['s']); $j++) { 
					$me1 = $me['s'][$j]; 
			?>
				<?php if($me1['line']) { //구분라인 ?>
					<li class="me-li1 me-line1"><a class="me-a1"><?php echo $me1['line'];?></a></li>
				<?php } ?>

				<li class="me-li1<?php echo ($me1['on']) ? ' active' : ''; ?>">

					<?php if(isset($me1['s'])) { //Is Sub Menu ?>
						<i class="fa fa-caret-down tree-toggle me-i1"></i>
					<?php } ?>

					<a class="me-a1" href="<?php echo $me1['href'];?>" target="<?php echo $me1['target'];?>">
						<i class="fa <?php echo $me1['icon'] ?> fa-fw" aria-hidden="true"></i>
						<?php echo $me1['text'];?>
					</a>
					<?php if(isset($me1['s'])) { // Is Sub Menu ?>
						<ul class="me-ul2 tree <?php echo ($me1['on']) ? 'on' : 'off'; ?>">
						<?php 
							for($k=0; $k < count($me1['s']); $k++) { 
								$me2 = $me1['s'][$k];
						?>
							<?php if($me2['line']) { //구분라인 ?>
								<li class="me-li2 me-line2"><a class="me-a2"><?php echo $me2['line'];?></a></li>
							<?php } ?>
							<li class="me-li2<?php echo ($me2['on']) ? ' active' : ''; ?>">
								<a class="me-a2" href="<?php echo $me2['href'] ?>" target="<?php echo $me2['target'] ?>">
									-
									<i class="fa <?php echo $me2['icon'] ?> fa-fw" aria-hidden="true"></i>
									<?php echo $me2['text'];?>
								</a>
							</li>
						<?php } //for ?>
						</ul>
					<?php } //is_sub ?>
				</li>
			<?php } //for ?>
			</ul>
		<?php } //is_sub ?>
	</li>
	<?php } //for ?>
	<?php if(!$menu_cnt) { ?>
		<li class="me-li">
			<a class="me-a" href="javascript:;">메뉴를 등록해 주세요.</a>
		</li>
	<?php } ?>
	</ul>
</div>

<div class="p-3 pb-5 border-top" style="margin-top:-1px;">
	<ul class="f-sm font-weight-normal">
		<?php if($stats['now_total']) { ?>
		<li class="clearfix">
			<a href="<?php echo G5_BBS_URL ?>/current_connect.php">
				<span class="float-left">현재 접속자</span>
				<span class="float-right"><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '(<b class="orangered">'.number_format($stats['now_mb']).'</b>)' : ''; ?> 명</span>
			</a>
		</li>
		<?php } ?>
		<li class="clearfix">
			<span class="float-left">오늘 방문자</span>
			<span class="float-right"><?php echo number_format($stats['visit_today']) ?> 명</span>
		</li>
		<li class="clearfix">
			<span class="float-left">어제 방문자</span>
			<span class="float-right"><?php echo number_format($stats['visit_yesterday']) ?> 명</span>
		</li>
		<li class="clearfix">
			<span class="float-left">최대 방문자</span>	
			<span class="float-right"><?php echo number_format($stats['visit_max']) ?> 명</span>
		</li>
		<li class="clearfix">
			<span class="float-left">전체 방문자</span>	
			<span class="float-right"><?php echo number_format($stats['visit_total']) ?> 명</span>
		</li>
		<?php if($stats['join_total']) { ?>
		<li class="clearfix">
			<span class="float-left">전체 회원수</span>
			<span class="float-right"><?php echo number_format($stats['join_total']) ?> 명</span>
		</li>
		<li class="clearfix">
			<span class="float-left">전체 게시물</span>	
			<span class="float-right"><?php echo number_format($stats['total_write']) ?> 개</span>
		</li>
		<li class="clearfix">
			<span class="float-left">전체 댓글수</span>
			<span class="float-right"><?php echo number_format($stats['total_comment']) ?> 개</span>
		</li>
		<?php } ?>
	</ul>
</div>
