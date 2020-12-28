<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 캐시 테이블 생성
if(isset($g5['na_cache']) && $g5['na_cache']) {
	if(!sql_query(" DESC {$g5['na_cache']} ", false)) {
		sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_cache']}` (
					`c_id` int(11) NOT NULL AUTO_INCREMENT,
					`c_name` varchar(255) NOT NULL,
					`c_text` text NOT NULL,
					`c_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
					PRIMARY KEY (`c_id`),
					UNIQUE KEY `fkey` (`c_name`)
			) ".na_db_set()."; ", false);
	}
}

?>