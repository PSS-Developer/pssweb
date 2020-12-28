<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

class G5_NARIYA {

    // Hook 포함 클래스 작성 요령
    // https://github.com/Josantonius/PHP-Hook/blob/master/tests/Example.php
    /**
     * Class instance.
     */

    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    public static function singletonMethod() {
        return self::getInstance();
    }

    public function __construct() {

		$this->add_hooks();
    }

	public function add_hooks() {

		// 글등록
		add_event('write_update_after', array($this, 'write_insert'), 10, 5);

		// 댓글등록
		add_event('comment_update_after', array($this, 'comment_insert'), 10, 5);

		// 확장 플러그인
		if(IS_NA_BBS || IS_NA_XP || IS_NA_NOTI) {
			// 글삭제
			add_event('bbs_delete', array($this, 'bbs_delete'), 10, 2);

			// 선택삭제
			add_event('bbs_delete_all', array($this, 'bbs_delete_all'), 10, 2);

			// 댓글삭제
			add_event('bbs_delete_comment', array($this, 'bbs_delete'), 10, 2);

			// 새글삭제
			add_event('bbs_new_delete', array($this, 'bbs_new_delete'), 10, 2);

			// 알림
			if(IS_NA_BBS || IS_NA_NOTI) {
				// 글 추천
		        add_event('bbs_increase_good_json', array($this, 'bbs_good'), 10, 3);

				// 댓글 추천
		        add_event('comment_increase_good_json', array($this, 'comment_good'), 10, 3);

				// 1:1 문의
				add_event('qawrite_update', array($this, 'qawrite_update'), 10, 4);
			}

			if(IS_NA_XP) {
				// 경험치 체크
				add_event('member_login_check', array($this, 'member_login_check'), 10, 3);

				// 자동등업
				add_event('tail_sub', array($this, 'tail_sub'), 10, 0);
			}
		}
	}

	// 1:1 문의
	public function qawrite_update($qa_id=0, $write=array(), $w='', $qaconfig){
		global $g5, $is_member, $member, $is_admin, $nariya;

		// 알림
		if(IS_NA_NOTI && $qa_id){

			$noti = array();
			$qa_write = array();

			$qa_id = (int)$qa_id;

			// 새글 알림
			if($nariya['noti_qa'] && ($w === '' || $w === 'r')) {

				$noti_mb = array();
				$noti_mb = array_map('trim', explode(",", $nariya['noti_qa']));

				if($is_member) {
					array_diff($noti_mb, array($member['mb_id']));
				}

				$noti_cnt = count($noti_mb);
				if($noti_cnt) {

					$qa_write = sql_fetch(" select * from {$g5['qa_content_table']} where qa_id = '$qa_id' ");

					$noti['wr_id'] = $noti['rel_wr_id'] = $qa_id;
					$noti['rel_mb_id'] = $member['mb_id'];
					$noti['rel_mb_nick'] = $member['mb_nick'];
					$noti['rel_url'] = '/'.G5_BBS_DIR.'/qaview.php?qa_id='.$qa_id;
					$noti['rel_msg'] = sql_real_escape_string(na_cut_text($qa_write['qa_content'], 70));
					$noti['parent_subject'] = sql_real_escape_string(na_cut_text($qa_write['qa_subject'], 70));

					// 알림 등록
					for($i=0; $i < $noti_cnt; $i++) {
						na_noti('inquire', 'inquire', $noti_mb[$i], $noti);
					}
				}
			}

			// 답변 알림
			if($w === 'a'){
				if(!isset($qa_write['qa_subject'])) {
					$qa_write = sql_fetch(" select * from {$g5['qa_content_table']} where qa_id = '$qa_id' ");
				}

				if ($qa_write['mb_id'] !== $member['mb_id']) {

					if(!isset($noti['wr_id'])) {
						$noti['wr_id'] = $noti['rel_wr_id'] = $qa_id;
						$noti['rel_mb_id'] = $member['mb_id'];
						$noti['rel_mb_nick'] = $member['mb_nick'];
						$noti['rel_url'] = '/'.G5_BBS_DIR.'/qaview.php?qa_id='.$qa_id;
						$noti['parent_subject'] = sql_real_escape_string(na_cut_text($qa_write['qa_subject'], 70));
					}						

					$qa_answer = (isset($_POST['qa_subject'])) ? $_POST['qa_subject'] : '';
					$noti['rel_msg'] = sql_real_escape_string(na_cut_text($qa_answer, 70));

					// 알림
					na_noti('inquire', 'answer', $qa_write['mb_id'], $noti);
				}
			}
		}
	}

	// 글 등록
	public function write_insert($board, $wr_id, $w, $qstr, $redirect_url) {
		global $g5, $member, $boset, $is_admin, $is_member, $is_direct, $file_upload_msg;

		$wr = array();
		$noti = array();

		$bo_table = $board['bo_table'];
		$write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블;
		$is_save = (isset($boset['na_save_image']) && $boset['na_save_image']) ? true : false;
		$wr_content = '';

		// 게시판 확장
		if(IS_NA_BBS) {
			global $as_type, $as_extend, $as_down, $as_view, $as_star_score, $as_star_cnt, $as_choice, $as_choice_cnt, $as_tag, $as_img;

			$wr = get_write($write_table, $wr_id, true);

			// 필드 확장
			$as_extend = (int)$as_extend;

			// 쿼리문
			$set_sql = ", as_extend = '".$as_extend."'
						, as_img = '".(int)$as_img."'
						, as_down = '".(int)$as_down."'
						, as_view = '".(int)$as_view."'
						, as_choice = '".(int)$as_choice."'
						, as_choice_cnt = '".(int)$as_choice_cnt."'";

			// 메인글
			if($is_admin) {
				global $config;

				$set_sql .= ", as_type = '".$as_type."'";

				// 새글DB 업데이트
				if($wr['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($config['cf_new_del'] * 86400))) {
					sql_query(" update {$g5['board_new_table']} set as_type = '{$as_type}' where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", false);
				}
			}

			// 태그
			if(isset($boset['na_tag']) && $boset['na_tag']) {
				$as_tag = na_add_tag($as_tag, $bo_table, $wr_id, $wr['mb_id']);
				$set_sql .= ", as_tag = '".addslashes($as_tag)."'";
			}

			// 별점
			if($as_star_score) {
				$set_sql .= ", as_star_score = '".(int)$as_star_score."', as_star_cnt = '".(int)$as_star_cnt."'";
			}

			// 내용
			if($as_extend) {
				// 필드 확장시
				$data = na_unpack($wr['wr_content']);
				$wr_content = $data['wr_content'];

				// 외부 이미지 저장 후 내용 치환
				if($is_save) {
					list($cnt, $wr_content) = na_content_image($wr_content);
					if($cnt) {
						$data['wr_content'] = $wr_content;
						$set_sql .= ", wr_content = '".na_pack($data)."'";
					}
				}
			} else {
				$wr_content = $wr['wr_content'];

				// 외부 이미지 저장 후 내용 치환
				if($is_save) {
					list($cnt, $wr_content) = na_content_image($wr_content);
					if($cnt) {
						$set_sql .= ", wr_content = '".addslashes($wr_content)."'";
					}
				}
			}

			// 이미지 추출을 위해 내용 다시 치환
			$wr['wr_content'] = $wr_content;
			
			// 이미지 초기화
			$wr['as_thumb'] = '';
			$seo_img = na_wr_img($bo_table, $wr);

			// 상대경로로 변경
			$seo_img = str_replace(G5_URL, "./", $seo_img);

			// 업데이트
			sql_query(" update {$write_table} set as_thumb = '".addslashes($seo_img)."'".$set_sql." where wr_id = '{$wr_id}' ");

		} else { 

			// 외부 이미지 저장
			if($is_save) {
				if(!isset($wr['wr_content'])) {
					$wr = get_write($write_table, $wr_id, true);
				}
				list($cnt, $wr_content) = na_content_image($wr['wr_content']);
				if($cnt) {
					sql_query(" update {$write_table} set wr_content = '".addslashes($wr_content)."' where wr_id = '{$wr_id}' ");
				}
			}
		}

		// 경험치
		if(IS_NA_XP) {
			if($member['mb_id'] && $w != 'u' && $boset['xp_write']) {
				$xp_txt = ($w) ? '글답변' : '글쓰기';
				na_insert_xp($member['mb_id'], $boset['xp_write'], "{$board['bo_subject']} {$wr_id} {$xp_txt}", $bo_table, $wr_id, '쓰기');
			}
		}

		// 알림
		if(IS_NA_NOTI) {
			// 새글 알림
			if($w != 'u' && $boset['noti_mb']) {

				$noti_mb = array();
				$noti_mb = array_map('trim', explode(",", $boset['noti_mb']));

				if($is_member) {
					array_diff($noti_mb, array($member['mb_id']));
				}

				$noti_cnt = count($noti_mb);
				if($noti_cnt) {
					if(!isset($wr['mb_id'])) {
						$wr = get_write($write_table, $wr_id, true);
					}
					if(!$wr_content) {
						$wr_content = $wr['wr_content'];
					}
					$noti['rel_msg'] = sql_real_escape_string(na_cut_text($wr_content, 70));
					$noti['parent_subject'] = sql_real_escape_string(na_cut_text($wr['wr_subject'], 90));
					$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
					$noti['wr_id'] = $noti['wr_parent'] = $noti['rel_wr_id'] = $wr_id;
					$noti['rel_mb_id'] = $wr['mb_id'];
					$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;

					if($is_member){
						$noti['rel_mb_nick'] = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
					} else {
						$noti['rel_mb_nick'] = addslashes($wr['wr_name']);
					}

					// 알림 등록
					for($i=0; $i < $noti_cnt; $i++) {

						if($wr['mb_id'] && $noti_mb[$i] === $wr['mb_id'])
							continue;

						na_noti('board', 'write', $noti_mb[$i], $noti);
					}
				}
			}

			// 답글 알림
			if($w == 'r' && isset($_POST['wr_id']) && $_POST['wr_id'] && !$boset['noti_no']) {
				// 원글
				$org = get_write(get_write_table_name($board['bo_table']), (int) $_POST['wr_id'], true);

				if($org['mb_id'] && $member['mb_id'] !== $org['mb_id']) {

					if(!isset($wr['mb_id'])) {
						$wr = get_write($write_table, $wr_id, true);
					}

					if(!$wr_content) {
						$wr_content = $wr['wr_content'];
					}

					unset($noti);
					$noti['rel_msg'] = sql_real_escape_string(na_cut_text($wr_content, 70));
					$noti['parent_subject'] = sql_real_escape_string(na_cut_text($org['wr_subject'], 90));
					$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
					$noti['wr_id'] = $noti['wr_parent'] = $org['wr_id'];
					$noti['rel_wr_id'] = $wr_id;
					$noti['rel_mb_id'] = $wr['mb_id'];
					$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;

					if($is_member){
						$noti['rel_mb_nick'] = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
					} else {
						$noti['rel_mb_nick'] = addslashes($wr['wr_name']);
					}

					// 알림 등록
					na_noti('board', 'reply', $org['mb_id'], $noti);
				}
			}
		}

		// 목록으로 이동
		if($w == '' && $is_direct) {
			if($file_upload_msg) {
				alert($file_upload_msg, short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table));
			} else {
				goto_url(short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table));
			}
		}

	}   // end function

	// 댓글 등록
	public function comment_insert($board, $wr_id, $w, $qstr, $redirect_url) {
		global $g5, $is_member, $member, $comment_id, $boset;

		// 게시판 테이블
		$bo_table = $board['bo_table'];
		$write_table = $g5['write_prefix'] . $bo_table;

		// 원 댓글
		$request_comment_id = (isset($_POST['comment_id']) && $_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;
		$reply_array = ($request_comment_id) ? get_write($write_table, $request_comment_id, true) : array();

		// 대댓글 대상 체크
		$set_sql = '';
		if($w === 'c' && $comment_id && isset($reply_array['wr_name']) && $reply_array['wr_name']) {
			$set_sql = "wr_9 = '".$reply_array['wr_name'].",".$reply_array['mb_id']."'";
		}

		// 럭키 점수
		$is_lucky = 0;
		if($member['mb_id'] && $comment_id && $w === 'c') {

			$lucky_point = (int)$boset['na_lucky_point'];
			$lucky_dice = (int)$boset['na_lucky_dice'];

			if($lucky_point > 0 && $lucky_dice > 0) {
				// 주사위 굴림
				$dice1 = rand(1, $lucky_dice);
				$dice2 = rand(1, $lucky_dice);
				if($dice1 == $dice2) {
					// 럭키포인트는 게시물당 1번만 당첨
					$sql = " select count(*) as cnt 
									from {$g5['point_table']} 
									where mb_id = '{$member['mb_id']}' 
										and po_rel_table = '$bo_table'
										and po_rel_id = '$wr_id'
										and po_rel_action = '@lucky' ";
					$row = sql_fetch($sql, false);

					// 당첨내역이 없을 경우 포인트 등록
					if(!$row['cnt']) {
						$point = rand(1, $lucky_point);
						$po_content = $board['bo_subject'].' '.$wr_id.' 럭키포인트 당첨!';

						insert_point($member['mb_id'], $point, $po_content, $bo_table, $wr_id, '@lucky');

						if($set_sql)
							$set_sql .= ', ';

						$set_sql .= "wr_10 = '".$point."'";
					}
				}
			}
		} 

		// 게시판 플러그인
		if(IS_NA_BBS) {
			global $as_star_score, $as_star_cnt;

			// 별점
			if($as_star_score) {
				if($set_sql)
					$set_sql .= ', ';

				$set_sql .= "as_star_score = '".(int)$as_star_score."', as_star_cnt = '".(int)$as_star_cnt."'";
			}
		}

		// 댓글 업데이트
		if($set_sql)
		    sql_query(" update $write_table set $set_sql where wr_id = '$comment_id' ");

		// 경험치
		if(IS_NA_XP) {
			if($member['mb_id'] && $w != 'cu' && $boset['xp_comment']) {
				na_insert_xp($member['mb_id'], $boset['xp_comment'], "{$board['bo_subject']} {$wr_id}-{$comment_id} 댓글쓰기", $bo_table, $comment_id, '댓글');
			}
		}

		// 알림
		if (IS_NA_NOTI && $comment_id && $w === 'c' && !$boset['noti_no']) {

			$noti = array();

			// 원 글
			$wr = get_write($write_table, $wr_id, true);
			
			// 현 댓글
			$comment_wr = get_write($write_table, $comment_id, true);

			// 자신의 댓글이 아닐 경우
			$is_reply_noti = (isset($reply_array['mb_id']) && $reply_array['mb_id'] !== $member['mb_id']) ? true : false;
			$mb_id = ($member['mb_id']) ? $member['mb_id'] : '';

			// 댓글을 남긴 경우
			if(($wr['mb_id'] && $wr['mb_id'] != $member['mb_id']) || $is_reply_noti){

				if( $is_member ){
					$noti['rel_mb_nick'] = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
				} else {
					$noti['rel_mb_nick'] = addslashes($comment_wr['wr_name']);
				}

				// 대댓글인 경우
				if(isset($reply_array['wr_is_comment']) && $reply_array['wr_is_comment']){
					$ph_to_case = 'comment';
					$tmp_mb_id = ($reply_array['mb_id']) ? $reply_array['mb_id'] : $wr['mb_id'];
					$noti['wr_id'] = ($reply_array['wr_id']) ? $reply_array['wr_id'] : $wr_id;
					$noti['parent_subject'] = sql_real_escape_string(na_cut_text($reply_array['wr_content'], 90));

				} else { // 댓글인 경우
					$ph_to_case = 'board';
					$tmp_mb_id = $wr['mb_id'];
					$noti['wr_id'] = $wr_id;
					$noti['parent_subject'] = sql_real_escape_string(na_cut_text($wr['wr_subject'], 90));
				}

				if($tmp_mb_id !== $member['mb_id']) {
					
					$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
					$noti['wr_parent'] = $wr['wr_parent'];
					$noti['rel_wr_id'] = $comment_id;
					$noti['rel_mb_id'] = $mb_id;
					$noti['rel_msg'] = sql_real_escape_string(na_cut_text($comment_wr['wr_content'], 70));
					$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id."#c_".$comment_id;

					// 알림 등록
					na_noti($ph_to_case, 'comment', $tmp_mb_id, $noti);
				}

				// 원글 알림
				if($reply_array['wr_id'] && ($wr['mb_id'] && $wr['mb_id'] != $member['mb_id'])){

					// 원글을 쓴 회원이 댓글을 써서 그 댓글에 댓글을 다는 경우가 맞다면... sql에서 insert 하지 않는다.
					$ph_readed = ($reply_array['mb_id'] && !strcmp($reply_array['mb_id'], $wr['mb_id'])) ? 'Y' : '';

					if($ph_readed !== 'Y' ) {
						if(!isset($noti['bo_table'])) {
							$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
							$noti['wr_parent'] = $wr['wr_parent'];
							$noti['rel_wr_id'] = $comment_id;
							$noti['rel_mb_id'] = $mb_id;
							$noti['rel_msg'] = sql_real_escape_string(na_cut_text($comment_wr['wr_content'], 70));
							$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id."#c_".$comment_id;
						}

						// 알림 등록
						na_noti('board', 'comment', $wr['mb_id'], $noti);
					}
				}
			}
		}

		// 새글 DB 업데이트
		if(IS_NA_BBS && $comment_id && $w === 'c') {
			if(!isset($wr['wr_id'])) {
				$wr = get_write($write_table, $wr_id, true);
			}
			sql_query(" update {$g5['board_new_table']} set as_comment = '{$wr['wr_comment']}' where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", false);
		}

	} // end function

    public function bbs_good($bo_table, $wr_id, $good){
        global $g5, $is_member, $member, $boset;

		if (!$boset['noti_no']) {
			$ph_from_case = ($good === 'good') ? 'good' : 'nogood';

			$wr = get_write(get_write_table_name($bo_table), $wr_id, true);

			$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
			$noti['wr_id'] = $noti['rel_wr_id'] = $wr_id;
			$noti['wr_parent'] = $wr['wr_parent'];
			$noti['rel_mb_id'] = $member['mb_id'];
			$noti['rel_mb_nick'] = $member['mb_nick'];
			$noti['rel_msg'] = sql_real_escape_string(na_cut_text($wr['wr_content'], 70));
			$noti['parent_subject'] = sql_real_escape_string(na_cut_text($wr['wr_subject'], 70));
			$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;

			// 알림 등록
			na_noti('board', $ph_from_case, $wr['mb_id'], $noti);
		}

		// 새글 DB 업데이트
		if(IS_NA_BBS) {
			if(!isset($wr['wr_id'])) {
				$wr = get_write(get_write_table_name($bo_table), $wr_id, true);
			}
			$sql_new = ($good === 'good') ? "as_good = '{$wr['wr_good']}'" : "as_nogood = '{$wr['wr_nogood']}'";
			sql_query(" update {$g5['board_new_table']} set $sql_new where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", false);
		}
	}

    public function comment_good($bo_table, $wr_id, $good){
        global $g5, $is_member, $member, $boset;

		if (!$boset['noti_no']) {
			$ph_from_case = ($good === 'good') ? 'good' : 'nogood';

			$wr = get_write(get_write_table_name($bo_table), $wr_id, true);

			$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
			$noti['wr_id'] = $noti['rel_wr_id'] = $wr_id;
			$noti['wr_parent'] = $wr['wr_parent'];
			$noti['rel_mb_id'] = $member['mb_id'];
			$noti['rel_mb_nick'] = $member['mb_nick'];
			$noti['rel_msg'] = sql_real_escape_string(na_cut_text($wr['wr_content'], 70));
			$noti['parent_subject'] = sql_real_escape_string(na_cut_text($wr['wr_content'], 70));
			$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr['wr_parent']."#c_".$wr_id;

			// 알림 등록
			na_noti('comment', $ph_from_case, $wr['mb_id'], $noti);
		}
	}

	// 새글삭제
	public function bbs_new_delete($chk_bn_id, $save_bo_table){
		global $g5;
				
		$mb_ids = array();

		if(is_array($chk_bn_id)){
			for($i=0;$i<count($chk_bn_id);$i++){
				
				$k = $chk_bn_id[$i];

				$bo_table = isset($_POST['bo_table'][$k]) ? preg_replace('/[^a-z0-9_]/i', '', $_POST['bo_table'][$k]) : '';
				$wr_id    = isset($_POST['wr_id'][$k]) ? preg_replace('/[^a-z0-9_]/i', '', $_POST['wr_id'][$k]) : 0;

				if($wr_id && $bo_table){

					// 태그, 신고 등 삭제
					na_delete($bo_table, $wr_id);

					// 읽지 않은 알림 삭제
					if(IS_NA_NOTI) {
						$result = sql_query(" select * from ".$g5['na_noti']." where ph_readed = 'N' and bo_table = '".$bo_table."' and rel_wr_id = '".$wr_id."' ");
						while($row=sql_fetch_array($result)){
							sql_query(" delete from ".$g5['na_noti']." where ph_id = '".$row['ph_id']."' ", false);
							$mb_ids[] = $row['mb_id'];
						}
					}
				}
			}
		}

		if(IS_NA_NOTI && !empty($mb_ids)){
			$mb_ids = array_unique($mb_ids);
			foreach($mb_ids as $mb_id){
				na_noti_update($mb_id);
			}
		}

	} // end function

	// 선택삭제
	public function bbs_delete_all($tmp_array, $board){
		global $g5;

		$mb_ids = array();

		foreach($tmp_array as $wr_id){
			na_delete($board['bo_table'], $wr_id); // 태그, 신고 등 삭제

			// 읽지 않은 알림 삭제
			if(IS_NA_NOTI) {
				$result = sql_query(" select * from ".$g5['na_noti']." where ph_readed = 'N' and bo_table = '".$board['bo_table']."' and rel_wr_id = '".$wr_id."' ");
				while( $row=sql_fetch_array($result) ){
					sql_query(" delete from ".$g5['na_noti']." where ph_id = '".$row['ph_id']."' ", false);
					$mb_ids[] = $row['mb_id'];
				}
			}
		}

		if(IS_NA_NOTI && !empty($mb_ids)){
			$mb_ids = array_unique($mb_ids);
			foreach($mb_ids as $mb_id){
				na_noti_update($mb_id);
			}
		}

	} // end function

	// 글삭제	
	public function bbs_delete($write_id, $board){

		if(is_array($write_id)){
			$delete_id = $write_id['wr_id'];
		} else {
			$delete_id = $write_id;
		}

		$this->bbs_delete_all( array($delete_id), $board );

	} // end function

	// 경험치 체크
	public function member_login_check($mb, $link, $is_social_login){
		
		// 경험치 합계
		na_sum_xp($mb);

	} // end function

	// 레벨업 메시지
	public function tail_sub(){
		global $g5, $member;

		if($member['mb_id']) {
			switch($member['as_msg']) { //Message
				case '1'	: $msg = '레벨업! '.$member['as_level'].'레벨이 되었습니다.';	break;
				case '2'	: $msg = '레벨다운! '.$member['as_level'].'레벨이 되었습니다.'; break;
				case '3'	: $msg = '등업! '.$member['mb_level'].'등급이 되었습니다.'; break;
				case '4'	: $msg = '등급다운! '.$member['mb_level'].'등급이 되었습니다.'; break;
				default		: $msg = ''; break;
			}

			if($msg) {
				// 회원정보 업데이트
				sql_query(" update {$g5['member_table']} set as_msg = '0' where mb_id = '{$member['mb_id']}' ", false);

				// 메시지
				echo "<script> $(document).ready(function(){ alert('".$msg."'); });</script>";
			}
		}
	} // end function
}

$GLOBALS['g5_nariya'] = G5_NARIYA::getInstance();

?>