<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<section id="bo_v_ans_form" class="mb-3 py-3 pb-4 border-top border-bottom">

    <?php 
	// 관리자이면 답변등록 
	if($is_admin) { 
		// 첨부파일
		na_script('fileinput');
	?>
    <form name="fanswer" method="post" action="./qawrite_update.php" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" autocomplete="off" class="px-3 px-sm-0">
    <input type="hidden" name="qa_id" value="<?php echo $view['qa_id']; ?>">
    <input type="hidden" name="w" value="a">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
		<div class="row mx-n2">
			<div class="col-sm-9 px-2">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">답변 제목</span>
					</div>	
					<input type="text" name="qa_subject" value="답변 드립니다." id="qa_subject" required class="form-control required" maxlength="255">
				</div>
			</div>
			<?php if ($is_dhtml_editor) { ?>
				<input type="hidden" name="qa_html" value="1">
			<?php } else { ?>
				<div class="col-sm-3 px-2">
					<div class="custom-control custom-checkbox mb-2 mt-0 mt-sm-1 ">
						<input type="checkbox" name="qa_html" value="<?php echo $html_value ?>" id="qa_html" onclick="html_auto_br(this);" class="custom-control-input" <?php echo $html_checked ?>>
						<label class="custom-control-label" for="qa_html"><span>HTML</span></label>
					</div>
				</div>
			<?php } ?>
		</div>

		<div class="form-group mb-3">
			<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>

			<?php if ($is_dhtml_editor) { ?>
				<style> #qa_content { border:0; display:none; } </style>
			<?php } else { ?>
				<script> $("#qa_content").hide().addClass("form-control").show(); </script>
			<?php } ?>
		</div>
		<div class="form-group f-sm mb-4">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<label class="input-group-text" for="bf_file1">파일 1</label>
				</div>
				<div class="custom-file">
					<input type="file" name="bf_file[1]" class="custom-file-input" title="파일 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" id="bf_file1">
					<label class="custom-file-label" for="bf_file1" data-browse="선택"></label>
				</div>
			</div>

			<div class="input-group">
				<div class="input-group-prepend">
					<label class="input-group-text" for="bf_file2">파일 2</label>
				</div>
				<div class="custom-file">
					<input type="file" name="bf_file[2]" class="custom-file-input" title="파일 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" id="bf_file2">
					<label class="custom-file-label" for="bf_file2" data-browse="선택"></label>
				</div>
			</div>
		</div>

		<div class="text-center">
			<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary">답변등록</button>
		</div>
    </form>

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

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>
    <?php } else { ?>
		<div id="ans_msg" class="px-3 pt-2 text-center">문의에 대한 답변을 준비 중입니다.</div>
    <?php } ?>
</section>

<div class="px-3 px-sm-0 pb-3">
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
				<a href="<?php echo $list_href ?>" class="btn btn_b01 nofocus" role="button"  title="목록">
					<i class="fa fa-list fa-md" aria-hidden="true"></i>
					<span class="sr-only">목록</span>
				</a>  
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
