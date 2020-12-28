<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 신고 댓글 삭제 불가
if(!$is_admin && IS_NA_BBS) {
	if($boset['na_shingo']) {
		// 파일 실행 위치 때문에 2번 처리해야 됨.ㅠㅠ
		$row = sql_fetch(" select as_type from {$write_table} where wr_id = '{$comment_id}' ", false);
		if($row['as_type'] == "-1") {
			if($boset['na_crows']) {
				die('신고된 댓글은 삭제할 수 없습니다.');
			} else {
				alert("신고된 댓글은 삭제할 수 없습니다.");
			}
		}
	}
}

?>