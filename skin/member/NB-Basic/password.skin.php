<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

@include_once(G5_THEME_PATH.'/head.php');

$delete_str = "";
if ($w == 'x') $delete_str = "댓";
if ($w == 'u') $g5['title'] = $delete_str."글 수정";
else if ($w == 'd' || $w == 'x') $g5['title'] = $delete_str."글 삭제";
else $g5['title'] = $g5['title'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<div id="mb_confirm" class="m-auto" style="max-width:400px">
	<div class="f-de px-3 my-5">
		<form name="fboardpassword" action="<?php echo $action; ?>" method="post">
		<input type="hidden" name="w" value="<?php echo $w ?>">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
		<input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<ul class="list-group mb-4">
			<li class="list-group-item bg-primary border-primary text-white">
				<h5 class="ellipsis"><?php echo $g5['title'] ?></h5>
			</li>
			<li class="list-group-item py-3">
				<?php if ($w == 'u') { ?>
					<p><strong>작성자만 글을 수정할 수 있습니다.</strong></p>
					<p>작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 수정할 수 있습니다.</p>
				<?php } else if ($w == 'd' || $w == 'x') {  ?>
					<p><strong>작성자만 글을 삭제할 수 있습니다.</strong></p>
					<p>작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 삭제할 수 있습니다.</p>
				<?php } else {  ?>
					<p><strong>비밀글 기능으로 보호된 글입니다.</strong></p>
					<p>작성자와 관리자만 열람하실 수 있습니다. 본인이라면 비밀번호를 입력하세요.</p>
				<?php }  ?>

				<div class="input-group mt-3 mb-0">
					<div class="input-group-prepend">
						<span class="input-group-text">비밀번호<strong class="sr-only"> 필수</strong></span>
					</div>
					<input type="password" name="wr_password" id="password_wr_password" required class="form-control required" maxLength="255">
					<div class="input-group-append">
						<button type="submit" id="btn_sumbit" class="btn btn-primary">확인</button>
					</div>
				</div>
			</li>
		</ul>

		<p class="text-center px-3">
			<a href="<?php echo G5_URL ?>">홈으로 돌아가기</a>
		</p>

		</form>
	</div>
</div>

<?php
// 헤더, 테일 사용설정
if(!$tset['page_sub'])
	include_once(G5_THEME_PATH.'/tail.php');
?>