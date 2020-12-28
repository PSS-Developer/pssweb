<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록

$boset['list_skin'] = ($boset['list_skin']) ? $boset['list_skin'] : 'basic';

?>
<script>
function na_change_skin(id, type, skin) {
	var url = "<?php echo NA_URL ?>/theme/skin_list.php?bo_table=<?php echo $bo_table ?>&type="+type+"&skin="+skin;
	$.get(url, function (data) {
		$("#"+id).html(data);
	});
}
</script>

<ul class="list-group">
	<li class="list-group-item bg-light border-bottom-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">목록 스킨</label>
			<div class="col-sm-3">
				<select name="boset[list_skin]" onchange="na_change_skin('list_skin', 'list', this.value);" class="custom-select">
				<?php
					$skinlist = na_dir_list($board_skin_path.'/list');
					$boset['list_skin'] = (is_dir($board_skin_path.'/list/'.$boset['list_skin'])) ? $boset['list_skin'] : $skinlist[0];
					for ($k=0; $k<count($skinlist); $k++) {
						echo '<option value="'.$skinlist[$k].'"'.get_selected($skinlist[$k], $boset['list_skin']).'>'.$skinlist[$k].'</option>'.PHP_EOL;
					} 
				?>
				</select>
			</div>
		</div>
	</li>
	<li class="list-group-item p-0 border-0">
		<div id="list_skin">
			<?php @include_once($board_skin_path.'/list/'.$boset['list_skin'].'/setup.skin.php');?>
		</div>
	</li>
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">출력 설정</label>
			<div class="col-sm-10">
				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
						<th class="text-center nw-c1">구분</th>
						<th class="text-center nw-c2">설정</th>
						<th class="text-center">비고</th>
					</tr>
					<tr>
					<td class="text-center">검색창 보이기</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="boset[search_open]" value="1"<?php echo get_checked('1', $boset['search_open'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						글 목록 상단에 검색창이 보이도록 출력함
					</td>
					</tr>
					<tr>
					<td class="text-center">목록 글 이동</td>
					<td class="text-center">
						<select name="boset[target]" class="custom-select">
							<?php echo na_target_options($boset['target']);?>
						</select>
					</td>
					<td class="text-muted">
						글 내용 또는 관련 링크1 페이지로 이동
					</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>
</ul>
