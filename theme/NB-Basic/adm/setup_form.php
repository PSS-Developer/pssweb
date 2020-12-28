<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.NA_URL.'/css/modal.css">', 0);

// 저장버튼
$btn_submit = '<p class="btn-submit"><button type="submit" class="btn btn-block btn-primary en">Save</button></p>';

// 체크박스 아이디
$idn = 1;

// 모달 내 모달 체크
$is_modalw = ($mode == 'page') ? 1 : '';

// 저장폴더 권한 체크
if(!$is_preview)
	@include_once(NA_PATH.'/theme/save.inc.php');

// input의 name - co:공통, pc:PC용, mo:모바일용
// pc와 mo는 같은 배열키를 가져야 하고, co와는 같으면 안됨(같을 경우 덮어씀)

// 항목탭
na_script('sly');

?>

<style>
#fsetup .btn-submit {
	max-width:200px;
	margin:15px auto;
}
#fsetup ol {
	padding-left:20px;
	margin-bottom:0;
}
</style>

<nav id="tab_adm" class="sly-tab font-weight-normal mb-2">
	<h3 class="sr-only"><?php echo $board['bo_subject'] ?> 분류 목록</h3>
	<div class="px-3<?php echo ($mode == 'page') ? '' : ' px-sm-0';?>">
		<div class="d-flex">
			<div id="adm_cate_list" class="sly-wrap flex-grow-1">
				<ul id="adm_cate_ul" class="sly-list d-flex border-left-0 text-nowrap">
					<li class="active"><a class="py-2 px-3" href="javascript:;">바로가기</a></li>
					<?php if(!$is_preview) { //미리보기에서 제외 열기 ?>
						<li><a class="py-2 px-3 move-adm" href="#adm_seo">SEO</a></li>
						<li><a class="py-2 px-3 move-adm" href="#adm_basic">기본</a></li>
					<?php } ?>
					<li><a class="py-2 px-3 move-adm" href="#adm_layout">레이아웃</a></li>
					<li><a class="py-2 px-3 move-adm" href="#adm_style">스타일</a></li>
					<li><a class="py-2 px-3 move-adm" href="#adm_menu">메뉴</a></li>
					<?php if($mode != 'page') { //페이지 설정용 ?>
						<li><a class="py-2 px-3 move-adm" href="#adm_index">인덱스</a></li>
					<?php } ?>
					<li><a class="py-2 px-3 move-adm" href="#adm_page">페이지</a></li>
					<li><a class="py-2 px-3 move-adm" href="#adm_footer">풋터</a></li>
				</ul>
			</div>
			<div>
				<a href="javascript:;" class="sly-btn sly-prev ca-prev py-2 px-3">
					<i class="fa fa-angle-left" aria-hidden="true"></i>
					<span class="sr-only">이전 분류</span>
				</a>
			</div>
			<div>
				<a href="javascript:;" class="sly-btn sly-next ca-next py-2 px-3">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
					<span class="sr-only">다음 분류</span>
				</a>				
			</div>
		</div>
	</div>
	<hr/>
	<script>
		$(document).ready(function() {
			$('#tab_adm .sly-wrap').sly({
				horizontal: 1,
				itemNav: 'basic',
				smart: 1,
				mouseDragging: 1,
				touchDragging: 1,
				releaseSwing: 1,
				startAt: 0,
				speed: 300,
				prevPage: '#tab_adm .ca-prev',
				nextPage: '#tab_adm .ca-next'
			});

			// Sly Tab
			var cate_id = 'tab_adm';
			var cate_size = na_sly_size(cate_id);

			na_sly(cate_id, cate_size);

			$(window).resize(function(e) {
				na_sly(cate_id, cate_size);
			});

			$('.move-adm').on('click', function () {
				var move_id = this.href;
				var hash = move_id.hash;
				var parser = document.createElement('a');
 				parser.href = this.href;
				$('html, body').animate({ scrollTop: $(parser.hash).offset().top - 60 }, 500);
				return false;
			});
		});
	</script>
</nav>

<ul class="list-group f-de">

	<li class="list-group-item pt-0 border-top-0<?php echo $px_css ?>">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">초기화</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de pt-1 pb-0 float-left">
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" name="freset" value="1" class="custom-control-input" id="fresetCheck">
						<label class="custom-control-label only-label" for="fresetCheck"><span>모든 설정값을 초기화(삭제) 합니다.</span></label>
					</div>
				</p>
			</div>
		</div>
	</li>

<?php if(!$is_preview) { //미리보기에서 제외 열기 ?>

	<?php if($mode == 'page') { //페이지 설정용 ?>
		<li class="list-group-item<?php echo $px_css ?>">
			<div class="form-group row mb-0">
				<label class="col-sm-2 col-form-label">주의사항</label>
				<div class="col-sm-10">
					<p class="form-control-plaintext f-de">
						<strong>기본 설정과 다른 것만 설정해 주세요.</strong> 같은데 또 설정하면 기본 설정 변경시 페이지 설정도 다 변경해야 합니다.
					</p>
				</div>
			</div>
		</li>
	<?php } ?>

	<li id="adm_seo" class="list-group-item<?php echo $px_css ?>">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">SEO 설정</label>
			<div class="col-sm-10">
				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center">설정</th>
					</tr>
					<tr>
					<td class="text-center">
						SEO 사용
					</td>
					<td>
						<select name="co[seo]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['seo']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $pc['seo']) ?>>자동 SEO + 검색엔진 수집 허용</option>
							<option value="2"<?php echo get_selected('2', $pc['seo']) ?>>자동 SEO + 검색엔진 수집 금지</option>
						</select>
					</td>
					</tr>
					<tr>
					<td class="text-center">
						SEO 설명글
					</td>
					<td>
						<textarea name="co[seo_desc]" rows="3" class="form-control" placeholder="한글 기준 160자 이내 등록"><?php echo $pc['seo_desc'] ?></textarea>		
					</td>
					</tr>
					<tr>
					<td class="text-center">
						SEO 키워드
					</td>
					<td>
						<textarea name="co[seo_keys]" rows="3" class="form-control" placeholder="콤마(,)로 키워드 구분"><?php echo $pc['seo_keys'] ?></textarea>		
						<p class="form-control-plaintext f-de text-muted pb-0 mb-0">
							※ 미 설정시 내용에서 3글자 이상인 한글로 최대 20개까지 키워드 자동생성
						</p>
					</td>
					<tr>
					<td class="text-center">
						SEO 이미지
					</td>						
					<td>
						<div class="input-group">
							<input type="text" id="seo-img" class="form-control" name="co[seo_img]" value="<?php echo $pc['seo_img'] ?>" placeholder="http://...">
							<div class="input-group-append">
								<a href="<?php echo na_theme_href('image', 'seo', 'seo-img') ?>" class="btn btn-primary btn-setup">
									<i class="fa fa-search"></i>
								</a>
							</div>
						</div>
						<p class="form-control-plaintext f-sm text-muted pb-0 mb-0">
							글내용 또는 페이지에 이미지가 있으면 자동 생성
						</p>
					</td>
					</tr>
					</tbody>
					</table>
				</div>
				<p class="form-text f-de text-muted mb-0 pb-0">
					※ SEO 출력 항목 수정은 /nariya/theme/seo.php 파일에서 할 수 있습니다.
				</p>				
			</div>
		</div>
		<?php echo $btn_submit ?>
	</li>
	<li id="adm_basic" class="list-group-item<?php echo $px_css ?>">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">기본 설정</label>
			<div class="col-sm-10">
				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th colspan="2" class="text-center">설정</th>
					</tr>
					<?php if($mode == 'page') { //페이지 설정용 
						// 아이콘 선택기
						na_script('iconpicker');
					?>
						<tr>
						<td class="text-center">
							페이지 타이틀
						</td>
						<td colspan="2">
							<div class="input-group">
								<div class="input-group-prepend">
									<button id="page_icon" class="btn btn-secondary" data-placement="bottom" data-icon="<?php echo $pc['page_icon'] ?>" role="iconpicker" name="co[page_icon]"></button>
								</div>
								<input type="text" name="co[page_title]" value="<?php echo $pc['page_title'] ?>" class="form-control">
							</div>
							<script>
							$('#page_icon').iconpicker();
							</script>
						</td>
						</tr>
						<tr>
						<td class="text-center">
							페이지 설명글
						</td>
						<td colspan="2">
							<input type="text" name="co[page_desc]" value="<?php echo $pc['page_desc'] ?>" class="form-control">
						</td>
						</tr>
					<?php } else { ?>
						<tr>
						<td class="text-center">
							이미지 로고
						</td>
						<td colspan="2" class="text-center">
							<div class="input-group">
								<input type="text" id="theme-logo-img" class="form-control" name="co[logo_img]" value="<?php echo $pc['logo_img'] ?>" placeholder="http://...">
								<div class="input-group-append">
									<a href="<?php echo na_theme_href('image', 'logo', 'theme-logo-img') ?>" class="btn btn-primary btn-setup">
										<i class="fa fa-search"></i>
									</a>
								</div>
							</div>
						</td>
						</tr>
						<tr>
						<td class="text-center">
							텍스트 로고
						</td>
						<td colspan="2">
							<textarea name="co[logo_text]" rows="3" class="form-control" placeholder="text..."><?php echo $pc['logo_text'] ?></textarea>		
						</td>
						</tr>
						<tr>
						<td class="text-center">
							통계 캐시
						</td>
						<td class="nw-c2 text-center">
							<div class="input-group">
								<input type="text" class="form-control" name="co[stats]" value="<?php echo $pc['stats'] ?>">
								<div class="input-group-append">
									<span class="input-group-text">분</span>
								</div>
							</div>
						</td>
						<td class="text-muted">
							미 설정시 방문자 통계만 출력, 글/댓글 통계는 검색 가능한 게시판에 대해서만 체크함
						</td>
						</tr>
						<tr>
						<td class="text-center">
							알림 자동 체크
						</td>
						<td class="nw-c2 text-center">
							<div class="input-group">
								<input type="text" class="form-control" name="co[noti]" value="<?php echo $pc['noti'] ?>">
								<div class="input-group-append">
									<span class="input-group-text">초</span>
								</div>
							</div>
						</td>
						<td class="text-muted">
							0 설정시 알림 자동 체크를 하지 않으며, 최소 30초 이상으로 설정
						</td>
						</tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
				<?php if($mode != 'page') { //페이지 설정용 ?>
					<p class="form-control-plaintext f-de text-muted pb-0 mb-0">
						※ 알림 자동 체크 시간이 짧을 경우 서버에서 DDos 공격으로 오해 할 수 있습니다.
					</p>
				<?php } ?>
			</div>
		</div>
		<?php echo $btn_submit ?>
	</li>
<?php } //미리보기에서 제외 닫기 ?>

	<li id="adm_layout" class="list-group-item<?php echo $px_css ?>">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">레이아웃 설정</label>
			<div class="col-sm-10">

				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center nw-c2">PC 설정</th>
					<th class="text-center nw-c2">모바일 설정</th>
					<th class="text-center">비고</th>
					</tr>
					<?php if($mode == 'page') { //페이지 설정용 ?>
					<tr>
					<td class="text-center">
						헤드/테일 숨김
					</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="pc[page_sub]" value="1"<?php echo get_checked('1', $pc['page_sub'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="mo[page_sub]" value="1"<?php echo get_checked('1', $mo['page_sub'])?> class="custom-control-input" id="idCheck<?php echo $idn ?>">
							<label class="custom-control-label" for="idCheck<?php echo $idn; $idn++; ?>"></label>
						</div>
					</td>
					<td class="text-muted">
						테마의 헤드와 테일을 출력안함
					</td>
					</tr>
					<?php } ?>
					<tr>
					<td class="text-center">
						반응형
					</td>
					<td class="text-center">
						<select name="pc[no_res]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['no_res']) ?>>사용함</option>
							<option value="1"<?php echo get_selected('1', $pc['no_res']) ?>>사용안함</option>
						</select>
					</td>
					<td class="text-center">
						사용함
					</td>
					<td class="text-muted">
						모바일은 반응형 고정
					</td>
					</tr>
					<tr>
					<td class="text-center">
						레이아웃
					</td>
					<td class="text-center">
						<select name="pc[layout]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="w"<?php echo get_selected('w', $pc['layout']) ?>>와이드</option>
							<option value="ac"<?php echo get_selected('ac', $pc['layout']) ?>>박스 A</option>
							<option value="bc"<?php echo get_selected('bc', $pc['layout']) ?>>박스 B</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[layout]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="w"<?php echo get_selected('w', $mo['layout']) ?>>와이드</option>
							<option value="ac"<?php echo get_selected('ac', $mo['layout']) ?>>박스 A</option>
							<option value="bc"<?php echo get_selected('bc', $mo['layout']) ?>>박스 B</option>
						</select>
					</td>
					<td class="text-muted">
						사이트 기본 스타일
					</td>
					</tr>

					<tr>
					<td class="text-center">
						사이트 너비
					</td>
					<td>
						<div class="input-group">
							<input type="text" class="form-control" name="pc[size]" value="<?php echo $pc['size'] ?>">
							<div class="input-group-append">
								<span class="input-group-text">px</span>
							</div>
						</div>
					</td>
					<td>
						<div class="input-group">
							<input type="text" class="form-control" name="mo[size]" value="<?php echo $mo['size'] ?>">
							<div class="input-group-append">
								<span class="input-group-text">px</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						사이트 컨텐츠 영역 너비
					</td>
					</tr>
					<tr>
					<td class="text-center">
						배경 이미지
					</td>
					<td>
						<div class="input-group">
							<input type="text" id="pc_bg_img" class="form-control" name="pc[bg_img]" value="<?php echo $pc['bg_img'] ?>" placeholder="http://...">
							<div class="input-group-append">
								<a href="<?php echo na_theme_href('image', 'bg_img', 'pc_bg_img') ?>" class="btn btn-primary btn-setup">
									<i class="fa fa-search"></i>
								</a>
							</div>
						</div>
					</td>
					<td>
						<div class="input-group">
							<input type="text" id="mo_bg_img" class="form-control" name="mo[bg_img]" value="<?php echo $mo['bg_img'] ?>" placeholder="http://...">
							<div class="input-group-append">
								<a href="<?php echo na_theme_href('image', 'bg_img', 'mo_bg_img') ?>" class="btn btn-primary btn-setup">
									<i class="fa fa-search"></i>
								</a>
							</div>
						</div>
					</td>
					<td class="text-muted">
						페이지 설정에서 적용하지 않을 경우 none 이라고 입력
					</td>
					</tr>

					<tr>
					<td class="text-center">
						배경 포지션
					</td>
					<td class="text-center">
						<select name="pc[bg_pos]" class="custom-select">
							<?php echo $sel_option ?>
							<?php echo na_bg_options($pc['bg_pos']) ?>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[bg_pos]" class="custom-select">
							<?php echo $sel_option ?>
							<?php echo na_bg_options($mo['bg_pos']) ?>
						</select>
					</td>
					<td class="text-muted">
						사이트 배경 이미지 위치
					</td>
					</tr>
					<tr>
					<td class="text-center">
						좌우 날개
					</td>
					<td class="text-center">
						<select name="pc[wing]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['wing']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $pc['wing']) ?>>사용함</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[wing]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $mo['wing']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $mo['wing']) ?>>사용함</option>
						</select>
					</td>
					<td class="text-muted">
						사이트 좌우측 배너, 테마 내 _wing.php 파일
					</td>
					</tr>

					</tbody>
					</table>
				</div>				
			</div>
		</div>
		<?php echo $btn_submit ?>
	</li>

	<li id="adm_style" class="list-group-item<?php echo $px_css ?>">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">스타일 설정</label>
			<div class="col-sm-10">

				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center nw-c2">PC 설정</th>
					<th class="text-center nw-c2">모바일 설정</th>
					<th class="text-center">비고</th>
					</tr>
					<tr>
					<td class="text-center">
						폰트셋
					</td>
					<td>
						<select name="co[font]" class="custom-select">
							<?php echo $sel_option ?>
							<?php 
							unset($skins);
							$skins = na_file_list(G5_THEME_PATH.'/css/font', 'css');
							for ($i=0; $i<count($skins); $i++) { 
							?>
								<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($pc['font'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<select name="co[font_mo]" class="custom-select">
							<?php echo $sel_option ?>
							<?php 
							unset($skins);
							$skins = na_file_list(G5_THEME_PATH.'/css/font/mobile', 'css');
							for ($i=0; $i<count($skins); $i++) { 
							?>
								<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($pc['font_mo'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
							<?php } ?>
						</select>
					</td>
					<td class="text-muted">
						테마 내 /css/font 폴더 내 CSS 파일
					</td>
					</tr>
					<tr>
					<td class="text-center">
						컬러셋
					</td>
					<td>
						<select name="pc[color]" class="custom-select">
							<?php echo $sel_option ?>
							<?php 
							unset($skins);
							$skins = na_file_list(G5_THEME_PATH.'/css/color', 'css');
							for ($i=0; $i<count($skins); $i++) { 
							?>
								<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($pc['color'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<select name="mo[color]" class="custom-select">
							<?php echo $sel_option ?>
							<?php for ($i=0; $i<count($skins); $i++) { // $skins PC랑 같은 배열임 ?>
								<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($mo['color'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
							<?php } ?>
						</select>
					</td>
					<td class="text-muted">
						테마 내 /css/color 폴더 내 CSS 파일
					</td>
					</tr>

					<tr>
					<td class="text-center">
						박스 스타일
					</td>
					<td class="text-center">
						<select name="pc[style]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['style']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $pc['style']) ?>>사용함</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[style]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $mo['style']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $mo['style']) ?>>사용함</option>
						</select>
					</td>
					<td class="text-muted">
						입력폼, 버튼, 카드 등 테두리 스타일
					</td>
					</tr>
					
					<tr>
					<td class="text-center">
						위젯 라인
					</td>
					<td class="text-center">
						<select name="pc[line]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['line']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $pc['line']) ?>>사용함</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[line]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $mo['line']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $mo['line']) ?>>사용함</option>
						</select>
					</td>
					<td class="text-muted">
						리스트형 위젯에서 게시물간 구분선 출력
					</td>
					</tr>

					</tbody>
					</table>
				</div>				
			</div>
		</div>
		<?php echo $btn_submit ?>
	</li>

	<li id="adm_menu" class="list-group-item<?php echo $px_css ?>">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">메뉴 설정</label>
			<div class="col-sm-10">

				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center nw-c2">PC 설정</th>
					<th class="text-center nw-c2">모바일 설정</th>
					<th class="text-center">비고</th>
					</tr>

					<tr>
					<td class="text-center">
						메뉴 스타일
					</td>
					<td class="text-center">
						<select name="pc[menu]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="1"<?php echo get_selected('1', $pc['menu']) ?>>배분-일반</option>
							<option value="2"<?php echo get_selected('2', $pc['menu']) ?>>좌측형</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[menu]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="1"<?php echo get_selected('1', $mo['menu']) ?>>배분-일반</option>
							<option value="2"<?php echo get_selected('2', $mo['menu']) ?>>좌측형</option>
						</select>
					</td>
					<td class="text-muted">
						상단 주메뉴 스타일
					</td>
					</tr>

					<tr>
					<td class="text-center">
						서브 메뉴 너비
					</td>
					<td>
						<div class="input-group">
							<input type="text" class="form-control" name="pc[sub_w]" value="<?php echo $pc['sub_w'] ?>">
							<div class="input-group-append">
								<span class="input-group-text">px</span>
							</div>
						</div>
					</td>
					<td>
						<div class="input-group">
							<input type="text" class="form-control" name="mo[sub_w]" value="<?php echo $mo['sub_w'] ?>">
							<div class="input-group-append">
								<span class="input-group-text">px</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						서브 메뉴 너비로 배분-일반 스타일은 나눔 기능이 2차 서브 메뉴만 적용됨
					</td>
					</tr>

					<tr>
					<td class="text-center">
						서브 메뉴 출력
					</td>
					<td class="text-center">
						<select name="pc[sub_pc]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['sub_pc']) ?>>출력함</option>
							<option value="1"<?php echo get_selected('1', $pc['sub_pc']) ?>>출력안함</option>
						</select>
					</td>
					<td class="text-center">
						&nbsp;
					</td>
					<td class="text-muted">
						상단 주메뉴에서 서브 메뉴 출력여부 설정
					</td>
					</tr>

					<tr>
					<td class="text-center">
						메뉴 고정
					</td>
					<td class="text-center">
						<select name="pc[sticky]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['sticky']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $pc['sticky']) ?>>사용함</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[sticky]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $mo['sticky']) ?>>사용안함</option>
							<option value="1"<?php echo get_selected('1', $mo['sticky']) ?>>사용함</option>
						</select>
					</td>
					<td class="text-muted">
						상단 주메뉴 페이지 상단에 고정
					</td>
					</tr>

					</tbody>
					</table>
				</div>				
			</div>
		</div>
		<?php echo $btn_submit ?>
	</li>

	<?php if($mode != 'page') { //페이지 설정에서는 출력 안함 ?>
		<li id="adm_index" class="list-group-item<?php echo $px_css ?>">
			<div id="index_setup" class="form-group row mb-0">
				<label class="col-sm-2 col-form-label">인덱스 설정</label>
				<div class="col-sm-10">
					<div class="table-responsive">
						<table class="table table-bordered mb-0">
						<tbody>
						<tr class="bg-light">
						<th class="text-center nw-c1">구분</th>
						<th class="text-center nw-c2">PC 설정</th>
						<th class="text-center nw-c2">모바일 설정</th>
						<th class="text-center">비고</th>
						</tr>

						<tr>
						<td class="text-center">
							인덱스 파일
						</td>
						<td>
							<select name="pc[index]" class="custom-select">
								<?php echo $sel_option ?>
								<?php 
								unset($skins);
								$skins = na_file_list(G5_THEME_PATH.'/index', 'php');
								for ($i=0; $i<count($skins); $i++) { 
								?>
									<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($pc['index'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
								<?php } ?>
							</select>
						</td>
						<td>
							<select name="mo[index]" class="custom-select">
								<?php echo $sel_option ?>
								<?php for ($i=0; $i<count($skins); $i++) { // $skins PC랑 같은 배열임 ?>
									<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($mo['index'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
								<?php } ?>
							</select>
						</td>
						<td class="text-muted">
							테마 내 /index 폴더
						</td>
						</tr>

						</tbody>
						</table>
					</div>				
					<p class="form-text f-de text-muted mb-0 pb-0">
						※ 인덱스 파일 상단에 별도 설정 부분이 있을 수 있으며, 위젯의 타이틀과 링크 등은 인덱스 파일에서 직접 수정해야 합니다.
					</p>
				</div>
			</div>
			<?php echo $btn_submit ?>
		</li>
	<?php } ?>

	<li id="adm_page" class="list-group-item<?php echo $px_css ?>">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">페이지 설정</label>
			<div class="col-sm-10">
				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center nw-c2">PC 설정</th>
					<th class="text-center nw-c2">모바일 설정</th>
					<th class="text-center">비고</th>
					</tr>
					<tr>
					<td class="text-center">
						페이지 스타일
					</td>
					<td class="text-center">
						<select name="pc[pwide]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['pwide']) ?>>박스형</option>
							<option value="1"<?php echo get_selected('1', $pc['pwide']) ?>>와이드형</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[pwide]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $mo['pwide']) ?>>박스형</option>
							<option value="1"<?php echo get_selected('1', $mo['pwide']) ?>>와이드형</option>
						</select>
					</td>
					<td class="text-muted">
						&nbsp;
					</td>
					</tr>
					<tr>
					<td class="text-center">
						페이지 최대 너비
					</td>
					<td>
						<div class="input-group">
							<input type="text" class="form-control" name="pc[pmax]" value="<?php echo $pc['pmax'] ?>">
							<div class="input-group-append">
								<span class="input-group-text">px</span>
							</div>
						</div>
					</td>
					<td>
						<div class="input-group">
							<input type="text" class="form-control" name="mo[pmax]" value="<?php echo $mo['pmax'] ?>">
							<div class="input-group-append">
								<span class="input-group-text">px</span>
							</div>
						</div>
					</td>
					<td class="text-muted">
						와이드형 페이지 스타일에서 컨텐츠 영역 최대 너비
					</td>
					</tr>
					<tr>
					<td class="text-center">
						페이지 타이틀
					</td>
					<td class="text-center">
						<select name="pc[ptitle]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $pc['ptitle']) ?>>출력함</option>
							<option value="1"<?php echo get_selected('1', $pc['ptitle']) ?>>출력안함</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[ptitle]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="0"<?php echo get_selected('0', $mo['ptitle']) ?>>출력함</option>
							<option value="1"<?php echo get_selected('1', $mo['ptitle']) ?>>출력안함</option>
						</select>
					</td>
					<td class="text-muted">
						사이드 크기가 0일 때는 자동으로 출력안됨
					</td>
					</tr>
					<tr>
					<td class="text-center">
						사이드 크기
					</td>
					<td>
						<select name="pc[scol]" class="custom-select">
							<?php echo $sel_option ?>
							<?php echo na_cols_select($pc['scol']) ?>
						</select>
					</td>
					<td>
						<select name="mo[scol]" class="custom-select">
							<?php echo $sel_option ?>
							<?php echo na_cols_select($mo['scol']) ?>
						</select>
					</td>
					<td class="text-muted">
						그리드(Grid)의 칼럼(col) 크기로 0 설정시 사이드 없는 1단으로 출력
					</td>
					</tr>

					<tr>
					<td class="text-center">
						사이드 파일
					</td>
					<td>
						<select name="pc[sfile]" class="custom-select">
							<?php echo $sel_option ?>
							<?php 
							unset($skins);
							$skins = na_file_list(G5_THEME_PATH.'/side', 'php');
							for ($i=0; $i<count($skins); $i++) { 
							?>
								<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($pc['sfile'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<select name="mo[sfile]" class="custom-select">
							<?php echo $sel_option ?>
							<?php for ($i=0; $i<count($skins); $i++) { // $skins PC랑 같은 배열임 ?>
								<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($mo['sfile'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
							<?php } ?>
						</select>
					</td>
					<td class="text-muted">
						테마 내 /side 폴더
					</td>
					</tr>

					<tr>
					<td class="text-center">
						사이드 위치
					</td>
					<td>
						<select name="pc[sloc]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="right"<?php echo get_selected('right', $pc['sloc']) ?>>우측 사이드</option>
							<option value="left"<?php echo get_selected('left', $pc['sloc']) ?>>좌측 사이드</option>
						</select>
					</td>
					<td>
						<select name="mo[sloc]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="right"<?php echo get_selected('right', $mo['sloc']) ?>>우측 사이드</option>
							<option value="left"<?php echo get_selected('left', $mo['sloc']) ?>>좌측 사이드</option>
						</select>
					</td>
					<td class="text-muted">
						&nbsp;
					</td>
					</tr>
					</tbody>
					</table>
				</div>				
				<p class="form-text f-de text-muted mb-0 pb-0">
					※ 페이지에서 설정한 사이드는 인덱스 페이지에 영향을 주지 않습니다.
				</p>
			</div>
		</div>
		<?php echo $btn_submit ?>
	</li>

	<li id="adm_footer" class="list-group-item<?php echo $px_css ?> border-bottom-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">풋터 설정</label>
			<div class="col-sm-10">

				<div class="table-responsive">
					<table class="table table-bordered mb-0">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center nw-c2">PC 설정</th>
					<th class="text-center nw-c2">모바일 설정</th>
					<th class="text-center">비고</th>
					</tr>

					<tr>
					<td class="text-center">
						풋터 스타일
					</td>
					<td class="text-center">
						<select name="pc[ftstyle]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="box"<?php echo get_selected('box', $pc['ftstyle']) ?>>박스형</option>
							<option value="wide"<?php echo get_selected('wide', $pc['ftstyle']) ?>>와이드형</option>
						</select>
					</td>
					<td class="text-center">
						<select name="mo[ftstyle]" class="custom-select">
							<?php echo $sel_option ?>
							<option value="box"<?php echo get_selected('box', $mo['ftstyle']) ?>>박스형</option>
							<option value="wide"<?php echo get_selected('wide', $mo['ftstyle']) ?>>와이드형</option>
						</select>
					</td>
					<td class="text-muted">
						사이트 하단 풋터 스타일
					</td>
					</tr>

					</tbody>
					</table>
				</div>				
			</div>
		</div>
		<?php echo $btn_submit ?>
	</li>
</ul>
