<?php
include_once('./_common.php');

$g5['title'] = '이미지 크게보기';
include_once(G5_PATH.'/head.sub.php');

$url = $_GET['fn'];
$p = @parse_url($url);

$file = basename($p['path']);
if(!$file || !na_file_path_check($p['path'])) {
    alert_close('잘못된 접근입니다.');
}

$ext = na_file_info($file);
if (!preg_match('/(jpg|jpeg|png|gif|bmp)$/i', $ext['ext'])){
    alert_close('이미지 파일이 아닙니다.');
}

// Loader
include_once(NA_PATH.'/theme/loader.php');
?>

<div>
	<img src="<?php echo $url ?>" alt="" id="img" class="draggable" style="position:relative;top:0;left:0;cursor:move;">
</div>

<script>
var win_w = $("#img").width();
var win_h = $("#img").height(); + 70;
var win_l = (screen.width - win_w) / 2;
var win_t = (screen.height - win_h) / 2;

if(win_w > screen.width) {
    win_l = 0;
    win_w = screen.width - 20;

    if(win_h > screen.height) {
        win_t = 0;
        win_h = screen.height - 40;
    }
}

if(win_h > screen.height) {
    win_t = 0;
    win_h = screen.height - 40;

    if(win_w > screen.width) {
        win_w = screen.width - 20;
        win_l = 0;
    }
}

window.moveTo(win_l, win_t);
window.resizeTo(win_w, win_h);

$(function() {
    var is_draggable = false;
    var x = y = 0;
    var pos_x = pos_y = 0;

    $(".draggable").mousemove(function(e) {
        if(is_draggable) {
            x = parseInt($(this).css("left")) - (pos_x - e.pageX);
            y = parseInt($(this).css("top")) - (pos_y - e.pageY);

            pos_x = e.pageX;
            pos_y = e.pageY;

            $(this).css({ "left" : x, "top" : y });
        }

        return false;
    });

    $(".draggable").mousedown(function(e) {
        pos_x = e.pageX;
        pos_y = e.pageY;
        is_draggable = true;
        return false;
    });

    $(".draggable").mouseup(function() {
        is_draggable = false;
        return false;
    });

    $(".draggable").dblclick(function() {
        window.close();
    });
});
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>