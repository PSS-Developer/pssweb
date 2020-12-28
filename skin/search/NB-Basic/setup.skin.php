<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
?>
<ul class="list-group">
	<li class="list-group-item">

		<div class="form-group form-row">
			<label class="col-sm-2 col-form-label">출력설정</label>
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
						<td class="text-center">
							목록 라인 색상
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
					</tbody>
					</table>
				</div>

			</div>
		</div>
	</li>
</ul>