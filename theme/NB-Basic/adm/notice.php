<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert('접근권한이 없습니다.');
}


$g5['title'] = '테마 안내';
include_once('../head.sub.php');

$tset['page_title'] = '테마 안내';
$tset['page_desc'] = '테마의 라이센스, 구입, 기능 등 안내입니다.';
$tset['side_lw'] = '0';
$tset['side_rw'] = '0';

// 1단
define('IS_ONECOLUMN', true);

include_once('../head.php');
@include_once(NA_THEME_ADMIN_PATH.'/_array.php');
 
?>
<?php if(IS_DEMO) { ?>
	<div class="alert alert-warning  mx-3 mx-sm-0" role="alert">
		본 페이지는 테마 적용 후 사이트 좌측상단의 테마 설정(<i class="fa fa-desktop"></i> 아이콘)에서 볼 수 있습니다.
	</div>
<?php } ?>

<?php
@include_once(NA_PATH.'/theme/notice.php');
include_once('../tail.php');
?>