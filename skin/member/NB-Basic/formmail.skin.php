<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

// 첨부파일
na_script('fileinput');

?>
<div id="fmail" class="mb-4">

	<div id="topNav" class="bg-primary text-white">
		<div class="p-3">
			<button type="button" class="close" aria-label="Close" onclick="window.close();">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<h5>
			<?php if($name) { ?>
				<?php echo $name ?> 님께 메일보내기
			<?php } else { ?>
				메일보내기
			<?php } ?>			
			</h5>
		</div>
	</div>

	<div id="topHeight"></div>

	<form name="fformmail" action="./formmail_send.php" onsubmit="return fformmail_submit(this);" method="post" enctype="multipart/form-data">
    <input type="hidden" name="to" value="<?php echo $email ?>">
    <input type="hidden" name="attach" value="2">
	<?php if ($is_member) { // 회원이면  ?>
		<input type="hidden" name="fnick" value="<?php echo get_text($member['mb_nick']) ?>">
		<input type="hidden" name="fmail" value="<?php echo $member['mb_email'] ?>">
	<?php }  ?>

	<ul class="list-group f-de mb-4">
		<?php if (!$is_member) {  ?>
			<li class="list-group-item border-left-0 border-right-0">
				<div class="form-group row mb-0 mx-n2">
					<label class="col-sm-2 col-form-label px-2" for="fnick">이름<strong class="sr-only">필수</strong></label>
					<div class="col-sm-10 px-2">
						<input type="text" name="fnick" id="fnick" required class="form-control required">
					</div>
				</div>
			</li>
			<li class="list-group-item border-left-0 border-right-0">
				<div class="form-group row mb-0 mx-n2">
					<label class="col-sm-2 col-form-label px-2" for="fmail">E-mail<strong class="sr-only">필수</strong></label>
					<div class="col-sm-10 px-2">
						<input type="text" name="fmail" id="fmain" required class="form-control required">
					</div>
				</div>
			</li>
		<?php }  ?>
		<li class="list-group-item border-left-0 border-right-0">
			<div class="form-group row mb-0">
				<label class="col-sm-2 col-form-label" for="subject">제목<strong class="sr-only">필수</strong></label>
				<div class="col-sm-10">
					<input type="text" name="subject" id="subject" required class="form-control required">
				</div>
			</div>
		</li>
		<li class="list-group-item border-left-0 border-right-0">
			<div class="form-group row mb-0 mx-n2">
				<label class="col-sm-2 col-form-label px-2" for="content">내용<strong class="sr-only">필수</strong></label>
				<div class="col-sm-10 px-2">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="type_text" name="type" value="0" checked class="custom-control-input">
						<label class="custom-control-label" for="type_text"><span>TEXT</span></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="type_html" name="type" value="1" class="custom-control-input">
						<label class="custom-control-label" for="type_html"><span>HTML</span></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="type_both" name="type" value="2" class="custom-control-input">
						<label class="custom-control-label" for="type_both"><span>TEXT+HTML</span></label>
					</div>

					<textarea name="content" id="content" rows="6" required class="form-control required mt-2"></textarea>
				</div>
			</div>
		</li>
		<li class="list-group-item border-left-0 border-right-0">
			<div class="form-group row mb-0 mx-n2">
				<label class="col-sm-2 col-form-label px-2">첨부파일</label>
				<div class="col-sm-10 px-2">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<label class="input-group-text" for="file1">파일 1</label>
						</div>
						<div class="custom-file">
							<input type="file" name="file1" class="custom-file-input" id="file1">
							<label class="custom-file-label" for="file1" data-browse="선택"></label>
						</div>
					</div>
					
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<label class="input-group-text" for="file2">파일 2</label>
						</div>
						<div class="custom-file">
							<input type="file" name="file2" class="custom-file-input" id="file2">
							<label class="custom-file-label" for="file2" data-browse="선택"></label>
						</div>
					</div>
					<p class="form-text f-de text-muted pb-0 mb-0">
						첨부파일은 누락될 수 있으므로 발송 후 반드시 첨부 여부를 확인해 주세요.
					</p>
				</div>
			</div>
		</li>
		<li class="list-group-item border-left-0 border-right-0">
			<div class="form-group row mb-0 mx-n2">
				<label class="col-sm-2 col-form-label px-2">자동등록방지</label>
				<div class="col-sm-10 px-2">
					<?php echo captcha_html(); ?>
				</div>
			</div>
		</li>
	</ul>	

	<p class="text-center">
		<button type="submit" id="btn_submit" class="btn btn-primary">메일발송</button>
	</p>

	</form>
</div>

<script>
with (document.fformmail) {
    if (typeof fname != "undefined")
        fname.focus();
    else if (typeof subject != "undefined")
        subject.focus();
}

function fformmail_submit(f) {

	<?php echo chk_captcha_js();  ?>

    if (f.file1.value || f.file2.value) {
        // 4.00.11
        if (!confirm("첨부파일의 용량이 큰경우 전송시간이 오래 걸립니다.\n\n메일보내기가 완료되기 전에 창을 닫거나 새로고침 하지 마십시오."))
            return false;
    }

    document.getElementById('btn_submit').disabled = true;

    return true;
}

$(window).on('load', function () {
	na_nav('topNav', 'topHeight', 'fixed-top');
});

</script>
<!-- } 폼메일 끝 -->