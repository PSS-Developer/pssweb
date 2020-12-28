<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert_close('접근권한이 없습니다.');
}

$g5['title'] = '메뉴 추가';
include_once(G5_THEME_PATH.'/head.sub.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.NA_URL.'/css/modal.css">', 0);

// Loader
include_once(NA_PATH.'/theme/loader.php');
?>

<form name="fmenuform" id="fmenuform">
	<ul class="list-group f-de font-weight-normal">
		<li class="list-group-item bg-primary text-white border-left-0 border-right-0">
			<button type="button" class="close close-setup" aria-label="Close">
				<span aria-hidden="true" class="text-white">&times;</span>
			</button>
			<b>메뉴 선택</b>
		</li>
		<li class="list-group-item border-left-0 border-right-0">
			<div class="form-group row mb-0">
				<label class="col-2 col-form-label">대상</label>
				<div class="col-10">
					<select name="me_type" id="me_type" class="custom-select">
						<option value="">직접입력</option>
						<option value="group">게시판그룹</option>
						<option value="board">게시판</option>
						<option value="content">내용관리</option>
						<?php if (defined('G5_USE_SHOP') && G5_USE_SHOP) { ?>
							<option value="category">상품분류</option>
						<?php } ?>
						<option value="page">페이지</option>
					</select>
				</div>
			</div>
		</li>
	</ul>

	<div id="menu_result"></div>

</form>

<script>
$(function() {
    $("#menu_result").load(
        "./menu_item.php"
    );

    $("#me_type").on("change", function() {
        var type = $(this).val();

		$("#menu_result").empty().load(
            "./menu_item.php",
            { type : type }
        );
    });

    $(document).on("click", "#add_manual", function() {
        var me_name = $.trim($("#me_name").val());
        var me_link = $.trim($("#me_link").val());

        add_menu_list(me_name, me_link);
    });

    $(document).on("click", ".add_select", function() {
        var me_name = $.trim($(this).siblings("input[name='subject[]']").val());
        var me_link = $.trim($(this).siblings("input[name='link[]']").val());

        add_menu_list(me_name, me_link);
    });

	$('.close-setup').click(function() {
		window.parent.closeSetupModal();
	});
});

function add_menu_list(name, link) {

	$("#me_text", parent.document).val(name);
    $("#me_href", parent.document).val(link);

	window.parent.closeSetupModal();
}
</script>

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>