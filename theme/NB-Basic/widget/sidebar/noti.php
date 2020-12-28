<?php
include_once("./_common.php");

if($is_guest)
	exit;

//안 읽은 알림
list($total_count, $list) = na_noti_list(15, '', 0, 'n', false); //15개 가져옴

$list = (is_array($list)) ? $list : array();
$list_cnt = count($list);
$noti_cnt = $member['as_noti'] + $member['mb_memo_cnt'];

?>
<div class="sidebar-list pb-5">
	<h5 class="clearfix f-de">
		알림
		<span class="nt-noti-label<?php echo ($noti_cnt) ? '' : ' d-none';?>">
			<b class="nt-noti-cnt orangered"><?php echo number_format($noti_cnt) ?></b>
		</span>
		<a href="<?php echo G5_BBS_URL ?>/noti.php" class="float-right f-sm font-weight-normal text-muted p-0">
			관리
		</a>
	</h5>
	<ul class="me-ul border-top f-sm font-weight-normal">
	<?php if($member['mb_memo_cnt']) { ?>
		<li>
			<a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo">
				<i class="fa fa-envelope-o" aria-hidden="true"></i>
				미확인 쪽지가 <b class="orangered"><?php echo number_format($member['mb_memo_cnt']) ?></b>통 있습니다.
			</a>
		</li>
	<?php } ?>
	<?php for($i=0; $i < $list_cnt; $i++) { ?>
		<li>
			<a href="<?php echo $list[$i]['href'] ?>">
				<?php echo $list[$i]['wtime'] ?>
				<span class="na-bar"></span>
				<?php echo $list[$i]['msg'] ?>
				<?php if($list[$i]['subject']) { ?>
					<span class="text-muted">
						<i class="fa fa-caret-right" aria-hidden="true"></i>
						<?php echo $list[$i]['subject'] ?>
					</span>
				<?php } ?>
			</a>
		</li>
	<?php } ?>
	<?php if(!$list_cnt) { ?>
		<li>
			<a href="<?php echo G5_BBS_URL ?>/noti.php">
				알림이 없습니다.
			</a>
		</li>
	<?php } ?>
	</ul>
</div>