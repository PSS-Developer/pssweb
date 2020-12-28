<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert('접근권한이 없습니다.');
}

// 페이지 주소 지정
$phref = G5_BBS_URL.'/register_email.php';

$g5['title'] = '메일인증 메일주소 변경';
include_once('../head.php');
?>

<p class="rg_em_p">메일인증을 받지 못한 경우 회원정보의 메일주소를 변경 할 수 있습니다.</p>

<form method="post" name="fregister_email" action="" onsubmit="return fregister_email_submit(this);">
<input type="hidden" name="mb_id" value="">

<div class="tbl_frm01 tbl_frm rg_em">
    <table>
    <caption>사이트 이용정보 입력</caption>
    <tr>
        <th scope="row"><label for="reg_mb_email">E-mail<strong class="sound_only">필수</strong></label></th>
        <td><input type="text" name="mb_email" id="reg_mb_email" required class="frm_input email required" size="30" maxlength="100" value="<?php echo $mb['mb_email']; ?>"></td>
    </tr>
    <tr>
        <th scope="row">자동등록방지</th>
        <td><?php echo captcha_html(); ?></td>
    </tr>
    </table>
</div>

<div class="btn_confirm">
    <input type="submit" id="btn_submit" class="btn_submit" value="인증메일변경">
    <a href="#" class="btn_cancel">취소</a>
</div>

</form>

<script>
function fregister_email_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
<?php
include_once('../tail.php');
?>