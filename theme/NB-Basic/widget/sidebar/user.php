<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가
?>

<div class="p-3">
	<div class="d-flex align-items-center">
		<div class="pr-3">
			<img src="<?php echo na_member_photo($member['mb_id']) ?>" class="rounded-circle">
		</div>
		<div class="flex-grow-1 pt-2">
			<h5 class="hide-photo mb-2">
				<b><?php echo str_replace('sv_member', 'sv_member en', $member['sideview']); ?></b>
			</h5>
			<p class="f-sm">
			<?php echo ($member['mb_grade']) ? $member['mb_grade'] : $member['mb_level'].'등급'; ?>
			<?php if ($is_admin == 'super' || $member['is_auth']) { ?>
				<span class="na-bar"></span>
				<a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
					관리자
				</a>
			<?php } ?>
			</p>
		</div>
	</div>

	<?php 
	// 멤버쉽 플러그인	
	if(IS_NA_XP) { 
		$per = (int)(($member['as_exp'] / $member['as_max']) * 100);
	?>
		<div class="clearfix f-sm mt-2">
			<span class="float-left">레벨 <?php echo $member['as_level'] ?></span>
			<span class="float-right">
				<a href="<?php echo G5_BBS_URL ?>/exp.php" target="_blank" class="win_point">
					Exp <?php echo number_format($member['as_exp']) ?>(<?php echo $per ?>%)
				</a>
			</span>
		</div>
		<div class="progress bg-white" title="레벨업까지 <?php echo number_format($member['as_max'] - $member['as_exp']);?> 경험치 필요">
			<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $per ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per ?>%">
				<span class="sr-only"><?php echo $per ?>%</span>
			</div>
		</div>
	<?php } ?>
</div>

<div class="sidebar-list pb-5">
	<ul class="me-ul border-top f-de font-weight-normal">
		<?php if($config['cf_use_point']) { ?>
			<li>
				<a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="win_point">
					포인트
					<b class="float-right orangered f-sm"><?php echo number_format($member['mb_point']) ?></b>
				</a>
			</li>
		<?php } ?>
		<li>
			<a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo">
				쪽지함
				<?php if ($member['mb_memo_cnt']) { ?> 
					<b class="float-right orangered f-sm"><?php echo number_format($member['mb_memo_cnt']) ?></b>
				<?php } ?>
			</a>
		</li>
		<?php if(IS_NA_NOTI) { // 알림 ?>
			<li>
				<a href="<?php echo G5_BBS_URL ?>/noti.php">
					알림관리
					<?php if ($member['as_noti']) { ?>
						<b class="float-right orangered f-sm"><?php echo number_format($member['as_noti']) ?></b>
					<?php } ?>
				</a>
			</li>
		<?php } ?>
		<li>
			<a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" class="win_scrap">
				스크랩함
			</a>
		</li>
		<li>
			<a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php">
				정보수정
			</a>
		</li>
		<li>
			<a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php">
				회원탈퇴
			</a>
		</li>
	</ul>
</div>