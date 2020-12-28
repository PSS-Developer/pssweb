<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Callback
function na_callback_map($m) {
	return na_map($m[2]);
}

function na_callback_video($m) {
	return na_video($m[2]);
}

function na_callback_soundcloud($m) {
	return na_soundcloud($m[1]);
}

function na_callback_icon($m) {
	return na_icon($m[2]);
}

function na_callback_emo($m) {
	return na_emoticon($m[2], '');
}

function na_callback_attach($m) {
	return na_attach($m[2]);
}

// Get Text
function na_get_text($str) {

	$str = strip_tags(preg_replace("/(<(script|style)\b[^>]*>).*?(<\/\2>)/is", "", $str));
	$str = preg_replace("/{(첨부|attach)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(지도|map)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(이미지|img)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(동영상|video)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(아이콘|icon)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(이모티콘|emo)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/\[soundcloud([^\]]*)\]/is", "", $str);
	$str = preg_replace("/\[code=([^\]]*)\]/is", "", $str);
	$str = str_replace(array("&nbsp;", "[code]", "[/code]", "[map]", "[/map]"), array("", "", "", "", ""), $str);
	$str = preg_replace("/\s\s+/", " ", $str);
	$str = trim(strip_tags($str));

	return $str;
}

// Cut Text
function na_cut_text($str, $len, $sfx="…") {

	$str = cut_str(na_get_text($str), $len, $sfx);

	return $str;
}

// FA Icon
function na_fa($str){
	$str = ($str) ? preg_replace_callback("/{(아이콘|icon)\:([^}]*)}/is", "na_callback_icon", $str) : $str;
	return $str;
}


// Emoticon Icon
function na_emo($str){
	$str = preg_replace_callback("/{(이모티콘|emo)\:([^}]*)}/is", "na_callback_emo", $str); // Emoticon 
	return $str;
}

//Show Contents
function na_content($str) {
	$str = preg_replace_callback("/{(첨부|attach)\:([^}]*)}/is", "na_callback_attach", $str); // Attach
	$str = preg_replace_callback("/{(지도|map)\:([^}]*)}/is", "na_callback_map", $str); // Map
	$str = preg_replace_callback("/{(동영상|video)\:([^}]*)}/is", "na_callback_video", $str); // Video
	$str = preg_replace_callback("/{(아이콘|icon)\:([^}]*)}/is", "na_callback_icon", $str); // FA Icon
	$str = preg_replace_callback("/{(이모티콘|emo)\:([^}]*)}/is", "na_callback_emo", $str); // Emoticon 
	$str = preg_replace_callback("/\[soundcloud([^\]]*)\]/is", "na_callback_soundcloud", $str); // SoundCloud
	$str = preg_replace_callback("/(\[code\]|\[code=(.*)\])(.*)\[\/code\]/iUs", "na_syntaxhighlighter", $str); // SyntaxHighlighter

	return $str;
}

// Get Star
function na_get_star($avg, $color='') {

	$star = '';

	list($star_s, $star_m) = explode(".", $avg);

	$star_e = ($star_m) ? 4 - $star_s : 5 - $star_s; 

	for($j=0; $j < $star_s; $j++) {
		$star .= '<i class="fa fa-star '.$color.'"></i>';
	}

	if($star_m) 
		$star .= '<i class="fa fa-star-half-empty '.$color.'"></i>';

	for($j=0; $j < $star_e; $j++) {
		$star .= '<i class="fa fa-star-o '.$color.'"></i>';
	}

	return $star;
}

// Post Star
function na_star($star_cnt, $star_score, $color='') {

	$score = $cnt = 0;
	if($star_cnt > 0) {
		$cnt = $star_cnt;
		$score = $star_cnt / $cnt;
	}

	$score = round($score, 1);
	$per = round($score) * 10;
	$star = array("star"=>na_get_star($score, $color), "score"=>$score, "cnt"=>$cnt, "per"=>$per);

	return $star;
}

// 확장자 종류체크
function na_ext_type($file) {

	if(!$file) 
		return;

	$video = array("mp4", "m4v", "f4v", "mov", "flv", "webm");
	$caption = array("vtt", "srt", "ttml", "dfxp");
	$audio = array("acc", "m4a", "f4a", "mp3", "ogg", "oga");
	$image = array("jpg", "jpeg", "gif", "png");
	$pdf = array("pdf");
	$torrent = array("torrent");

	$ext = strtolower(substr(strrchr($file, "."), 1)); 

	$type = 0;
	if(in_array($ext, $image)) {
		$type = 1;
	} else if(in_array($ext, $video)) {
		$type = 2;
	} else if(in_array($ext, $audio)) {
		$type = 3;
	} else if(in_array($ext, $pdf)) {
		$type = 4;
	} else if(in_array($ext, $caption)) {
		$type = 5;
	} else if(in_array($ext, $torrent)) {
		$type = 6;
	}

	return $type;
}

// BS3 Style
function na_paging($write_pages, $cur_page, $total_page, $url, $add='') {

	$first = '<i class="fa fa-angle-double-left"></i>';
	$prev = '<i class="fa fa-angle-left"></i>';
	$next = '<i class="fa fa-angle-right"></i>';
	$last = '<i class="fa fa-angle-double-right"></i>';

    $url = preg_replace('#(&amp;)?page=[0-9]*#', '', $url);
	$url .= substr($url, -1) === '?' ? 'page=' : '&amp;page=';

	if(!$cur_page) $cur_page = 1;
	if(!$total_page) $total_page = 1;

	$str = '';
	if($first) {
		if ($cur_page < 2) {
			$str .= '<li class="page-first page-item disabled"><a class="page-link">'.$first.'</a></li>';
		} else {
			$str .= '<li class="page-first page-item"><a class="page-link" href="'.$url.'1'.$add.'">'.$first.'</a></li>';
		}
	}

	$start_page = (((int)(($cur_page - 1 ) / $write_pages)) * $write_pages) + 1;
	$end_page = $start_page + $write_pages - 1;

	if ($end_page >= $total_page) { 
		$end_page = $total_page;
	}

	if ($start_page > 1) { 
		$str .= '<li class="page-prev page-item"><a class="page-link" href="'.$url.($start_page-1).$add.'">'.$prev.'</a></li>';
	} else {
		$str .= '<li class="page-prev page-item disabled"><a class="page-link">'.$prev.'</a></li>'; 
	}

	if ($total_page > 0){
		for ($k=$start_page;$k<=$end_page;$k++){
			if ($cur_page != $k) {
				$str .= '<li class="page-item"><a class="page-link" href="'.$url.$k.$add.'">'.$k.'</a></li>';
			} else {
				$str .= '<li class="page-item active" aria-current="page"><a class="page-link">'.$k.'<span class="sr-only">(current)</span>
</a></li>';
			}
		}
	}

	if ($total_page > $end_page) {
		$str .= '<li class="page-next page-item"><a class="page-link" href="'.$url.($end_page+1).$add.'">'.$next.'</a></li>';
	} else {
		$str .= '<li class="page-next page-item disabled"><a class="page-link">'.$next.'</a></li>';
	}

	if($last) {
		if ($cur_page < $total_page) {
			$str .= '<li class="page-last page-item"><a class="page-link" href="'.$url.($total_page).$add.'">'.$last.'</a></li>';
		} else {
			$str .= '<li class="page-last page-item disabled"><a class="page-link">'.$last.'</a></li>';
		}
	}

	return $str;
}

function na_ajax_paging($id, $write_pages, $cur_page, $total_page, $url, $add='') {

	$first = '<i class="fa fa-angle-double-left"></i>';
	$prev = '<i class="fa fa-angle-left"></i>';
	$next = '<i class="fa fa-angle-right"></i>';
	$last = '<i class="fa fa-angle-double-right"></i>';

    $url = preg_replace('#(&amp;)?page=[0-9]*#', '', $url);
	$url .= substr($url, -1) === '?' ? 'page=' : '&amp;page=';

	if(!$cur_page) $cur_page = 1;
	if(!$total_page) $total_page = 1;

	$ajax = ($css) ? ' class="'.$css.'"' : ''; // Ajax용 클래스

	$str = '';
	if($first) {
		if ($cur_page < 2) {
			$str .= '<li class="page-first page-item disabled"><a class="page-link">'.$first.'</a></li>';
		} else {
			$str .= '<li class="page-first page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.'1'.$add.'\', \'1\');">'.$first.'</a></li>';
		}
	}

	$start_page = (((int)(($cur_page - 1 ) / $write_pages)) * $write_pages) + 1;
	$end_page = $start_page + $write_pages - 1;

	if ($end_page >= $total_page) { 
		$end_page = $total_page;
	}

	if ($start_page > 1) { 
		$str .= '<li class="page-prev page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.($start_page-1).$add.'\', \'1\'); return false;">'.$prev.'</a></li>';
	} else {
		$str .= '<li class="page-prev page-item disabled"><a class="page-link">'.$prev.'</a></li>'; 
	}

	if ($total_page > 0){
		for ($k=$start_page;$k<=$end_page;$k++){
			if ($cur_page != $k) {
				$str .= '<li class="page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.$k.$add.'\', \'1\'); return false;">'.$k.'</a></li>';
			} else {
				$str .= '<li class="page-item active" aria-current="page"><a class="page-link">'.$k.'<span class="sr-only">(current)</span></a></li>';
			}
		}
	}

	if ($total_page > $end_page) {
		$str .= '<li class="page-next page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.($end_page+1).$add.'\', \'1\'); return false;">'.$next.'</a></li>';
	} else {
		$str .= '<li class="page-next page-item disabled"><a class="page-link">'.$next.'</a></li>';
	}

	if($last) {
		if ($cur_page < $total_page) {
			$str .= '<li class="page-last page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.($total_page).$add.'\', \'1\'); return false;">'.$last.'</a></li>';
		} else {
			$str .= '<li class="page-last page-item disabled"><a class="page-link">'.$last.'</a></li>';
		}
	}

	return $str;
}

// Icon
function na_icon($str){

	if(!$str || $str == 'none') return;

	list($icon, $opt) = explode(";", $str);
	switch($opt) {
		case 'c' : $str = "<i class='".$icon."'></i>"; break;
		case 't' : $str = $icon; break;
		default	 : $str = "<i class='fa fa-".$icon."'></i>"; break;
	}

	return $str;
}

// Emoticon
function na_emoticon($str){

	if(!$str) return;

	list($emo, $width) = explode(":", $str);
	if(is_file(NA_PATH.'/skin/emo/'.$emo)) {
		$width = ($width > 0) ? $width : 50;
		$icon = '<img src="'.NA_URL.'/skin/emo/'.$emo.'" width="'.$width.'" alt="" />';
	} else {
		$icon = '';
	}

	return $icon;
}

//Syntaxhighlighter
function na_syntaxhighlighter($m) {

	$str = $m[3];

	if(!$str) return;

	$str = stripslashes($str);
	$str = preg_replace("/(<br>|<br \/>|<br\/>|<p>)/i", "\n", $str);
	$str = preg_replace("/(<div>|<\/div>|<\/p>)/i", "", $str);
	$str = str_replace("&nbsp;", " ", $str);
	$str = str_replace("/</", "&lt;", $str);

	if(!$str) return;

	$brush = strtolower(trim($m[2]));
	$brush_arr = array('css', 'js', 'jscript', 'javascript', 'php', 'xml', 'xhtml', 'xslt', 'html');
	$brush = ($brush && in_array($brush, $brush_arr)) ? $brush : 'html';

	na_script('code');

	return '<pre class="brush: '.$brush.';">'.$str.'</pre>'.PHP_EOL;
}

//Google Map
function na_map($geo_data) {

	$geo_data = stripslashes($geo_data);

	if(!$geo_data) 
		return;

	$geo_data = str_replace(array("&#034;", "&#039;"), array("\"", "'"), $geo_data);

	$map = array();
	$map = na_query($geo_data);

	if(isset($map['loc']) && $map['loc']) {
		list($lat, $lng) = explode(",", $map['loc']);
		$zoom = (isset($map['z']) && $map['z']) ? $map['z'] : '';
	} else {
		$map['geo'] = (isset($map['geo']) && $map['geo']) ? $map['geo'] : '';
		list($lat, $lng, $zoom) = explode(",", $map['geo']);
	}
	
	if(!$lat || !$lng) return;

	//Map
	$map['geo'] = $lat.','.$lng.','.$zoom;

	//Marker
	preg_match("/m=\"([^\"]*)\"/is", $geo_data, $marker);
	$map['m'] = $marker[1];

	//Place
	preg_match("/p=\"([^\"]*)\"/is", $geo_data, $place);
	$map['p'] = $place[1];

	$id = na_rid();

	$canvas = '<div class="na-videowrap mb-3"><div class="na-videoframe"><iframe id="map_'.$id.'" name="map_'.$id.'" src="'.NA_URL.'/bbs/map.php?id='.urlencode($id).'&amp;geo='.urlencode($map['geo']).'&amp;marker='.urlencode($map['m']).'&amp;place='.urlencode($map['p']).'" marginwidth="0" marginheight="0" frameborder="0" width="100%" height="100%" scrolling="no"></iframe></div></div>';

	return $canvas;
}

// SoundCloud
function na_soundcloud($str) {

	$str = strip_tags($str);
	$str = str_replace(array("&#034;", "&#039;", "\"", "'"), array("", "", "", ""), $str);

	if(!$str) return;

	$cloud = array();
	$cloud = na_query($str);
	$player = '';
	if($cloud['url'] && preg_match('/api.soundcloud.com/i', $cloud['url'])) {
		$cloud['params'] = ($cloud['params']) ? '&'.str_replace("&amp;", "&", $cloud['params']) : '';
		$player = '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.urlencode($cloud['url']).$cloud['params'].'"></iframe>'.PHP_EOL;
	}

	return $player;
}

function na_member_photo($mb_id){

    static $no_profile_cache = '';
    static $member_cache = array();
    
    $src = '';

    if( $mb_id ){
        if( isset($member_cache[$mb_id]) ){
            $src = $member_cache[$mb_id];
        } else {
            $member_img = G5_DATA_PATH.'/member_image/'.substr($mb_id,0,2).'/'.get_mb_icon_name($mb_id).'.gif';
            if (is_file($member_img)) {
                $member_cache[$mb_id] = $src = str_replace(G5_DATA_PATH, G5_DATA_URL, $member_img);
            }
        }
    }

    if( !$src ){
        if( !empty($no_profile_cache) ){
            $src = $no_profile_cache;
        } else {
            // 프로필 이미지가 없을때 기본 이미지
            $no_profile_img = (defined('G5_THEME_NO_PROFILE_IMG') && G5_THEME_NO_PROFILE_IMG) ? G5_THEME_NO_PROFILE_IMG : G5_NO_PROFILE_IMG;
            $tmp = array();
            preg_match( '/src="([^"]*)"/i', $no_profile_img, $tmp );
            $no_profile_cache = $src = isset($tmp[1]) ? $tmp[1] : G5_IMG_URL.'/no_profile.gif';
        }
    }

	return $src;
}

function na_name_photo($mb_id, $name){
	global $config;

	if(!$config['cf_use_member_icon'] || !$mb_id)
		return $name;

	preg_match_all("/<img([^>]*)>/iS", $name, $matches);

    if(empty($matches))
        return $name;

    for($i=0; $i<count($matches[1]); $i++) {

        preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[1][$i], $m);

		if($m[1]) {
			return str_replace($matches[0][$i], '<img src="'.na_member_photo($mb_id).'" width="'.$config['cf_member_icon_width'].'" height="'.$config['cf_member_icon_height'].'" alt="회원사진"/>', $name);
		}
    }

	return $name;
}

function na_sns_share_icon($url, $title, $img='', $icon='', $eol='') {
	global $config;

	$sns_url = $url;
	$sns_msg = str_replace('\"', '"', strip_tags($title));
	$sns_msg = str_replace('\'', '', $sns_msg);
	$sns_send  = NA_URL.'/bbs/sns.php?longurl='.urlencode($sns_url).'&amp;title='.urlencode($sns_msg);
	$sns_img = ($icon) ? $icon : NA_URL.'/img/sns';

	$eol = ($eol) ? '' : PHP_EOL;
	
	$is_kakao = false;
	if($config['cf_kakao_js_apikey']) {
		if(!defined('NA_KAKAO')) {
			define('NA_KAKAO', true);
			echo '<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>'.PHP_EOL;
			echo '<script src="'.G5_JS_URL.'/kakaolink.js"></script>'.PHP_EOL;
			echo '<script>Kakao.init("'.$config['cf_kakao_js_apikey'].'");</script>'.PHP_EOL;
		}
		$is_kakao = true;
	}

	$sns = array();
	$sns[] = array('facebook', 'Facebook');
	$sns[] = array('twitter', 'Twitter');
	//$sns[] = array('googleplus', 'GooglePlus');
	$sns[] = array('kakaostory', 'KakaoStory');
	$sns[] = array('kakaotalk', 'KakaoTalk');
	$sns[] = array('naverband', 'NaverBand');
	$sns[] = array('naver', 'Naver');
	$sns[] = array('tumblr', 'Tumblr');
	$sns[] = array('pinterest', 'Pinterest');

	$sns_cnt = count($sns);

	$sns_icon = '';
	for($i=0; $i < $sns_cnt; $i++) {

		$sns_href = $sns_send.'&amp;sns='.$sns[$i][0];

		if($sns[$i][0] == 'pinterest') {

			if(!$img) continue;

			$sns_href .= '&amp;img='.urlencode($img);
		}

		if($sns[$i][0] == 'kakaotalk') {

			if(!$is_kakao) continue;

			$sns_icon .= '<a href="'.$sns_href.'" onclick="kakaolink_send(\''.$sns_msg.'\',\''.$sns_url.'\',\''.$img.'\'); return false;" target="_blank">';
			$sns_icon .= '<img src="'.$sns_img.'/'.$sns[$i][0].'.png" alt="'.$sns[$i][1].'"></a>'.$eol;
		} else {
			$sns_icon .= '<a href="'.$sns_href.'" onclick="na_sns(\''.$sns[$i][0].'\',\''.$sns_href.'\'); return false;" target="_blank">';
			$sns_icon .= '<img src="'.$sns_img.'/'.$sns[$i][0].'.png" alt="'.$sns[$i][1].'"></a>'.$eol;
		}
	}

    return $sns_icon;
}

// 이미지 넘기는 형태
function na_img_rows($img, $rows) {
	return ($rows > 1) ? $img : $img[0];
}

// 게시물 이미지 추출
function na_wr_img($bo_table, $wr) {
    global $g5, $config;

	$rows = (int)$wr['img_rows'];
	$rows = ($rows > 1) ? $rows : 1;

	// 전체 이미지 뽑기
	$all = (isset($wr['imgs_all']) && $wr['imgs_all']) ? true : false;

	if(!$all && $rows == "1" && isset($wr['as_thumb']) && $wr['as_thumb']) {
		// 상대경로 전환
		return str_replace("./", G5_URL, $wr['as_thumb']);
	}

	$img = array();
	$link = array();

	// 이미지 카운팅
	$z = 0; // 직접
	$n = 0; // 링크

	// 직접 첨부
	if($wr['wr_file']) {
		$sql = " select bf_file, bf_content 
					from {$g5['board_file_table']} 
					where bo_table = '$bo_table' 
						and wr_id = '{$wr['wr_id']}' 
						and bf_type between '1' and '3' 
					order by bf_no ";
		$result = sql_query($sql, false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			if($row['bf_file']) {
				$img[$z] = G5_DATA_URL.'/file/'.$bo_table.'/'.$row['bf_file'];
				$z++;
				if(!$all && $z == $rows)
					return na_img_rows($img, $rows);
			} 
		}
	}

	// 본문 보다 링크 동영상 먼저 체크
	for ($i=1; $i<=G5_LINK_COUNT; $i++) {
		$wr_link = $wr["wr_link{$i}"];

		if(!$wr_link)
			continue;

		$vimg = na_video_img(na_video_info(trim(strip_tags($wr_link))));
		if(!$vimg)
			continue;

		$img[$z] = str_replace(G5_PATH, G5_URL, $vimg);
		$z++;
		if(!$all && $z == $rows) 
			return na_img_rows($img, $rows);
	}

	// 본문
	if($wr['wr_content']) {
		// 본문 이미지
		$matches = get_editor_image($wr['wr_content'], false);
		$imgs = (is_array($matches[1])) ? $matches[1] : array();
		$imgs_cnt = count($imgs);
		for($i=0; $i < $imgs_cnt; $i++) {
			// 이미지 path 구함
			$p = @parse_url($imgs[$i]);
			if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
				$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
			else
				$data_path = $p['path'];

			$srcfile = G5_PATH.$data_path;

			if(is_file($srcfile)) {
				$size = @getimagesize($srcfile);
				// 아이콘 등 링크 제거를 위해 100px 이하 이미지는 제외함
				if(empty($size) || $size[0] < 100)
					continue;

				$img[$z] = $imgs[$i];
				$z++;
				if(!$all && $z == $rows)
					return na_img_rows($img, $rows);

			} else {
				$link[$n] = $matches[1][$i];
				$n++;
			}
		}

		// 본문 동영상
		if(preg_match_all("/{(동영상|video)\:([^}]*)}/is", $wr['wr_content'], $match)) {
			$vimgs = (is_array($match[2])) ? $match[2] : array();
			$vimgs_cnt = count($vimgs);
			for ($i=0; $i < $vimgs_cnt; $i++) {

				$vimg = na_video_img(na_video_info(trim(strip_tags($vimgs[$i]))));

				if(!$vimg || $vimg == 'none') 
					continue;

				$img[$z] = str_replace(G5_PATH, G5_URL, $vimg);
				$z++;
				if(!$all && $z == $rows) 
					return na_img_rows($img, $rows);

			}
		}

		// 본문링크 이미지
		$link_cnt = count($link);
		for($i=0; $i < $link_cnt; $i++) {
			$img[$z] = $link[$i];
			$z++;
			if(!$all && $z == $rows) 
				return na_img_rows($img, $rows);
		}
	}

	// 이미지 없음
	$img[$z] = '';

    return na_img_rows($img, $rows);
}

// 썸네일
function na_thumb($img, $thumb_w, $thumb_h) {

	if($thumb_w > 0) {
		// 이미지 path 구함
		$p = parse_url($img);
		if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
			$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
		else
			$data_path = $p['path'];

		$srcfile = G5_PATH.$data_path;

		if(is_file($srcfile)) {
			$filename = basename($srcfile);
			$filepath = dirname($srcfile);
			$tname = thumbnail($filename, $filepath, $filepath, $thumb_w, $thumb_h, false, true);
			$img = G5_URL.str_replace($filename, $tname, $data_path);
		}
	}

	return $img;
}

// 미디어 종류 파악
function na_check_ext($type='') {

	if($type == 'video') {
		$ext = array('mp4', 'm4v', 'f4v', 'mov', 'flv', 'webm');
	} else if($type == 'audio') {
		$ext = array('acc', 'm4a', 'f4a', 'mp3', 'ogg', 'oga');
	} else if($type == 'caption') {
		$ext = array('vtt', 'srt', 'ttml', 'dfxp');
	} else if($type == 'image') {
		$ext = array('jpg', 'jpeg', 'gif', 'png');
	} else {
		$ext = array("mp4", "m4v", "f4v", "mov", "flv", "webm", "acc", "m4a", "f4a", "mp3", "ogg", "oga");
	}

	return $ext;
}

// 동영상 종류 파악
function na_video_info($video_url) {
	global $boset;

	$video = array();
	$query = array();
	$option = array();

	$video_url = trim(strip_tags($video_url));

	list($url, $opt) = explode("|", $video_url);
	
	$url = trim($url);

	if($url) {
		if(!preg_match('/(http|https)\:\/\//i', $url)) {
			$url = 'http:'.$url;
		}
	} else {
		return;
	}

	$video['video'] = str_replace(array("&nbsp;", " "), array("", ""), $url);
	$video['video_url'] = str_replace(array("&nbsp;", "&amp;", " "), array("", "&", ""), $url);

	if($opt)
		$option = na_query($opt);

	// 미디어파일 직접 지정일 경우(jwplayer)
	if($option['file']) {
		$video['type'] = 'file';
		$video['vid'] = 'file';
		$video['img'] = ($option['img']) ? str_replace(array("&nbsp;", " "), array("", ""), trim(strip_tags($option['img']))) : '';
		$video['caption'] = ($option['caption']) ? str_replace(array("&nbsp;", " "), array("", ""), trim(strip_tags($option['caption']))) : '';
		return $video;
	}

	$info = @parse_url($video['video_url']); 
	if($info['query']) 
		parse_str($info['query'], $query); 
	
	// 확장자 체크 && jwplayer
	$filename = basename($info['path']);
	if($filename) {
		$ext = na_file_info($filename);
		if(in_array($ext['ext'], na_check_ext())) {
			$video['type'] = 'file';
			$video['vid'] = 'file';
			return $video;
		}
	}

	// Fullscreen
	$fs = ' allowfullscreen webkitallowfullscreen mozallowfullscreen';
	$vw = 640;
	$vh = 360;

	switch($info['host']) {

		// Youtube
		case 'www.youtube.com' :
		case 'm.youtube.com'   :
		case 'youtu.be'		   :   
			$video['type'] = 'youtube';
			if($info['host'] == 'youtu.be') {
				$video['vid'] = trim(str_replace("/","", trim($info['path'])));
				$video['vid'] = substr($video['vid'], 0, 11);
			} else {
				if(preg_match('/\/embed\//i', $video['video_url'])) {
					list($yt_url, $yt_opt) = explode("/embed/", $video['video_url']);
					$vids = explode("?", $yt_opt);
					$video['vid'] = $vids[0];
				} else {
					$video['vid'] = $query['v'];
				}
			}

			$video['s'] = ($option['s']) ? $option['s'] : $query['s'];
			if($video['s']) { 
				$vw = 480; 
				$vh = 880; 
			}
			$vlist = ($query['list']) ? '&list='.$query['list'] : '';
			$start = ($option['start']) ? $option['start'] : $query['start'];
			$start = ($start) ? '&start='.$start : '';
			$autoplay = ($boset['na_autoplay']) ? '&autoplay=1' : '';
			$video['iframe'] = '<iframe width="'.$vw.'" height="'.$vh.'" src="https://www.youtube.com/embed/'.$video['vid'].'?autohide=1&vq=hd720&wmode=opaque'.$vlist.$autoplay.$start.'" frameborder="0"'.$fs.'></iframe>';
			break;

		// Vimeo
		case 'vimeo.com' :
			$video['type'] = 'vimeo';
			$vquery = explode("/",$video['video_url']);
			$num = count($vquery) - 1;
			list($video['vid']) = explode("#",$vquery[$num]);
			$vw = 717; 
			$vh = 403;
			$autoplay = ($boset['na_autoplay']) ? '&amp;autoplay=1' : '';
			$video['iframe'] = '<iframe src="https://player.vimeo.com/video/'.$video['vid'].'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff'.$autoplay.'&amp;wmode=opaque" width="'.$vw.'" height="'.$vh.'" frameborder="0"'.$fs.'></iframe>';
			break;

		// Ted
		case 'www.ted.com' :
			$video['type'] = 'ted';
			$vids = explode("?", $video['video_url']);
			$vquery = explode("/",$vids[0]);
			$num = count($vquery) - 1;
			list($video['vid']) = explode(".", $vquery[$num]);
			list($rid) = explode(".", trim($info['path']));
			$rid = str_replace($video['vid'], '', $rid);
			$lang = ($query['language']) ? 'lang/'.$query['language'].'/' : '';
			if($lang) {
				$rid = (stripos($rid, $lang) === false) ? $rid.$lang : $rid;
			}
			$video['rid'] = trim($rid.$video['vid']).'.html';
			$video['iframe'] = '<iframe src="https://embed-ssl.ted.com'.$video['rid'].'?&wmode=opaque" width="'.$vw.'" height="'.$vh.'" frameborder="0" scrolling="no"'.$fs.'></iframe>';
			break;

		// Kakao tv & Daum tv
		case 'tvpot.daum.net' :
		case 'tv.kakao.com'	  :
			$video['type'] = 'kakao';
			if($query['vid']) {
				$video['vid'] = $query['vid'];
			} else if($query['clipid']) {
				$video['vid'] = 1;
				$play = ap_video_id($video);
				$video['vid'] = $play['vid'];
			} else {
				$video['vid'] = trim(str_replace("/v/","",$info['path']));
			}
			$autoplay = ($boset['na_autoplay']) ? '&autoplay=1' : '';
			$video['iframe'] = '<iframe width="'.$vw.'" height="'.$vh.'" src="https://tv.kakao.com/embed/player/cliplink/'.$video['vid'].'?service=kakao_tv'.$autoplay.'&wmode=opaque" frameborder="0" scrolling="no"'.$fs.'></iframe>';
			break;

		// Pandora tv
		case 'channel.pandora.tv' :
		case 'www.pandora.tv'	  :
		case 'pan.best'			  :
			$video['type'] = 'pandora';
			$video['vid'] = 1;
			$play = na_video_id($video);
			$video['ch_userid'] = $play['userid'];
			$video['prgid'] = $play['prgid'];
			$video['vid'] = $video['ch_userid'].'_'.$video['prgid'];
			$video['iframe'] = '<iframe frameborder="0" width="'.$vw.'" height="'.$vh.'" src="https://channel.pandora.tv/php/embed.fr1.ptv?userid='.$video['ch_userid'].'&prgid='.$video['prgid'].'&skin=1&share=on&wmode=opaque"'.$fs.'></iframe>';
			break;

		// Dailymotion
		case 'www.dailymotion.com'  :
		case 'dai.ly'				:
			$video['type'] = 'dailymotion';
			if($info['host'] == 'dai.ly') {
				$video['vid'] = trim($info['path']);
			} else {
				$vurl = explode("#", $video['video_url']);
				$vquery = explode("/", $vurl[0]);
				$num = count($vquery) - 1;
				list($video['vid']) = explode("_", $vquery[$num]);
			}
			$video['iframe'] = '<iframe frameborder="0" width="'.$vw.'" height="'.$vh.'" src="https://www.dailymotion.com/embed/video/'.$video['vid'].'?&wmode=opaque"'.$fs.'></iframe>';
			break;

		// Facebook
		case 'www.facebook.com'  :
			$video['type'] = 'facebook';
			if($query['video_id']){
				$video['vid'] = $query['video_id'];
			} else if($query['v']) {
				$video['vid'] = $query['v'];
			} else {
				$vtmp = explode("/videos/", trim($info['path']));
				$vquery = explode("/", $vtmp[1]);
				$video['vid'] = $vquery[0];
			}
			if(is_numeric($video['vid'])) {
				$video['iframe'] = '<iframe src="https://www.facebook.com/video/embed?video_id='.urlencode($video['vid']).'" width="'.$vw.'" height="'.$vh.'" frameborder="0"'.$fs.'></iframe>';
			} else {
				$video = NULL;
			}
			break;

		// Naver Blog
		case 'serviceapi.nmv.naver.com'  :
			$video['type'] = 'naver';
			$video['vid'] = $query['vid'];
			$video['outKey'] = $query['outKey'];
			$vw = 720;
			$vh = 438;
			$autoplay = ($boset['na_autoplay']) ? '&isp=1' : '';
			$video['iframe'] = '<iframe width="'.$vw.'" height="'.$vh.'" src="https://serviceapi.nmv.naver.com/flash/convertIframeTag.nhn?vid='.$video['vid'].'&outKey='.$video['outKey'].'&wmode=opaque'.$autoplay.'" frameborder="no" scrolling="no"'.$fs.'></iframe>';
			break;

		// Naver tvcast
		case 'serviceapi.rmcnmv.naver.com'  :
		case 'tvcast.naver.com'				:
		case 'tv.naver.com'					:
			$video['type'] = 'tvcast';
			if($query['vid']) {
				$video['vid'] = $query['vid'];
				$video['outKey'] = $query['outKey'];
			} else {
				list($vid) = explode("/", trim(str_replace("/v/","",$info['path']))); 
				$video['vid'] = $vid;
			}
			$vw = 740;
			$vh = 416;
			$autoplay = ($boset['na_autoplay']) ? 'true' : 'false';
			$video['iframe'] = '<iframe src="https://tv.naver.com/embed/'.$video['vid'].'?autoPlay='.$autoplay.'" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" width="'.$vw.'" height="'.$vh.'" allow="autoplay"'.$fs.'></iframe>';
			break;

		// Slideshare
		case 'www.slideshare.net'  :
			$video['type'] = 'slideshare';
			$video['vid'] = 1;
			$play = na_video_id($video);
			$video['play_url'] = $play['play_url'];
			$video['vid'] = $play['vid'];
			$vw = 425;
			$vh = 355;
			$video['iframe'] = '<iframe src="'.str_replace("http:", "https:", $video['play_url']).'" width="'.$vw.'" height="'.$vh.'" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"'.$fs.'></iframe>';
			break;

		// Vid
		case 'vid.me'  :
			$video['type'] = 'vid';
			$video['vid'] = trim(str_replace("/","",$info['path']));
			$vw = 854;
			$vh = 480;
			$autoplay = ($boset['na_autoplay']) ? '&amp;autoplay=1' : '';
			$video['iframe'] = '<iframe src="https://vid.me/e/'.$video['vid'].'?stats=1&amp;tools=1'.$autoplay.'" width="'.$vw.'" height="'.$vh.'" frameborder="0" scrolling="no"'.$fs.'></iframe>';
			break;

		// Sendvid
		case 'sendvid.com'  :
			$video['type'] = 'sendvid';
			$video['vid'] = trim(str_replace("/","",$info['path']));
			$vw = 853;
			$vh = 480;
			$video['iframe'] = '<iframe src="https://sendvid.com/embed/'.$video['vid'].'" width="'.$vw.'" height="'.$vh.'" frameborder="0"'.$fs.'></iframe>';
			break;

		// Vine
		case 'vine.co'  :
			$video['type'] = 'vine';
			$vtmp = explode("/v/", trim($info['path']));
			$vquery = explode("/", $vtmp[1]);
			$video['vid'] = $vquery[0];
			$vw = 600; 
			$vh = 600;
			$video['iframe'] = '<iframe src="https://vine.co/v/'.$video['vid'].'/embed/simple" width="'.$vw.'" height="'.$vh.'" frameborder="0"'.$fs.'></iframe>';
			break;

		// Yinyuetai
		case 'player.yinyuetai.com'  :
		case 'v.yinyuetai.com'		 :
			$video['type'] = 'yinyuetai';
			$video['vid'] = str_replace("/", "", str_replace("v_0.swf", "", str_replace("player", "", str_replace("video","",$info['path']))));
			$vw = 480; 
			$vh = 334; 
			$video['iframe'] = '<embed src="https://player.yinyuetai.com/video/player/'.$video['vid'].'/v_0.swf" quality="high" width="'.$vw.'" height="'.$vh.'" align="middle" allowScriptAccess="sameDomain" allowfullscreen="true" type="application/x-shockwave-flash"></embed>';
			break;

		// Vlive
		case 'www.vlive.tv'  :
			$video['type'] = 'vlive';
			$vtmp = explode("/video/", trim($info['path']));
			$vquery = explode("/", $vtmp[1]);
			$video['vid'] = $vquery[0];
			$vw = 544; 
			$vh = 306; 
			$autoplay = ($boset['na_autoplay']) ? '?autoPlay=true' : '';
			$video['iframe'] = '<iframe src="https://www.vlive.tv/embed/'.$video['vid'].$autoplay.'" width="'.$vw.'" height="'.$vh.'" frameborder="no" scrolling="no" marginwidth="0" marginheight="0"'.$fs.'></iframe>';
			break;
			
		// Srook
		case 'www.srook.net'  :
			$video['type'] = 'srook';
			$vquery = explode("/", trim($info['path']));
			$video['author'] = $vquery[1];
			$video['key'] = $vquery[2];
			$video['vid'] = $video['author'].'_'.$video['key'];
			$video['pageNo'] = ($query['pageNo']) ? '&pageNo='.$query['pageNo'] : '';
			$vw = 720; 
			$vh = 480; 
			$video['iframe'] = '<iframe src="https://www.srook.net/nemo_embed/srookviewer.html?author='.$video['author'].'&key='.$video['key'].'&btype=0'.$video['pageNo'].'" width="'.$vw.'" height="'.$vh.'" frameborder="no" scrolling="no" marginwidth="0" marginheight="0"'.$fs.'></iframe>';
			break;

		// Twitch
		case 'www.twitch.tv'  :
			$video['type'] = 'twitch';
			$vtmp = explode("/videos/", trim($info['path']));
			$vquery = explode("/", $vtmp[1]);
			$video['vid'] = $vquery[0];
			$vw = 620; 
			$vh = 378; 
			$video['iframe'] = '<iframe src="https://player.twitch.tv/?video='.$video['vid'].'&parent='.$_SERVER["SERVER_NAME"].'" width="'.$vw.'" height="'.$vh.'" frameborder="no" scrolling="no"'.$fs.'></iframe>';
			break;

		// Openload
		case 'openload.co'  :
			$video['type'] = 'openload';
			$vtmp = explode("/embed/", trim($info['path']));
			$vquery = explode("/", $vtmp[1]);
			$video['vid'] = $vquery[0];
			$video['iframe'] = '<iframe src="https://openload.co/embed/'.$video['vid'].'?wmode=opaque" width="'.$vw.'" height="'.$vh.'" frameborder="no" scrolling="no"'.$fs.'></iframe>';
			break;

		// Soundcloud
		case 'soundcloud.com'  :
			$video['type'] = 'soundcloud';
			$play = na_video_id($video);
			$video['vid'] = $play['vid'];
			break;
	}

	// 동영상 비율
	$video['ratio'] = round(($vh / $vw), 4) * 100;

	return $video;
}

// Video Player
function na_video($vid, $opt='') {

	$video = array();
	$vid = str_replace("&nbsp;", " ", $vid);
	$video = na_video_info($vid);

	if($opt) 
		return $video; //비디오 정보만 넘기기

	if(!$video['vid']) 
		return;

	// JWPLAYER6
	$iframe = '';
	if($video['type'] == "file") {
		return na_jwplayer($video['video'], $video['img'], $video['caption']);

	} else if($video['iframe']) {
		$iframe = $video['iframe'];
		// vine.co
		if($video['type'] == "vine" && !defined('VINE_VIDEO')) {
			define('VINE_VIDEO', true);
			$iframe .= '<script src="https://platform.vine.co/static/scripts/embed.js"></script>';
		}

	} else if($video['type'] == "soundcloud") {
		$vpath = str_replace("-", "/", $video['vid']);
		list($vtype, $vcode) = explode("/", $vpath);
		if(G5_IS_MOBILE) {
			$iframe = '<div class="na-soundcloud-mo">';
			if($vtype == 'playlists') {
				$iframe .= '<iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/'.$vpath.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>';
			} else {
				$iframe .= '<iframe width="100%" height="400" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/'.$vpath.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>';
			}
			$iframe .= '</div>';
		} else {
			$iframe = '<div class="na-soundcloud">';
			if($vtype == 'playlists') {
				$iframe .= '<iframe width="100%" height="450" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/'.$vpath.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
			} else {
				$iframe .= '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/'.$vpath.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
			}
			$iframe .= '</div>';
		}

		return $iframe;
	}

	$player = '';
	if($iframe) {
		$sero_size = ($video['s']) ? ' na-video-sero' : '';
		$player .= '<div class="na-videowrap'.$sero_size.'">'.PHP_EOL;
		$player .= '<div class="na-videoframe" style="padding-bottom: '.$video['ratio'].'%;">'.PHP_EOL;
		$player .= $iframe.PHP_EOL;
		$player .= '</div>'.PHP_EOL;
		$player .= '</div>'.PHP_EOL;
	}

	return $player;
}

// 동영상 이미지 주소 가져오기
function na_video_imgurl($video) {
	global $nariya;

	$url = $video['video_url'];
	$vid = $video['vid'];
	$type = $video['type'];

	$imgurl = '';
	if($type == "file") { //JWPLAYER
		return;
	} else if($type == "vimeo") { //비메오
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://vimeo.com/api/v2/video/".$vid.".php");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = unserialize(curl_exec($ch));
		curl_close($ch);

		$imgurl = $output[0]['thumbnail_large'];

	} else if($type == "youtube") { //유튜브

		$imgurl = 'https://img.youtube.com/vi/'.$vid.'/hqdefault.jpg';

	} else if($type == "sendvid") { //Sendvid

		$imgurl = 'https://sendvid.com/'.$vid.'.jpg';

	} else if($type == "srook") { //www.srook.net

		list($author, $key) = explode("_", $vid);

		$imgurl = 'http://www.srook.net/ctlimg/pageImg.ashx?p=1|'.$key.'|'.$author;

	} else if($type == "facebook"){

		if(!$nariya['fb_key']) 
			return;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v2.8/".$vid."?fields=id,picture&access_token=".$nariya['fb_key']);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = json_decode(curl_exec($ch));
		curl_close($ch);
		
		$imgurl = $output->picture;

	} else if($type == "naver" || $type == "tvcast"){ //라니안님 코드 반영

		$info = @parse_url($url);

		if($info['host'] == "tvcast.naver.com" || $info['host'] == "tv.naver.com") {
			;
		} else {
			$url_type = ($type == "naver") ? "nmv" : "rmcnmv"; // 네이버 블로그 영상과 tvcast 영상 구분
			parse_str($info['query'], $query); 

			$vid .= "&outKey=".$query['outKey'];
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://serviceapi.{$url_type}.naver.com/flash/videoInfo.nhn?vid=".$vid);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$output = curl_exec($ch);
			curl_close($ch);

			preg_match('/\<CoverImage\>\<\!\[CDATA\[(?P<img_url>[^\s\'\"]+)\]\]\>\<\/CoverImage\>/i', $output, $video);

			$imgurl = $video['img_url'];
		}

	}
	
	if(!$imgurl) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		if($type == "soundcloud") {
			$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0'; 
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);

		//parsing begins here:
		$doc = new DOMDocument();
		@$doc->loadHTML($output);

		$metas = $doc->getElementsByTagName('meta');

		for ($i = 0; $i < $metas->length; $i++) {
			$meta = $metas->item($i);
			if($meta->getAttribute('property') == "og:image" || $meta->getAttribute('name') == "og:image") {
				if($meta->getAttribute('content')) {
					$imgurl = str_replace("type=f240", "type=f640", $meta->getAttribute('content')); //640 사이즈로 변경
				}
				break;
			}
		}
	}

	return $imgurl;
}

// 동영상 이미지 가져오기
function na_video_img($video, $fimg='') {
	global $nariya;

	if(!$video['type']) 
		return;

	if($video['type'] == 'file') 
		return $fimg;

	// 동영상 대표이미지 링크 그대로 사용
	if(!$nariya['save_video_img']) {
		return na_video_imgurl($video);
	}

	$no_image = NA_PATH.'/img/blank.gif';
	$video_path = G5_DATA_PATH.'/'.NA_DIR.'/video';
	$video_url = G5_DATA_URL.'/'.NA_DIR.'/video';
	$type_path = $video_path.'/'.$video['type'];
	$type_url = $video_url.'/'.$video['type'];

	$code_vid = urldecode(na_fid($video['vid']));

	$img = $type_path.'/'.$code_vid.'.jpg';
	$no_img = $type_path.'/'.$code_vid.'_none';

	if(is_file($img)) {
		return $img;
	} else if($video['type'] != 'youtube' && is_file($no_img)) { // 유튜브만 이미지 다시 가져옴
		return;
	} else {
		//썸네일 저장폴더
		if(!is_dir($video_path)) {
	        @mkdir($video_path, G5_DIR_PERMISSION);
	        @chmod($video_path, G5_DIR_PERMISSION);
		}

		if(!is_dir($type_path)) {
	        @mkdir($type_path, G5_DIR_PERMISSION);
	        @chmod($type_path, G5_DIR_PERMISSION);
		}

		//동영상 이미지 주소 가져오기
		$imgurl = na_video_imgurl($video);

		if($imgurl) {
			$ch = curl_init ($imgurl);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$err = curl_error($ch);
			if(!$err) 
				$rawdata=curl_exec($ch);
			curl_close ($ch);
			if($rawdata) {
				$fp = fopen($img,'w'); 
				fwrite($fp, $rawdata); 
				fclose($fp); 
				@chmod($img, G5_FILE_PERMISSION);
				@unlink($no_img);
				return $img;
			} else {
				if(!is_file($no_img)) {
					@copy($no_image, $no_img);
					@chmod($no_img, G5_FILE_PERMISSION);
				}
				return;
			}
		} 

		if(!is_file($no_img)) {
			@copy($no_image, $no_img);
			@chmod($no_img, G5_FILE_PERMISSION);
		}

		return;
	} 

	return;
}

// 동영상 실제 아이디 가져오기
function na_video_id($vinfo) {

	$play = array();
	$info = array();
	$query = array();

	if (!$vinfo['type'] || $vinfo['type'] == 'file')
		return $play;

	$url = $vinfo['video_url'];
	$vid = $vinfo['vid'];
	$type = $vinfo['type'];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	if($type == "soundcloud") {
		$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0'; 
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	}
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = curl_exec($ch);
	curl_close($ch);

	switch($type) {
		case 'tvcast' : 
			$name = 'property'; 
			$key = 'og:video:url'; 
			$value = 'content'; 
			break;

		case 'daum' : 
			$name = 'property'; 
			$key = 'og:url'; 
			$value = 'content'; 
			break;

		case 'kakao' : 
			$name = 'property'; 
			$key = 'og:url'; 
			$value = 'content'; 
			break;

		case 'pandora' : 
			$name = 'property'; 
			$key = 'og:url'; 
			$value = 'content'; 
			break;

		case 'slideshare' : 
			$name = 'name'; 
			$key = 'twitter:player'; 
			$value = 'value'; 
			break;

		case 'soundcloud' : 
			$name = 'property'; 
			$key = 'twitter:player'; 
			$value = 'content'; 
			break;

		default : 
			break;
	}

	if(!$name)
		return $play;

	// Parsing begins here:
	$doc = new DOMDocument();
	@$doc->loadHTML($output);

	$metas = $doc->getElementsByTagName('meta');

	for ($i = 0; $i < $metas->length; $i++) {
		$meta = $metas->item($i);
		if($meta->getAttribute($name) == $key) {
			$content = str_replace("&amp;", "&", $meta->getAttribute($value));
			break;
		}
	}

	if(!$content)
		return $play;
	
	$info = @parse_url($content);
	switch($type) {
		case 'tvcast' :
			@parse_str($info['query'], $query); 
			$play['vid'] = $query['vid'];
			$play['outKey']= $query['outKey'];
			break;

		case 'tvcast' :
		case 'daum'	  :
			$play['vid'] = trim(str_replace("/v/","",$info['path']));
			break;

		case 'pandora' :
			list($play['userid'], $play['prgid']) = explode("/", trim(str_replace("/view/","",$info['path'])));
			break;

		case 'slideshare' :
			$play['play_url'] = $content;
			$play['vid'] = trim(str_replace("/slideshow/embed_code/","",$info['path'])); 
			break;

		case 'soundcloud' :
			@parse_str($info['query'], $query);
			$vinfo = @parse_url($query['url']);
			if(strpos($vinfo['path'], '/tracks/') !== false || strpos($vinfo['path'], '/playlists/') !== false) {
				$play['vid'] = str_replace(array("/tracks/", "/playlists/"), array("tracks-", "playlists-"), $vinfo['path']);
			}
			break;

		default	: 
			break;
	}

	return $play;
}

// Jwpalyer Caption
function na_get_caption($attach, $source, $num) {

	if(!$source) 
		return;

	$carr = array();
	$iarr = array();
	$earr = array();

	$caption = na_check_ext('caption');
	$image = na_check_ext('image');
	$fname = na_file_info($source);

	for ($i=0; $i < $attach['count']; $i++) {

		if($i == $num) 
			continue;

		$file = na_file_info($attach[$i]['source']);

		if($fname['name'] == $file['name']) {
			$fileurl = $attach[$i]['path'].'/'.$attach[$i]['file'];
			if(in_array($file['ext'], $caption)) {
				$carr[] = $fileurl;
			} else if(in_array($file['ext'], $image)) {
				$iarr[] = $fileurl;
				$earr[] = $i;
			}
		}
	}

	// 제외번호는 배열로 다 넘김
	return array($iarr[0], $carr[0], $earr);
}

// JWPlayer List
function na_jwplayer_list($url) {

	if(!$url) return;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$xml = trim(curl_exec($ch));
	curl_close($ch);

	if(!$xml) return;

	preg_match_all("/<item>(.*)<\/item>/is", $xml, $matchs);

	return count($matchs[1]);
}

// JWPlayer6
function na_jwplayer($url, $img='', $caption='', $title=''){
	global $nariya, $boset;

	if(!$url) 
		return;

	$video = na_check_ext('video');
	$audio = na_check_ext('audio');
	$file = na_file_info($url);

	if($file['ext'] == "rss") {
		$type = 'plist';
		$cnt = na_jwplayer_list($url);
		if($cnt > 0) {
			;
		} else {
			return;
		}
	} else if(in_array($file['ext'], $audio)) {
		$type = 'audio';
	} else if(in_array($file['ext'], $video)) {
		$type = 'video';
	} else {
		return;
	}

	$jw_id = na_rid();

	// 자동실행
	$auto = ($boset['na_autoplay']) ? 'true' : 'false';

	$jw_script = '';	
	if($type == 'audio' && !$img && !$caption) {
		$jw_script .= '<script>
					    jwplayer("'.$jw_id.'").setup({
							file: "'.$url.'",
							title: "'.$title.'",
							autostart: "'.$auto.'",
							width: "100%",
							height: "40",
							repeat: "file"
						});
					 </script>'.PHP_EOL;
	} else if($type == 'plist') {
		$plist = (G5_IS_MOBILE) ? 'aspectratio: "16:9", listbar: { position: "right", size:150 }' : 'aspectratio: "16:9", listbar: { position: "right", size:200 }';
		$jw_script .= '<script>
						jwplayer("'.$jw_id.'").setup({
							playlist: "'.$url.'",
							autostart: "'.$auto.'",
							width: "100%",
							'.$plist.'
						});
					 </script>'.PHP_EOL;
	} else {
		$img = ($img) ? 'image: "'.$img.'",' : '';
		$caption = ($caption) ? 'tracks: [{file: "'.$caption.'"}],' : '';
		$jw_script .= '<script>
						jwplayer("'.$jw_id.'").setup({
							file: "'.$url.'",
							title: "'.$title.'",
							autostart: "'.$auto.'",
							'.$img.'
							'.$caption.'
							aspectratio: "16:9",
							width: "100%"
						});
					 </script>'.PHP_EOL;
	}

	$jw = '';
	if($jw_script) {
		if(!defined('NA_JW6')) {
			define('NA_JW6', true);
			$jw .= '<script src="'.NA_URL.'/app/jwplayer/jwplayer.js"></script>'.PHP_EOL;
			$jw .= '<script>jwplayer.key="'.$nariya['jw6_key'].'";</script>'.PHP_EOL;
		}
		$jw .= '<div class="na-jwplayer"><div id="'.$jw_id.'">Loading the player...</div>'.PHP_EOL;
		$jw .= $jw_script;
		$jw .= '</div>'.PHP_EOL;
	}

	return $jw;
}

// 첨부 동영상 출력
function na_video_attach($attach='', $num='') {

	if(!$attach || !is_array($attach)) {
		global $view;

		$attach = array();
		$attach = $view['file'];
	}

	$video = '';
	$exceptfile = array();

	if($attach['count']) {

		$vext = na_check_ext();
		$vext[] = 'rss'; // jwplayer rss 추가

		for ($i=0; $i<$attach['count']; $i++) {

			if ($attach[$i]['source'] && !$attach[$i]['view']) {

				$ext = na_file_info($attach[$i]['source']);

				if(in_array($ext['ext'], $vext)) {
					list($screen, $caption, $except) = na_get_caption($attach, $attach[$i]['source'], $i);

					$except = (is_array($except)) ? $except : array();

					$title = ($attach[$i]['content']) ? $attach[$i]['content'] : $attach[$i]['source'];

					$video .= na_jwplayer($attach[$i]['path'].'/'.$attach[$i]['file'], $screen, $caption, $title);

					if(count($except) > 0) 
						$exceptfile = array_merge($exceptfile, $except);
				}
			}
		}

		// 동영상 이미지는 출력이미지에서 제외
		if(isset($view['file']) && count($exceptfile)) { 
			$refile = array();
			$j = 0;
			for ($i=0; $i<$attach['count']; $i++) {

				if (in_array($i, $exceptfile)) 
					continue;

				$refile[$j] = $attach[$i];
				$j++;
			}

			if($j > 0) {
				$view['file'] = $refile;
				$view['file']['count'] = $j;
			}
		}
	}

	return $video;
}

// 링크 동영상 출력
function na_video_link($link, $num='', $img='') {

	$vext = na_check_ext();

	$j = 0;
	$video = '';
	$link = (is_array($link)) ? $link : array();
	$img = (is_array($img)) ? $img : array();
	$link_cnt = count($link);
	for ($i=0; $i<=$link_cnt; $i++) {

		if(!$link[$i]) 
			continue;

		list($url) = explode("|", $link[$i]);

		$url = str_replace("&amp;", "&", $url);
		$ext = strtolower(substr(strrchr(basename($url), "."), 1));
		$player = ($ext && in_array($ext, $vext)) ? na_jwplayer($url, $img[$i]) : na_video($url);

		if($player) {
			$video .= $player;
			$j++;
			if($num && $j == $num) return $video;
		}
	}

	return $video;
}

// UTF-8 확장 커스텀 함수 - http://jmnote.com/wiki/Utf8_ord
function na_utf8_ord($ch) {
	$len = strlen($ch);
	if($len <= 0) return false;
	$h = ord($ch{0});
	if($h <= 0x7F) return $h;
	if($h < 0xC2) return false;
	if($h <= 0xDF && $len>1) return ($h & 0x1F) <<  6 | (ord($ch{1}) & 0x3F);
	if($h <= 0xEF && $len>2) return ($h & 0x0F) << 12 | (ord($ch{1}) & 0x3F) << 6 | (ord($ch{2}) & 0x3F);
	if($h <= 0xF4 && $len>3) return ($h & 0x0F) << 18 | (ord($ch{1}) & 0x3F) << 12 | (ord($ch{2}) & 0x3F) << 6 | (ord($ch{3}) & 0x3F);
	return false;
}

 // UTF-8 한글 초성 추출 - http://jmnote.com/wiki/UTF-8_%ED%95%9C%EA%B8%80_%EC%B4%88%EC%84%B1_%EB%B6%84%EB%A6%AC_(PHP)
function na_chosung($str) {

	$result = array();

	//$cho = array("가","까","나","다","따","라","마","바","빠","사","싸","아","자","짜","차","카","타","파","하");
	//$cho = array("ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ");
	//$cho = array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18");

	$cho = array("가","가","나","다","다","라","마","바","바","사","사","아","자","자","차","카","타","파","하");
	$str = mb_substr($str,0,1,"UTF-8");
	$code = na_utf8_ord($str) - 44032;
	if ($code > -1 && $code < 11172) {
		$cho_idx = $code / 588;
		$result[0] = 0; //한글
		$result[1] = $cho[$cho_idx];
	} else {
		$str = strtoupper($str); //대문자로 변경
		if(preg_match("/[0-9]+/i", $str)) {
			$result[0] = 2; //숫자
			$result[1] = $str;
		} else if(preg_match("/[A-Z]+/i", $str)) {
			$result[0] = 1; //영어
			$result[1] = $str;
		} else {
			$result[0] = 3; //특수문자
			$result[1] = addslashes($str);
		}
	}

	return $result;
}

// Check Tag
function na_check_tag($tag) {

	$tag = str_replace(array("\"", "'"), array("", ""), na_get_text($tag));

	if(!$tag) 
		return;
	
	$list = array();
	$arr = array_map('trim', explode(',', $tag));
	foreach($arr as $tmp) {
		if(!$tmp) 
			continue;

		$list[] = $tmp;
	}

	if(count($list) == 0) 
		return;

	$list = array_unique($list);

	$str = implode(',', $list);

	return $str;
}

// Delete Tag
function na_delete_tag($bo_table, $wr_id='') {
    global $g5;

	if($bo_table && $wr_id) {
	    $result = sql_query("select tag_id from {$g5['na_tag_log']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
	    while ($row = sql_fetch_array($result)) {
			sql_query("update {$g5['na_tag']} set cnt = cnt - 1 where id = '{$row['tag_id']}'");
	    }
		sql_query("delete from {$g5['na_tag_log']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}'");
	} else if($bo_table) {
	    $result = sql_query("select tag_id from {$g5['na_tag_log']} where bo_table = '{$bo_table}' ");
	    while ($row = sql_fetch_array($result)) {
			sql_query("update {$g5['na_tag']} set cnt = cnt - 1 where id = '{$row['tag_id']}'");
	    }
		sql_query("delete from {$g5['na_tag_log']} where bo_table = '{$bo_table}'");
	}

	return;
}

// Add Tag
function na_add_tag($it_tag, $bo_table, $wr_id='', $mb_id='') {
    global $g5;

	$arr = array();

	// 기존 태그 삭제
	na_delete_tag($bo_table, $wr_id);

	// 태그정리
	$it_tag = na_check_tag($it_tag);

	if(!$it_tag) 
		return;

	// 카운팅이 0 또는 음수인 태그 삭제
	sql_query("delete from {$g5['na_tag']} where cnt <= '0'");

	// 태그등록
	$tags = array_map('trim', explode(',', $it_tag));
	foreach($tags as $tag) {
		$row = sql_fetch("select id from {$g5['na_tag']} where tag = '{$tag}' ");
		if ($row['id']) {
			$tag_id = $row['id'];
			sql_query("update {$g5['na_tag']} set cnt = cnt + 1, lastdate='".G5_TIME_YMDHIS."' where id='{$tag_id}'");
		} else {
			//색인 만들기
			list($type, $idx) = na_chosung($tag);
			sql_query("insert into {$g5['na_tag']} set type = '{$type}', idx = '{$idx}', tag='".addslashes($tag)."', cnt=1, regdate='".G5_TIME_YMDHIS."', lastdate='".G5_TIME_YMDHIS."'");
			$tag_id = sql_insert_id();
		} 

		sql_query("insert into {$g5['na_tag_log']} set bo_table = '{$bo_table}', wr_id = '{$wr_id}', tag_id = '{$tag_id}', tag = '".addslashes($tag)."', mb_id = '{$mb_id}', regdate = '".G5_TIME_YMDHIS."' ");
	}

	return $it_tag;
}

// Get Tag
function na_get_tag($it_tag) {

	$it_tag = na_get_text($it_tag);

	if(!$it_tag) 
		return;

	$tags = array();
	$tags = array_map('trim', explode(",", $it_tag));

	$i = 0;
	$str = '';
	foreach($tags as $tag) {
		if($i > 0)
			$str .= ', ';

		$str .= '<a href="'.G5_BBS_URL.'/tag.php?q='.urlencode($tag).'" rel="tag">#'.$tag.'</a>';
		$i++;
	}

	return $str;
}

// Delete
function na_delete($bo_table, $wr_id) {
	global $g5;

	// 게시판 플러그인
	if(IS_NA_BBS) {
		// 태그 삭제
		na_delete_tag($bo_table, $wr_id);

		// 신고 삭제
		sql_query(" delete from {$g5['na_shingo']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", false);
	}

	// 멤버쉽 플러그인
	if(IS_NA_XP) {
		// 쓰기, 댓글 경험치만 삭제
        $row = sql_fetch(" select mb_id, xp_rel_action from {$g5['na_xp']}
                  where xp_rel_table = '$bo_table'
                    and xp_rel_id = '$wr_id'
                    and (xp_rel_action = '쓰기' or xp_rel_action = '댓글') ", false);

		if($row['mb_id'])
			na_delete_xp($row['mb_id'], $bo_table, $wr_id, $row['xp_rel_action']);
	}
}

function na_rich_content_video($matches){
	global $view;

	$num = $matches[2];

	if(isset($view['file'][$num]['file']) && $view['file'][$num]['file'])
		$num = $view['file'][$num]['path'].'/'.$view['file'][$num]['file'];

	$str = ($matches[3]) ? $num.':'.$matches[3] : $num;

	return '{동영상:'.$str.'}';
}

function na_view($data){

	if(isset($data['as_img']) && $data['as_img'] == "2") {
		$data['content'] = $data['rich_content'];
	}

	$data['content'] = preg_replace_callback("/{(동영상|video)\:([0-9]+)[:]?([^}]*)}/i", "na_rich_content_video", $data['content']);

	return na_content($data['content']);
}

?>