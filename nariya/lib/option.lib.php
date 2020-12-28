<?php
if (!defined('_GNUBOARD_')) exit;

function na_options($opt, $value) {

	$opt_cnt = count($opt);
	$options = '';
	for($i=0; $i < $opt_cnt; $i++) {
		$options .= '<option value="'.$opt[$i][0].'"'.get_selected($opt[$i][0], $value).'>'.$opt[$i][1].'</option>'.PHP_EOL;
	}

	return $options;
}

function na_color_options($value) {
		
	$opt = array();
	$opt[] = array('blue', 'Blue');
	$opt[] = array('indigo', 'Indigo');
	$opt[] = array('purple', 'Purple');
	$opt[] = array('pink', 'Pink');
	$opt[] = array('red', 'Red');
	$opt[] = array('orangered', 'OrangeRed');
	$opt[] = array('orange', 'Orange');
	$opt[] = array('yellow', 'Yellow');
	$opt[] = array('green', 'Green');
	$opt[] = array('teal', 'Teal');
	$opt[] = array('cyan', 'Cyan');
	$opt[] = array('navy', 'Navy');
	$opt[] = array('dark', 'Dark');
	$opt[] = array('white', 'White');
	$opt[] = array('primary', 'Primary');
	$opt[] = array('secondary', 'Secondary');
	$opt[] = array('success', 'Success');
	$opt[] = array('info', 'Info');
	$opt[] = array('warning', 'Warning');
	$opt[] = array('danger', 'Danger');

	return na_options($opt, $value);
}

function na_target_options($value) {

	$opt = array();
	$opt[] = array('', '내용-현재');
	$opt[] = array('1', '내용-새창');
	$opt[] = array('2', '링크-현재');
	$opt[] = array('3', '링크-새창');

	return na_options($opt, $value);
}

function na_sort_options($value) {

	$opt = array();
	$opt[] = array('', '최근순');
	$opt[] = array('asc', '등록순');
	$opt[] = array('date', '날짜순');
	$opt[] = array('hit', '조회순');
	$opt[] = array('comment', '댓글순');
	$opt[] = array('good', '추천순');
	$opt[] = array('nogood', '비추천순');
	$opt[] = array('like', '추천-비추천순');

	return na_options($opt, $value);
}

function na_member_options($value) {

	$opt = array();
	$opt[] = array('point', '포인트');
	if(IS_NA_XP) {
		$opt[] = array('exp', '경험치');
	}
	$opt[] = array('post', '글등록');
	$opt[] = array('comment', '댓글등록');
	$opt[] = array('new', '신규가입');
	$opt[] = array('recent', '최근접속');
	$opt[] = array('connect', '현재접속');

	return na_options($opt, $value);
}

function na_shadow_options($value) {

	$opt = array();
	$opt[] = array('', '그림자 없음');
	$opt[] = array('1', '그림자1');
	$opt[] = array('2', '그림자2');
	$opt[] = array('3', '그림자3');
	$opt[] = array('4', '그림자4');

	return na_options($opt, $value);
}

function na_grade_options($value) {

	$options = '';
	for($i=10; $i > 0; $i--) {
		$options .= '<option value="'.$i.'"'.get_selected($i, $value).'>'.$i.'</option>'.PHP_EOL;
	}

	return $options;
}

function na_term_options($value) {

	$opt = array();
	$opt[] = array('', '사용안함');
	$opt[] = array('day', '일자 지정');
	$opt[] = array('today', '오늘');
	$opt[] = array('yesterday', '어제');
	$opt[] = array('week', '주간');
	$opt[] = array('month', '이번달');
	$opt[] = array('prev', '지난달');

	return na_options($opt, $value);
}

function na_skin_options($path, $dir, $value, $opt) {

	$path = $path.'/'.$dir;
	$skin = ($opt) ? na_skin_file_list($path, $opt) : na_skin_dir_list($path);
	$options = '';
	for ($i=0; $i<count($skin); $i++) {
		$options .= "<option value=\"".$skin[$i]."\"".get_selected($value, $skin[$i]).">".$skin[$i]."</option>\n";
	} 

	return $options;
}

function na_owl_in_options($value) {

	$options = '<optgroup label="Attention Seekers">'.PHP_EOL;
	$options .= '<option value="bounce"'.get_selected('bounce', $value).'>bounce</option>'.PHP_EOL;
	$options .= '<option value="flash"'.get_selected('flash', $value).'>flash</option>'.PHP_EOL;
	$options .= '<option value="pulse"'.get_selected('pulse', $value).'>pulse</option>'.PHP_EOL;
	$options .= '<option value="rubberBand"'.get_selected('rubberBand', $value).'>rubberBand</option>'.PHP_EOL;
	$options .= '<option value="shake"'.get_selected('shake', $value).'>shake</option>'.PHP_EOL;
	$options .= '<option value="swing"'.get_selected('swing', $value).'>swing</option>'.PHP_EOL;
	$options .= '<option value="tada"'.get_selected('tada', $value).'>tada</option>'.PHP_EOL;
	$options .= '<option value="wobble"'.get_selected('wobble', $value).'>wobble</option>'.PHP_EOL;
	$options .= '<option value="jello"'.get_selected('jello', $value).'>jello</option>'.PHP_EOL;
	$options .= '<option value="heartBeat"'.get_selected('heartBeat', $value).'>heartBeat</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Bouncing Entrances">'.PHP_EOL;
	$options .= '<option value="bounceIn"'.get_selected('bounceIn', $value).'>bounceIn</option>'.PHP_EOL;
	$options .= '<option value="bounceInDown"'.get_selected('bounceInDown', $value).'>bounceInDown</option>'.PHP_EOL;
	$options .= '<option value="bounceInLeft"'.get_selected('bounceInLeft', $value).'>bounceInLeft</option>'.PHP_EOL;
	$options .= '<option value="bounceInRight"'.get_selected('bounceInRight', $value).'>bounceInRight</option>'.PHP_EOL;
	$options .= '<option value="bounceInUp"'.get_selected('bounceInUp', $value).'>bounceInUp</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Fading Entrances">'.PHP_EOL;
	$options .= '<option value="fadeIn"'.get_selected('fadeIn', $value).'>fadeIn</option>'.PHP_EOL;
	$options .= '<option value="fadeInDown"'.get_selected('fadeInDown', $value).'>fadeInDown</option>'.PHP_EOL;
	$options .= '<option value="fadeInDownBig"'.get_selected('fadeInDownBig', $value).'>fadeInDownBig</option>'.PHP_EOL;
	$options .= '<option value="fadeInLeft"'.get_selected('fadeInLeft', $value).'>fadeInLeft</option>'.PHP_EOL;
	$options .= '<option value="fadeInLeftBig"'.get_selected('fadeInLeftBig', $value).'>fadeInLeftBig</option>'.PHP_EOL;
	$options .= '<option value="fadeInRight"'.get_selected('fadeInRight', $value).'>fadeInRight</option>'.PHP_EOL;
	$options .= '<option value="fadeInRightBig"'.get_selected('fadeInRightBig', $value).'>fadeInRightBig</option>'.PHP_EOL;
	$options .= '<option value="fadeInUp"'.get_selected('fadeInUp', $value).'>fadeInUp</option>'.PHP_EOL;
	$options .= '<option value="fadeInUpBig"'.get_selected('fadeInUpBig', $value).'>fadeInUpBig</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Flippers">'.PHP_EOL;
	$options .= '<option value="flip"'.get_selected('flip', $value).'>flip</option>'.PHP_EOL;
	$options .= '<option value="flipInX"'.get_selected('flipInX', $value).'>flipInX</option>'.PHP_EOL;
	$options .= '<option value="flipInY"'.get_selected('flipInY', $value).'>flipInY</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Lightspeed">'.PHP_EOL;
	$options .= '<option value="lightSpeedIn"'.get_selected('lightSpeedIn', $value).'>lightSpeedIn</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Rotating Entrances">'.PHP_EOL;
	$options .= '<option value="rotateIn"'.get_selected('rotateIn', $value).'>rotateIn</option>'.PHP_EOL;
	$options .= '<option value="rotateInDownLeft"'.get_selected('rotateInDownLeft', $value).'>rotateInDownLeft</option>'.PHP_EOL;
	$options .= '<option value="rotateInDownRight"'.get_selected('rotateInDownRight', $value).'>rotateInDownRight</option>'.PHP_EOL;
	$options .= '<option value="rotateInUpLeft"'.get_selected('rotateInUpLeft', $value).'>rotateInUpLeft</option>'.PHP_EOL;
	$options .= '<option value="rotateInUpRight"'.get_selected('rotateInUpRight', $value).'>rotateInUpRight</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Sliding Entrances">'.PHP_EOL;
	$options .= '<option value="slideInUp"'.get_selected('slideInUp', $value).'>slideInUp</option>'.PHP_EOL;
	$options .= '<option value="slideInDown"'.get_selected('slideInDown', $value).'>slideInDown</option>'.PHP_EOL;
	$options .= '<option value="slideInLeft"'.get_selected('slideInLeft', $value).'>slideInLeft</option>'.PHP_EOL;
	$options .= '<option value="slideInRight"'.get_selected('slideInRight', $value).'>slideInRight</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Zoom Entrances">'.PHP_EOL;
	$options .= '<option value="zoomIn"'.get_selected('zoomIn', $value).'>zoomIn</option>'.PHP_EOL;
	$options .= '<option value="zoomInDown"'.get_selected('zoomInDown', $value).'>zoomInDown</option>'.PHP_EOL;
	$options .= '<option value="zoomInLeft"'.get_selected('zoomInLeft', $value).'>zoomInLeft</option>'.PHP_EOL;
	$options .= '<option value="zoomInRight"'.get_selected('zoomInRight', $value).'>zoomInRight</option>'.PHP_EOL;
	$options .= '<option value="zoomInUp"'.get_selected('zoomInUp', $value).'>zoomInUp</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Specials">'.PHP_EOL;
	$options .= '<option value="hinge"'.get_selected('hinge', $value).'>hinge</option>'.PHP_EOL;
	$options .= '<option value="jackInTheBox"'.get_selected('jackInTheBox', $value).'>jackInTheBox</option>'.PHP_EOL;
	$options .= '<option value="rollIn"'.get_selected('rollIn', $value).'>rollIn</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	return $options;
}

function na_owl_out_options($value) {

	$options = '<optgroup label="Attention Seekers">'.PHP_EOL;
	$options .= '<option value="bounce"'.get_selected('bounce', $value).'>bounce</option>'.PHP_EOL;
	$options .= '<option value="flash"'.get_selected('flash', $value).'>flash</option>'.PHP_EOL;
	$options .= '<option value="pulse"'.get_selected('pulse', $value).'>pulse</option>'.PHP_EOL;
	$options .= '<option value="rubberBand"'.get_selected('rubberBand', $value).'>rubberBand</option>'.PHP_EOL;
	$options .= '<option value="shake"'.get_selected('shake', $value).'>shake</option>'.PHP_EOL;
	$options .= '<option value="swing"'.get_selected('swing', $value).'>swing</option>'.PHP_EOL;
	$options .= '<option value="tada"'.get_selected('tada', $value).'>tada</option>'.PHP_EOL;
	$options .= '<option value="wobble"'.get_selected('wobble', $value).'>wobble</option>'.PHP_EOL;
	$options .= '<option value="jello"'.get_selected('jello', $value).'>jello</option>'.PHP_EOL;
	$options .= '<option value="heartBeat"'.get_selected('heartBeat', $value).'>heartBeat</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Bouncing Exits">'.PHP_EOL;
	$options .= '<option value="bounceOut"'.get_selected('bounceOut', $value).'>bounceOut</option>'.PHP_EOL;
	$options .= '<option value="bounceOutDown"'.get_selected('bounceOutDown', $value).'>bounceOutDown</option>'.PHP_EOL;
	$options .= '<option value="bounceOutLeft"'.get_selected('bounceOutLeft', $value).'>bounceOutLeft</option>'.PHP_EOL;
	$options .= '<option value="bounceOutRight"'.get_selected('bounceOutRight', $value).'>bounceOutRight</option>'.PHP_EOL;
	$options .= '<option value="bounceOutUp"'.get_selected('bounceOutUp', $value).'>bounceOutUp</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Fading Exits">'.PHP_EOL;
	$options .= '<option value="fadeOut"'.get_selected('fadeOut', $value).'>fadeOut</option>'.PHP_EOL;
	$options .= '<option value="fadeOutDown"'.get_selected('fadeOutDown', $value).'>fadeOutDown</option>'.PHP_EOL;
	$options .= '<option value="fadeOutDownBig"'.get_selected('fadeOutDownBig', $value).'>fadeOutDownBig</option>'.PHP_EOL;
	$options .= '<option value="fadeOutLeft"'.get_selected('fadeOutLeft', $value).'>fadeOutLeft</option>'.PHP_EOL;
	$options .= '<option value="fadeOutLeftBig"'.get_selected('fadeOutLeftBig', $value).'>fadeOutLeftBig</option>'.PHP_EOL;
	$options .= '<option value="fadeOutRight"'.get_selected('fadeOutRight', $value).'>fadeOutRight</option>'.PHP_EOL;
	$options .= '<option value="fadeOutRightBig"'.get_selected('fadeOutRightBig', $value).'>fadeOutRightBig</option>'.PHP_EOL;
	$options .= '<option value="fadeOutUp"'.get_selected('fadeOutUp', $value).'>fadeOutUp</option>'.PHP_EOL;
	$options .= '<option value="fadeOutUpBig"'.get_selected('fadeOutUpBig', $value).'>fadeOutUpBig</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Flippers">'.PHP_EOL;
	$options .= '<option value="flip"'.get_selected('flip', $value).'>flip</option>'.PHP_EOL;
	$options .= '<option value="flipOutX"'.get_selected('flipOutX', $value).'>flipOutX</option>'.PHP_EOL;
	$options .= '<option value="flipOutY"'.get_selected('flipOutY', $value).'>flipOutY</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Lightspeed">'.PHP_EOL;
	$options .= '<option value="lightSpeedOut"'.get_selected('lightSpeedOut', $value).'>lightSpeedOut</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Rotating Exits">'.PHP_EOL;
	$options .= '<option value="rotateOut"'.get_selected('rotateOut', $value).'>rotateOut</option>'.PHP_EOL;
	$options .= '<option value="rotateOutDownLeft"'.get_selected('rotateOutDownLeft', $value).'>rotateOutDownLeft</option>'.PHP_EOL;
	$options .= '<option value="rotateOutDownRight"'.get_selected('rotateOutDownRight', $value).'>rotateOutDownRight</option>'.PHP_EOL;
	$options .= '<option value="rotateOutUpLeft"'.get_selected('rotateOutUpLeft', $value).'>rotateOutUpLeft</option>'.PHP_EOL;
	$options .= '<option value="rotateOutUpRight"'.get_selected('rotateOutUpRight', $value).'>rotateOutUpRight</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Sliding Exits">'.PHP_EOL;
	$options .= '<option value="slideOutUp"'.get_selected('slideOutUp', $value).'>slideOutUp</option>'.PHP_EOL;
	$options .= '<option value="slideOutDown"'.get_selected('slideOutDown', $value).'>slideOutDown</option>'.PHP_EOL;
	$options .= '<option value="slideOutLeft"'.get_selected('slideOutLeft', $value).'>slideOutLeft</option>'.PHP_EOL;
	$options .= '<option value="slideOutRight"'.get_selected('slideOutRight', $value).'>slideOutRight</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Zoom Exits">'.PHP_EOL;
	$options .= '<option value="zoomOut"'.get_selected('zoomOut', $value).'>zoomOut</option>'.PHP_EOL;
	$options .= '<option value="zoomOutDown"'.get_selected('zoomOutDown', $value).'>zoomOutDown</option>'.PHP_EOL;
	$options .= '<option value="zoomOutLeft"'.get_selected('zoomOutLeft', $value).'>zoomOutLeft</option>'.PHP_EOL;
	$options .= '<option value="zoomOutRight"'.get_selected('zoomOutRight', $value).'>zoomOutRight</option>'.PHP_EOL;
	$options .= '<option value="zoomOutUp"'.get_selected('zoomOutUp', $value).'>zoomOutUp</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	$options .= '<optgroup label="Specials">'.PHP_EOL;
	$options .= '<option value="hinge"'.get_selected('hinge', $value).'>hinge</option>'.PHP_EOL;
	$options .= '<option value="jackInTheBox"'.get_selected('jackInTheBox', $value).'>jackInTheBox</option>'.PHP_EOL;
	$options .= '<option value="rollOut"'.get_selected('rollOut', $value).'>rollOut</option>'.PHP_EOL;
	$options .= '</optgroup>'.PHP_EOL;

	return $options;
}

// Background Options
function na_bg_options($value) {
		
	$opt = array();
	$opt[] = array('top', '상단 맞춤');
	$opt[] = array('center', '중앙 맞춤');
	$opt[] = array('bottom', '하단 맞춤');

	return na_options($opt, $value);
}

// Mask Options
function na_mask_options($value) {
		
	$opt = array();
	$opt[] = array('none', '사용안함');
	$opt[] = array('border', 'Border');
	$opt[] = array('brush1', 'Brush 1');
	$opt[] = array('brush2', 'Brush 2');
	$opt[] = array('bubble1', 'Bubble 1');
	$opt[] = array('bubble2', 'Bubble 2');
	$opt[] = array('line1', 'Line 1');
	$opt[] = array('line2', 'Line 2');
	$opt[] = array('round1', 'Round 1');
	$opt[] = array('round2', 'Round 2');
	$opt[] = array('round3', 'Round 3');
	$opt[] = array('round4', 'Round 4');
	$opt[] = array('round5', 'Round 5');
	$opt[] = array('wave1', 'Wave 1');
	$opt[] = array('wave2', 'Wave 2');
	$opt[] = array('wave3', 'Wave 3');
	$opt[] = array('wave4', 'Wave 4');
	$opt[] = array('wave5', 'Wave 5');
	$opt[] = array('special1', 'Special 1');
	$opt[] = array('special2', 'Special 2');
	$opt[] = array('special3', 'Special 3');

	return na_options($opt, $value);
}

function na_cols_select($value) {

	$value = (string)$value;
	
	$opt = array();
	for($i=0;$i < 7;$i++) {
		$opt[] = array((string)$i, (string)$i);
	}

	return na_options($opt, $value);
}

?>