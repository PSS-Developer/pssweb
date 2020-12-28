<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<script>
$(document).ready(function(){ 
	$('body').css('background', '#fff url("<?php echo na_url($tset['bg_img']) ?>") no-repeat <?php echo $tset['bg_pos'] ?> fixed');
});
</script>
