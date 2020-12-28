<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 공통배열
$gnu = array();
$gnu['gnu'] = 'g5'; // 테마 종류
$gnu['free'] = true; // 유료와 무료 구분
$gnu['buy'] = 'http://amina.co.kr/bbs/board.php?bo_table=nariya'; // 구입 또는 다운로드 주소

// 제한사항
$limit = array();
$limit[] = 'Bootstrap 4.5.3, jQuery 3.5.1, HTML5, CSS3 기반으로 제작(IE 10이하 지원안함)'; 
$limit[] = '그누보드5(5.4.3 이상), 나리야빌더(1.1.0 이상)에서 사용 가능'; 

// 라이선스
$license = array();
$license[] = 'GNU LESSER GENERAL PUBLIC LICENSE Version 2.1'; 
$license[] = 'License URI: <a href="https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html" target="_blank">https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html</a>'; 
$license[] = '테마의 구성 요소에 대한 수정 및 삭제가 가능합니다.';

?>