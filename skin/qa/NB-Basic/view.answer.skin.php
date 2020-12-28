<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 답변 첨부파일
$answer['img_file'] = array();
$answer['download_href'] = array();
$answer['download_source'] = array();
$answer['img_count'] = 0;
$answer['download_count'] = 0;

for ($i=1; $i<=2; $i++) {
	if(preg_match("/\.({$config['cf_image_extension']})$/i", $answer['qa_file'.$i])) {
		$answer['img_file'][] = '<a href="'.G5_BBS_URL.'/view_image.php?fn='.urlencode('/data/qa/'.$answer['qa_file'.$i]).'" target="_blank" class="view_image"><img src="'.G5_DATA_URL.'/qa/'.$answer['qa_file'.$i].'"></a>';
		$answer['img_count']++;
		continue;
	}

	if ($answer['qa_file'.$i]) {
		$answer['download_href'][] = G5_BBS_URL.'/qadownload.php?qa_id='.$answer['qa_id'].'&amp;no='.$i;
		$answer['download_source'][] = $answer['qa_source'.$i];
		$answer['download_count']++;
	}
}

?>

<section id="bo_v_ans">
    <h3 class="sr-only">답변</h3>
	<div class="bg-light px-3 py-2 border-top border-bottom">
		<b><?php echo get_text($answer['qa_subject']) ?></b>
	</div>
	<?php if($answer['download_count']) { ?>
		<div class="clearfix f-de border-bottom text-muted px-3 py-2">
			<?php for ($i=0; $i<$answer['download_count']; $i++) { // 가변 파일 ?>
				<i class="fa fa-download fa-fw" aria-hidden="true"></i>	
				<a href="<?php echo $answer['download_href'][$i] ?>" class="view_file_download mr-3">
					<?php echo $answer['download_source'][$i] ?>
				</a>	
			<?php } ?>
		</div>
	<?php } ?>
	<div class="clearfix f-sm text-muted pl-3 pt-2 pr-2">
		<h3 class="sr-only">작성자 정보</h3>
		<ul class="d-flex align-items-center">
			<li class="pr-3">
				<span class="sr-only">답변일</span>
				<time class="f-xs" datetime="<?php echo date('Y-m-d\TH:i:s+09:00', strtotime($answer['qa_datetime'])) ?>"><?php echo date("Y.m.d H:i", strtotime($answer['qa_datetime'])) ?></time>
			</li>
			<li id="bo_v_btn" class="flex-grow-1 text-right">
				<?php if ($answer_update_href || $answer_delete_href){ ?>
					<div class="btn-group" role="group">
						<?php if($answer_update_href) { ?>
							<a href="<?php echo $answer_update_href ?>" class="btn btn_b01 nofocus py-1" title="답변 수정" role="button">
								<i class="fa fa-edit fa-md" aria-hidden="true"></i>
								<span class="sr-only">답변 수정</span>
							</a>
						<?php } ?>
						<?php if($answer_delete_href) { ?>
							<a href="<?php echo $answer_delete_href ?>" class="btn btn_b01 nofocus py-1" title="답변 삭제" role="button" onclick="del(this.href); return false;">
								<i class="fa fa-trash-o fa-md" aria-hidden="true"></i>
								<span class="sr-only">답변 삭제</span>
							</a>
						<?php } ?>	
					</div>
				<?php } ?>
			</li>
		</ul>
	</div>
	<div id="ans_con" class="p-3">
		<?php
			// 파일 출력
			if($answer['img_count']) {
				echo "<div id=\"ans_v_img\">\n";

				for ($i=0; $i<$answer['img_count']; $i++) {
					echo get_view_thumbnail($answer['img_file'][$i], $qaconfig['qa_image_width']);
				}

				echo "</div>\n";
			}

			echo na_content(get_view_thumbnail(conv_content($answer['qa_content'], $answer['qa_html']), $qaconfig['qa_image_width'])); 
		?>
	</div>
</section>

<div class="px-3 px-sm-0 py-3 border-top">
	<div class="na-table d-table w-100">
		<div class="d-table-row">
			<div class="d-table-cell nw-3 text-left">
				<?php if ($prev_href) { ?>
					<a href="<?php echo $prev_href ?>" class="btn btn_b01 nofocus" title="이전 문의">
						<i class="fa fa-chevron-left fa-md" aria-hidden="true"></i>
						<span class="sr-only">이전 문의</span>
					</a>
				<?php } ?>
			</div>
			<div class="d-table-cell text-center">
				<div class="btn-group">
					<a href="<?php echo $rewrite_href ?>" class="btn btn-primary" role="button">
						추가 문의
					</a>  
					<a href="<?php echo $list_href ?>" class="btn btn-primary" role="button" title="목록">
						<i class="fa fa-list fa-md" aria-hidden="true"></i>
						<span class="sr-only">목록</span>
					</a>
				</div>
			</div>
			<div class="d-table-cell nw-3 text-right">
				<?php if ($next_href) { ?>
					<a href="<?php echo $next_href ?>" class="btn btn_b01 nofocus" title="다음 문의">
						<i class="fa fa-chevron-right fa-md" aria-hidden="true"></i>
						<span class="sr-only">다음 문의</span>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>