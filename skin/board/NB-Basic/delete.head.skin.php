<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 신고 글 삭제 불가
if(!$is_admin && IS_NA_BBS) {
	if($boset['na_shingo'] && $write['as_type'] == "-1") {
		alert("신고된 글은 삭제할 수 없습니다.");
	}
}

?>