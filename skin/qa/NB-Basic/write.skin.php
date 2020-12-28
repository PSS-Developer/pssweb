<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 첨부파일
na_script('fileinput');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);

// 스킨 설정값
$wset = na_skin_config('qa');

?>

<section id="bo_w" class="f-de font-weight-normal mb-4">

	<h2 class="sr-only"><?php echo ($w == "u") ? '글수정' : '글작성'; ?></h2>

	<!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="qa_id" value="<?php echo $qa_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">

	<ul class="list-group mb-3">
	<li class="list-group-item border-top-0">
		<h5 class="font-weight-bold en"><?php echo ($w == "u") ? '문의글 수정' : '문의글 작성'; ?></h5>
	</li>

	<?php if ($is_email) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="qa_email">E-mail</label>
				<div class="col-md-4">
	                <input type="text" name="qa_email" value="<?php echo get_text($write['qa_email']) ?>" id="qa_email" <?php echo $req_email ?> class="form-control email <?php echo $req_email ?>" maxlength="100">
				</div>
				<div class="col-sm-6">
					<div class="custom-control custom-checkbox mb-2 mt-0 mt-sm-1 ">
						<input type="checkbox" name="qa_email_recv" value="1" id="qa_email_recv" class="custom-control-input"<?php if($write['qa_email_recv']) echo ' checked="checked"'; ?>>
						<label class="custom-control-label" for="qa_email_recv"><span>답변 받기</span></label>
					</div>
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($is_hp) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="qa_hp">휴대폰</label>
				<div class="col-md-4">
	                <input type="text" name="qa_hp" value="<?php echo get_text($write['qa_hp']); ?>" id="qa_hp" <?php echo $req_hp; ?> class="form-control <?php echo $req_hp; ?>">
				</div>
				<?php if($qaconfig['qa_use_sms']) { ?>
					<div class="col-sm-6">
						<div class="custom-control custom-checkbox mb-2 mt-0 mt-sm-1 ">
							<input type="checkbox" name="qa_sms_recv" value="1" id="qa_sms_recv" class="custom-control-input"<?php if($write['qa_sms_recv']) echo ' checked="checked"'; ?>>
							<label class="custom-control-label" for="qa_sms_recv"><span>답변등록 SMS알림 수신</span></label>
						</div>
					</div>
				<?php } ?>
			</div>
		</li>
	<?php } ?>

	<?php if ($category_option) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">분류<strong class="sr-only">필수</strong></label>
				<div class="col-md-4">
					<select name="qa_category" id="qa_category" required class="custom-select">
						<option value="">선택하세요</option>
						<?php echo $category_option ?>
					</select>
				</div>
			</div>
		</li>
	<?php } ?>

	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label" for="qa_subject">제목<strong class="sr-only">필수</strong></label>
			<div class="col-sm-7">
				<input type="text" name="qa_subject" value="<?php echo get_text($write['qa_subject']); ?>" id="qa_subject" required class="form-control required" maxlength="255">
			</div>
			<?php if ($is_dhtml_editor) { ?>
				<input type="hidden" name="qa_html" value="1">
			<?php } else { ?>
				<div class="col-sm-3">
					<div class="custom-control custom-checkbox mb-2 mb-sm-0 mt-0 mt-sm-1 ">
						<input type="checkbox" name="qa_html" value="<?php echo $html_value ?>" id="qa_html" onclick="html_auto_br(this);" class="custom-control-input" <?php echo $html_checked ?>>
						<label class="custom-control-label" for="qa_html"><span>HTML</span></label>
					</div>
				</div>
			<?php } ?>
		</div>
	</li>

	<li class="list-group-item">

		<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>

		<?php if ($is_dhtml_editor) { ?>
			<style> #qa_content { border:0; display:none; } </style>
		<?php } else { ?>
			<script> $("#qa_content").hide().addClass("form-control").show(); </script>
		<?php } ?>
	</li>
	<li class="list-group-item">
		<div class="f-sm mb-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<label class="input-group-text" for="bf_file1">파일 1</label>
				</div>
				<div class="custom-file">
					<input type="file" name="bf_file[1]" class="custom-file-input" title="파일 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" id="bf_file1">
					<label class="custom-file-label" for="bf_file1" data-browse="선택"></label>
				</div>
			</div>
			<?php if($w == 'u' && $write['qa_file1']) { ?>
				<div class="custom-control custom-checkbox py-2">
					<input type="checkbox" name="bf_file_del[1]" value="1" id="bf_file_del1" class="custom-control-input">
					<label class="custom-control-label" for="bf_file_del1"><span><?php echo $write['qa_source1']; ?> 파일 삭제</span></label>
				</div>
			<?php } ?>
		</div>
		<div class="f-sm">
			<div class="input-group">
				<div class="input-group-prepend">
					<label class="input-group-text" for="bf_file2">파일 2</label>
				</div>
				<div class="custom-file">
					<input type="file" name="bf_file[2]" class="custom-file-input" title="파일 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" id="bf_file2">
					<label class="custom-file-label" for="bf_file2" data-browse="선택"></label>
				</div>
			</div>
			<?php if($w == 'u' && $write['qa_file2']) { ?>
				<div class="custom-control custom-checkbox pt-2">
					<input type="checkbox" name="bf_file_del[2]" value="1" id="bf_file_del2" class="custom-control-input">
					<label class="custom-control-label" for="bf_file_del2"><span><?php echo $write['qa_source2']; ?> 파일 삭제</span></label>
				</div>
			<?php } ?>
		</div>
	</li>
	</ul>

	<div class="px-3 px-sm-0">
		<div class="row mx-n2">
			<div class="col order-2 px-2">
				<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg btn-block en">작성완료</button>
			</div>
			<div class="col order-1 px-2">
				<a href="<?php echo $list_href ?>" class="btn btn-basic btn-lg btn-block en" role="button">취소</a>
			</div>
		</div>
	</div>

	</form>
</section>

<script>
function html_auto_br(obj) {

	if (obj.checked) {
		result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		if (result)
			obj.value = "2";
		else
			obj.value = "1";
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
			"subject": f.qa_subject.value,
			"content": f.qa_content.value
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
		f.qa_subject.focus();
		return false;
	}

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		if (typeof(ed_qa_content) != "undefined")
			ed_qa_content.returnFalse();
		else
			f.qa_content.focus();
		return false;
	}

	<?php if ($is_hp) { ?>
	var hp = f.qa_hp.value.replace(/[0-9\-]/g, "");
	if(hp.length > 0) {
		alert("휴대폰번호는 숫자, - 으로만 입력해 주십시오.");
		return false;
	}
	<?php } ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>
<!-- } 게시물 작성/수정 끝 -->