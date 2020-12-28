<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/json.lib.php');

check_demo();

if ($is_admin != 'super')
    alert('접근권한이 없습니다.');

$mode = na_fid($mode);

if(!$mode)
    alert('값이 넘어오지 않았습니다.');

$menu_json = $_POST['menu_json'];

if(!$menu_json)
    alert('등록된 메뉴가 없습니다.');

$data = json_decode(stripslashes($menu_json));

// stdClass to array
function convert_object_to_array($data) {

    if (is_object($data)) {
        $data = get_object_vars($data);
    }

    if (is_array($data)) {
        return array_map(__FUNCTION__, $data);
    } else {
        return $data;
    }
}

$data = convert_object_to_array($data);

if(empty($data))
    alert('등록된 메뉴가 없습니다.');

// 메뉴 배열 저장(string)
na_file_var_save(G5_THEME_PATH.'/storage/menu-'.$mode.'-raw.php', $menu_json, 1); //폴더 퍼미션 체크

// 메뉴 배열 정리
$data = array_map_deep('stripslashes',  $data);

// PC 메뉴 리스트 저장
$list = na_menu_list($data, 'pc');
na_file_var_save(G5_THEME_PATH.'/storage/menu-'.$mode.'-pc.php', $list);

// 모바일 메뉴 리스트 저장
$list = na_menu_list($data, 'mo');
na_file_var_save(G5_THEME_PATH.'/storage/menu-'.$mode.'-mo.php', $list);

goto_url('./menu_form.php?mode='.urlencode($mode));

?>