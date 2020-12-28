<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

global $menu, $menu_cnt;

$mes = array();
for ($i=0; $i < $menu_cnt; $i++) { 
	// 주메뉴 이하 사이트이고 서브메뉴가 있으면...
	if($menu[$i]['on']) {
		$mes = $menu[$i];
		break;
	}
}

if(empty($mes))
	return;

add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);
?>
<div id="nt_side_menu" class="font-weight-normal mb-4">
	<div class="bg-primary text-white text-center p-3 py-sm-4 en">
		<h4>
			<i class="fa <?php echo $mes['icon'] ?>" aria-hidden="true"></i>
			<?php echo $mes['text'];?>
		</h4>
	</div>
	<?php if(isset($mes['s'])) { ?>
		<ul class="me-ul border border-top-0">
		<?php for ($i=0; $i < count($mes['s']); $i++) { 
			$me = $mes['s'][$i]; 
		?>
		<li class="me-li<?php echo ($me['on']) ? ' active' : ''; ?>">
			<?php if(isset($me['s'])) { //Is Sub Menu ?>
				<i class="fa fa-caret-down tree-toggle me-i"></i>
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
						<li class="me-line1"><a class="me-a1"><?php echo $me1['line'];?></a></li>
					<?php } ?>

					<li class="me-li1<?php echo ($me1['on']) ? ' active' : ''; ?>">
						<a class="me-a1" href="<?php echo $me1['href'];?>" target="<?php echo $me1['target'];?>">
							<i class="fa <?php echo $me1['icon'] ?> fa-fw" aria-hidden="true"></i>
							<?php echo $me1['text'];?>
						</a>
					</li>
				<?php } //for ?>
				</ul>
			<?php } //is_sub ?>
		</li>
		<?php } //for ?>
		</ul>
	<?php } //is_sub ?>
</div>
<script>
$(document).ready(function () {
	$(document).on('click', '#nt_side_menu .tree-toggle', function () {
		$(this).parent().children('ul.tree').toggle(200);
	});
});
</script>
