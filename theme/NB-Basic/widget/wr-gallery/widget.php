<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

/* 게시물 추출 위젯 - 일반 갤러리형 */

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

// 반응구간
$xs = ($wset['xs']) ? $wset['xs'] : 2;
$sm = ($wset['sm']) ? $wset['sm'] : 3;
$md = ($wset['md']) ? $wset['md'] : 4;
$lg = ($wset['lg']) ? $wset['lg'] : 4;
$xl = ($wset['xl']) ? $wset['xl'] : 4;

?>

<ul class="row row-cols-<?php echo $xs ?> row-cols-sm-<?php echo $sm ?> row-cols-md-<?php echo $md ?> row-cols-lg-<?php echo $lg ?> row-cols-xl-<?php echo $xl ?> mx-n2">
<?php 
if($wset['cache']) {
	echo na_widget_cache($widget_path.'/widget.rows.php', $wset, $wcache);
} else {
	include($widget_path.'/widget.rows.php');
}
?>
</ul>

<?php if($setup_href) { ?>
	<div class="btn-wset pt-0">
		<a href="<?php echo $setup_href;?>" class="btn-setup">
			<span class="f-sm text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>