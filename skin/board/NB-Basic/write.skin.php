<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css" media="screen">', 0);

// Clip Modal
na_script('clip');

// 임시 저장된 글 기능 : AutoSave Modal
if ($is_member)
	na_script('autosave');
?>

<section id="bo_w" class="f-de font-weight-normal mb-4">
    <h2 class="sr-only"><?php echo $g5['title'] ?></h2>

	<!-- 게시물 작성/수정 시작 { -->
	<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">

	<?php
		$option = '';
		$option_hidden = '';
		if ($is_notice || $is_html || $is_secret || $is_mail) {
			$option_start = PHP_EOL.'<div class="custom-control custom-checkbox custom-control-inline">'.PHP_EOL;
			$option_end = PHP_EOL.'</div>'.PHP_EOL;

			if ($is_html) {
				if ($is_dhtml_editor) {
					$option_hidden .= '<input type="hidden" value="html1" name="html">';
				} else {
					$option .= $option_start;
					$option .= '<input type="checkbox" name="html" value="'.$html_value.'" id="html" onclick="html_auto_br(this);" class="custom-control-input" '.$html_checked.'>';
					$option .= '<label class="custom-control-label" for="html"><span>HTML</span></label>';
					$option .= $option_end;
				}
			}

			if ($is_notice) {
				$option .= $option_start;
				$option .= '<input type="checkbox" name="notice" value="1" id="notice" class="custom-control-input" '.$notice_checked.'>';
				$option .= '<label class="custom-control-label" for="notice"><span>공지</span></label>';
				$option .= $option_end;
			}

			if ($is_secret) {
				if ($is_admin || $is_secret==1) {
					$option .= $option_start;
					$option .= '<input type="checkbox" name="secret" value="secret" id="secret" class="custom-control-input" '.$secret_checked.'>';
					$option .= '<label class="custom-control-label" for="secret"><span>비밀</span></label>';
					$option .= $option_end;
				} else {
					$option_hidden .= '<input type="hidden" name="secret" value="secret">';
				}
			}

			// 게시판 플러그인 사용시
			if (IS_NA_BBS && $is_notice) {
				$as_type_checked = ($write['as_type'] == "1") ? ' checked' : '';
				$option .= $option_start;
				$option .= '<input type="checkbox" name="as_type" value="1" id="as_type" class="custom-control-input" '.$as_type_checked.'>';
				$option .= '<label class="custom-control-label" for="as_type"><span>메인</span></label>';
				$option .= $option_end;
			}

			if ($is_mail) {
				$option .= $option_start;
				$option .= '<input type="checkbox" name="mail" value="mail" id="mail" class="custom-control-input" '.$recv_email_checked.'>';
				$option .= '<label class="custom-control-label" for="mail"><span>답변메일받기</span></label>';
				$option .= $option_end;
			}
		}

		echo $option_hidden;
	?>

	<ul class="list-group mb-3">
	<li class="list-group-item border-top-0">
		<h5 class="font-weight-bold en"><?php echo str_replace($board['bo_subject'], '', $g5['title']) ?></h5>
	</li>
	<?php if ($is_name) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="wr_name">이름<strong class="sr-only">필수</strong></label>
				<div class="col-md-4">
					<input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="form-control required" maxlength="20">
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($is_password) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="wr_password">비밀번호<strong class="sr-only">필수</strong></label>
				<div class="col-md-4">
					<input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="form-control <?php echo $password_required ?>" maxlength="20">
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($is_email) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="wr_email">E-mail</label>
				<div class="col-md-7">
					<input type="text" name="wr_email" id="wr_email" value="<?php echo $email ?>" class="form-control email" maxlength="100">
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($is_homepage) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="wr_homepage">홈페이지</label>
				<div class="col-md-7">
					<input type="text" name="wr_homepage" id="wr_homepage" value="<?php echo $homepage ?>" class="form-control">
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($option) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">옵션</label>
				<div class="col-sm-10">
					<p class="form-control-plaintext pt-1 pb-0 float-left">
						<?php echo $option ?>
					</p>
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($is_category) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">분류<strong class="sr-only">필수</strong></label>
				<div class="col-md-4">
					<select name="ca_name" id="ca_name" required class="custom-select">
						<option value="">선택하세요</option>
						<?php echo $category_option ?>
					</select>
				</div>
			</div>
		</li>
	<?php } ?>

	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label" for="wr_subject">제목<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
				<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="form-control required" maxlength="255">
			</div>
		</div>
	</li>
	<li class="list-group-item">
	   <span class="sr-only">내용<strong>필수</strong></span>
		<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<p id="char_count_desc" class="f-sm text-muted">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
		<?php } ?>

		<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>

		<?php if($is_dhtml_editor) { ?>
			<style> #wr_content { display:none; } </style>
		<?php } else { ?>
			<script> $("#wr_content").hide().addClass("form-control").show(); </script>
		<?php } ?>

		<div class="text-center en">
			<div class="btn-group btn-group-lg" role="group">
				<button type="button" class="btn btn-basic" title="이모티콘" onclick="na_clip('emo', '<?php echo $is_dhtml_editor ?>');">
					<i class="fa fa-smile-o" aria-hidden="true"></i>
					<span class="sr-only">이모티콘</span>
				</button>
				<button type="button" class="btn btn-basic" title="폰트어썸 아이콘" onclick="na_clip('fa', '<?php echo $is_dhtml_editor ?>');">
					<i class="fa fa-font-awesome" aria-hidden="true"></i>
					<span class="sr-only">폰트어썸 아이콘</span>
				</button>
				<button type="button" class="btn btn-basic" title="동영상" onclick="na_clip('video', '<?php echo $is_dhtml_editor ?>');">
					<i class="fa fa-youtube-play" aria-hidden="true"></i>
					<span class="sr-only">동영상</span>
				</button>
				<button type="button" class="btn btn-basic" title="지도" onclick="na_clip('map', '<?php echo $is_dhtml_editor ?>');">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<span class="sr-only">지도</span>
				</button>
				<?php if ($is_member) { // 임시 저장된 글 기능 ?>
					<button type="button" id="btn_autosave" data-toggle="modal" data-target="#saveModal" class="btn btn-basic" title="임시 저장된 글 목록 열기">
						<i class="fa fa-repeat" aria-hidden="true"></i>
						<span class="sr-only">임시저장글</span>
						<span id="autosave_count" class="orangered"><?php echo $autosave_count; ?></span>
					</button>
				<?php } ?>
			</div>
		</div>
	</li>
	
	<?php if(isset($boset['na_tag']) && $boset['na_tag']) { //태그 ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="as_tag">태그</label>
				<div class="col-md-10">
					<input type="text" name="as_tag" id="as_tag" value="<?php echo $write['as_tag']; ?>" class="form-control" placeholder="콤마(,)로 구분하여 복수 태그 등록 가능">
				</div>
			</div>
		</li>
	<?php } ?>

	<?php //관련링크
		if ($is_link) {
			$link_holder = (isset($boset['na_video_link']) && $boset['na_video_link']) ? '유튜브 등 동영상 공유주소 등록시 자동 출력' : 'https://...';
	?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">관련 링크</label>
				<div class="col-md-10">
				<?php for ($i=1; $i<=G5_LINK_COUNT; $i++) { ?>
					<div class="<?php echo ($i > 1) ? 'mt-2' : 'mt-0'; ?>">
						<input type="text" name="wr_link<?php echo $i ?>" value="<?php echo $write['wr_link'.$i]; ?>" id="wr_link<?php echo $i ?>" class="form-control" placeholder="<?php echo $link_holder ?>">
					</div>
				<?php } ?>
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($is_file && (int)$board['bo_upload_count'] > 0) { // 첨부파일 ?>
		<li class="list-group-item">
			<?php
				na_script('fileinput');

				// 칼럼
				$file_col = ($is_file_content) ? 'col-sm-6' : 'col';

				$file_script = "";
				$file_length = -1;
				// 수정의 경우 파일업로드 필드가 가변적으로 늘어나야 하고 삭제 표시도 해주어야 합니다.
				if ($w == "u") {
					for ($i=0; $i<$file['count']; $i++) {
						if ($file[$i]['source']) {
							$file_script .= "add_file('";
							if ($is_file_content) {
								$file_script .= '<div class="'.$file_col.' mt-2 px-2"><input type="text" name="bf_content[]" value="'.addslashes(get_text($file[$i]['bf_content'])).'" class="form-control" placeholder="파일 내용 입력"></div>';
							}

							$file_script .= '<div class="col-12 mt-2 px-2 f-de"><div class="custom-control custom-checkbox">';
							$file_script .= '<input type="checkbox" name="bf_file_del['.$i.']" value="1" id="bf_file_del'.$i.'" class="custom-control-input">';
							$file_script .= '<label class="custom-control-label" for="bf_file_del'.$i.'"><span>'.$file[$i]['source'].'('.$file[$i]['size'].') 파일 삭제 - <a href="'.$file[$i]['href'].'">열기</a></span></label>';
							$file_script .= '</div></div>';
							$file_script .= "');\n";
						} else {
							$file_script .= "add_file('');\n";
						}
					}
					$file_length = $file['count'] - 1;
				}

				if ($file_length < 0) {
					$file_script .= "add_file('');\n";
					$file_length = 0;
				}	
			?>
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">첨부 파일</label>
				<div class="col-md-10">
					<button type="button" onclick="add_file();" class="btn btn-basic">
						<span class="text-muted"><i class="fa fa-plus"></i> 파일 추가</span>
					</button>
					<button type="button" onclick="del_file();" class="btn btn-basic">
						<span class="text-muted"><i class="fa fa-times"></i> 파일 삭제</span>
					</button>

					<table id="variableFiles" class="w-100"></table>

					<script>
					var flen = 0;
					function add_file(delete_code) {

						var upload_count = <?php echo (int)$board['bo_upload_count']; ?>;
						if (upload_count && flen >= upload_count) {
							alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
							return;
						}

						var objTbl;
						var objNum;
						var objRow;
						var objCell;
						var objContent;
						if (document.getElementById)
							objTbl = document.getElementById("variableFiles");
						else
							objTbl = document.all["variableFiles"];

						objNum = objTbl.rows.length;
						objRow = objTbl.insertRow(objNum);
						objCell = objRow.insertCell(0);

						objContent = '<div class="row mx-n2">';
						objContent += '<div class="<?php echo $file_col ?> mt-2 px-2"><div class="input-group"><div class="input-group-prepend"><label class="input-group-text" for="fwriteFile'+objNum+'">파일 '+objNum+'</label></div>';
						objContent += '<div class="custom-file"><input type="file" name="bf_file[]" class="custom-file-input" title="파일 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" id="fwriteFile' + objNum + '">';
						objContent += '<label class="custom-file-label" for="imgboxFile" data-browse="선택"></label></div></div></div>';
						if (delete_code) {
							objContent += delete_code;
						} else {
							<?php if ($is_file_content) { ?>
							objContent += '<div class="<?php echo $file_col ?> mt-2 px-2"><input type="text" name="bf_content[]" class="form-control" placeholder="파일 내용 입력"></div>';
							<?php } ?>
							;
						}
						objContent += "</div>";

						objCell.innerHTML = objContent;

						bsCustomFileInput.init();

						flen++;
					}

					<?php echo $file_script; //수정시에 필요한 스크립트?>

					function del_file() {
						// file_length 이하로는 필드가 삭제되지 않아야 합니다.
						var file_length = <?php echo (int)$file_length; ?>;
						var objTbl = document.getElementById("variableFiles");
						if (objTbl.rows.length - 1 > file_length) {
							objTbl.deleteRow(objTbl.rows.length - 1);
							flen--;
						}
					}
					</script>
				</div>
			</div>
		</li>	
		<?php if (IS_NA_BBS) { ?>
			<li class="list-group-item">
				<div class="form-group row mb-0">
					<label class="col-md-2 col-form-label">첨부 사진</label>
					<div class="col-sm-10">
						<p class="form-control-plaintext pt-1 pb-0 float-left">
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="as_img" name="as_img" value="0"<?php echo (!$write['as_img']) ? ' checked' : ''; ?> class="custom-control-input">
								<label class="custom-control-label" for="as_img"><span>상단 위치</span></label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="as_img1" name="as_img" value="1"<?php echo get_checked('1', $write['as_img']) ?> class="custom-control-input">
								<label class="custom-control-label" for="as_img1"><span>하단 위치</span></label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="as_img2" name="as_img" value="2"<?php echo get_checked('2', $write['as_img']) ?> class="custom-control-input">
								<label class="custom-control-label" for="as_img2"><span>본문 삽입</span></label>
							</div>
						</p>
						<p class="form-control-plaintext f-de text-muted pb-0">
							본문 삽입시 {이미지:0}, {이미지:1} 형태로 글내용에 입력시 지정 첨부사진이 출력됩니다.
						</p>
					</div>
				</div>
			</li>
		<?php } ?>
	<?php } ?>

	<?php if ($captcha_html) { //자동등록방지  ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">자동등록방지</label>
				<div class="col-md-10 f-small">
					<?php echo $captcha_html; ?>
				</div>
			</div>
		</li>
	<?php } ?>

	</ul>

	<div class="px-3 px-sm-0">
		<div class="row mx-n2">
			<div class="col-6 order-2 px-2">
				<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg btn-block en">작성완료</button>
			</div>
			<div class="col-6 order-1 px-2">
				<a href="<?php echo get_pretty_url($bo_table); ?>" class="btn btn-basic btn-lg btn-block en">취소</a>
			</div>
		</div>
	</div>

	</form>

</section>

<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
	$("#wr_content").on("keyup", function() {
		check_byte("wr_content", "char_count");
	});
});
<?php } ?>

function html_auto_br(obj) {
	if (obj.checked) {
		result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		if (result)
			obj.value = "html2";
		else
			obj.value = "html1";
	}
	else
		obj.value = "";
}

function fwrite_submit(f) {

	<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

	var subject = "";
	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"subject": f.wr_subject.value,
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

	if (subject) {
		alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
		f.wr_subject.focus();
		return false;
	}

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		if (typeof(ed_wr_content) != "undefined")
			ed_wr_content.returnFalse();
		else
			f.wr_content.focus();
		return false;
	}

	if (document.getElementById("char_count")) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte("wr_content", "char_count"));
			if (char_min > 0 && char_min > cnt) {
				alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			}
			else if (char_max > 0 && char_max < cnt) {
				alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			}
		}
	}

	<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>