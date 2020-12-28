<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록

?>
<ul class="list-group">
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">출력설정</label>
			<div class="col-sm-10">
				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
						<th class="text-center nw-c1">구분</th>
						<th class="text-center nw-c2">사용</th>
						<th class="text-center">비고</th>
					</tr>
					<tr>
						<td class="text-center">
							목록 헤더 색상
						</td>
						<td class="text-center">
							<select name="wset[head_color]" class="form-control">
								<option value="">자동 컬러</option>
								<?php echo na_color_options($wset['head_color']);?>
							</select>
						</td>
						<td class="text-muted">
							&nbsp;
						</td>
					</tr>
					<tr>
					<td class="text-center">검색창 보이기</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="wset[search_open]" value="1"<?php echo get_checked('1', $wset['search_open'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						목록 상단에 검색창이 보이도록 출력함
					</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>

</ul>

