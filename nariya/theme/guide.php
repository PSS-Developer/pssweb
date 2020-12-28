<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 공통 배열
@include_once(NA_PATH.'/theme/_array.php');

// 코드 출력
na_script('code');
?>

<style>
	#fguide .list-group-item { padding-left:0; padding-right:0;	border-left:0 !important; border-right:0 !important; }
	#fguide ol { padding-left:20px; margin-bottom:0; }
</style>

<form id="fguide" class="f-de font-weight-normal pb-4">

<ul class="list-group f-de">
	<li class="list-group-item px-3 px-sm-0 border-top-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">설치 및 적용</label>
			<div class="col-sm-10">

				<p class="form-control-plaintext f-de">
					테마를 설치 및 적용하는 방법입니다.
				</p>

				<div class="table-responsive mt-2 mb-2">
					<table class="table table-bordered mb-0" style="min-width:500px;">
					<tbody>
					<tr class="bg-light">
					<th class="text-center">단계</th>
					<th class="text-center nw-c1">다운로드</th>
					<th class="text-center nw-c1">가이드</th>
					</tr>
					<tr>
					<td>1. <?php echo $gnu['name'] ?> 설치</td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['download'] ?>" role="button" target="_blank">다운로드</a></td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['install'] ?>" role="button" target="_blank">설치안내</a></td>
					</tr>
					<tr>
					<td>2. 나리야 빌더 설치</td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['download_na'] ?>" role="button" target="_blank">다운로드</a></td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['install_na'] ?>" role="button" target="_blank">설치안내</a></td>
					</tr>
					<tr>
					<td>3. 서버에 테마 설치</td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['buy'] ?>" role="button" target="_blank">다운로드</a></td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['guide'] ?>" role="button" target="_blank">설치안내</a></td>
					</tr>
					<tr>
					<td>4. 사이트에 테마 적용</td>
					<td>&nbsp;</td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['guide'] ?>" role="button" target="_blank">적용안내</a></td>
					</tr>
					<tr>
					<td>5. 게시판 스킨 등 추가 설치</td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['skin_na'] ?>" role="button" target="_blank">다운로드</a></td>
					<td>&nbsp;</td>
					</tr>
					<?php if(isset($gnu['free']) && !$gnu['free']) { ?>
						<tr>
						<td>6. 그누보드5 자료실</td>
						<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['skin_g5'] ?>" role="button" target="_blank">다운로드</a></td>
						<td>&nbsp;</td>
						</tr>
						<?php if($gnu['gnu'] == 'yc5') { ?>
							<tr>
							<td>7. 영카트5 자료실</td>
							<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['skin_yc5'] ?>" role="button" target="_blank">다운로드</a></td>
							<td>&nbsp;</td>
							</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
					</table>
				</div>
				<p class="form-control-plaintext f-de pb-0 mb-0">
					※ /theme 폴더를 반드시 쓰기 가능한 퍼미션(755 등)으로 변경해 주셔야 테마 설정값이 저장됩니다.
				</p>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">데이터 이전</label>
			<div class="col-sm-10">

				<p class="form-control-plaintext f-de">
					기존 사용 테마에서 /storage 폴더 내 자료 중에서 이전해 와야 하는 것은 다음과 같습니다.
				</p>

				<ol>
					<li>이전 테마 내 /storage 폴더 내 <b>menu-bbs-raw.php</b>, <b>menu-shop-raw.php</b> 처럼 사이트 메뉴 파일입니다.<br>해당 파일을 신규 테마의 /storage 폴더에 넣으면 메뉴설정에 그대로 노출되기 때문에 저장만 해 주면 됩니다.</li>
					<li>이전 테마의 /storage 폴더에서 메뉴 파일을 제외한 나머지 파일들을 가져오면 설정값이 이전 테마 것으로 초기 적용되기 때문에 오히려 작업하시는데 방해만 됩니다.</li>
					<li>이전 테마 내 /storage 폴더에 있는 <b>/board</b>, <b>/image</b>, <b>/skin</b>, <b>/addon</b> 폴더만 가져 옵니다.<br>board는 각 게시판의 스킨설정 파일이, image는 등록하신 이미지들, skin은 일반 페이지들의 스킨설정 파일, addon은 공용으로 적용하신 애드온의 설정 파일이기 때문에 이전해 오지 않으면 다시 재설정해 주셔야 합니다.</li>
					<li>그 외 /cache, /page, /widget 폴더는 가져오면 이전 테마 설정파일이기 때문에 작업하는데 방해만 됩니다.</li>
				</ol>

				<p class="form-control-plaintext f-de pb-0 mb-0">
					※ /storage 폴더의 자료 중 메뉴 파일과 스킨설정 관련 폴더(board, image, skin, addon)만 이전해 주세요.
				</p>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">기본 매뉴얼</label>
			<div class="col-sm-10">

				<p class="form-control-plaintext f-de">
					테마의 사용 및 수정 등과 관련된 기본 매뉴얼입니다.
				</p>

				<div class="table-responsive mt-2 mb-2">
					<table class="table table-bordered mb-0" style="min-width:500px;">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center nw-c1">매뉴얼</th>
					<th class="text-center">비고</th>
					</tr>
					<tr>
					<td class="text-center"><?php echo $gnu['name'] ?></td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['manual'] ?>" role="button" target="_blank">매뉴얼</a></td>
					<td>사이트의 기능 및 구조 등</td>
					</tr>
					<tr>
					<td class="text-center">Bootstrap 4</td>
					<td><a class="btn btn-primary btn-block" href="https://getbootstrap.com/docs/4.4/layout/overview/" role="button" target="_blank">매뉴얼</a></td>
					<td>테마의 마크업 등</td>
					</tr>
					<tr>
					<td class="text-center">Font Awesome 4</td>
					<td><a class="btn btn-primary btn-block" href="https://fontawesome.com/v4.7.0/icons/" role="button" target="_blank">매뉴얼</a></td>
					<td>웹폰트 아이콘</td>
					</tr>
					<tr>
					<td class="text-center">Ionicons</td>
					<td><a class="btn btn-primary btn-block" href="https://ionicons.com/v2/" role="button" target="_blank">매뉴얼</a></td>
					<td>웹폰트 아이콘</td>
					</tr>
					</tbody>
					</table>
				</div>

			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">스킨 적용</label>
			<div class="col-sm-10">

				<p class="form-control-plaintext f-de">
					테마 적용 후 기본 환경설정, 1:1문의설정, 게시판관리에서 각 스킨의 적용 방법입니다.
				</p>

				<div class="table-responsive mt-2 mb-2">
					<table class="table table-bordered mb-0" style="min-width:700px;">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center nw-c1">PC 스킨</th>
					<th class="text-center nw-c1">모바일 스킨</th>
					<th class="text-center">비고</th>
					</tr>
					<tr>
					<td class="text-center">최근게시물 스킨</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">PC-Skin</td>
					<td>새글모음 페이지</td>
					</tr>
					<tr>
					<td class="text-center">검색 스킨</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">PC-Skin</td>
					<td>전체검색 페이지</td>
					</tr>
					<tr>
					<td class="text-center">접속자 스킨</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">PC-Skin</td>
					<td>현재 접속자 페이지</td>
					</tr>
					<tr>
					<td class="text-center">FAQ 스킨</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">PC-Skin</td>
					<td>자주하는 질문 페이지</td>
					</tr>
					<tr>
					<td class="text-center">회원 스킨</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">PC-Skin</td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="text-center">각 게시판 스킨</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">PC-Skin</td>
					<td>게시판관리 > 게시판관리에서 설정</td>
					</tr>
					<tr>
					<td class="text-center">1:1문의 스킨</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">NB-Basic</td>
					<td>게시판관리 > 1:1문의설정에서 설정</td>
					</tr>
					</tbody>
					</table>
				</div>
				<p class="form-control-plaintext f-de text-muted pb-0 mb-0">
					※ 모바일 스킨을 PC-Skin 이외의 스킨으로 적용시 해당 스킨으로 적용됩니다.
				</p>

			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">문서 적용</label>
			<div class="col-sm-10">

				<p class="form-control-plaintext f-de">
					테마 적용 후 내용관리와 연계한 일반문서의 적용 방법입니다.
				</p>

				<ol>
					<li>게시판관리 > 내용관리에서 기존 등록 또는 신규 생성한 문서의 PC/모바일 스킨을 <b class="font-weight-bold">NB-Basic</b>으로 설정해 주세요.</li>
					<li>내용관리의 스킨이 <b class="font-weight-bold">NB-Basic</b>이 아닐 경우 테마 내 /page 폴더의 문서와 연동이 안될 수도 있습니다.</li>
					<li>내용관리 아이디(co_id)와 테마 내 /page 폴더의 php 파일명이 같으면 해당 php 파일이 출력됩니다.</li>
					<li>게시판관리 > 내용관리에서 다음 문서의 아이디(co_id)로 신규 등록해 주셔야 합니다.</li>
				</ol>

				<div class="table-responsive mt-2 mb-2">
					<table class="table table-bordered mb-0" style="min-width:600px !important;">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">내용관리 아이디</th>
					<th class="text-center">페이지명</th>
					<th class="text-center nw-c1">PC 스킨</th>
					<th class="text-center nw-c1">모바일 스킨</th>
					</tr>
					<tr>
					<td class="text-center">company</td>
					<td class="text-center">사이트 소개</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">NB-Basic</td>
					</tr>
					<tr>
					<td class="text-center">provision</td>
					<td class="text-center">이용약관</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">NB-Basic</td>
					</tr>
					<tr>
					<td class="text-center">privacy</td>
					<td class="text-center">개인정보처리방침</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">NB-Basic</td>
					</tr>
					<tr>
					<td class="text-center">noemail</td>
					<td class="text-center">이메일 무단수집거부</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">NB-Basic</td>
					</tr>
					<tr>
					<td class="text-center">disclaimer</td>
					<td class="text-center text-nowrap">책임의 한계와 법적책임</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">NB-Basic</td>
					</tr>
					<tr>
					<td class="text-center">guide</td>
					<td class="text-center">이용안내</td>
					<td class="text-center">NB-Basic</td>
					<td class="text-center">NB-Basic</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">메뉴 설정</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					테마 적용 후 사이트 좌측상단의 테마 설정(<i class="fa fa-desktop"></i> 아이콘)에서 할 수 있습니다.(환경설정 > 메뉴설정은 사용안함)
				</p>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">테마 설정</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					테마 적용 후 사이트 좌측상단의 테마 설정(<i class="fa fa-desktop"></i> 아이콘)에서 할 수 있습니다.
				</p>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">테마 수정</label>
			<div class="col-sm-10">

				<p class="form-control-plaintext f-de">
					<a data-toggle="collapse" href="#theme_edit" aria-expanded="false" aria-controls="theme_edit">
						테마의 인덱스, 사이드, 풋터 등에서 자신에게 맞도록 수정해야 합니다.
					</a>
				</p>

				<ol>
					<li>테마의 <b class="font-weight-bold">인덱스 파일</b>(테마 내 /index 폴더)에서 각 위젯의 타이틀 및 링크를 자신에게 맞도록 수정합니다.
<div class="pt-2 pb-3">
<pre class="brush:html,php">
&lt;!-- 위젯 시작 { -->
&lt;h3 class="h3 f-lg en">
	&lt;a href="&lt;?php echo get_pretty_url('video') ?>">
		&lt;span class="float-right more-plus"></span>
		게시판
	&lt;/a>
&lt;/h3>

1.게시판 아이디 변경 : get_pretty_url('video') 에서 video 대신 원하는 게시판 아이디(bo_table) 입력
2.제목 변경 : '게시판' 대신 원하는 제목 입력
3.링크 주소 변경 : &lt;?php echo get_pretty_url('video') ?> 대신 원하는 주소(url) 입력
</pre>
</div>
					</li>
					<li>테마의 <b class="font-weight-bold">사이드 파일</b>(테마 내 /side 폴더)에서 인덱스 파일과 같은 방법으로 각 위젯의 타이틀 및 링크를 자신에게 맞도록 수정합니다.</li>
					<li>테마의 <b class="font-weight-bold">풋터 파일</b>(테마 내 tail.php 파일)에서 사이트 및 사업자 정보 등을 자신에게 맞도록 수정합니다.</li>
					<li>테마의 회원약관 등 <b class="font-weight-bold">문서 파일</b>(테마 내 /page 폴더)에서 사이트 및 각종 정보 등을 자신에게 맞도록 수정합니다.</li>
					<li>테마의 PC/모바일 로고 등은 테마 설정(<i class="fa fa-desktop"></i> 아이콘)의 사이트 설정에서 등록하거나 테마 내 head.php 파일에서 직접 수정할 수 있습니다.</li>
				</ol>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">위젯 설정</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					테마 적용 후 사이트 좌측상단의 위젯 설정(<i class="fa fa-cube"></i> 아이콘) 클릭 후 각 위젯별로 노출되는 "위젯설정"에서 할 수 있습니다.
				</p>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">위젯 변경</label>
			<div class="col-sm-10">

				<p class="form-control-plaintext f-de">
					테마에서 리스트형 위젯을 갤러리형 위젯으로, 회원 위젯을 게시물 위젯 등으로 변경하는 방법입니다.
				</p>

				<ol>
					<li>위젯은 테마 내 /widget 폴더에 설치되어 있으며, 각 폴더명이 해당 위젯의 위젯명이 됩니다.</li>
					<li>위젯함수는 아래와 같이 각 구성되어 있으며, 첫번째 인자를 다른 위젯명(/widget 폴더 내 폴더명)으로 변경해 주면 위젯이 변경됩니다.
<div class="pt-2 pb-3">
<pre class="brush:html,php">
&lt;?php echo na_widget('위젯명', '임의설정값아이디', 'PC 초기값', '모바일 초기값') ?>

1.위젯명 : 테마 내 /widget 폴더 내 하위 폴더명
2.임의설정값아이디 : 위젯설정값이 저장될 아이디명으로 임의로 입력해 주면 됩니다. ex) board1234
3.PC 및 모바일 초기값은 설정하지 않아도 됩니다. ex) &lt;?php echo na_widget('wr-list', 'news') ?>
</pre>
</div>
					</li>
					<li>동일 내용의 위젯이 아닌 경우 임의설정값아이디를 다르게 설정해 줘야 각 위젯에 맞게 출력됩니다. (위젯설정 항목이 제대로 출력되지 않는다면 대부분 위젯의 임의설정값아이디가 중복되거나 다르게 적용받는 경우임)</li>
				</ol>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">그룹 메인</label>
			<div class="col-sm-10">
				<ol>
					<li>각 게시판그룹은 기본적으로 테마 내 group.php 파일이 그룹 메인으로 출력됩니다.</li>
					<li>그룹 아이디(gr_id)와 테마 내 /group 폴더의 php 파일명이 같으면 해당 파일이 해당 그룹의 메인으로 출력됩니다.</li>
				</ol>
			</div>
		</div>
	</li>
</ul>
<p class="f-de p-3 text-muted text-center">
	※ 그밖의 내용은 <a href="http://amina.co.kr" target="_blank">아미나(http://amina.co.kr)</a> 사이트의 활용팁이나 질답게시판을 이용해 주세요.
</p>
</form>
