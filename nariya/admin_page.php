<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<form name="fnariya" id="fnariya" method="post" onsubmit="return fnariya_submit(this);">
	<input type="hidden" name="post_action" value="save" >
	<input type="hidden" name="token" value="" id="token">

	<section id="anc_na_basic">
		<h2 class="h2_frm">기본 설정</h2>

		<div class="tbl_frm01 tbl_wrap">
			<table>
			<colgroup>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">
					버전
				</th>
				<td colspan="3">
					<?php echo NA_VERSION ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					새글 DB
				</th>
				<td colspan="3">
					<?php echo help('기본환경설정의 최근글 삭제일 기준으로 새글 DB를 복구합니다.') ?>
					<button type="button" class="btn btn_03" onclick="na_upgrade('<?php echo NA_URL ?>/bbs/restore_new.php');">복구하기</button>
				</td>
			</tr>
			<tr>
				<th scope="row">
					최고관리자
				</th>
				<td colspan="3">
					<?php echo help('회원아이디를 콤마(,)로 구분하여 복수 회원 등록이 가능합니다.') ?>
					<input type="text" name="na[cf_admin]" value="<?php echo $nariya['cf_admin'] ?>" class="frm_input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					그룹관리자
				</th>
				<td colspan="3">
					<?php echo help('회원아이디를 콤마(,)로 구분하여 복수 회원 등록이 가능합니다.') ?>
					<input type="text" name="na[cf_group]" value="<?php echo $nariya['cf_group'] ?>" class="frm_input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					알림 설정
				</th>
				<td colspan="3">
					<?php echo help('/'.NA_DIR.'/skin/noti 폴더') ?>
					<select name="na[noti]">
						<option value="">사용안함</option>
						<?php 
						unset($skins);
						$skins = na_dir_list(NA_PATH.'/skin/noti');
						for ($i=0; $i<count($skins); $i++) { 
						?>
							<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($nariya['noti'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					알림 보관일
				</th>
				<td colspan="3">
					<?php echo help('설정일이 지난 알림 자동 삭제, 0 이면 사용안함') ?>
					<input type="text" name="na[noti_days]" value="<?php echo $nariya['noti_days'] ?>" class="frm_input" size="5"> 일
				</td>
			</tr>
			<tr>
				<th scope="row">
					문의 알림
				</th>
				<td colspan="3">
					<?php echo help('1:1 문의에 새글 등록시 알림받을 회원아이디 목록으로 콤마(,)로 구분하여 복수등록 가능합니다.') ?>
					<input type="text" name="na[noti_qa]" value="<?php echo $nariya['noti_qa'] ?>" class="frm_input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					공유 동영상 이미지
				</th>
				<td colspan="3">
					<?php echo help('유튜브, 비메오 등 동영상 썸네일용 대표이미지를 서버의 /data/'.NA_DIR.'/video 폴더 내에 저장합니다.') ?>
					<label>
						<input type="checkbox" name="na[save_video_img]" value="1"<?php echo get_checked('1', $nariya['save_video_img'])?>> 서버 저장
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					페이스북 토큰
				</th>
				<td colspan="3">
					<?php echo help('페북 동영상 썸네일을 가져오기 위해서는 페북 개발자센터에서 앱을 등록하고 Tools & Support > Graph API Explorer 메뉴에서 Get Token > Get App Token 실행 후 생성된 토큰을 등록해야 합니다.') ?>
					<input type="text" name="na[fb_key]" value="<?php echo $nariya['fb_key'] ?>" class="frm_input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					JWPlayer 6 라이센스 키
				</th>
				<td colspan="3">
					<?php echo help('JWPlayer6 라이센스키를 입력하면 상업적 이용 및 로고 삭제가 가능합니다.') ?>
					<input type="text" name="na[jw6_key]" value="<?php echo $nariya['jw6_key'] ?>" class="frm_input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					구글맵 API 키
				</th>
				<td colspan="3">
					<?php echo help('Google API Console에서 서버키(안되면 브라우저 API 키)를 발급받은 후 라이브러리에서 Google Maps JavaScript API를 사용설정해야 합니다.') ?>
					<input type="text" name="na[google_key]" value="<?php echo $nariya['google_key'] ?>" class="frm_input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					유튜브 API 키
				</th>
				<td colspan="3">
					<?php echo help('Google API Console에서 서버키(안되면 브라우저 API 키)를 발급받은 후 라이브러리에서 YouTube Data API를 사용설정해야 합니다.') ?>
					<input type="text" name="na[youtube_key]" value="<?php echo $nariya['youtube_key'] ?>" class="frm_input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					회원등급명
				</th>
				<td colspan="3">
					<?php echo help('회원 등급에 따른 이름으로 미설정시 출력되지 않습니다.') ?>

					<div class="tbl_head01 tbl_wrap">
						<table>
						<caption>회원등급명</caption>
						<thead>
						<tr>
							<th scope="col">구분</th>
							<th scope="col">1등급</th>
							<th scope="col">2등급</th>
							<th scope="col">3등급</th>
							<th scope="col">4등급</th>
							<th scope="col">5등급</th>
							<th scope="col">6등급</th>
							<th scope="col">7등급</th>
							<th scope="col">8등급</th>
							<th scope="col">9등급</th>
							<th scope="col">10등급</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								회원등급명
							</td>
							<td>
								<input type="text" name="na[mb_gn1]" value="<?php echo $nariya['mb_gn1'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn2]" value="<?php echo $nariya['mb_gn2'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn3]" value="<?php echo $nariya['mb_gn3'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn4]" value="<?php echo $nariya['mb_gn4'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn5]" value="<?php echo $nariya['mb_gn5'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn6]" value="<?php echo $nariya['mb_gn6'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn7]" value="<?php echo $nariya['mb_gn7'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn8]" value="<?php echo $nariya['mb_gn8'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn9]" value="<?php echo $nariya['mb_gn9'] ?>" class="frm_input">
							</td>
							<td>
								<input type="text" name="na[mb_gn10]" value="<?php echo $nariya['mb_gn10'] ?>" class="frm_input">
							</td>
						</tr>
						<tr>
							<td>예시</td>
							<td>비회원</td>
							<td>일반회원</td>
							<td>정회원</td>
							<td>VIP</td>
							<td>일반운영자</td>
							<td>그룹운영자</td>
							<td>통합운영자</td>
							<td>일반관리자</td>
							<td>중간관리자</td>
							<td>최고관리자</td>
						</tr>
						</tbody>
						</table>
				    </div>

				</td>
			</tr>
			</tbody>
			</table>
		</div>
	</section>

	<?php
		// 게시판 플러그인
		@include_once(NA_PATH.'/extend/bbs/admin.php');

		// 멤버십 플러그인
		@include_once(NA_PATH.'/extend/membership/admin.php');
	?>

	<div class="btn_fixed_top btn_confirm">
		<input type="submit" value="저장" class="btn_submit btn" accesskey="s">
	</div>
</form>


<script>
function na_upgrade(url) {
	$.post(url, function(data) {
		alert(data);
		return false;
	});
}
function fnariya_submit(f) {

    return true;

}
</script>