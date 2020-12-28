<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 페이징 댓글 사용유무
$is_paging = ($boset['na_crows']) ? true : false;

// 댓글 추천 비추천 설정
$is_cgood = ($boset['na_cgood']) ? true : false;
$is_cnogood = ($boset['na_cnogood']) ? true : false;

?>

<?php if(!$is_ajax_comment) { // 1번만 출력 ?>
	<script>
	// 글자수 제한
	var char_min = parseInt(<?php echo $comment_min ?>); // 최소
	var char_max = parseInt(<?php echo $comment_max ?>); // 최대
	</script>

<!-- 댓글 시작 { -->
<div id="viewcomment">
<?php } ?>
	<div class="clearfix f-de px-3 px-sm-0 pt-4 pt-sm-5 pb-1">
		<div class="float-left">
			댓글 <b class="orangered"><?php echo $write['wr_comment'] ?></b>개
			<?php if($is_paging && $page) { ?>
				/ <?php echo $page ?>페이지
			<?php } ?>
		</div>
		<?php if($is_paging) { //페이징 

			$cmt_sort_href = NA_URL.'/bbs/comment_view.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id;
			
			switch($cob) {
				case 'new'		: $cmt_sort_txt = '최신순'; break;
				case 'good'		: $cmt_sort_txt = '추천순'; break;
				case 'nogood'	: $cmt_sort_txt = '비추천순'; break;
				default			: $cmt_sort_txt = '과거순'; break;
			}
		?>
			<div class="float-right dropdown">
				<a href="javascript:;" class="dropdown-toggle dropdown-toggle-empty" id="cmt_sort" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-caret-down text-muted" aria-hidden="true"></i>
					<?php echo $cmt_sort_txt ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right p-0 border-0 bg-transparent text-right f-de" aria-labelledby="cmt_sort">
					<div class="btn-group-vertical bg-white border py-1 rounded">
						<button onclick="na_comment_sort('viewcomment', '<?php echo $cmt_sort_href ?>', 'old');" class="btn px-3 py-1 text-left" role="button">
							과거순
						</button>
						<button onclick="na_comment_sort('viewcomment', '<?php echo $cmt_sort_href ?>', 'new');" class="btn px-3 py-1 text-left" role="button">
							최신순
						</button>
						<?php if($is_cgood) { ?>
							<button onclick="na_comment_sort('viewcomment', '<?php echo $cmt_sort_href ?>', 'good');" class="btn px-3 py-1 text-left" role="button">
								추천순
							</button>
						<?php } ?>
						<?php if($is_cnogood) { ?>
							<button onclick="na_comment_sort('viewcomment', '<?php echo $cmt_sort_href ?>', 'nogood');" class="btn px-3 py-1 text-left" role="button">
								비추천순
							</button>
						<?php } ?>
					</div> 
				</div>
			</div>
		<?php } ?>
	</div>
	<section id="bo_vc" class="na-fadein">
		<?php
		// 댓글목록
		$cmt_amt = count($list);
		for ($i=0; $i<$cmt_amt; $i++) {
			$comment_id = $list[$i]['wr_id'];
			$cmt_depth = strlen($list[$i]['wr_comment_reply']) * 20;
			$comment = $list[$i]['content'];
			/*
			if (strstr($list[$i]['wr_option'], "secret")) {
				$str = $str;
			}
			*/

			// 이미지
			$comment = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src=\"$1://$2.$3\" alt=\"\" class=\"img-fluid\">", $comment);

			// 동영상
			$comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);

			// 컨텐츠
			$comment = na_content($comment);

			$cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
			$c_reply_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w';
			$c_edit_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w';
			$is_comment_reply_edit = ($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) ? 1 : 0;
			$cmt_shingo = (IS_NA_BBS && $boset['na_shingo']) ? true : false;
			$by_writer = ($view['mb_id'] && $view['mb_id'] == $list[$i]['mb_id']) ? ' by-writer' : '';
		 ?>
		<article id="c_<?php echo $comment_id ?>" <?php if ($cmt_depth) { ?>style="margin-left:<?php echo $cmt_depth ?>px;"<?php } ?>>
			<div class="cmt-wrap position-relative mb-2">
				<?php if ($cmt_depth) { ?>
					<div class="cmt-reply position-absolute mt-1">
						<span class="na-icon na-reply"></span>
					</div>
				<?php } ?>
				<header style="z-index:<?php echo $cmt_sv; ?>">
					<h2 class="sr-only">
						<?php echo get_text($list[$i]['wr_name']); ?>님의 	<?php if ($cmt_depth) { ?><span class="sr-only">댓글의</span><?php } ?> 댓글
					</h2>
					<div class="clearfix font-weight-normal bg-light border-top text-muted f-sm px-3 py-2<?php echo $by_writer ?>">
						<ul class="d-flex align-items-center">
							<li class="pr-2">
								<?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']); ?>
								<?php include(G5_SNS_PATH.'/view_comment_list.sns.skin.php'); // SNS ?>
							</li>
							<?php if ($is_ip_view) { ?>
								<li class="pr-2">
									<span class="sr-only">아이피</span>
									<span class="f-xs text-muted"><?php echo $list[$i]['ip'] ?></span>
								</li>
							<?php } ?>
							</li>
							<li class="flex-grow-1 text-right">
								<span class="sr-only">작성일</span>
								<time class="f-xs" datetime="<?php echo date('Y-m-d\TH:i:s+09:00', strtotime($list[$i]['wr_datetime'])) ?>"><?php echo na_date($list[$i]['wr_datetime'], 'orangered', 'H:i', 'm.d H:i', 'Y.m.d H:i'); ?></time>
							</li>
						</ul>
					</div>
				</header>
		
				<!-- 댓글 출력 -->
				<div class="cmt-content p-3">
					<?php if(IS_NA_BBS && $is_admin && $list[$i]['as_type'] == "-1") { // 신고처리 ?>
						<p class="text-danger font-weight-bold">신고처리된 댓글입니다.</p>
					<?php } ?>

					<?php 
					$is_lock = false;	
					if (strstr($list[$i]['wr_option'], "secret")) { 
						$is_lock = true;	
					?>
						<span class="na-icon na-secret"></span>
					<?php } ?>
					
					<?php echo $comment ?>

				</div>
				<?php if(!$is_lock && (int)$list[$i]['wr_10']) { // 럭키포인트 ?>
					<div class="f-sm text-muted px-3 my-2">
						<i class="fa fa-gift" aria-hidden="true"></i> 
						<b class="orangered"><?php echo number_format($list[$i]['wr_10']) ?></b> 럭키포인트 당첨!
					</div>
				<?php } ?>
				<?php if($is_comment_reply_edit || $cmt_shingo || $is_cgood || $is_cnogood) {
					if($w == 'cu') {
						$sql = " select wr_id, wr_content, mb_id from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
						$cmt = sql_fetch($sql);
						if (!($is_admin || ($member['mb_id'] == $cmt['mb_id'] && $cmt['mb_id'])))
							$cmt['wr_content'] = '';
						$c_wr_content = $cmt['wr_content'];
					}
				?>
					<div class="cmt-btn clearfix font-weight-normal px-3">
						<ul class="float-right">
						<?php if ($list[$i]['is_reply']) { ?>
							<li><a href="javascript:;" onclick="comment_box('<?php echo $comment_id ?>','c'); return false;">답글</a></li>
						<?php } ?>
						<?php if ($list[$i]['is_edit']) { ?>
							<li><a href="javascript:;" onclick="comment_box('<?php echo $comment_id ?>','cu'); return false;">수정</a></li>
						<?php } ?>
						<?php if ($list[$i]['is_del']) { ?>
							<li><a href="<?php echo $list[$i]['del_link']; ?>" onclick="<?php echo ($list[$i]['del_back']) ? "na_delete('viewcomment', '".$list[$i]['del_href']."','".$list[$i]['del_back']."'); return false;" : "return comment_delete();";?>">삭제</a></li>
						<?php } ?>
						<?php if ($cmt_shingo) { ?>
							<li><a href="javascript:;" onclick="na_shingo('<?php echo $bo_table ?>','<?php echo $comment_id ?>','<?php echo $wr_id ?>'); return false;">신고</a></li>
						<?php } ?>
						<?php if($is_cgood || $is_cnogood) { ?>
							<li class="no-bar p-0">
								<?php if($is_cgood) { ?>
									<a href="javascript:;" class="na-cgood" onclick="na_good('<?php echo $bo_table ?>', '<?php echo $comment_id ?>', 'good', 'c_g<?php echo $comment_id ?>', 1);" title="추천">	<span class="sr-only">추천</span><b id="c_g<?php echo $comment_id ?>" class="orangered"><?php echo $list[$i]['wr_good'] ?></b></a><?php } ?><?php if($is_cnogood) { ?><a href="javascript:;" class="na-cnogood" onclick="na_good('<?php echo $bo_table ?>', '<?php echo $comment_id ?>', 'nogood', 'c_ng<?php echo $comment_id ?>', 1);" title="비추천"><span class="sr-only">비추천</span><b id="c_ng<?php echo $comment_id;?>"><?php echo $list[$i]['wr_nogood']; ?></b>
									</a>
								<?php } ?>
							</li>
						<?php } ?>
						</ul>
					</div>
				<?php } ?>
				<div class="clearfix pl-3">
					<span id="edit_<?php echo $comment_id ?>" class="bo_vc_w"></span><!-- 수정 -->
					<span id="reply_<?php echo $comment_id ?>" class="bo_vc_re"></span><!-- 답변 -->
					<?php if($is_paging) { ?>
						<input type="hidden" value="<?php echo $comment_url.'&amp;page='.$page; ?>" id="comment_url_<?php echo $comment_id ?>">
						<input type="hidden" value="<?php echo $page; ?>" id="comment_page_<?php echo $comment_id ?>">
					<?php } ?>
					<input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
					<textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
				</div>
			</div>
		</article>
		<?php } ?>
		<?php if (!$cmt_amt) { //댓글이 없다면 : 숨김처리함 ?>
			<div id="bo_vc_empty" class="f-de font-weight-normal text-center text-muted border-top px-3 py-5">
				등록된 댓글이 없습니다.
			</div>
		<?php } ?>
		<?php if($is_paging) { //페이징 ?>
			<div class="border-top font-weight-normal pb-3">
				<div class="row">
					<div class="col-md-9 pt-3">
						<ul class="pagination justify-content-center justify-content-md-start en">
							<?php echo na_ajax_paging('viewcomment', $write_pages, $page, $total_page, $comment_page); ?>
						</ul>
					</div>
					<div class="col-md-3 pt-3">
						<div class="px-3 px-sm-0">
							<button class="btn btn-basic btn-block" onclick="na_comment_new('viewcomment','<?php echo $comment_url ?>','<?php echo $total_count ?>');">
								새로운 댓글 확인
							</button>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</section>

<?php if(!$is_ajax_comment) { // 1번만 출력 ?>

</div><!-- #viewcomment 닫기 -->
<!-- } 댓글 끝 -->

	<?php if ($is_comment_write) {
		if($w == '') 
			$w = 'c';
	?>
		<!-- 댓글 쓰기 시작 { -->
		<aside id="bo_vc_w">
			<h2 class="sr-only">댓글쓰기</h2>
			<form id="fviewcomment" name="fviewcomment" action="<?php echo $comment_action_url; ?>" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off" class="cmt-form font-weight-normal">
			<input type="hidden" name="w" value="<?php echo $w ?>" id="w">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
			<input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
			<?php if($is_paging) { //페이징 ?>
				<input type="hidden" name="comment_url" value="" id="comment_url">
				<input type="hidden" name="cob" value="<?php echo $cob ?>">
			<?php } ?>
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
			<input type="hidden" name="stx" value="<?php echo $stx ?>">
			<input type="hidden" name="spt" value="<?php echo $spt ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>" id="comment_page">
			<input type="hidden" name="is_good" value="">

			<div class="cmt-box p-3 bg-light border na-round">
				<?php if ($is_guest) { ?>
					<div class="row mx-n1">
						<div class="col-6 px-1">
							<div class="form-group mb-2">
								<label for="wr_name" class="sr-only">이름<strong class="sr-only"> 필수</strong></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fa fa-user text-muted" aria-hidden="true"></i></span>
									</div>
									<input type="text" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" class="form-control" maxLength="20" placeholder="이름">
								</div>
							</div>
						</div>
						<div class="col-6 px-1">
							<div class="form-group mb-2">
								<label for="wr_password" class="sr-only">비밀번호<strong class="sr-only"> 필수</strong></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fa fa-lock text-muted" aria-hidden="true"></i></span>
									</div>
									<input type="password" name="wr_password" id="wr_password" class="form-control" maxLength="20" placeholder="비밀번호">
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				<?php if ($comment_min || $comment_max) { ?>
					<div class="text-muted f-sm mb-2" id="char_cnt">
						<i class="fa fa-commenting-o fa-lg"></i>
						현재 <b class="orangered"><span id="char_count">0</span></b>글자
						/
						<?php if($comment_min) { ?>
							<?php echo number_format($comment_min);?>글자 이상
						<?php } ?>
						<?php if($comment_max) { ?>
							<?php echo number_format($comment_max);?>글자 이하
						<?php } ?>
					</div>
				<?php } ?>

				<div class="input-group mb-3">
					<textarea id="wr_content" name="wr_content" maxlength="10000" rows="4" class="form-control" 
					<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content;  ?></textarea>
					<?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
					<div class="input-group-append">
						<button <?php echo ($is_paging) ? 'type="button" onclick="na_comment(\'viewcomment\');"' : 'type="submit"';?> class="btn btn-primary px-4" onKeyDown="na_comment_onKeyDown(<?php echo $is_paging?>);" id="btn_submit">등록</button>
					</div>
				</div>

				<ul class="d-flex align-items-center f-sm">
					<li class="flex-grow-1 text-nowrap pr-2">
					<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) {	?>
						<div id="bo_vc_opt">
							<ol class="float-left">
								<li id="bo_vc_send_sns"></li>
							</ol>
						</div>
					<?php } ?>
					</li>
					<li class="text-nowrap pr-2">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="wr_secret" value="secret" id="wr_secret" class="custom-control-input">
							<label class="custom-control-label" for="wr_secret"><span>비밀</span></label>
						</div>
					</li>
					<li class="text-nowrap">
						<div class="btn-group" role="group">
							<button type="button" class="btn nofocus p-0 mx-2" title="이모티콘" onclick="na_clip('emo');">
								<i class="fa fa-smile-o fa-md text-black-50" aria-hidden="true"></i>
								<span class="sr-only">이모티콘</span>
							</button>
							<button type="button" class="btn nofocus p-0 mx-2" title="폰트어썸 아이콘" onclick="na_clip('fa');">
								<i class="fa fa-font-awesome fa-md text-black-50" aria-hidden="true"></i>
								<span class="sr-only">폰트어썸 아이콘</span>
							</button>
							<button type="button" class="btn nofocus p-0 mx-2" title="동영상" onclick="na_clip('video');">
								<i class="fa fa-youtube-play fa-md text-black-50" aria-hidden="true"></i>
								<span class="sr-only">동영상</span>
							</button>
							<button type="button" class="btn nofocus p-0 mx-2" title="지도" onclick="na_clip('map');">
								<i class="fa fa-map-marker fa-md text-black-50" aria-hidden="true"></i>
								<span class="sr-only">지도동영상</span>
							</button>
							<button type="button" class="btn nofocus d-none d-sm-block p-0 mx-2" title="댓글창 늘이기" onclick="na_textarea('wr_content','down');">
								<i class="fa fa-plus-circle fa-md text-black-50" aria-hidden="true"></i>
								<span class="sr-only">댓글창 늘이기</span>
							</button>
							<button type="button" class="btn nofocus d-none d-sm-block p-0 mx-2" title="댓글창 줄이기" onclick="na_textarea('wr_content','up');">
								<i class="fa fa-minus-circle fa-md text-black-50" aria-hidden="true"></i>
								<span class="sr-only">댓글창 줄이기</span>
							</button>
							<button type="button" class="btn nofocus p-0 ml-2" title="새 댓글 작성" onclick="comment_box('','c');">
								<i class="fa fa-refresh fa-md text-black-50" aria-hidden="true"></i>
								<span class="sr-only">새 댓글 작성</span>
							</button>
						</div>
					</li>
				</ul>
				<?php if ($is_guest) { ?>
					<div class="mt-3 text-center f-sm">
						<?php echo $captcha_html; ?>
					</div>
				<?php } ?>
			</div>
			</form>
		</aside>
	<?php } else { ?>
		<div id="bo_vc_login" class="alert alert-dark bg-light border mb-0 py-4 text-center f-de" role="alert">
			<?php if($is_guest) { ?>
				<a href="<?php echo G5_BBS_URL ?>/login.php?wr_id=<?php echo $wr_id.$qstr ?>&amp;url=<?php echo urlencode(get_pretty_url($bo_table, $wr_id, $qstr).'#bo_vc_w') ?>">로그인한 회원만 댓글 등록이 가능합니다.</a>
			<?php } else { ?>
				댓글을 등록할 수 있는 권한이 없습니다.
			<?php } ?>
		</div>
	<?php } ?>

	<?php if ($is_comment_write) { ?>
		<script>
		var save_before = '';
		var save_html = document.getElementById('bo_vc_w').innerHTML;

		function good_and_write() {
			var f = document.fviewcomment;
			if (fviewcomment_submit(f)) {
				f.is_good.value = 1;
				f.submit();
			} else {
				f.is_good.value = 0;
			}
		}

		function fviewcomment_submit(f) {

			f.is_good.value = 0;

			var subject = "";
			var content = "";
			$.ajax({
				url: g5_bbs_url+"/ajax.filter.php",
				type: "POST",
				data: {
					"subject": "",
					"content": f.wr_content.value
				},
				dataType: "json",
				async: false,
				cache: false,
				success: function(data, textStatus) {
					subject = data.subject;
					content = data.content;
				}
			});

			if (content) {
				alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
				f.wr_content.focus();
				return false;
			}

			// 양쪽 공백 없애기
			var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
			document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
			if (char_min > 0 || char_max > 0)
			{
				check_byte('wr_content', 'char_count');
				var cnt = parseInt(document.getElementById('char_count').innerHTML);
				if (char_min > 0 && char_min > cnt)
				{
					alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
					return false;
				} else if (char_max > 0 && char_max < cnt)
				{
					alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
					return false;
				}
			}
			else if (!document.getElementById('wr_content').value)
			{
				alert("댓글을 입력하여 주십시오.");
				return false;
			}

			if (typeof(f.wr_name) != 'undefined')
			{
				f.wr_name.value = f.wr_name.value.replace(pattern, "");
				if (f.wr_name.value == '')
				{
					alert('이름이 입력되지 않았습니다.');
					f.wr_name.focus();
					return false;
				}
			}

			if (typeof(f.wr_password) != 'undefined')
			{
				f.wr_password.value = f.wr_password.value.replace(pattern, "");
				if (f.wr_password.value == '')
				{
					alert('비밀번호가 입력되지 않았습니다.');
					f.wr_password.focus();
					return false;
				}
			}
			
			<?php if($is_guest) echo chk_captcha_js();  ?>

			set_comment_token(f);

			document.getElementById("btn_submit").disabled = "disabled";

			return true;
		}

		function comment_box(comment_id, work) {
			var el_id,
				form_el = 'fviewcomment',
				respond = document.getElementById(form_el);

			// 댓글 아이디가 넘어오면 답변, 수정
			if (comment_id) {
				if (work == 'c')
					el_id = 'reply_' + comment_id;
				else
					el_id = 'edit_' + comment_id;
			} else
				el_id = 'bo_vc_w';

			if (save_before != el_id) {
				if (save_before) {
					document.getElementById(save_before).style.display = 'none';
				}

				document.getElementById(el_id).style.display = '';
				document.getElementById(el_id).appendChild(respond);
				//입력값 초기화
				document.getElementById('wr_content').value = '';
				
				// 댓글 수정
				if (work == 'cu') {
					document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
					if (typeof char_count != 'undefined')
						check_byte('wr_content', 'char_count');
					if (document.getElementById('secret_comment_'+comment_id).value)
						document.getElementById('wr_secret').checked = true;
					else
						document.getElementById('wr_secret').checked = false;
				}

				document.getElementById('comment_id').value = comment_id;
				document.getElementById('w').value = work;

				<?php if($is_paging) { //페이징 ?>
				if (comment_id) {
					document.getElementById('comment_page').value = document.getElementById('comment_page_'+comment_id).value;
					document.getElementById('comment_url').value = document.getElementById('comment_url_'+comment_id).value;
				} else {
					document.getElementById('comment_page').value = '';
					document.getElementById('comment_url').value = '<?php echo NA_URL ?>/bbs/comment_view.php?bo_table=<?php echo $bo_table;?>&wr_id=<?php echo $wr_id;?>';
				}
				<?php } ?>

				if(save_before)
					$("#captcha_reload").trigger("click");

				save_before = el_id;
			}
		}

		function comment_delete(){
			return confirm("이 댓글을 삭제하시겠습니까?");
		}

		comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

		<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>
		// sns 등록
		$(function() {
			$("#bo_vc_send_sns").load(
				"<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
				function() {
					save_html = document.getElementById('bo_vc_w').innerHTML;
				}
			);
		});
		<?php } ?>
		</script>

		<?php na_script('clip'); // 아이콘 등 ?>
	<?php } ?>
<?php } ?>