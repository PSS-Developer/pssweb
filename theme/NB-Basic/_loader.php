<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<script>
// Page Loader
$(window).on('load', function () {
	$("#nt_loader").delay(100).fadeOut("slow");
});
$(document).ready(function() {
	$('#nt_loader').on('click', function () {
		$('#nt_loader').fadeOut();
	});
});
</script>
<div id="nt_loader">
	<div class="loader">
		<i class="fa fa-spinner fa-spin text-primary"></i>
		<span class="sr-only">Loading...</span>
	</div>
</div>
