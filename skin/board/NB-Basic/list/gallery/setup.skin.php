<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록
?>

<ul class="list-group">
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">목록 헤드</label>
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
					<td class="text-center">헤드 라인 컬러</td>
					<td class="text-center">
						<select name="boset[head_color]" class="custom-select">
						<option value="">자동 컬러</option>
						<?php echo na_color_options($boset['head_color']);?>
						</select>
					</td>
					<td class="text-muted">
						목록 상단 라인 컬러
					</td>
					</tr>
					<tr>
					<td class="text-center">새글 표시 색상</td>
					<td class="text-center">
						<select name="boset[new]" class="custom-select">
							<option value="">자동 컬러</option>
							<?php echo na_color_options($boset['new']);?>
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

	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">이미지 설정</label>
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
					<td class="text-center">썸네일 너비</td>
					<td>
						<div class="input-group">
							<input type="text" name="boset[thumb_w]" value="<?php echo $boset['thumb_w'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">px</span>
							</div>
						</div>
					</td>
					<td class="text-muted">기본값 : 400 - 0 설정시 썸네일 생성 안 함</td>
					</tr>
					<tr>
					<td class="text-center">썸네일 높이</td>
					<td class="text-center">
						<div class="input-group">
							<input type="text" name="boset[thumb_h]" value="<?php echo $boset['thumb_h'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">px</span>
							</div>
						</div>
					</td>
					<td class="text-muted">기본값 : 225 - 0 설정시 이미지 비율대로 생성</td>
					</tr>
					<tr>
					<td class="text-center">기본 높이</td>
					<td>
						<div class="input-group">
							<input type="text" name="boset[thumb_d]" value="<?php echo $boset['thumb_d'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">%</span>
							</div>
						</div>
					</td>
					<td class="text-muted">기본값 : 56.25 - 썸네일 높이를 0으로 설정시 적용</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>

	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">이미지 가로수</label>
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
					<td class="text-center">기본 배치</td>
					<td>
						<div class="input-group">
							<input name="boset[xl]" value="<?php echo ($boset['xl']) ? $boset['xl'] : '4'; ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">개</span>
							</div>
						</div>
					</td>
					<td class="text-muted">Extra large screen / wide desktop</td>
					</tr>
					<tr>
					<td class="text-center">1200px 미만</td>
					<td>
						<div class="input-group">
							<input name="boset[lg]" value="<?php echo ($boset['lg']) ? $boset['lg'] : '4'; ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">개</span>
							</div>
						</div>
					</td>
					<td class="text-muted">Large screen / desktop</td>
					</tr>
					<tr>
					<td class="text-center">992px 미만</td>
					<td>
						<div class="input-group">
							<input name="boset[md]" value="<?php echo ($boset['md']) ? $boset['md'] : '4'; ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">개</span>
							</div>
						</div>
					</td>
					<td class="text-muted">Medium screen / tablet</td>
					</tr>
					<tr>
					<td class="text-center">768px 미만</td>
					<td>
						<div class="input-group">
							<input name="boset[sm]" value="<?php echo ($boset['sm']) ? $boset['sm'] : '3'; ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">개</span>
							</div>
						</div>
					</td>
					<td class="text-muted">Small screen / phone</td>
					</tr>
					<tr>
					<td class="text-center">576px 미만</td>
					<td>
						<div class="input-group">
							<input name="boset[xs]" value="<?php echo ($boset['xs']) ? $boset['xs'] : '2'; ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">개</span>
							</div>
						</div>
					</td>
					<td class="text-muted">Extra small screen / phone</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>

</ul>
