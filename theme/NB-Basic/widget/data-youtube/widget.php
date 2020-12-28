<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

/* 유튜브 동영상 랜덤 출력 위젯 */

na_script('youtube');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

$list = array();

$n = 0;
if(isset($wset['d']['vid']) && is_array($wset['d']['vid'])) {
	$data_cnt = count($wset['d']['vid']);
	for($i=0; $i < $data_cnt; $i++) {
		if($wset['d']['vid'][$i]) {
			$list[$n]['vid'] = get_text($wset['d']['vid'][$i]);
			$list[$n]['img'] = na_url($wset['d']['img'][$i]);
			$list[$n]['pv'] = get_text($wset['d']['pv'][$i]);
			$list[$n]['rate'] = get_text($wset['d']['rate'][$i]);
			$n++;
		}
	}
}

// 샘플
if(!$n) {
	$sample = array();
	@include(NA_THEME_ADMIN_PATH.'/sample.php');
	$list[0]['vid'] = $sample[0][0];
	$list[0]['pv'] = 'maxresdefault';
	$list[0]['img'] = '';
	$list[0]['rate'] = '';
}

// 랜덤
if($n > 1) 
	shuffle($list);

// 비율
$rate = ($list[0]['rate']) ? ' style="padding-bottom:75%;"' : '';

// 랜덤아이디
$id = 'vid_'.na_rid();
?>

<div class="img-wrap na-round"<?php echo $rate ?>>
	<div class="img-item">
		<div id="<?php echo $id ?>"></div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#<?php echo $id ?>').prettyEmbed({
		videoID: '<?php echo $list[0]['vid'] ?>',
		previewSize: '<?php echo $list[0]['pv'] ?>',
		customPreviewImage: '<?php echo $list[0]['img'] ?>',
		showInfo: false,
		showControls: true,
		loop: false,
		colorScheme: 'dark',
		showRelated: false,
		useFitVids: true
	});
});
</script>
<?php if($setup_href) { ?>
	<div class="btn-wset">
		<a href="<?php echo $setup_href;?>" class="btn-setup">
			<span class="f-sm text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>
