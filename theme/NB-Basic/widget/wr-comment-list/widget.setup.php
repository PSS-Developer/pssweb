<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키], mo[배열키] 형태로 등록
// 기본은 wset[배열키], 모바일 설정은 mo[배열키] 형식을 가짐

// 아이콘 선택기
na_script('iconpicker');

?>

<ul class="list-group">
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
					<td class="text-center">캐시 설정</td>
					<td>
						<div class="input-group">
							<input type="text" name="wset[cache]" value="<?php echo $wset['cache'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">분</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						&nbsp;
					</td>
					</tr>
					<tr>
					<td class="text-center">새 글 표시</td>
					<td>
						<div class="input-group">
							<input type="text" name="wset[bo_new]" value="<?php echo $wset['bo_new'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">시</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						기본값 : 24시간 이내 등록 글
					</td>
					</tr>
					<tr>
					<td class="text-center">글 아이콘</td>
					<td class="text-center">
						<button id="wr_icon" type="button" class="btn btn-secondary" data-icon="<?php echo $wset['icon'] ?>" name="wset[icon]"></button>
						<script>
						$('#wr_icon').iconpicker();
						</script>
					</td>
					<td class="text-muted">
						랭크 표시 설정시 작동 안 함
					</td>
					</tr>
					<tr>
					<td class="text-center">보드/분류명</td>
					<td>
						<div class="input-group">
							<input type="text" name="wset[bo_name]" value="<?php echo $wset['bo_name'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">자</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						복수 추출시 보드명, 단일 게시판 출력시 분류명 출력 (0 설정시 자르지 않음, 미설정시 출력안함)
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
			<label class="col-sm-2 col-form-label">추출 대상</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext">
					<i class="fa fa-caret-right" aria-hidden="true"></i>
					콤마(,)로 구분해서 복수 등록 가능하며, 그룹 또는 복수 게시판 추출시 검색 가능한 게시판만 추출됨
				</p>
				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center nw-c2">제외 설정</th>
					<th class="text-center">대상 설정</th>
					</tr>
					
					<tr>
					<td class="text-center">게시판 그룹</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="wset[gr_except]" value="1"<?php echo get_checked('1', $wset['gr_except'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td>
						<input type="text" name="wset[gr_list]" value="<?php echo $wset['gr_list'] ?>" class="form-control" placeholder="그룹아이디(gr_id)">
					</td>
					</tr>
					<tr>
					<td class="text-center">게시판</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="wset[bo_except]" value="1"<?php echo get_checked('1', $wset['bo_except'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td>
						<input type="text" name="wset[bo_list]" value="<?php echo $wset['bo_list'] ?>" class="form-control" placeholder="게시판아이디(bo_table)">
					</td>
					</tr>
					<tr>
					<td class="text-center">글 분류</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="wset[ca_except]" value="1"<?php echo get_checked('1', $wset['ca_except'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td>
						<input type="text" name="wset[ca_list]" value="<?php echo $wset['ca_list'] ?>" class="form-control" placeholder="분류명(ca_name) - 단일게시판 추출시에만 작동함">
					</td>
					</tr>
					<tr>
					<td class="text-center">등록 회원</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="wset[mb_except]" value="1"<?php echo get_checked('1', $wset['mb_except'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td>
						<input type="text" name="wset[mb_list]" value="<?php echo $wset['mb_list'] ?>" class="form-control" placeholder="회원아이디(mb_id)">
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
			<label class="col-sm-2 col-form-label">추출 옵션</label>
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
					<td class="text-center">PC 목록수</td>
					<td>
						<div class="input-group">
							<input type="text" name="wset[rows]" value="<?php echo $wset['rows'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">개</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						&nbsp;
					</td>
					</tr>
					<tr>
					<td class="text-center">모바일 목록수</td>
					<td>
						<div class="input-group">
							<input type="text" name="mo[rows]" value="<?php echo $mo['rows'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">개</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						&nbsp;
					</td>
					</tr>
					<tr>
					<td class="text-center">추출 페이지</td>
					<td>
						<div class="input-group">
							<input type="text" name="wset[page]" value="<?php echo $wset['page'] ?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">쪽</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						추출 목록수 기준 페이지임
					</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>
</ul>
