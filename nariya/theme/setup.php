<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!-- 셋업 모달 시작 { -->
<div class="modal fade" id="setupModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div id="setupBox" class="modal-dialog modal-xl">
		<div class="modal-content">
			<div id="setupWin"></div>
		</div>
	</div>
</div>
<script>
// iframe에서 모달창 닫기용
window.closeSetupModal = function() {
	$('#setupModal').modal('hide');
}
$(function(){
	$(document).on('click', '.widget-setup', function() {
		var wsetup = $('.btn-wset');
		if(wsetup.is(":visible")){
			wsetup.hide();
		} else {
			wsetup.show();
		}
		return false;
	});

	$(document).on('click', '.btn-setup', function() {

		var setup_href = this.href;

		$('#setupModal').on('show.bs.modal', function () {
			var setup_height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
			$("#setupWin").html('<iframe id="setupContent" src="' + setup_href + '"></iframe>');
			$('#setupContent').height(parseInt(setup_height * 0.85)); // 85%
		});

		$('#setupModal').modal('show');

		return false;
	});
});
</script>
<!-- 셋업 모달 끝 { -->
