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
			<label class="col-sm-2 col-form-label">사용환경</label>
			<div class="col-sm-10">
				<ol>
				<?php for($i=0; $i < count($limit); $i++) { ?>
					<li><?php echo $limit[$i] ?></li>
				<?php } ?>
				</ol>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">라이선스</label>
			<div class="col-sm-10">
				<ol>
				<?php for($i=0; $i < count($license); $i++) { ?>
					<li><?php echo $license[$i] ?></li>
				<?php } ?>
				</ol>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">주의사항</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					추가 게시판 스킨(NB-Basic 제외)과 플러그인(게시판 및 멤버십 플러그인)은 나리야빌더 기본 배포판에 포함되어 있지 않기 때문에 필요한 경우 아래 자료실에서 다운로드 받아서 설치 및 적용해 주셔야 합니다.
				</p>
				<div class="table-responsive mt-2 mb-2">
					<table class="table table-bordered mb-0" style="min-width:500px;">
					<tbody>
					<tr class="bg-light">
					<th class="text-center">자료실</th>
					<th class="text-center nw-c1">다운로드</th>
					</tr>
					<tr>
					<td>1. 게시판, 멤버십 플러그인</td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['download_na'] ?>" role="button" target="_blank">바로가기</a></td>
					</tr>
					<tr>
					<td>2. 무료 배포 자료실</td>
					<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['skin_na'] ?>" role="button" target="_blank">바로가기</a></td>
					</tr>
					<?php if(isset($gnu['free']) && !$gnu['free']) { ?>
						<tr>
						<td>3. 그누보드5 자료실</td>
						<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['skin_g5'] ?>" role="button" target="_blank">바로가기</a></td>
						</tr>
						<?php if($gnu['gnu'] == 'yc5') { ?>
							<tr>
							<td>4. 영카트5 자료실</td>
							<td><a class="btn btn-primary btn-block" href="<?php echo $gnu['skin_yc5'] ?>" role="button" target="_blank">바로가기</a></td>
							</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">테마 기능</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					테마의 레이아웃 및 스타일 등과 관련된 주요 설정 내용입니다.
					<?php if(IS_DEMO) { ?>
						(데모 사이트의 <b>테스트 메뉴</b>에서 체험가능)
					<?php } ?>
				</p>
				<ol>
					<li>사이트 레이아웃 및 스타일 설정</li>
					<li>다양한 메뉴 스타일 설정</li>
					<li>주메뉴 > 서브 1 > 서브 2의 3단계 메뉴 설정(메뉴는 최대 5단계까지 생성 가능)</li>
					<li>폰트셋 설정(돋움, 고딕, 넥슨고딕, 나눔고딕, 나눔바탕 등)</li>
					<li>컬러셋 설정</li>
					<li>PC 비반응형 설정</li>
					<li>페이지별 레이아웃 및 스타일 설정</li>
					<li>페이지별 자동 SEO 설정</li>
					<li>페이지별 사이드 메뉴 자동 생성 가능</li>
					<li>메뉴에 현재 페이지 위치 자동 표시 가능</li>
					<?php if(isset($gnu['free']) && !$gnu['free']) { ?>
						<li>3단 레이아웃 설정</li>
						<li>부분별 마스크 스타일 설정</li>
					<?php } ?>
					<li>위젯 기능</li>
					<li>캐시 기능 등</li>
				</ol>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">기본 기능</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					<?php echo $gnu['name'] ?>과 나리야빌더의 모든 기능이 사용가능합니다.
				</p>
				<ol>
					<li><?php echo $gnu['name'] ?> 기능 일체 사용 가능</li>
					<li>복수 관리자 설정</li>
					<li>글, 댓글 등 알림 설정</li>
					<li>회원 등급명 설정</li>
					<li>유튜브, 비메모 등 동영상 이미지 서버 저장 설정 가능 등</li>
				</ol>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">게시판 기능</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					게시판 스킨과 상관없이 모든 게시판에 적용되는 공통 기능입니다.
				</p>
				<ol>
					<li>게시판 글목록 스킨화</li>
					<li>게시판 스킨 추가 설정 기능</li>
					<li>복수 게시판 관리자 설정 가능</li>
					<li>새 게시물 알림 기능</li>
					<li>SyntaxHighLighter 지원</li>
					<li>외부이미지 서버 저장 가능</li>
					<li>댓글 페이징 설정 가능</li>
					<li>댓글 정렬 기능</li>
					<li>댓글 랜덤 럭키 포인트 설정 가능</li>
					<li>댓글 추천/비추천 설정 가능</li>
					<li>추천/비추천 취소 설정 가능</li>
					<li>유튜브, 비메오 등 동영상 자동 실행 가능</li>
					<li>첨부 동영상 자동 출력 또는 본문 삽입 가능</li>
					<li>이모티콘, FA아이콘, 지도 기능 지원</li>
					<li>게시물별 자동 SEO 생성 가능 등</li>
				</ol>
			</div>
		</div>
	</li>

	<li class="list-group-item px-3 px-sm-0">
		<div class="form-group row mb-0">
			<label class="col-sm-2 col-form-label">플러그인 기능</label>
			<div class="col-sm-10">
				<p class="form-control-plaintext f-de">
					각 플러그인을 설치 및 적용시 추가되는 기능입니다.
				</p>
				<div class="table-responsive mt-2 mb-2">
					<table class="table table-bordered mb-0" style="min-width:500px;">
					<tbody>
					<tr class="bg-light">
					<th class="text-center nw-c1">구분</th>
					<th class="text-center">주요 기능</th>
					<th class="text-center nw-c1">다운로드</th>
					</tr>
					<tr>
					<td class="text-center align-middle">게시판</td>
					<td>
						<ol>
							<li>게시판 기능 확장 (특수보드 사용 가능)</li>
							<li>게시판별 개별 에디터 설정</li>
							<li>태그 기능</li>
							<li>신고 기능 등</li>
						</ol>					
					</td>
					<td class="text-center align-middle">
						<a class="btn btn-primary btn-block" href="<?php echo $gnu['download_na'] ?>" role="button" target="_blank">다운로드</a>
					</td>
					</tr>
					<tr>
					<td class="text-center align-middle">멤버십</td>
					<td>
						<ol>
							<li>회원 기능 확장</li>
							<li>회원 레벨 기능</li>
							<li>경험치 기능 설정</li>
							<li>자동등업 설정 등</li>
						</ol>					
					</td>
					<td class="text-center align-middle">
						<a class="btn btn-primary btn-block" href="<?php echo $gnu['download_na'] ?>" role="button" target="_blank">다운로드</a>
					</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</li>
</ul>
<p class="f-de p-3 text-muted text-center">
	※ 그밖의 사항은 <a href="http://amina.co.kr" target="_blank">아미나(http://amina.co.kr)</a> 사이트를 참고해 주세요.
</p>

<p class="m-auto py-4" style="max-width:200px">
	<a href="<?php echo $gnu['buy'] ?>" target="_blank" class="btn btn-primary btn-block btn-lg en py-3">
		<?php echo (isset($gnu['free']) && !$gnu['free']) ? '테마 구입하기' : '테마 다운로드'; ?>
	</a>
</p>

</form>
