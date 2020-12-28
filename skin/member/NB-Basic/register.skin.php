<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="register m-auto f-de">
	<?php 
		// 소셜로그인 사용시 소셜로그인 버튼
		@include_once(get_social_skin_path().'/social_register.skin.php');
	?>
	<form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
		<ul class="list-group mb-4">
			<li class="list-group-item border-top-0">
				<h5>회원가입약관</h5>
			</li>
			<li class="list-group-item py-md-4">
				<?php if(is_file(G5_THEME_PATH.'/page/provision.php')) { ?>
					<div class="f-sm" style="overflow:auto; height:12.0rem;">
						<?php @include_once (G5_THEME_PATH.'/page/provision.php'); ?>
					</div>
				<?php } else { ?>
					<textarea class="form-control border-0 bg-white" rows="8" readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
				<?php } ?>
			</li>
			<li class="list-group-item py-md-4">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" name="agree" value="1" class="custom-control-input" id="agree11">
					<label class="custom-control-label" for="agree11"><span>회원가입약관의 내용에 동의합니다.</span></label>
				</div>
			</li>
			<li class="list-group-item pt-5">
				<h5>개인정보처리방침</h5>
			</li>
			<li class="list-group-item py-md-4">
				<div class="table-responsive">
					<table class="table table-bordered mb-3 mb-md-4" style="min-width:500px;">
					<tbody>
					<tr class="bg-light">
						<th class="text-center">목적</th>
						<th class="w-25 text-center">항목</th>
						<th class="w-25 text-center">보유기간</th>
					</tr>
					<tr>
						<td>이용자 식별 및 본인여부 확인</td>
						<td>아이디, 이름, 비밀번호</td>
						<td>회원 탈퇴 시까지</td>
					</tr>
					<tr>
						<td>서비스 이용에 관한 통지, CS대응을 위한 이용자 식별</td>
						<td>연락처 (이메일, 휴대전화번호)</td>
						<td>회원 탈퇴 시까지</td>
					</tr>
					</tbody>
					</table>
				</div>

				<div class="custom-control custom-checkbox">
					<input type="checkbox" name="agree2" value="1" class="custom-control-input" id="agree21">
					<label class="custom-control-label" for="agree21"><span>개인정보처리방침의 내용에 동의합니다.</span></label>
				</div>
			</li>
			<li class="list-group-item py-md-4">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" name="chk_all" value="1" class="custom-control-input" id="chk_all">
					<label class="custom-control-label" for="chk_all"><b><span>위 내용에 모두 동의합니다.</span></b></label>
				</div>
			</li>
		</ul>

		<div class="px-3 px-sm-0 mb-4">
			<div class="row mx-n2">
				<div class="col-6 order-2 px-2">
					<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg btn-block en">회원가입</button>
				</div>
				<div class="col-6 order-1 px-2">
					<a href="<?php echo G5_URL ?>" class="btn btn-basic btn-lg btn-block en">취소</a>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
    function fregister_submit(f) {
        if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("개인정보처리방침의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
        }

        return true;
    }

    $(function($){
        // 모두선택
        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });
    });
</script>
