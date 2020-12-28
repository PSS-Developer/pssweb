<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키], mo[배열키] 형태로 등록
// 기본은 wset[배열키], 모바일 설정은 mo[배열키] 형식을 가짐

?>
<script>
function view_youtube(id) {

	var vid = $('#' + id).val();

	if(vid == '') {

		alert('유튜브 동영상 아이디를 입력해 주세요.');

		$('#' + id).focus();

		return false;
	}

	window.open('https://youtu.be/' + vid);
}
</script>
<ul class="list-group">
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">유튜브 동영상</label>
			<div class="col-sm-10">
				<style>
					#widgetData.table { border-left:0; border-right:0; }
					#widgetData thead th { border-bottom:0; }
					#widgetData th,
					#widgetData td { vertical-align:middle; border-left:0; border-right:0; }
				</style>

				<p class="form-control-plaintext">
					<i class="fa fa-caret-right" aria-hidden="true"></i>
					동영상 아이디가 있는 것 중에서 1개를 랜덤 출력
				</p>

				<div class="table-responsive">
					<table id="widgetData" class="table table-bordered order-list mb-0">
					<thead>
					<tr class="bg-light">
						<th class="text-center nw-20">동영상 아이디</th>
						<th class="text-center nw-9">비율</th>
						<th class="text-center nw-11">이미지</th>
						<th class="text-center">대체 이미지</th>
						<th class="text-center nw-4">삭제</th>
					</tr>
					</thead>
					<tbody id="sortable">
					<?php 

					// 직접등록 입력폼 
					$data = array();
					$data_cnt = (is_array($wset['d']['vid'])) ? count($wset['d']['vid']) : 1;

					// 이미지 검색주소
					$img_search_href = na_theme_href('image', 'vid');

					for($i=0; $i < $data_cnt; $i++) {
						$n = $i + 1;
					?>
						<tr class="bg-light<?php echo ($i%2 != 0) ? '' : '-1';?>">
						<td>
							<div class="input-group">
								<input type="text" id="vid_<?php echo $n ?>" name="wset[d][vid][]" value="<?php echo $wset['d']['vid'][$i] ?>" class="form-control">
								<div class="input-group-append">
									<button type="button" onclick="view_youtube('vid_<?php echo $n ?>');" class="btn btn-primary">
										<i class="fa fa-youtube-play"></i>
									</button>
								</div>
							</div>
						</td>
						<td>
							<select id="rate_<?php echo $n ?>" name="wset[d][rate][]" class="form-control">
								<option value="">16:9</option>
								<option value="1"<?php echo get_selected('1', $wset['d']['rate'][$i])?>>4:3</option>
							</select>
						</td>
						<td>
							<select id="pv_<?php echo $n ?>" name="wset[d][pv][]" class="custom-select">
								<option value="hd"<?php echo get_selected('hd', $wset['d']['pv'][$i])?>>hd(default)</option>
								<option value="maxresdefault"<?php echo get_selected('maxresdefault', $wset['d']['pv'][$i])?>>max</option>
								<option value="high"<?php echo get_selected('high', $wset['d']['pv'][$i])?>>high</option>
								<option value="medium"<?php echo get_selected('medium', $wset['d']['pv'][$i])?>>medium</option>
								<option value="default"<?php echo get_selected('default', $wset['d']['pv'][$i])?>>default</option>
								<option value="thumb-default"<?php echo get_selected('thumb-default', $wset['d']['pv'][$i])?>>thumb-default</option>
								<option value="thumb-1"<?php echo get_selected('thumb-1', $wset['d']['pv'][$i])?>>thumb-1</option>
								<option value="thumb-2"<?php echo get_selected('thumb-2', $wset['d']['pv'][$i])?>>thumb-1</option>
								<option value="thumb-3"<?php echo get_selected('thumb-3', $wset['d']['pv'][$i])?>>thumb-1</option>
							</select>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="img_<?php echo $n ?>" name="wset[d][img][]" value="<?php echo $wset['d']['img'][$i] ?>" class="form-control" placeholder="http://...">
								<div class="input-group-append">
									<a href="<?php echo $img_search_href.'&amp;fid=img_'.$n; ?>" class="btn btn-primary btn-setup">
										<i class="fa fa-search"></i>
									</a>
								</div>
							</div>
						</td>
						<td class="text-center">
							<?php if($i > 0) { ?>
								<a href="javascript:;" class="ibtnDel"><i class="fa fa-times-circle fa-2x text-muted"></i></a>
							<?php } ?>
						</td>
						</tr>
					<?php } ?>
					</tbody>
					</table>
				</div>

				<div class="text-center mt-3">
					<button type="button" class="btn btn-outline-primary btn-lg en" id="addrow">
						<span class="white">Add Youtube</span>
					</button>
				</div>	
			</div>
		</div>
	</li>
</ul>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script> 
<script>
$(document).ready(function () {
	var counter = <?php echo $data_cnt + 1 ?>;
	$("#addrow").on("click", function () {
		var trbg = (counter%2 === 1) ? 'bg-light-1' : 'bg-light';
		var newRow = $("<tr class=" + trbg + ">");
		var cols = "";

		cols += '<td>';
		cols += '	<div class="input-group">';
		cols += '		<input type="text" id="vid_' + counter + '" name="wset[d][vid][]" value="" class="form-control">';
		cols += '			<div class="input-group-append">';
		cols += '				<button type="button" onclick="view_youtube(\'' + counter + '\');" class="btn btn-primary">';
		cols += '					<i class="fa fa-youtube-play"></i>';
		cols += '				</button>';
		cols += '			</div>';
		cols += '	</div>';
		cols += '</td>';
		cols += '<td>';
		cols += '	<select id="rate_' + counter + '" name="wset[d][rate][]" class="form-control">';
		cols += '		<option value="">16:9</option>';
		cols += '		<option value="1">4:3</option>';
		cols += '	</select>';
		cols += '</td>';
		cols += '<td>';
		cols += '	<select id="pv_' + counter + '" name="wset[d][pv][]" class="custom-select">';
		cols += '		<option value="hd">hd(default)</option>';
		cols += '		<option value="maxresdefault">max</option>';
		cols += '		<option value="high">high</option>';
		cols += '		<option value="medium">medium</option>';
		cols += '		<option value="default">default</option>';
		cols += '		<option value="thumb-default">thumb-default</option>';
		cols += '		<option value="thumb-1">thumb-1</option>';
		cols += '		<option value="thumb-2">thumb-1</option>';
		cols += '		<option value="thumb-3">thumb-1</option>';
		cols += '	</select>';
		cols += '</td>';
		cols += '<td>';
		cols += '	<div class="input-group">';
		cols += '		<input type="text" id="img_' + counter + '" name="wset[d][img][]" class="form-control" placeholder="http://...">';
		cols += '		<div class="input-group-append">';
		cols += '			<a href="<?php echo $img_search_href ?>&amp;fid=img_' + counter +'" class="btn btn-primary btn-setup">';
		cols += '				<i class="fa fa-search"></i></a></div>';
		cols += '			</a>';
		cols += '		</div>';
		cols += '	</div>';
		cols += '</td>';
		cols += '<td class="text-center">';
		cols += '	<a href="javascript:;" class="ibtnDel"><i class="fa fa-times-circle fa-2x text-muted"></i></a>';
		cols += '</td>';

		newRow.append(cols);
		$("table.order-list").append(newRow);
		counter++;
	});

	$("table.order-list").on("click", ".ibtnDel", function (event) {
		$(this).closest("tr").remove();
	});

	$("#sortable").sortable();
});
</script>
