<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

/* 슬라이드 이미지 위젯 - Bootstrap4 Carousel */

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

// 자동실행
$interval = ($wset['auto']) ? 'false' : 5000;

// 페이드 효과
$fade = ($wset['fade']) ? ' carousel-fade' : '';

$list = array();

$n = 0;
if(isset($wset['d']['img']) && is_array($wset['d']['img'])) {
	$data_cnt = count($wset['d']['img']);
	for($i=0; $i < $data_cnt; $i++) {
		if($wset['d']['img'][$i]) {
			$list[$n]['img'] = na_url($wset['d']['img'][$i]);
			$list[$n]['link'] = na_url($wset['d']['link'][$i]);
			$list[$n]['alt'] = get_text($wset['d']['alt'][$i]);
			$list[$n]['target'] = $wset['d']['target'][$i];
			$n++;
		}
	}
}

$list_cnt = $n;

// 샘플
if(!$list_cnt) {
	$sample = array();
	@include(NA_THEME_ADMIN_PATH.'/sample.php');
	$data_cnt = count($sample);
	for($i=0; $i < $data_cnt; $i++) {
		$list[$i]['img'] = 'https://img.youtube.com/vi/'.$sample[$i][0].'/maxresdefault.jpg';
		$list[$i]['link'] = 'https://youtu.be/'.$sample[$i][0];
		$list[$i]['alt'] = $sample[$i][1];
		$list[$i]['target'] = '_blank';
	}
	$list_cnt = $i;
}

// 랜덤
if($wset['rand'] && $list_cnt) 
	shuffle($list);

// 랜덤아이디
$id = 'carousel_'.na_rid(); 

?>
<style>
	#<?php echo $id;?> .img-wrap { 
		padding-bottom:<?php echo ($wset['xl']) ? $wset['xl'] : '27%' ;?>; 
	}
	<?php if(_RESPONSIVE_) { //반응형일 때만 작동 ?>
		@media (max-width:1199px) { 
			.responsive #<?php echo $id;?> .img-wrap { 
				padding-bottom:<?php echo ($wset['lg']) ? $wset['lg'] : '27%' ;?> !important; 
			} 
		}
		@media (max-width:991px) { 
			.responsive #<?php echo $id;?> .img-wrap { 
				padding-bottom:<?php echo ($wset['md']) ? $wset['md'] : '35%' ;?> !important; 
			} 
		}
		@media (max-width:767px) { 
			.responsive #<?php echo $id;?> .img-wrap { 
				padding-bottom:<?php echo ($wset['sm']) ? $wset['sm'] : '45%' ;?> !important; 
			} 
		}
		@media (max-width:575px) { 
			.responsive #<?php echo $id;?> .img-wrap { 
				padding-bottom:<?php echo ($wset['xs']) ? $wset['xs'] : '56.25%' ;?> !important; 
			} 
		}
	<?php } ?>
</style>
<div id="<?php echo $id;?>" class="carousel slide<?php echo $fade ?>" data-ride="carousel" data-interval="<?php echo $interval;?>">
	<div class="carousel-inner">
		<?php for ($i=0; $i < $list_cnt; $i++) { ?>
			<div class="carousel-item<?php echo (!$i) ? ' active' : '';?>">
				<div class="img-wrap">
					<div class="img-item">
						<a href="<?php echo ($list[$i]['link']) ? $list[$i]['link'] : 'javascript:;';?>" target="<?php echo $list[$i]['target'] ?>">
							<img src="<?php echo $list[$i]['img'] ?>" alt="<?php echo $list[$i]['alt'] ?>">
						</a>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if(!$list_cnt) { ?>
			<div class="carousel-item active">
				<div class="img-wrap bg-primary">
					<div class="img-item">
						<div class="position-absolute text-center text-white en mt-n3 w-100" style="top:50%; left:0;">
							<h4>위젯설정에서 이미지 등록</h4>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<!-- Controls -->
	<a class="carousel-control-prev" href="#<?php echo $id;?>" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#<?php echo $id;?>" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
	<?php if(!$wset['nav']) { ?>
		 <!-- Indicators -->
		<ol class="carousel-indicators">
			<?php for ($i=0; $i < $list_cnt; $i++) { ?>
				<li data-target="#<?php echo $id;?>" data-slide-to="<?php echo $i;?>"<?php echo (!$i) ? ' class="active"' : '';?>></li>
			<?php } ?>
		</ol>
	<?php } ?>
</div>

<?php 
//그림자 
if($wset['shadow'])
	echo na_shadow($wset['shadow']);
?>

<?php if($setup_href) { ?>
	<div class="btn-wset">
		<a href="<?php echo $setup_href;?>" class="btn-setup">
			<span class="f-sm text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>