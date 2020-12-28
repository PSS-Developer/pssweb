<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$is_admin) {
	if (G5_IS_MOBILE) {
		if($group['gr_device'] == 'pc')
			alert($group['gr_subject'].' 그룹은 PC에서만 접근할 수 있습니다.');
	} else {
		if($group['gr_device'] == 'mobile')
		    alert($group['gr_subject'].' 그룹은 모바일에서만 접근할 수 있습니다.');
	}
}

$g5['title'] = $group['gr_subject'];
include_once(G5_THEME_PATH.'/head.sub.php');

include_once(G5_THEME_PATH.'/_loader.php');

include_once(G5_THEME_PATH.'/head.php');

// layout 내 경로지정
$group_skin_path = G5_THEME_PATH.'/group';
$group_skin_url = G5_THEME_URL.'/group';
if(is_file($group_skin_path.'/'.$gr_id.'.php')) {
	include_once($group_skin_path.'/'.$gr_id.'.php');
	include_once(G5_THEME_PATH.'/tail.php');
	return;
}

// 칼럼
if($tset['pwide']) {
	$gr_row_cols = ($tset['scol']) ? 'row-cols-xl-3' : 'row-cols-lg-3 row-cols-xl-4';
} else {
	$gr_row_cols = ($tset['scol']) ? '' : 'row-cols-lg-3';
}

?>

<div class="mb-3 mb-sm-4 mt-n3 mt-sm-0">
	<?php echo na_widget('data-carousel', 'grt-'.$gr_id, 'xl=27%', 'auto=0'); //타이틀 ?>
</div>

<div class="row row-cols-1 row-cols-sm-2 <?php echo $gr_row_cols ?> na-row">
<?php 
// 보드추출
$bo_device = (G5_IS_MOBILE) ? 'pc' : 'mobile';
$sql = " select bo_table, bo_subject
            from {$g5['board_table']}
            where gr_id = '{$gr_id}'
              and bo_list_level <= '{$member['mb_level']}'
              and bo_device <> '{$bo_device}' ";
if(!$is_admin)
    $sql .= " and bo_use_cert = '' ";
$sql .= " order by bo_order ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
	<div class="col na-col">
		<!-- 위젯 시작 { -->
		<h3 class="h3 f-lg en">
			<a href="<?php echo get_pretty_url($row['bo_table']); ?>">
				<span class="pull-right more-plus"></span>
				<?php echo get_text($row['bo_subject']) ?>
			</a>
		</h3>
		<hr class="hr"/>
		<div class="mt-3 mb-4">
			<?php echo na_widget('wr-list', 'gr-'.$row['bo_table'], 'bo_list='.$row['bo_table'].' cache=5'); ?>
		</div>
	</div>
<?php } ?>
</div>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
