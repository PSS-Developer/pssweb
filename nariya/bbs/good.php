<?php
include_once('./_common.php');

if($opt) { 
	//댓글일 때 설정값 변경
	$board['bo_use_good'] = $boset['na_cgood'];
	$board['bo_use_nogood'] = $boset['na_cnogood'];

	run_event('comment_good_before', $bo_table, $wr_id, $good);
} else {
	run_event('bbs_good_before', $bo_table, $wr_id, $good);

	@include_once($board_skin_path.'/good.head.skin.php');
} 

$error = $success = $count = "";

function print_result($error, $success, $count) {
	echo '{ "error": "' . $error . '", "success": "' . $success . '", "count": "' . $count . '" }';
	if($error)
		exit;
}

if (!$is_member) {
	$error = '회원만 가능합니다.';
	print_result($error, $success, $count);
}

if (!($bo_table && $wr_id)) {
	$error = '값이 제대로 넘어오지 않았습니다.';
	print_result($error, $success, $count);
}

if (!$board['bo_table']) {
	$error = '존재하는 게시판이 아닙니다.';
	print_result($error, $success, $count);
}

$ss_name = ($write['wr_is_comment']) ? 'ss_view_'.$bo_table.'_'.$write['wr_parent'] : 'ss_view_'.$bo_table.'_'.$wr_id;
if (!get_session($ss_name)) {
	$error = '해당 게시물에서만 추천 또는 비추천 하실 수 있습니다.';
	print_result($error, $success, $count);
}

$is_success = false;
$ss_times = (int)$boset['na_gtimes']; // 횟수
$ss_name = 'ss_good_'.$bo_table.'_'.$wr_id; // 세션

if ($good == 'good' || $good == 'nogood') {

	if($write['mb_id'] == $member['mb_id']) {
		$error = '자신의 글에는 추천 또는 비추천 하실 수 없습니다.';
		print_result($error, $success, $count);
	}

	if (!$board['bo_use_good'] && $good == 'good') {
		$error = '이 게시판은 추천 기능을 사용하지 않습니다.';
		print_result($error, $success, $count);
	}

	if (!$board['bo_use_nogood'] && $good == 'nogood') {
		$error = '이 게시판은 비추천 기능을 사용하지 않습니다.';
		print_result($error, $success, $count);
	}

	$sql = " select bg_id, bg_flag, bg_datetime from {$g5['board_good_table']}
				where bo_table = '{$bo_table}'
				and wr_id = '{$wr_id}'
				and mb_id = '{$member['mb_id']}'
				and bg_flag in ('good', 'nogood') ";
	$row = sql_fetch($sql);
	if ($row['bg_flag']) {

		$good = $row['bg_flag'];

		if ($good == 'good')
			$status = '추천';
		else
			$status = '비추천';

		// 취소체크
		$cancel_sec = (int)$boset['na_gcancel'];
		if($cancel_sec > 0 && G5_SERVER_TIME < (strtotime($row['bg_datetime']) + $cancel_sec)) {
			if($ss_times > 0) {
				$times = get_session($ss_name);
				if($times) {
					if($ss_times > $times) {
						set_session($ss_name, $times + 1);
					} else {
						$error = "더이상 취소할 수 없습니다.";
						print_result($error, $success, $count);
					}
				} else {
					set_session($ss_name, 1);
				}
			}
			
			// 내역 삭제
			sql_query(" delete from {$g5['board_good_table']} where bg_id = '{$row['bg_id']}' ");

			// 추천(찬성), 비추천(반대) 카운트 감소
			sql_query(" update {$g5['write_prefix']}{$bo_table} set wr_{$good} = wr_{$good} - 1 where wr_id = '{$wr_id}' ");

			$count = $write['wr_'.$good] - 1;
			$success = "$status 취소를 하셨습니다.";

		} else {
			$error = "이미 $status 하셨습니다.";
		}

		print_result($error, $success, $count);

	} else{

		// 추천(찬성), 비추천(반대) 카운트 증가
		sql_query(" update {$g5['write_prefix']}{$bo_table} set wr_{$good} = wr_{$good} + 1 where wr_id = '{$wr_id}' ");

		// 내역 생성
		sql_query(" insert {$g5['board_good_table']} set bo_table = '{$bo_table}', wr_id = '{$wr_id}', mb_id = '{$member['mb_id']}', bg_flag = '{$good}', bg_datetime = '".G5_TIME_YMDHIS."' ");

		$sql = " select wr_{$good} as count from {$g5['write_prefix']}{$bo_table} where wr_id = '$wr_id' ";
		$row = sql_fetch($sql);

		$count = $row['count'];

		if ($good == 'good')
			$status = '추천';
		else
			$status = '비추천';

		if($opt) {
			run_event('comment_increase_good_json', $bo_table, $wr_id, $good);
		} else {
			run_event('bbs_increase_good_json', $bo_table, $wr_id, $good);
		}

		$is_success = true;
	}
}

//댓글은 실행안함
if($opt) {
	run_event('comment_good_after', $bo_table, $wr_id, $good);
} else {
	run_event('bbs_good_after', $bo_table, $wr_id, $good);

	@include_once($board_skin_path.'/good.tail.skin.php');
}

if($is_success) {
	$success = "$status 하셨습니다.";
	print_result($error, $success, $count);
}
?>