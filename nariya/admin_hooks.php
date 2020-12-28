<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

class G5_NARIYA_ADMIN {

	public $na_basic_number = 100990;
	public $na_xp_number = 100991;

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
		global $nariya;

		// 관리자 메뉴 추가
		add_replace('admin_menu', array($this, 'add_admin_menu'), 1, 1);

		// 관리자 페이지 추가
		add_event('admin_get_page_nariya', array($this, 'admin_page_nariya'), 1, 2);

		// 경험치 관리 페이지 추가
		if(IS_NA_XP) {
			add_event('admin_get_page_nariya_xp', array($this, 'admin_page_nariya_xp'), 1, 2);
		}

		$this->add_hooks();
    }

	public function add_hooks() {


	}

	public function add_admin_menu($admin_menu){
		global $nariya;
		
		$admin_menu['menu100'][] = array($this->na_basic_number, '나리야 설정', G5_ADMIN_URL.'/view.php?call=nariya', 'nariya');

		if(IS_NA_XP) {
			$admin_menu['menu100'][] = array($this->na_xp_number, '경험치 관리', G5_ADMIN_URL.'/view.php?call=nariya_xp', 'nariya_xp');
		}
		return $admin_menu;
	}

	public function admin_page_nariya($arr_query, $token){
		global $g5, $is_admin, $auth, $member;
		
		if(isset($_POST['post_action']) && isset($_POST['token'])){
			
			check_demo();
			auth_check($auth[$this->na_basic_number], 'w');

			// 기본 폴더 체크
			$save_path = G5_DATA_PATH.'/'.NA_DIR;
			if(is_dir($save_path)) {
				; // 통과
			} else {
				@mkdir($save_path, G5_DIR_PERMISSION);
				@chmod($save_path, G5_DIR_PERMISSION);
			}

			// 영상폴더 체크
			$video_path = $save_path.'/video';
			if(is_dir($video_path)) {
				; //통과
			} else {
				@mkdir($video_path, G5_DIR_PERMISSION);
				@chmod($video_path, G5_DIR_PERMISSION);
			}

			// 알림(내글반응)
			if(isset($_POST['na']['noti']) && $_POST['na']['noti'] && !isset($member['as_noti'])) {

				// 회원정보 테이블에 필드 추가
				sql_query(" ALTER TABLE `{$g5['member_table']}`
								ADD `as_noti` int(11) NOT NULL DEFAULT '0' AFTER `mb_10` ", false);

				// 알림(내글반응) 테이블 추가
				$na_db_set = na_db_set();

				if(!sql_query(" DESC {$g5['na_noti']} ", false)) {
					sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_noti']}` (
								  `ph_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
								  `ph_to_case` varchar(50) NOT NULL DEFAULT '',
								  `ph_from_case` varchar(50) NOT NULL DEFAULT '',
								  `bo_table` varchar(20) NOT NULL DEFAULT '',
								  `rel_bo_table` varchar(20) NOT NULL DEFAULT '',
								  `wr_id` int(11) NOT NULL DEFAULT 0,
								  `rel_wr_id` int(11) NOT NULL DEFAULT 0,
								  `mb_id` varchar(255) NOT NULL DEFAULT '',
								  `rel_mb_id` varchar(255) NOT NULL DEFAULT '',
								  `rel_mb_nick` varchar(255) DEFAULT NULL,
								  `rel_msg` varchar(255) NOT NULL DEFAULT '',
								  `rel_url` varchar(200) NOT NULL DEFAULT '',
								  `ph_readed` char(1) NOT NULL DEFAULT 'N',
								  `ph_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
								  `parent_subject` varchar(255) NOT NULL,
								  `wr_parent` int(11) DEFAULT 0,
								  PRIMARY KEY (`ph_id`)
							) ".$na_db_set."; ", false);
				}
			}

			// 설정값
			$na = array();
			$na = $_POST['na'];
			na_file_var_save($save_path.'/nariya.php', $na, 'nariya'); //data 폴더 체크

		}

		auth_check($auth[$this->na_basic_number], 'r');

		$nariya = array();
		$nariya = na_config('nariya');

		include_once(NA_PATH.'/admin_page.php');
	}

	public function admin_page_nariya_xp($arr_query, $token){
		global $is_admin, $auth, $nariya;

		include_once(NA_PATH.'/extend/membership/admin_xp.php');
	}
}

$GLOBALS['g5_nariya_admin'] = G5_NARIYA_ADMIN::getInstance();
?>