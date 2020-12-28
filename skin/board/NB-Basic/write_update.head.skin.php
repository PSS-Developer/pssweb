<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 간단쓰기 제목처리
if($w == '' && $is_subject) {
	$wr_subject = na_cut_text($wr_content, 40); // 글내용 40자 자르기
}

?>