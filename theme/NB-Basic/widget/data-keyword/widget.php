<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// Sly
na_script('sly');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

$list = array();

$n = 0;
if(isset($wset['d']['pp_word']) && is_array($wset['d']['pp_word'])) {
	$data_cnt = count($wset['d']['pp_word']);
	for($i=0; $i < $data_cnt; $i++) {
		if($wset['d']['pp_word'][$i]) {
			$list[$n]['pp_word'] = $wset['d']['pp_word'][$i];
			$list[$n]['pp_link'] = $wset['d']['pp_link'][$i];
			$n++;
		}
	}
} else {
	if($wset['q']) {
		$tmp = explode(",", $wset['q']);
		for($i=0; $i < count($tmp); $i++) {
			if($tmp[$i]) {
				$list[$n]['pp_word'] = $tmp[$i];
				$list[$n]['pp_link'] = '';
				$n++;
			}
		}
	}
}

$list_cnt = $n;

if($list_cnt && $wset['rand']) 
	shuffle($list);

// 랜덤아이디
$id = 'pp_'.na_rid();

// 검색주소
$search_href = G5_BBS_URL.'/search.php?sfl='.urlencode('wr_subject||wr_content');

?>

<!-- 인기검색어 시작 { -->
<section id="<?php echo $id ?>" class="basic-keyword f-sm font-weight-normal">
    <h3 class="sound_only">인기검색어</h3>
	<div class="d-flex">
		<div class="pp-sly flex-grow-1 text-nowrap">
			<ul>
			<?php for ($i=0; $i < $list_cnt; $i++) { ?>
				<li class="d-inline-block mr-3">
					<?php if($list[$i]['pp_link']) { ?>
						<a href="<?php echo $list[$i]['pp_link'] ?>">
					<?php } else { ?>
						<a href="<?php echo $search_href ?>&amp;stx=<?php echo urlencode($list[$i]['pp_word']) ?>">
					<?php } ?>
					<?php echo get_text($list[$i]['pp_word']); ?>
					</a>
				</li>
			<?php } ?>
			<?php if(!$list_cnt) { ?>
				<li class="d-inline-block mr-3"><a>위젯설정에서 검색어를 설정해 주세요.</a></li>
			<?php } ?>
			<li class="d-inline-block pp-last mr-3"><a>&nbsp;</a></li>
			</ul>
		</div>
		<div class="pl-2">
			<a href="javascript:;" class="pp-prev">
				<i class="fa fa-angle-left" aria-hidden="true"></i>
			</a>
		</div>
		<div>
			<a href="javascript:;" class="pp-next">
				<i class="fa fa-angle-right" aria-hidden="true"></i>
			</a>				
		</div>
	</div>
</section>

<script>
$(document).ready(function() {
	$('#<?php echo $id ?> .pp-sly').sly({
		horizontal: 1,
		itemNav: 'basic',
		smart: 1,
		mouseDragging: 1,
		touchDragging: 1,
		releaseSwing: 1,
		speed: 300,
		elasticBounds: 1,
		dragHandle: 1,
		dynamicHandle: 1,
		prevPage: '#<?php echo $id ?> .pp-prev',
		nextPage: '#<?php echo $id ?> .pp-next'
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
