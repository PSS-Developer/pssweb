<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Page ID 생성
function na_pid($link='') {
	global $bo_table, $wr_id, $sca, $gr_id, $co_id, $ca_id, $qstr, $demo;

	if(!$link) {
		$link = G5_URL . str_replace(G5_PATH, '', $_SERVER['SCRIPT_FILENAME']);
	}

	$url = @parse_url(str_replace(G5_URL.'/', '', $link));
	$file = basename($url['path'],".php");

	$mid = array();
	$href = '';
	$is_pid = false;
	if(strpos($link, G5_BBS_URL) !== false) {
		if($bo_table && ($file == 'board' || $file == 'write')) {
			$me_id = G5_BBS_DIR.'-board-'.$bo_table;			
			$mid[] = $me_id;
			if(IS_DEMO && $demo) {
				$mid[] = $me_id.'-'.$demo;
			}
			if($sca) {
				$mid[] = $me_id.'-'.$sca;
			}
			if($wr_id) {
				$mid[] = $me_id.'-'.$wr_id;
				$href = get_pretty_url($bo_table, $wr_id);
			} else {
				$href = get_pretty_url($bo_table, '', $qstr);
			}
		} else if($gr_id && $file == 'group') {
			$mid[] = G5_BBS_DIR.'-group-'.$gr_id;
		} else if($co_id && $file == 'content') {
			$mid[] = G5_BBS_DIR.'-content-'.$co_id;
			$href = get_pretty_url('content', $co_id, $qstr);
		} else if($file == 'qalist' || $file == 'qaview' || $file == 'qawrite') {
			$mid[] = G5_BBS_DIR.'-qa';
		} else {
			$is_pid = true;
		}
	} else if(IS_YC) {
		if(strpos($link, G5_SHOP_URL) !== false) {
			if($ca_id && ($file == 'list' || $file == 'item')) {
				$me_id = G5_SHOP_DIR.'-list-'.$ca_id;
				$mid[] = $me_id;
				if($it_id) {
					$me_it = G5_SHOP_DIR.'-item-'.$it_id;
					$mid[] = $me_it;
					if(IS_DEMO && $demo) {
						$mid[] = $me_it.'-'.$demo;
					}
					$href = shop_item_url($it_id);
				} else {
					if(IS_DEMO && $demo) {
						$mid[] = $me_id.'-'.$demo;
					}
					$href = add_pretty_shop_url(shop_category_url($ca_id), 'shop', $qstr);
				}
			} else if($type && $file == 'listtype') {
				$mid[] = G5_SHOP_DIR.'-type-'.$type;
				$href = add_pretty_shop_url(shop_type_url($type), 'shop', $qstr);
			} else {
				$is_pid = true;
			}
		} else {
			$is_pid = true;
		}
	} else {
		$is_pid = true;
	}

	if($is_pid) {
		$pdir = str_replace('/', '-', str_replace(basename($url['path']), '', $url['path']));
		if($pdir && substr($pdir, -1) === '-') {
			$pdir = substr($pdir, 0, -1); 
		}
		$pdir = ($pdir) ? $pdir : 'root';
		$me_id = $pdir.'-page-'.$file;
		$mid[] = $me_id;
		if(IS_DEMO && $demo) {
			$mid[] = $me_id.'-'.$demo;
		}
	}

	if(!$href) {
		$href = $link;
		$url = @parse_url($_SERVER['REQUEST_URI']);
		if($url['query']) {
			$href .= '?'.$url['query'];
		}
	}

	$pset = array('pid'=>$mid[0], 'mid'=>$mid, 'href'=>$href, 'file'=>$file);

	return $pset;
}

// SEO 생성
function na_seo($buffer, $opt='') {

	if($opt) {
		ob_start();
		include_once (NA_PATH.'/theme/seo.php');
		$meta = ob_get_contents();
		ob_end_clean();

		if(trim($meta)) {
			$nl = "\n";
		    $buffer = preg_replace('#(</title>)#', "$0{$nl}$meta", $buffer);
		}
	}

	return $buffer;
}

// 테마 설정 불러오기
function na_theme($id, $pid) {

	$data = array();

	$id = na_fid($id);
	$device = (G5_IS_MOBILE) ? 'mo' : 'pc';
	$file = G5_THEME_PATH.'/storage/theme-'.$id.'-'.$device.'.php';
	//초기세팅
	if(!is_file($file)) {
		$file = G5_THEME_PATH.'/adm/theme-'.$id.'-setting.php';
	}
	$data = na_file_var_load($file);

	// 인덱스 설정이 없으면 페이지 설정 가져옴
	if($pid) {
		$pdata = array();
		$pid = na_fid($pid);
		$pdata = na_file_var_load(G5_THEME_PATH.'/storage/page/page-'.$pid.'-'.$device.'.php');
		if(!empty($pdata))
			$data = array_merge($data, $pdata);
	}

	// 데모용
	if(IS_DEMO) {
		global $config;

		$pv_name = $config['cf_theme'].'_'.$id;
		$pv = get_session($pv_name);
		if($pv) {
			$pc = na_unpack(stripslashes($pv));

			if(!empty($pc))
				$data = array_merge($data, $pc);
		}
	}

	return $data;
}

// 스킨설정 페이지
function na_setup_href($type, $wid='', $wname='') {

	$href = NA_URL.'/theme/';

	if($type == 'widget') {
		$href .= 'widget_form.php?wname='.urlencode($wname).'&amp;wid='.urlencode($wid);
	} else if($type == 'board') {
		$href .= 'skin_form.php?bo_table='.urlencode($wid).'&amp;skin=board';
	} else {
		$href .= 'skin_form.php?skin='.$type;
	}

	return $href;
}

// 관리페이지 페이지
function na_theme_href($type, $mode='', $fid='', $sid='') {
	global $is_modal_win;

	$href = NA_URL.'/theme/';

	if($type == 'image') {
		$href .= 'image_form.php?mode='.urlencode($mode);
		if($fid)
			$href .= '&amp;fid='.urlencode($fid);
		if($is_modal_win)
			$href .= '&amp;win=1';
	} else if($type == 'menu') {
		$href .= 'menu_search.php';
	} else {
		return;
	}

	return $href;
}

// 메뉴 아이템 가공
function na_menu_item($it) {

	$me = array();

	$me = $it;
	
	// url 치환
	$it['href'] = na_url_amp(na_url($it['href']));

	// 링크 분석
	if(strpos($it['href'], G5_URL) !== false) {

		// url 분해
		$url = @parse_url(str_replace(G5_URL.'/', '', $it['href']));
		$file = basename($url['path'],".php");

		// parameter 분해
		@parse_str($url['query'], $query);

		$is_pid = false;
		if(strpos($it['href'], G5_BBS_URL) !== false) {
			if(isset($query['bo_table']) && $query['bo_table'] && ($file == 'board' || $file == 'write')) {
				$me['id'] = G5_BBS_DIR.'-board-'.$query['bo_table'];
				if(isset($query['wr_id']) && $query['wr_id']) {
					$me['id'] .= '-'.$query['wr_id'];
				} else if(isset($query['sca']) && $query['sca']) {
					$me['id'] .= '-'.$query['sca'];
				} else if(isset($query['demo']) && $query['demo']) {
					$me['id'] .= '-'.$query['demo'];
				}
				$me['bo_table'] = $query['bo_table'];
				$me['wr_id'] = $query['wr_id'];
				$me['sca'] = $query['sca'];
				$me['href'] = short_url_clean($it['href']);
			} else if(isset($query['gr_id']) && $query['gr_id'] && $file == 'group') {
				$me['id'] = G5_BBS_DIR.'-group-'.$query['gr_id'];
				$me['gr_id'] = $query['gr_id'];
				$me['href'] = $it['href'];
			} else if(isset($query['co_id']) && $query['co_id'] && $file == 'content') {
				$me['id'] = G5_BBS_DIR.'-content-'.$query['co_id'];
				$me['co_id'] = $query['co_id'];
				$me['href'] = short_url_clean($it['href']);
			} else if($file == 'qalist' || $file == 'qaview' || $file == 'qawrite') {
				$me['id'] = G5_BBS_DIR.'-qa';
				$me['href'] = $it['href'];
			} else {
				$is_pid = true;
			}
		} else if(IS_YC) {
			if(strpos($it['href'], G5_SHOP_URL) !== false) {
				if(isset($query['type']) && $query['type'] && $file == 'listtype') {
					$me['id'] = G5_SHOP_DIR.'-type-'.$query['type'];
					$me['type'] = $query['type'];
					$me['href'] = shop_short_url_clean($it['href']);
				} else if(isset($query['it_id']) && $query['it_id'] && $file == 'item') {
					$me['id'] = G5_SHOP_DIR.'-item-'.$query['it_id'];
					if(isset($query['demo']) && $query['demo']) {
						$me['id'] .= '-'.$query['demo'];
					}
					$me['it_id'] = $query['it_id'];
					$me['href'] = shop_short_url_clean($it['href']);
				} else if(isset($query['ca_id']) && $query['ca_id'] && $file == 'list') {
					$me['id'] = $id.'-list-'.$query['ca_id'];
					if(isset($query['demo']) && $query['demo']) {
						$me['id'] .= '-'.$query['demo'];
					}
					$me['ca_id'] = $query['ca_id'];
					$me['href'] = shop_short_url_clean($it['href']);
				} else {
					$is_pid = true;
				}
			} else {
				$is_pid = true;
			}
		} else {
			$is_pid = true;
		}

		if($is_pid) {
			$pdir = str_replace('/', '-', str_replace(basename($url['path']), '', $url['path']));
			if($pdir && substr($pdir, -1) === '-') {
				$pdir = substr($pdir, 0, -1); 
			}
			$pdir = ($pdir) ? $pdir : 'root';
			$me['id'] = $pdir.'-page-'.$file;
			if(isset($query['demo']) && $query['demo']) {
				$me['id'] .= '-'.$query['demo'];
			}
			$me['href'] = $it['href'];
		}

	} else {
		$me['id'] = 'link';
		$me['href'] = $it['href'];
	}
	
	// 링크 정리
	$me['href'] = na_url_amp(na_url_amp($me['href']), 1);
	if(!$me['href'])
		$me['href'] = '#';

	// 아이콘 정리
	$me['icon'] = (!$me['icon']) ? 'empty' : $me['icon'];

	// 회원등급
	$me['grade'] = (int)$me['grade'];

	unset($me['device']);
	unset($me['title']);

	return $me;
}

// 메뉴 리스트 생성 - 정리는 나중에...ㅠㅠ
function na_menu_list($nu, $device='') {
	
	$me = array();

	// 주메뉴
	$i = 0;
	$nu_cnt = (is_array($nu)) ? count($nu) : 0;
	for($o=0; $o < $nu_cnt; $o++) {

		// 기기 체크
		$me_device = $nu[$o]['device'];

		if($device && $me_device && $me_device != $device)
			continue;

		$me[$i] = na_menu_item($nu[$o]);

		unset($me[$i]['children']);

		// 1차 서브
		if(isset($nu[$o]['children'])) {
			$j = 0;
			$nu1_cnt = (is_array($nu[$o]['children'])) ? count($nu[$o]['children']) : 0;
			for($p=0; $p < $nu1_cnt; $p++) {

				// 기기 체크
				$me_device = $nu[$o]['children'][$p]['device'];
				if($device && $me_device && $me_device != $device)
					continue;

				$me[$i]['s'][$j] = na_menu_item($nu[$o]['children'][$p]);

				unset($me[$i]['s'][$j]['children']);

				//2차 서브
				if(isset($nu[$o]['children'][$p]['children'])) {
					$k = 0;
					$nu2_cnt = (is_array($nu[$o]['children'][$p]['children'])) ? count($nu[$o]['children'][$p]['children']) : 0;
					for($q=0; $q < $nu2_cnt; $q++) {

						// 기기 체크
						$me_device = $nu[$o]['children'][$p]['children'][$q]['device'];
						if($device && $me_device && $me_device != $device)
							continue;

						$me[$i]['s'][$j]['s'][$k] = na_menu_item($nu[$o]['children'][$p]['children'][$q]);

						unset($me[$i]['s'][$j]['s'][$k]['children']);

						// 3차 서브
						if(isset($nu[$o]['children'][$p]['children'][$q]['children'])) { 
							$l = 0;
							$nu3_cnt = (is_array($nu[$o]['children'][$p]['children'][$q]['children'])) ? count($nu[$o]['children'][$p]['children'][$q]['children']) : 0;
							for($r=0; $r < $nu3_cnt; $r++) {

								// 기기 체크
								$me_device = $nu[$o]['children'][$p]['children'][$q]['children'][$r]['device'];
								if($device && $me_device && $me_device != $device)
									continue;

								$me[$i]['s'][$j]['s'][$k]['s'][$l] = na_menu_item($nu[$o]['children'][$p]['children'][$q]['children'][$r]);

								unset($me[$i]['s'][$j]['s'][$k]['s'][$l]['children']);

								// 4차 서브
								if(isset($nu[$o]['children'][$p]['children'][$q]['children'][$r]['children'])) { 
									$m = 0;
									$nu4_cnt = (is_array($nu[$o]['children'][$p]['children'][$q]['children'][$r]['children'])) ? count($nu[$o]['children'][$p]['children'][$q]['children'][$r]['children']) : 0;
									for($s=0; $s < $nu4_cnt; $s++) {

										// 기기 체크
										$me_device = $nu[$o]['children'][$p]['children'][$q]['children'][$r]['children'][$s]['device'];
										if($device && $me_device && $me_device != $device)
											continue;

										$me[$i]['s'][$j]['s'][$k]['s'][$l]['s'][$m] = na_menu_item($nu[$o]['children'][$p]['children'][$q]['children'][$r]['children'][$s]);

										unset($me[$i]['s'][$j]['s'][$k]['s'][$l]['s'][$m]['children']);
										$m++;
									}
								}
								$l++;
							}
						}
						$k++;
					}
				}
				$j++;
			}
		}
		$i++;
	}

	return $me;
}

// 메뉴 출력
function na_menu($id, $mid, $dm='') {
	global $g5, $member, $sca;

	$me = array();
	$nu = array();
	$nav = array();
	$icon = array();

	$id = na_fid($id);
	$device = (G5_IS_MOBILE) ? 'mo' : 'pc';

	// 메뉴 불러오기
	$nu = na_file_var_load(G5_THEME_PATH.'/storage/menu-'.$id.'-'.$device.'.php');

	// 데모 메뉴
	if(IS_DEMO && $dm) {
		@include(NA_PATH.'/theme/menu.php');
		if(isset($menu) && is_array($menu) && count($menu) > 0) {
			$i = (is_array($nu)) ? count($nu) : 0;
			for($j=0; $j < count($menu); $j++) {
				$nu[$i] = $menu[$j];
				$i++;
			}
		}
	}

	// 메뉴 정리
	$i = 0;
	$mb_level = (int)$member['mb_level'];
	$nu_cnt = (is_array($nu)) ? count($nu) : 0;
	for($o=0; $o < $nu_cnt; $o++) {

		// 권한 체크
		if($nu[$o]['limit'] && (int)$nu[$o]['grade'] > $mb_level)
			continue;

		// 1차 서브
		$on1 = 0;
		if(isset($nu[$o]['s'])) {
			$j = 0;
			$nu1_cnt = (is_array($nu[$o]['s'])) ? count($nu[$o]['s']) : 0;
			for($p=0; $p < $nu1_cnt; $p++) {

				// 권한 체크
				if($nu[$o]['s'][$p]['limit'] && (int)$nu[$o]['s'][$p]['grade'] > $mb_level)
					continue;

				//2차 서브
				$on2 = 0;
				if(isset($nu[$o]['s'][$p]['s'])) {
					$k = 0;
					$nu2_cnt = (is_array($nu[$o]['s'][$p]['s'])) ? count($nu[$o]['s'][$p]['s']) : 0;
					for($q=0; $q < $nu2_cnt; $q++) {

						// 권한 체크
						if($nu[$o]['s'][$p]['s'][$q]['limit'] && (int)$nu[$o]['s'][$p]['s'][$q]['grade'] > $mb_level)
							continue;

						// 3차 서브
						$on3 = 0;
						if(isset($nu[$o]['s'][$p]['s'][$q]['s'])) { 
							$l = 0;
							$nu3_cnt = (is_array($nu[$o]['s'][$p]['s'][$q]['s'])) ? count($nu[$o]['s'][$p]['s'][$q]['s']) : 0;
							for($r=0; $r < $nu3_cnt; $r++) {

								// 권한 체크
								if($nu[$o]['s'][$p]['s'][$q]['s'][$r]['limit'] && (int)$nu[$o]['s'][$p]['s'][$q]['s'][$r]['grade'] > $mb_level)
									continue;

								// 4차 서브
								$on4 = 0;
								if(isset($nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'])) { 
									$m = 0;
									$nu4_cnt = (is_array($nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'])) ? count($nu[$o]['s'][$p]['s'][$q]['s'][$r]['s']) : 0;
									for($s=0; $s < $nu4_cnt; $s++) {

										// 권한 체크
										if($nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['limit'] && (int)$nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['grade'] > $mb_level)
											continue;

										// 현재 위치
										$me_id = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['id'];
										$is_nav = true;
										if($mid && $me_id && in_array($me_id, $mid)) {
											$nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['on'] = 1;
											$on4++;
											$text = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['text'];
											$href = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['href'];
											$target = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['target'];
										} else {
											$is_nav = false;
											$nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['on'] = 0;
										}

										if($is_nav) {
											$nav[] = array('href'=>$href, 'target'=>$target, 'text'=>$text);
											$icon[] = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s]['icon'];
										}

										// 담기
										$me[$i]['s'][$j]['s'][$k]['s'][$l]['s'][$m] = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'][$s];
										$m++;
									}

									unset($nu[$o]['s'][$p]['s'][$q]['s'][$r]['s']);

									if($m) {
										$nu[$o]['s'][$p]['s'][$q]['s'][$r]['s'] = $me[$i]['s'][$j]['s'][$k]['s'][$l]['s'];
									} else {
										unset($nu[$o]['s'][$p]['s'][$q]['s'][$r]['s']);
									}
								}

								// 현재 위치
								$is_nav = true;
								if($on4) {
									$nu[$o]['s'][$p]['s'][$q]['s'][$r]['on'] = 1;
									$on3++;
									$text = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['text'];
									$href = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['href'];
									$target = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['target'];
								} else {
									$me_id = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['id'];
									if($mid && $me_id && in_array($me_id, $mid)) {
										$nu[$o]['s'][$p]['s'][$q]['s'][$r]['on'] = 1;
										$on3++;
										$text = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['text'];
										$href = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['href'];
										$target = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['target'];
									} else {
										$is_nav = false;
										$nu[$o]['s'][$p]['s'][$q]['s'][$r]['on'] = 0;
									}
								}

								if($is_nav) {
									$nav[] = array('href'=>$href, 'target'=>$target, 'text'=>$text);
									$icon[] = $nu[$o]['s'][$p]['s'][$q]['s'][$r]['icon'];
								}

								// 담기
								$me[$i]['s'][$j]['s'][$k]['s'][$l] = $nu[$o]['s'][$p]['s'][$q]['s'][$r];
								$l++;
							}

							if($l) {
								$nu[$o]['s'][$p]['s'][$q]['s'] = $me[$i]['s'][$j]['s'][$k]['s'];
							} else {
								unset($nu[$o]['s'][$p]['s'][$q]['s']);
							}
						}

						// 현재 위치
						$is_nav = true;
						if($on3) {
							$nu[$o]['s'][$p]['s'][$q]['on'] = 1;
							$on2++;
							$text = $nu[$o]['s'][$p]['s'][$q]['text'];
							$href = $nu[$o]['s'][$p]['s'][$q]['href'];
							$target = $nu[$o]['s'][$p]['s'][$q]['target'];
						} else {
							$me_id = $nu[$o]['s'][$p]['s'][$q]['id'];
							if($mid && $me_id && in_array($me_id, $mid)) {
								$nu[$o]['s'][$p]['s'][$q]['on'] = 1;
								$on2++;
								$text = $nu[$o]['s'][$p]['s'][$q]['text'];
								$href = $nu[$o]['s'][$p]['s'][$q]['href'];
								$target = $nu[$o]['s'][$p]['s'][$q]['target'];
							} else {
								$is_nav = false;
								$nu[$o]['s'][$p]['s'][$q]['on'] = 0;
							}
						}

						if($is_nav) {
							$nav[] = array('href'=>$href, 'target'=>$target, 'text'=>$text);
							$icon[] = $nu[$o]['s'][$p]['s'][$q]['icon'];
						}

						// 담기
						$me[$i]['s'][$j]['s'][$k] = $nu[$o]['s'][$p]['s'][$q];
						$k++;
					}

					if($k) {
						$nu[$o]['s'][$p]['s'] = $me[$i]['s'][$j]['s'];
					} else {
						unset($nu[$o]['s'][$p]['s']);
					}
				}

				// 현재 위치
				$is_nav = true;
				if($on2) {
					$nu[$o]['s'][$p]['on'] = 1;
					$on1++;
					$text = $nu[$o]['s'][$p]['text'];
					$href = $nu[$o]['s'][$p]['href'];
					$target = $nu[$o]['s'][$p]['target'];
				} else {
					$me_id = $nu[$o]['s'][$p]['id'];
					if($mid && $me_id && in_array($me_id, $mid)) {
						$nu[$o]['s'][$p]['on'] = 1;
						$on1++;
						$text = $nu[$o]['s'][$p]['text'];
						$href = $nu[$o]['s'][$p]['href'];
						$target = $nu[$o]['s'][$p]['target'];
					} else {
						$is_nav = false;
						$nu[$o]['s'][$p]['on'] = 0;
					}
				}

				if($is_nav) {
					$nav[] = array('href'=>$href, 'target'=>$target, 'text'=>$text);
					$icon[] = $nu[$o]['s'][$p]['icon'];
				}

				// 담기
				$me[$i]['s'][$j] = $nu[$o]['s'][$p];
				$j++;
			}

			if($j) {
				$nu[$o]['s'] = $me[$i]['s'];
			} else {
				unset($nu[$o]['s']);
			}
		}

		// 현재 위치
		$is_nav = true;
		if($on1) {
			$nu[$o]['on'] = 1;
			$text = $nu[$o]['text'];
			$href = $nu[$o]['href'];
			$target = $nu[$o]['target'];
		} else {
			$me_id = $nu[$o]['id'];
			if($mid && $me_id && in_array($me_id, $mid)) {
				$nu[$o]['on'] = 1;
				$text = $nu[$o]['text'];
				$href = $nu[$o]['href'];
				$target = $nu[$o]['target'];
			} else {
				$is_nav = false;
				$nu[$o]['on'] = 0;
			}
		}

		if($is_nav) {
			$nav[] = array('href'=>$href, 'target'=>$target, 'text'=>$text);
			$icon[] = $nu[$o]['icon'];
		}

		// 담기
		$me[$i] = $nu[$o];
		$i++;
	}

	if(!empty($nav))
		$nav = array_reverse($nav);

	return array($me, $nav);
}

// 사이트 통계 캐시 생성
function na_stats_cache($cache_file, $cache) {
    global $g5, $config;

	$stats = array();

	// 현재 접속자
    $row = sql_fetch(" select sum(IF(mb_id<>'',1,0)) as mb_cnt, count(*) as total_cnt from {$g5['login_table']} where mb_id <> '{$config['cf_admin']}' ", false);
	$stats['now_total'] = $row['total_cnt'];
	$stats['now_mb'] = ($row['mb_cnt']) ? $row['mb_cnt'] : 0;

	// 전체회원
	$row = sql_fetch(" select count(*) as cnt from {$g5['member_table']} ", false); 
	$stats['join_total'] = $row['cnt'];

	// 총 글수 : 검색가능 게시판에 대해서만 집계
	$row = sql_fetch(" select sum(bo_count_write) as w_cnt, sum(bo_count_comment) as c_cnt from {$g5['board_table']} where bo_use_search = 1 ", false); 
	$stats['total_write'] = $row['w_cnt'];
	$stats['total_comment'] = $row['c_cnt'];

	if($cache) {
		na_file_var_save($cache_file, $stats);
	}

    return $stats;
}

// 사이트 통계 출력
function na_stats($cache) {
	global $config;

	$data = array();

	$cache = (int)$cache;
	$cache_file = G5_THEME_PATH.'/storage/cache/stats-cache.php';

	if($cache > 0) {
		$is_cache = true;
		if(is_file($cache_file)) {
			$filetime = filemtime($cache_file);
			if($filetime && $filetime < (G5_SERVER_TIME - 60 * $cache)) {
				$is_cache = false;
			}
        } else {
			$is_cache = false;
        }

		$data = ($is_cache) ? na_file_var_load($cache_file) : na_stats_cache($cache_file, true);
	} else {
		$data = na_stats_cache($cache_file, false);
	}

	// 방문통계는 그대로 출력
    // visit 배열변수에 $visit[1] = 오늘, $visit[2] = 어제, $visit[3] = 최대, $visit[4] = 전체 숫자가 들어감
    preg_match("/오늘:(.*),어제:(.*),최대:(.*),전체:(.*)/", $config['cf_visit'], $visit);

	$data['visit_today'] = (int)$visit[1];
	$data['visit_yesterday'] = (int)$visit[2];
	$data['visit_max'] = (int)$visit[3];
	$data['visit_total'] = (int)$visit[4];

    return $data;
}

// Page Title
function na_page_title($tset) {
	global $g5, $board, $ca, $it;

	if($tset['page_title']) {
		$title = $tset['page_title'];
	} else if($board['bo_subject']) {
		$title = $board['bo_subject'];
	} else if($it['ca_name']) {
		$title = $it['ca_name'];
	} else if($ca['ca_name']) {
		$title = $ca['ca_name'];
	} else {
		$title = $g5['title'];
	}

	return $title;
}

// Layout Skin Path
function na_layout_content($type, $skin, $basic='') {

	$path = array();
	if($skin == 'none')
		return $path;

	$skin = ($skin) ? $skin : $basic;

	if($skin)
		$path = array(G5_THEME_URL.'/layout/'.$type.'/'.$skin, G5_THEME_PATH.'/layout/'.$type.'/'.$skin); 

	return $path;
}

// Shadow Line
function na_shadow($type='1') {

	if(!$type)
		return;

	$line = '<div class="shadow-line"><img src="'.NA_URL.'/img/shadow'.$type.'.png" alt="Shadow'.$type.'"></div>'.PHP_EOL;

	return $line;
}

// 회원등급명
function na_grade($grade) {
	global $nariya;

	if(!$grade)
		$grade = 1;

	$g = 'mb_gn'.$grade;

	$gn = (isset($nariya[$g]) && $nariya[$g]) ? $nariya[$g] : '';

	return $gn;
}

// 회원정보 재가공
function na_member($member) {
	global $g5, $is_member;

	$member['is_auth'] = false;

	if ($is_member) {
		$member['sideview'] = na_name_photo($member['mb_id'], get_sideview($member['mb_id'], $member['mb_nick'], $member['mb_email'], $member['mb_homepage']));
		$member['mb_scrap_cnt'] = (int)$member['mb_scrap_cnt'];
		$sql = " select count(*) as cnt from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' ";
        $row = sql_fetch($sql);
        if ($row['cnt'])
           	$member['is_auth'] = true;
    }

	// 알림
	if(!isset($member['as_noti']))
		$member['as_noti'] = 0;

	// 레벨
	if(!isset($member['as_level']))
		$member['as_level'] = 0;

	// 총 알림수
	$member['noti_cnt'] = $member['as_noti'] + $member['mb_memo_cnt'];

	$member['mb_grade'] = na_grade($member['mb_level']);

	return $member;
}

// 위젯 캐시
function na_widget_cache($widget_file, $wset, $wcache){
	global $g5, $config;

	if(!is_file($widget_file)) 
		return;

	$widget_url = $wcache['url'];
	$widget_path = $wcache['path'];

	$wid = $wcache['id'];
	$cache = (int)$wset['cache'];

	//캐시 적용시
	if($cache > 0) { 
		// 캐시 아이디
		$c_id = $g5['ms_id'].'|'.$config['cf_theme'];
		if($wcache['addon']) {
			$c_name = (G5_IS_MOBILE) ? $c_id.'|ma|'.$wid : $c_id.'|pa|'.$wid;
		} else {
			$c_name = (G5_IS_MOBILE) ? $c_id.'|mw|'.$wid : $c_id.'|pw|'.$wid;
		}

	    $result = sql_fetch(" select c_name, c_text, c_datetime from {$g5['na_cache']} where c_name = '$c_name' ", false);

		if(!$result) {
			// 캐시 테이블 생성
			if(is_null($result)) {
				@include_once (NA_PATH.'/extend/cache.php');
			}

			// 시간을 offset 해서 입력 (-1을 해줘야 처음 call에 캐쉬를 만듭니다)
			$new_time = date("Y-m-d H:i:s", G5_SERVER_TIME - $cache - 1);
			$result['c_datetime'] = $new_time;
		    sql_query(" insert into {$g5['na_cache']} set c_name = '$c_name', c_datetime = '$new_time' ", false);
		}

		$sec_diff = G5_SERVER_TIME - strtotime($result['c_datetime']);
		if($sec_diff > $cache) {
			ob_start();
			@include($widget_file);
			$widget = ob_get_contents();
			ob_end_clean();

			if (trim($widget) == "")
				return;

			sql_query(" update {$g5['na_cache']} set c_text = '".addslashes($widget)."', c_datetime='".G5_TIME_YMDHIS."' where c_name = '$c_name' ", false);

		} else {
			$widget = $result['c_text'];
		}
	} else {
	    ob_start();
		@include ($widget_file);
	    $widget = ob_get_contents();
		ob_end_clean();
	}

	return $widget;
}

// 위젯 파일 캐시
function na_widget_cache_file($widget_file, $wset, $wcache){

	if(!is_file($widget_file)) 
		return;

	$widget_url = $wcache['url'];
	$widget_path = $wcache['path'];

	$wid = $wcache['id'];
	$cache = (int)$wset['cache'];

	if($cache > 0) { //캐시 적용시

		$cache_file = $wcache['file'];

		$is_cache = true;
		if(is_file($cache_file)) {
			$filetime = filemtime($cache_file);
			if($filetime && $filetime > (G5_SERVER_TIME - $cache)) {
				$is_cache = false;
			}
        } 

		if($is_cache) {
			ob_start();
			@include($widget_file);
			$widget = ob_get_contents();
			ob_end_clean();

			// 이전 캐시 삭제
			@unlink($cache_file);

			$handle = fopen($cache_file, 'w');
			$content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n?>\n".$widget."\n";
			fwrite($handle, $content);
			fclose($handle);
		} else {
			ob_start();
			@include($cache_file);
			$widget = ob_get_contents();
			ob_end_clean();
		}
	} else {
	    ob_start();
		@include ($widget_file);
	    $widget = ob_get_contents();
		ob_end_clean();
	}

	return $widget;
}

// 위젯 함수
function na_widget($wname, $wid='', $opt='', $mopt='', $wdir='', $addon=''){
	global $is_admin;

	// 적합성 체크
	if(!na_check_id($wname) || !na_check_id($wid))
		return '<p class="text-muted text-center">스킨명과 아이디는 영문자, 숫자, -, _ 만 가능함</p>';

	if($wdir) {
	    $wdir = preg_replace('/[^-A-Za-z0-9_\/]/i', '', trim(str_replace(G5_PATH, '', $wdir)));
		$widget_path = G5_PATH.$wdir.'/'.$wname;
		$widget_url = str_replace(G5_PATH, G5_URL, $widget_path);
	} else if($addon) {
		$widget_url = NA_URL.'/skin/addon/'.$wname;
		$widget_path = NA_PATH.'/skin/addon/'.$wname;
	} else {
		$widget_url = G5_THEME_URL.'/widget/'.$wname;
		$widget_path = G5_THEME_PATH.'/widget/'.$wname;
	}

	if(!is_file($widget_path.'/widget.php')) 
		return;

	$wchk = ($addon) ? 'addon' : 'widget'; 
	$wfile = (G5_IS_MOBILE) ? 'mo' : 'pc'; 
	$widget_file = G5_THEME_PATH.'/storage/'.$wchk.'/'.$wchk.'-'.$wname.'-'.$wid.'-'.$wfile.'.php';
	$cache_file = G5_THEME_PATH.'/storage/cache/'.$wchk.'-'.$wname.'-'.$wid.'-'.$wfile.'-cache.php';
	$setup_href = '';

	// 캐시용
	$wcache = array('id'=>$wid, 'url'=>$widget_url, 'path'=>$widget_path, 'file'=>$cache_file, 'addon'=>$addon);

	$wset = array();

	$is_opt = true;
	if($wid) {
		if(is_file($widget_file)) {
			$wset = na_file_var_load($widget_file);
			$is_opt = false;
		}

		if($is_admin == 'super' || IS_DEMO) {
			$setup_href = na_setup_href('widget', $wid, $wname);
			if($wdir) {
				$setup_href .= '&amp;wdir='.urlencode($wdir);
			}
			if($addon) {
				$setup_href .= '&amp;opt=1';
			}
		}
	}
	
	if($is_opt && $opt) {
		$wset = na_query($opt);
		if(G5_IS_MOBILE && !empty($wset) && $mopt) {
			$wset = array_merge($wset, na_query($mopt));
		}

		// 설정 초기값
		if($setup_href) {
			$setup_href .= '&amp;optp='.urlencode($opt);
			if($mopt) {
				$setup_href .= '&amp;optm='.urlencode($mopt);
			}
		}
		// 옵션지정시 추가쿼리구문 작동안됨
		unset($wset['where']);
		unset($wset['orderby']);
	}

	// 초기값
	if($wset['bo_new'] == "")
		$wset['bo_new'] = 24;

	$wset['cache'] = (int)$wset['cache'];

    ob_start();
	@include ($widget_path.'/widget.php');
    $widget = ob_get_contents();
	ob_end_clean();

	return $widget;
}

// 애드온 함수
function na_addon($wname, $wid='', $opt='', $mopt='', $wdir=''){
	return na_widget($wname, $wid, $opt, $mopt, $wdir, 1);
}

// 기간 체크
function na_sql_term($term, $field) {

	$sql_term = '';
	if($term && $field) {
		if($term > 0 || $term == 'week') {
			$term = ($term == 'week') ? 1 + (int)date("w", G5_SERVER_TIME) : $term;
			$chk_term = date("Y-m-d H:i:s", G5_SERVER_TIME - ($term * 86400));
			$sql_term = " and $field >= '{$chk_term}' ";
		} else {
			$day = getdate();
			$today = $day['year'].'-'.sprintf("%02d",$day['mon']).'-'.sprintf("%02d",$day['mday']).' 00:00:00';	// 오늘
			$yesterday = date("Y-m-d", (G5_SERVER_TIME - 86400)).' 00:00:00'; // 어제
			$nowmonth = $day['year'].'-'.sprintf("%02d",$day['mon']).'-01 00:00:00'; // 이번달

			if($day['mon'] == "1") { //1월이면
				$prevyear = $day['year'] - 1;
				$prevmonth = $prevyear.'-12-01 00:00:00';
			} else {
				$prev = $day['mon'] - 1;
				$prevmonth = $day['year'].'-'.sprintf("%02d",$prev).'-01 00:00:00';
			}

			switch($term) {
				case 'today'		: $sql_term = " and $field >= '{$today}'"; break;
				case 'yesterday'	: $sql_term = " and $field >= '{$yesterday}' and $field < '{$today}'"; break;
				case 'month'		: $sql_term = " and $field >= '{$nowmonth}'"; break;
				case 'prev'			: $sql_term = " and $field >= '{$prevmonth}' and $field < '{$nowmonth}'"; break;
			}
		}
	}

	return $sql_term;
}

// 자료 소팅
function na_sql_sort($type, $sort) {

	$orderby = '';
	if($type == 'new') {
		if(IS_NA_BBS) {
			switch($sort) { 
				case 'asc'			: $orderby = 'a.bn_id'; break;
				case 'date'			: $orderby = 'a.bn_datetime desc'; break;
				case 'comment'		: $orderby = 'a.as_comment desc'; break;
				case 'good'			: $orderby = 'a.as_good desc'; break;
				case 'nogood'		: $orderby = 'a.as_nogood desc'; break;
				case 'like'			: $orderby = '(a.as_good - a.as_nogood) desc'; break;
				default				: $orderby = 'a.bn_id desc'; break;
			}
		} else {
			switch($sort) { 
				case 'asc'			: $orderby = 'a.bn_id'; break;
				case 'date'			: $orderby = 'a.bn_datetime desc'; break;
				default				: $orderby = 'a.bn_id desc'; break;
			}
		}
	} else if($type == 'bo') {
		switch($sort) { 
			case 'asc'			: $orderby = 'wr_id'; break;
			case 'date'			: $orderby = 'wr_datetime desc'; break;
			case 'hit'			: $orderby = 'wr_hit desc'; break;
			case 'comment'		: $orderby = 'wr_comment desc'; break;
			case 'good'			: $orderby = 'wr_good desc'; break;
			case 'nogood'		: $orderby = 'wr_nogood desc'; break;
			case 'like'			: $orderby = '(wr_good - wr_nogood) desc'; break;
			case 'link'			: $orderby = '(wr_link1_hit + wr_link2_hit) desc'; break;
			default				: $orderby = 'wr_id desc'; break;
		}
	}

	return $orderby;
}

// 게시판 정리
function na_sql_find($field, $str, $ex) {

	if(!$field || !$str)
		return;

	$ex = ($ex) ? '=0' : '';
	$sql = "and find_in_set(".$field.", '".$str."')".$ex;

	return $sql;
}

// 랭킹시작 번호
function na_rank_start($rows, $page) {

	$rows = (int)$rows;
	$page = (int)$page;

	$rank = ($rows > 0 && $page > 1) ?  (($page - 1) * $rows + 1) : 1;

	return $rank;
}

// Date & Time
function na_date($date, $class='', $day='H:i', $month='m.d H:i', $year='Y.m.d H:i') {

	$date = strtotime($date);
	$today = date('Y-m-d', $date);

	if (G5_TIME_YMD == $today) {
		if($day == 'before') {
			$diff = G5_SERVER_TIME - $date;

			$s = 60; //1분 = 60초
			$h = $s * 60; //1시간 = 60분
			$d = $h * 24; //1일 = 24시간
			$y = $d * 10; //1년 = 1일 * 10일

			if ($diff < $s) {
				$time = $diff.'초 전';
			} else if ($h > $diff && $diff >= $s) {
				$time = $diff.'분 전';
			} else if ($d > $diff && $diff >= $h) {
				$time = $diff.'시간 전';
			} else {
				$time = date($day, $date);
			} 
		} else {
			$time = date($day, $date);
		}

		if($class) {
			$time = '<span class="'.$class.'">'.$time.'</span>';
		}
	} else if(substr(G5_TIME_YMD, 0, 7) == substr($today, 0, 7)) {
		$time = date($month, $date);
	} else {
		$time = date($year, $date);
	} 

	return $time;
}

// 게시물 정리
function na_wr_row($wr, $wset) {
	global $g5;

	//비번은 아예 배열에서 삭제
	unset($wr['wr_password']);

	//이메일 저장 안함
	$wr['wr_email'] = '';
	if($wset['comment']) { // 댓글일 때
		if (strstr($wr['wr_option'], 'secret')){
			$wr['wr_subject'] = $wr['wr_content'] = '비밀댓글입니다.';
		} else {
			$tmp_write_table = $g5['write_prefix'] . $wr['bo_table'];
			$row = sql_fetch("select wr_option from $tmp_write_table where wr_id = '{$wr['wr_parent']}' ", false);
			if (strstr($row['wr_option'], 'secret')){
				$wr['wr_subject'] = $wr['wr_content'] = '비밀댓글입니다.';
				$wr['wr_option'] = $row['wr_option'];
			} else {
				// 댓글에서 40자 잘라서 글제목으로
				$wr['wr_subject'] = cut_str($wr['wr_content'], 80);
			}
		}
	} else if (strstr($wr['wr_option'], 'secret')){
		$wr['wr_content'] = '비밀글입니다.';
		$wr['wr_link1'] = $wr['wr_link2'] = '';
		$wr['file'] = array('count'=>0);
	}

	$bo = array();
	$bo['bo_table'] = $wr['bo_table'];
	$bo['bo_new'] = $wset['bo_new'];
	$bo['bo_use_list_content'] = $wset['list_content'];
	$bo['bo_use_sideview'] = $wset['sideview'];
	$bo['bo_use_list_file'] = $wset['list_file'];
	
	$list = array();
	$list = na_get_list($wr, $bo, $wset['widget_url'], 255);

	if($bo['bo_use_sideview']) {
		$list['name'] = na_name_photo($list['mb_id'], $list['name']);
	}

	return $list;
}

// 그룹 내 게시판
function na_bo_list($gr_list, $gr_except, $bo_list, $bo_except) {
	global $g5;

	$bo = array();
	$plus = array();
	$minus = array();

	if($gr_list) {
		$gr = array();

		// 지정그룹의 게시판 다 뽑기
		$result = sql_query(" select bo_table from {$g5['board_table']} where find_in_set(gr_id, '{$gr_list}') ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$gr[] = $row['bo_table'];
		}

		if($bo_list) {
			$bo = array_map('trim', explode(",", $bo_list));
			if($gr_except) {
				if($bo_except) {
					$minus = array_unique($gr, $bo);
				} else {
					$minus = array_diff($gr, $bo);
					$plus = $bo;
				}
			} else {
				if($bo_except) {
					$plus = array_diff($gr, $bo);
					$minus = $bo;
				} else {
					$plus = array_unique($gr, $bo);
				}
			}
		} else {
			if($gr_except) {
				$minus = $gr;				
			} else {
				$plus = $gr;
			}
		}
	} else if($bo_list) {
		$bo = array_map('trim', explode(",", $bo_list));
		if($bo_except) {
			$minus = $bo;
		} else {
			$plus = $bo;
		}
	} 

	return array(implode(',', $plus), implode(',', $minus));
}

// 게시물 추출
function na_board_rows($wset) {
	global $g5, $member;

	$list = array();

	$rows = (int)$wset['rows'];
	$rows = ($rows > 0) ? $rows : 7;
	$page = (int)$wset['page'];
	$page = ($page > 1) ? $page : 1;

	//페이징
	$paging = (int)$wset['paging'];

	$bo_table = $wset['bo_list'];
	$term = ($wset['term'] == 'day' && (int)$wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];
	$sql_where = ($wset['where']) ? 'and '.$wset['where'] : '';
	$sql_orderby = ($wset['orderby']) ? $wset['orderby'].',' : '';

	$start_rows = 0;
	$board_cnt = array_map('trim', explode(",", $bo_table));
	if(!$bo_table || count($board_cnt) > 1 || $wset['bo_except']) {

		// 메인글
		$sql_main = (IS_NA_BBS && $wset['main']) ? "and a.as_type = '".(int)$wset['main']."'" : "";

		// 회원글
		$sql_mb = na_sql_find('a.mb_id', $wset['mb_list'], $wset['mb_except']);

		// 정렬
		$orderby = na_sql_sort('new', $wset['sort']);
		$orderby = ($orderby) ? $orderby : 'a.bn_id desc';

		// 추출게시판 정리
		list($plus, $minus) = na_bo_list($wset['gr_list'], $wset['gr_except'], $wset['bo_list'], $wset['bo_except']);
		$sql_plus = na_sql_find('a.bo_table', $plus, 0);
		$sql_minus = na_sql_find('a.bo_table', $minus, 1);

		//글, 댓글
		$sql_wr = ($wset['comment']) ? "and a.wr_parent <> a.wr_id" : "and a.wr_parent = a.wr_id";

		// 기간(일수,today,yesterday,month,prev)
		$sql_term = na_sql_term($term, 'a.bn_datetime');
		
		// 공통쿼리
		$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b where a.bo_table = b.bo_table and b.bo_use_search = 1 $sql_plus $sql_minus $sql_wr $sql_term $sql_mb $sql_main $sql_where ";
		if($paging || $page > 1) {
			$total = sql_fetch("select count(*) as cnt $sql_common ", false);
			$total_count = $total['cnt'];
			$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
			$start_rows = ($page - 1) * $rows; // 시작 열을 구함
		}
		$result = sql_query(" select a.bo_table, a.wr_id, b.bo_subject $sql_common order by $sql_orderby $orderby limit $start_rows, $rows ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			$tmp_write_table = $g5['write_prefix'] . $row['bo_table']; 

			$wr = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ", false);
			
			$wr['bo_table'] = $row['bo_table'];
			$wr['bo_subject'] = $row['bo_subject'];

			$list[$i] = na_wr_row($wr, $wset);
		}
	} else { //단수

		// 메인글
		$sql_main = (IS_NA_BBS && $wset['main']) ? "and as_type = '".(int)$wset['main']."'" : "";

		// 회원글
		$sql_mb = na_sql_find('mb_id', $wset['mb_list'], $wset['mb_except']);

		// 정렬
		$orderby = na_sql_sort('bo', $wset['sort']);
		$orderby = ($orderby) ? $orderby : 'wr_id desc';

		// 기간(일수,today,yesterday,month,prev)
		$sql_term = na_sql_term($term, 'wr_datetime');

		// 분류
		$sql_ca = na_sql_find('ca_name', $wset['ca_list'], $wset['ca_except']);

		//글, 댓글
		$sql_wr = ($wset['comment']) ? 1 : 0;

		$tmp_write_table = $g5['write_prefix'] . $bo_table;

		$sql_common = "from $tmp_write_table where wr_is_comment = '{$sql_wr}' $sql_ca $sql_term $sql_mb $sql_main $sql_where";
		if($paging || $page > 1) {
			$total = sql_fetch("select count(*) as cnt $sql_common ", false);
			$total_count = $total['cnt'];
			$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
			$start_rows = ($page - 1) * $rows; // 시작 열을 구함
		}
		$result = sql_query(" select * $sql_common order by $sql_orderby $orderby limit $start_rows, $rows ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) { 

			$row['bo_table'] = $bo_table;

			$list[$i] = na_wr_row($row, $wset);
		}
	}

	if($paging)
		return array($total_page, $list);

	return $list;
}

// 회원추출
function na_member_rows($wset) {
	global $g5;

	$list = array();

	$rows = (int)$wset['rows'];
	$rows = ($rows > 0) ? $rows : 7;
	$mode = (isset($wset['mode']) && $wset['mode']) ? $wset['mode'] : '';
	$term = ($wset['term'] == 'day' && (int)$wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];
	$sql_mb = na_sql_find('mb_id', $wset['mb_list'], 1);

	if($mode == 'connect') { // 현재접속회원
		$sql = " select * from {$g5['login_table']} where mb_id <> '' $sql_mb order by lo_datetime desc ";

	} else if($mode == 'post' || $mode == 'comment') { // 글,댓글 등록수
		$sql_term = na_sql_term($term, 'bn_datetime');
		$sql_wr = ($mode == 'comment') ? "and wr_parent <> wr_id" : "and wr_parent = wr_id";
		$sql = " select mb_id, count(mb_id) as cnt from {$g5['board_new_table']} 
					where mb_id <> '' $sql_wr $sql_mb $sql_term group by mb_id order by cnt desc limit 0, $rows ";

	} else if($term && $mode == 'point') { // 포인트(기간설정)
		$sql_term = na_sql_term($term, 'po_datetime');
		$sql = " select mb_id, sum(po_point) as cnt from {$g5['point_table']} 
					where po_point > 0 $sql_mb $sql_term group by mb_id order by cnt desc limit 0, $rows ";

	} else if($term && $mode == 'exp') { // 경험치(기간설정)
		$sql_term = na_sql_term($term, 'xp_datetime');
		$sql = " select mb_id, sum(xp_point) as cnt from {$g5['na_xp']} 
					where 1 $sql_mb $sql_term group by mb_id order by cnt desc limit 0, $rows ";

	} else {
		$field = 'mb_point';
		switch($mode) {
			case 'exp'		: $field = 'as_exp'; $orderby = 'as_exp desc'; break; //경험치
			case 'new'		: $orderby = 'mb_datetime desc'; break; //신규가입
			case 'recent'	: $orderby = 'mb_today_login desc'; break; //최근접속
			default			: $orderby = 'mb_point desc'; break; //포인트(기본값)
		}
		$sql = "select *, $field as cnt from {$g5['member_table']} where mb_leave_date = '' and mb_intercept_date = '' $sql_mb order by $orderby limit 0, $rows ";
	}

	$result = sql_query($sql, false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = ($row['mb_id'] && $row['mb_nick']) ? $row : get_member($row['mb_id']);
		$list[$i]['cnt'] = $row['cnt'];
		if(!$list[$i]['mb_open']) {
			$list[$i]['mb_email'] = '';
			$list[$i]['mb_homepage'] = '';
		}
		$list[$i]['name'] = get_sideview($list[$i]['mb_id'], $list[$i]['mb_nick'], $list[$i]['mb_email'], $list[$i]['mb_homepage']);
	}

	return $list;
}

// 인기검색어 추출
function na_popular_rows($wset) {
	global $g5;

	$list = array();

	$rows = (int)$wset['rows'];
	$rows = ($rows > 0) ? $rows : 10;

	// 기간(일수,today,yesterday,month,prev)
	$term = ($wset['term'] == 'day' && (int)$wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];
	$sql_term = na_sql_term($term, 'pp_date');

	// 한글이 포함된 검색어만
	$sql_han = ($wset['han']) ? "and pp_word regexp '[가-힣]'" : '';
	$sql = " select pp_word, count(pp_word) as cnt from {$g5['popular_table']} where (1) $sql_term $sql_han group by pp_word order by cnt desc limit 0, $rows ";
	$result = sql_query($sql, false);
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
	}

	return $list;
}

// 태그추출
function na_tag_rows($wset) {
	global $g5;

	$list = array();

	$rows = (int)$wset['rows'];
	$rows = ($rows > 0) ? $rows : 10;

	$orderby = ((int)$wset['new'] > 0) ? "lastdate desc," : "";
	$result = sql_query(" select * from {$g5['na_tag']} where cnt > 0 order by $orderby cnt desc, type, idx, tag limit 0, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = $row;
		$list[$i]['href'] = G5_BBS_URL.'/tag.php?q='.urlencode($row['tag']);
	}
	return $list;
}

// 태그 관련글 추출
function na_tag_post_rows($wset) {
	global $g5;

	$list = array();

	$tag = $wset['tag'];

	if(!$tag)
		return $list;	

	$rows = (int)$wset['rows'];
	$rows = ($rows > 0) ? $rows : 7;
	$page = (int)$wset['page'];
	$page = ($page > 1) ? $page : 1;

	$term = ($wset['term'] == 'day' && (int)$wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];

	// 회원글
	$sql_mb = na_sql_find('mb_id', $wset['mb_list'], $wset['mb_except']);

	// 추출게시판 정리
	list($plus, $minus) = na_bo_list($wset['gr_list'], $wset['gr_except'], $wset['bo_list'], $wset['bo_except']);
	$sql_plus = na_sql_find('bo_table', $plus, 0);
	$sql_minus = na_sql_find('bo_table', $minus, 1);

	// 기간(일수,today,yesterday,month,prev)
	$sql_term = na_sql_term($term, 'lastdate');

	$start_rows = 0;

	// 공통쿼리
	$sql_common = " from {$g5['na_tag_log']} where bo_table <> '' and find_in_set(tag, '{$tag}') $sql_plus $sql_minus $sql_mb $sql_term group by bo_table, wr_id ";

	if($page > 1) {
		$total = sql_query(" select count(*) as cnt $sql_common ", false);
		$total_count = @sql_num_rows($total);
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}

	$result = sql_query(" select bo_table, wr_id $sql_common order by regdate desc limit $start_rows, $rows ", false);

	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$tmp_write_table = $g5['write_prefix'] . $row['bo_table']; 

		$wr = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ", false);
		
		$wr['bo_table'] = $row['bo_table'];

		$list[$i] = na_wr_row($wr, $wset);
	}

	return $list;
}

// FAQ 추출
function na_faq_rows($wset) {
	global $g5;

	$list = array();

	$rows = (int)$wset['rows'];
	$rows = ($rows > 0) ? $rows : 7;

	$sql_fa = na_sql_find('fm_id', $wset['fa_list'], $wset['except']);

	$result = sql_query(" select * from {$g5['faq_table']} where 1 $sql_fa order by fa_order, fa_id limit 0, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['subject'] = get_text($row['fa_subject']);
		$list[$i]['content'] = conv_content($row['fa_content'], 1);
		$list[$i]['href'] = G5_BBS_URL.'/faq.php?fm_id='.$row['fm_id'];
	}

	return $list;
}

// 칼럼 구하기
function na_row_cols($xs, $sm='', $md='', $lg='', $xl='') {

	$cols = '';
	if($xs)
		$cols .= ' row-cols-'.$xs;
	if($sm)
		$cols .= ' row-cols-sm-'.$sm;
	if($md)
		$cols .= ' row-cols-md-'.$md;
	if($lg)
		$cols .= ' row-cols-lg-'.$lg;
	if($xl)
		$cols .= ' row-cols-xl-'.$xl;

	return $cols;
}

?>