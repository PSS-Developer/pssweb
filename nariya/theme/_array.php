<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 그누보드5
$gnu['name_g5'] = '그누보드5(G5)';
$gnu['download_g5'] = 'https://sir.kr/g5_pds';
$gnu['install_g5'] = 'https://sir.kr/manual/g5/2';
$gnu['manual_g5'] = 'https://sir.kr/manual/g5';
$gnu['guide_g5'] = 'https://sir.kr/manual/g5/25';

// 영카트5
$gnu['name_yc5'] = '영카트5(YC5)';
$gnu['download_yc5'] = 'https://sir.kr/yc5_pds';
$gnu['install_yc5'] = 'https://sir.kr/manual/yc5/67';
$gnu['manual_yc5'] = 'https://sir.kr/manual/yc5';
$gnu['guide_yc5'] = 'https://sir.kr/manual/yc5/163';

// 나리야
$gnu['download_na'] = 'http://amina.co.kr/bbs/board.php?bo_table=nariya';
$gnu['install_na'] = 'http://amina.co.kr/bbs/board.php?bo_table=nariya&wr_id=344';
$gnu['manual_na'] = '';
$gnu['guide_na'] = '';
$gnu['skin_na'] = 'http://amina.co.kr/bbs/board.php?bo_table=nariya_skin';
$gnu['skin_g5'] = 'http://amina.co.kr/bbs/board.php?bo_table=nariya_g5'; 
$gnu['skin_yc5'] = 'http://amina.co.kr/bbs/board.php?bo_table=nariya_yc5';

// 값 정리
$tt = (isset($gnu['gnu']) && $gnu['gnu'] == 'yc5') ? '_yc5' : '_g5';
$gnu['name'] = $gnu['name'.$tt];
$gnu['download'] = $gnu['download'.$tt];
$gnu['install'] = $gnu['install'.$tt];
$gnu['manual'] = $gnu['manual'.$tt];
$gnu['guide'] = $gnu['guide'.$tt];

?>