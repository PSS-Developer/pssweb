<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 헤더, 테일 사용설정
@include_once(G5_THEME_PATH.'/head.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<section id="mb_login" class="f-de py-4 m-auto" style="max-width:260px;">
	<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" autocomplete="off">
	<input type="hidden" name="url" value="<?php echo $login_url ?>">

		<h1 class="text-primary text-center text-uppercase mb-1">
			Login
		</h1>

		<div class="bg-primary" style="height:4px;"></div>

		<div class="form-group my-3">
			<div class="custom-control custom-switch">
			  <input type="checkbox" name="auto_login" class="custom-control-input remember-me" id="login_auto_login">
			  <label class="custom-control-label float-left" for="login_auto_login">자동로그인</label>
			</div>
		</div>

		<div class="form-group">
			<label for="login_id" class="sr-only">아이디<strong class="sr-only"> 필수</strong></label>			
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fa fa-user text-muted"></i></span>
				</div>
				<input type="text" name="mb_id" id="login_id" class="form-control required" placeholder="아이디">
			</div>
		</div>
		<div class="form-group">	
			<label for="login_pw" class="sr-only">비밀번호<strong class="sr-only"> 필수</strong></label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fa fa-lock text-muted"></i></span>
				</div>
				<input type="password" name="mb_password" id="login_pw" class="form-control required" placeholder="비밀번호">
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block p-3 en">
				<h5>로그인</h5>
			</button>    
		</div>	

		<div class="clearfix">
			<a href="<?php echo G5_BBS_URL ?>/register.php" class="float-left">
				회원가입하기
			</a>
			<a href="<?php echo G5_BBS_URL ?>/password_lost.php" class="win_password_lost float-right">
				회원정보찾기
			</a>
		</div>

	</form>

	<?php @include (get_social_skin_path().'/social_login.skin.php'); // 소셜로그인 사용시 소셜로그인 버튼 ?>

	<p class="text-center px-3 pt-3 mt-3 border-top">
		<a href="<?php echo G5_URL ?>">홈으로 돌아가기</a>
	</p>

</section>

<?php if(IS_YC && $default['de_level_sell'] == 1) { // 쇼핑몰 상품구입 권한 ?>

	<!-- 주문하기, 신청하기 -->
	<?php if (preg_match("/orderform.php/", $url)) { ?>
    <section id="mb_login_notmb" class="m-auto" style="max-width:480px;">
		<div class="f-de px-3 my-3">
			<ul class="list-group">
				<li class="list-group-item bg-primary border-primary text-white">
					<h5 class="ellipsis">비회원 구매</h5>
				</li>
				<li class="list-group-item py-3">
					<p>비회원으로 주문하시는 경우 포인트는 지급하지 않습니다.</p>

					<div id="guest_privacy" class="table-responsive mt-2 mb-3">
						<table class="na-table table table-bordered mb-0">
						<tbody>
						<tr class="bg-light">
							<th class="nw-7 text-center">구분</th>
							<th class="text-center">개인정보수집 내용</th>
						</tr>
						<tr>
							<td class="text-center">수집 목적</td>
							<td>서비스 이용에 관한 통지, CS대응을 위한 이용자 식별</td>
						</tr>
						<tr>
							<td class="text-center">수집 항목</td>
							<td>이름, 비밀번호, 주소, 이메일, 연락처, 결제정보</td>
						</tr>
						<tr>
							<td class="text-center">보유 기간</td>
							<td>5년(전자상거래 등에서의 소비자보호에 관한 법률)</td>
						</tr>
						</tbody>
						</table>
					</div>

					<div class="custom-control custom-checkbox mb-3">
						<input type="checkbox" name="agree" value="1" class="custom-control-input" id="agree">
						<label class="custom-control-label" for="agree"><span>개인정보수집에 대한 내용에 동의합니다.</span></label>
					</div>
		
					<div class="btn_confirm">
						<a href="javascript:guest_submit(document.flogin);" class="btn btn-primary btn-block py-3">비회원으로 구매하기</a>
					</div>
				</li>
			</ul>
			<script>
			function guest_submit(f) {
				if (document.getElementById('agree')) {
					if (!document.getElementById('agree').checked) {
						alert("개인정보수집에 대한 내용에 동의하셔야 합니다.");
						return;
					}
				}
				f.url.value = "<?php echo $url; ?>";
				f.action = "<?php echo $url; ?>";
				f.submit();
			}
			</script>
		</div>
		<p class="text-center px-3 mt-3">
			<a href="<?php echo G5_URL ?>">홈으로 돌아가기</a>
		</p>		
    </section>

    <?php } else if (preg_match("/orderinquiry.php$/", $url)) { ?>

    <section id="mb_login_od_wr" class="m-auto" style="max-width:380px;">
		<div class="f-de px-3 my-3">
			<ul class="list-group">
				<li class="list-group-item bg-primary border-primary text-white">
					<h5 class="ellipsis">비회원 주문조회</h5>
				</li>
				<li class="list-group-item py-3">
					<p>메일로 발송해드린 주문서의 <strong>주문번호</strong> 및 주문 시 입력하신 <strong>비밀번호</strong>를 정확히 입력해주십시오.</p>

					<form name="forderinquiry" method="post" action="<?php echo urldecode($url); ?>" autocomplete="off">
						<div class="input-group mt-2 mb-0">
							<div class="input-group-prepend">
								<span class="input-group-text">주문번호<strong class="sr-only"> 필수</strong></span>
							</div>
							<input type="text" name="od_id" id="od_id" required class="form-control required">
						</div>
						<div class="input-group mt-2 mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">비밀번호<strong class="sr-only"> 필수</strong></span>
							</div>
							<input type="password" name="od_pwd" id="od_pwd" required class="form-control required">
						</div>
						<div class="btn_confirm">
							<button type="submit" class="btn btn-primary btn-block py-3">조회하기</button>
						</div>
					</form>
				</li>
			</ul>
			<p class="text-center px-3 mt-3">
				<a href="<?php echo G5_URL ?>">홈으로 돌아가기</a>
			</p>		
		</div>
    </section>
    <?php } ?>

<?php } ?>

<script>
function flogin_submit(f) {

    if( $( document.body ).triggerHandler( 'login_sumit', [f, 'flogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>
<!-- } 로그인 끝 -->

<?php
// 헤더, 테일 사용설정
if(!$tset['page_sub'])
	include_once(G5_THEME_PATH.'/tail.php');
?>