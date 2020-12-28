<?php
include_once('./_common.php');

if(!isset($member['as_noti']))
	$member['as_noti'] = 0;

$noti_cnt = $member['as_noti'] + $member['mb_memo_cnt'];

echo '{ "count": "' . $noti_cnt . '" }';
exit;
?>