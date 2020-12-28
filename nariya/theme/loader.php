<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<script>
// Page Loader
$(window).on('load', function () {
	$("#modal_loader").delay(100).fadeOut("slow");
});
$(document).ready(function() {
	$('#modal_loader').on('click', function () {
		$('#modal_loader').fadeOut();
	});
});
</script>
<div id="modal_loader">
	<div class="modal_loader">
		<i class="fa fa-spinner fa-spin text-primary"></i>
		<span class="sr-only">Loading...</span>
	</div>
</div>
