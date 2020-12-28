<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
	die('접근권한이 없습니다.');
}

// clean the output buffer
ob_end_clean();

function sql_query_union($sql, $error=G5_DISPLAY_SQL_ERROR, $link=null) {
    global $g5;

    if(!$link)
        $link = $g5['connect_db'];

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query') && G5_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }

    return $result;
}

// 자료가 많을 경우 대비 설정변경
@ini_set('memory_limit', '-1');

// 새글 DB 전체 지우기
sql_query(" delete from {$g5['board_new_table']} ");

// 최근글 삭제일 체크
$sql_where = "";
if(isset($config['cf_new_del']) && $config['cf_new_del'] > 0) {
	$new_date = date('Y-m-d H:i:s', (G5_SERVER_TIME - $config['cf_new_del'] * 86400));

	// 게시판 플러그인 사용시 메인글 체크된 것도 가져옴
	$sql_where = (IS_NA_BBS) ? " where wr_datetime >= '{$new_date}' or as_type = '1' " : " where wr_datetime >= '{$new_date}' ";
}

// 보드그룹
$sql = array();
if(IS_NA_BBS) {
	$sql_field = "bo_table, wr_id, wr_parent, wr_datetime, mb_id, wr_comment, wr_good, wr_nogood, as_type";
} else {
	$sql_field = "bo_table, wr_id, wr_parent, wr_datetime, mb_id";

}
$result = sql_query(" select bo_table from {$g5['board_table']} ", false);
for ($i=0; $row=sql_fetch_array($result); $i++) {

	if(!$row['bo_table']) 
		continue;

	$tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

	$sql[] = " (select '{$row['bo_table']}' as $sql_field from $tmp_write_table $sql_where) ";
}

$i = 0;
if(count($sql) > 0) {
	$result = sql_query_union(" select * from (".implode("UNION ALL", $sql).") as a order by wr_datetime ");
	// 새글 등록
	if(IS_NA_BBS) {
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			sql_query("insert into {$g5['board_new_table']} 
							set bo_table = '{$row['bo_table']}',
								wr_id = '{$row['wr_id']}',
								wr_parent = '{$row['wr_parent']}',
								mb_id = '{$row['mb_id']}',
								as_type = '{$row['as_type']}',
								as_comment = '{$row['wr_comment']}',
								as_good = '{$row['wr_good']}',
								as_nogood = '{$row['wr_nogood']}',
								bn_datetime = '{$row['wr_datetime']}'
						");
		}
	} else {
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			sql_query("insert into {$g5['board_new_table']} 
							set bo_table = '{$row['bo_table']}',
								wr_id = '{$row['wr_id']}',
								wr_parent = '{$row['wr_parent']}',
								mb_id = '{$row['mb_id']}',
								bn_datetime = '{$row['wr_datetime']}'
						");
		}
	}
}

die('총 '.$i.'건의 새글DB 복구 완료');
?>