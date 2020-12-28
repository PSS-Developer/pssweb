<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

global $is_member, $editor_content_js;

if(!$is_member)
	return;

?>
<!-- 임시 저장된 글 목록 모달 { -->
<div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div id="autosave_wrapper" class="modal-content">
			<script src="<?php echo NA_URL; ?>/js/autosave.js"></script>
			<?php 
			if($editor_content_js) 
				echo $editor_content_js; 
			?>
			<div id="autosave_pop">
				<div class="p-3 bg-primary text-white">
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5>임시 저장된 글 목록</h5>
				</div>
				<ul class="list-group mb-0"></ul>
			</div>
		</div>
	</div>
</div>
<!-- 임시 저장된 글 목록 모달 끝 { -->