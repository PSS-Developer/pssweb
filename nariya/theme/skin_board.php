<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록

?>
<ul class="list-group">
	<li class="list-group-item bg-light border-top-0">
		<b>기능 설정</b>
	</li>
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">추가 관리자</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="boset[bo_admin]" value="<?php echo $boset['bo_admin'] ?>">
				<p class="form-text text-muted">
					회원 아이디를 콤마(,)로 구분하여 복수 회원 등록 가능
				</p>
			</div>
		</div>
	</li>
	<?php if(IS_NA_NOTI) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-sm-2 col-form-label">새 글 알림</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="boset[noti_mb]" value="<?php echo $boset['noti_mb'] ?>">
					<p class="form-text text-muted">
						새글 알림을 받을 회원 아이디를 콤마(,)로 구분하여 복수 회원 등록 가능
					</p>
				</div>
			</div>
		</li>
	<?php } ?>
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">동영상 등</label>
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
						첨부 동영상 출력
					</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="boset[na_video_attach]" value="1"<?php echo get_checked('1', $boset['na_video_attach'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						동일 파일명의 이미지 첨부시 표지 이미지 자동 적용
					</td>
					</tr>
					<tr>
					<td class="text-center">
						링크 동영상 출력
					</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="boset[na_video_link]" value="1"<?php echo get_checked('1', $boset['na_video_link'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						관련 링크에 등록된 유튜브, 비메오 등 공유 주소
					</td>
					</tr>
					<tr>
					<td class="text-center">
						동영상 자동 실행
					</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="boset[na_autoplay]" value="1"<?php echo get_checked('1', $boset['na_autoplay'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						복수 출력시 문제될 수 있으며, 크롬 등 브라우저에 따라 안될 수 있음
					</td>
					</tr>
					<tr>
					<td class="text-center">
						SyntaxHighLighter
					</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="boset[na_code]" value="1"<?php echo get_checked('1', $boset['na_code'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						[code]...[/code]를 이용한 HTML, PHP 등 코드 등록
					</td>
					</tr>
					<tr>
					<td class="text-center">
						외부 이미지 저장
					</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="boset[na_save_image]" value="1"<?php echo get_checked('1', $boset['na_save_image'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						글 내용의 외부 이미지를 자동으로 서버에 저장
					</td>
					</tr>
					<?php if(IS_NA_NOTI) { ?>
						<tr>
						<td class="text-center">
							알림 사용안함
						</td>
						<td class="text-center">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="boset[noti_no]" value="1"<?php echo get_checked('1', $boset['noti_no'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
								<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
							</div>
						</td>
						<td class="text-muted">
							답글/댓글/추천 등 알림 기능 끄기
						</td>
						</tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">댓글 설정</label>
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
					<td class="text-center">댓글 페이징</td>
					<td>
						<div class="input-group">
							<input type="text" class="form-control" name="boset[na_crows]" value="<?php echo $boset['na_crows'] ?>">
							<div class="input-group-append">
								<div class="input-group-text">개</div>
							</div>
						</div>
					</td>
					<td class="text-muted">
						댓글 목록을 설정한 목록수로 페이징함
					</td>
					</tr>
					<tr>	
					<td class="text-center">댓글 목록</td>
					<td>
						<div class="input-group">
							<select name="boset[na_cob]" class="custom-select">
								<option value="old"<?php echo get_selected('old', $boset['na_cob']) ?>>과거순</option>
								<option value="new"<?php echo get_selected('new', $boset['na_cob']) ?>>최신순</option>
								<option value="good"<?php echo get_selected('good', $boset['na_cob']) ?>>추천순</option>
								<option value="nogood"<?php echo get_selected('nogood', $boset['na_cob']) ?>>비추천순</option>
							</select>
						</div>
					</td>
					<td class="text-muted">
						페이징 댓글 사용시에만 적용됨
					</td>
					</tr>
					<tr>
					<td class="text-center">럭키 점수</td>
					<td>
						<div class="input-group">
							<input type="text" class="form-control" name="boset[na_lucky_point]" value="<?php echo $boset['na_lucky_point'] ?>">
							<div class="input-group-append">
								<div class="input-group-text">점</div>
							</div>
						</div>
					</td>
					<td class="text-muted">
						댓글 럭키 점수 당첨시 최대 지급 점수
					</td>
					</tr>
					<tr>
					<td class="text-center">럭키 확률</td>
					<td>
						<input type="text" class="form-control" name="boset[na_lucky_dice]" value="<?php echo $boset['na_lucky_dice'] ?>">
					</td>
					<td class="text-muted">
						1/n의 n값으로 럭키 점수와 확률 모두 설정해야 작동함
					</td>
					</tr>
					<tr>
					<td class="text-center">댓글 추천</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="boset[na_cgood]" value="1"<?php echo get_checked('1', $boset['na_cgood'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						&nbsp;
					</td>
					</tr>
					<tr>
					<td class="text-center">댓글 비추천</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="boset[na_cnogood]" value="1"<?php echo get_checked('1', $boset['na_cnogood'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
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
			<label class="col-sm-2 col-form-label">추천 취소</label>
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
					<td class="text-center">가능 시간</td>
					<td class="text-center">
						<div class="input-group">
							<input type="text" class="form-control" name="boset[na_gcancel]" value="<?php echo $boset['na_gcancel'] ?>">
							<div class="input-group-append">
								<div class="input-group-text">초</div>
							</div>
						</div>
					</td>
					<td class="text-muted">
						추천 후 설정 시간 내 재추천시 취소 가능
					</td>
					</tr>
					<tr>
					<td class="text-center">취소 횟수</td>
					<td class="text-center">
						<div class="input-group">
							<input type="text" class="form-control" name="boset[na_gtimes]" value="<?php echo $boset['na_gtimes'] ?>">
							<div class="input-group-append">
								<div class="input-group-text">회</div>
							</div>
						</div>
					</td>
					<td class="text-muted">
						시간 내 횟수로 글/댓글 모두 동일하게 적용됨
					</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>
	<?php if(IS_NA_BBS) { // 게시판 플러그인 ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-sm-2 col-form-label">부가 기능</label>
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
						<td class="text-center">모바일 에디터</td>
						<td class="text-center">
							<select name="boset[editor_mo]" class="custom-select">
							<option value="">기본 설정</option>
							<?php
								$skinlist = na_dir_list(G5_EDITOR_PATH);
								for ($k=0; $k<count($skinlist); $k++) {
									echo '<option value="'.$skinlist[$k].'"'.get_selected($skinlist[$k], $boset['editor_mo']).'>'.$skinlist[$k].'</option>'.PHP_EOL;
								} 
							?>
							</select>
						</td>
						<td class="text-muted">
							모바일 기기에서 사용할 에디터
						</td>
						</tr>
						<tr>
						<td class="text-center">신고 기능</td>
						<td class="text-center">
							<div class="input-group">
								<input type="text" class="form-control" name="boset[na_shingo]" value="<?php echo $boset['na_shingo'] ?>">
								<div class="input-group-append">
									<div class="input-group-text">회</div>
								</div>
							</div>
						</td>
						<td class="text-muted">
							신고 횟수가 설정 횟수 이상일 때 비밀글로 잠금처리
						</td>
						</tr>
						<tr>
						<td class="text-center">태그 등록</td>
						<td class="text-center">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="boset[na_tag]" value="1"<?php echo get_checked('1', $boset['na_tag'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
								<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
							</div>
						</td>
						<td class="text-muted">
							글 등록시 태그 등록 가능
						</td>
						</tr>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</li>
	<?php } ?>
	<?php if(IS_NA_XP) { // 멤버십 플러그인 ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-sm-2 col-form-label">경험치 설정</label>
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
						<td class="text-center">글 쓰기</td>
						<td class="text-center">
							<div class="input-group">
								<input type="text" class="form-control" name="boset[xp_write]" value="<?php echo $boset['xp_write'] ?>">
								<div class="input-group-append">
									<div class="input-group-text">점</div>
								</div>
							</div>
						</td>
						<td class="text-muted">
							&nbsp;
						</td>
						</tr>
						<tr>
						<td class="text-center">댓글 쓰기</td>
						<td class="text-center">
							<div class="input-group">
								<input type="text" class="form-control" name="boset[xp_comment]" value="<?php echo $boset['xp_comment'] ?>">
								<div class="input-group-append">
									<div class="input-group-text">점</div>
								</div>
							</div>
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
	<?php } ?>
</ul>