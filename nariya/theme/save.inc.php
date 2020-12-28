<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$theme_save = G5_PATH.'/'.G5_THEME_DIR;

// theme 디렉토리에 파일 생성 가능한지 검사.
if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
    $sapi_type = php_sapi_name();
    if (substr($sapi_type, 0, 3) == 'cgi') {
        if (!(is_readable($theme_save) && is_executable($theme_save))) {
        ?>
        <div class="alert alert-danger">
			<b>주의!</b> /<?php echo G5_THEME_DIR ?> 디렉토리의 퍼미션을 705로 변경하셔야 설정값이 저장됩니다.
        </div>
        <?php
        }
    } else {
        if (!(is_readable($theme_save) && is_writeable($theme_save) && is_executable($theme_save))) {
        ?>
        <div class="alert alert-danger">
			<b>주의!</b> /<?php echo G5_THEME_DIR ?> 디렉토리의 퍼미션을 707 또는 777로 변경하셔야 설정값이 저장됩니다.
        </div>
        <?php
        }
    }
}
unset($theme_save);
?>