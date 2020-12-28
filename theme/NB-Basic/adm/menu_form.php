<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    alert('접근권한이 없습니다.');
}

$mode = na_fid($mode);

if(!$mode)
    alert('값이 넘어오지 않았습니다.');

$g5['title'] = '메뉴 설정';
include_once('../head.sub.php');

// 페이지설정
$tset['page_title'] = '메뉴 설정';
$tset['page_desc'] = '사이트에서 사용할 메뉴를 설정합니다.';
$tset['side_lw'] = '0';
$tset['side_rw'] = '0';

// 1단
define('IS_ONECOLUMN', true);

include_once(G5_THEME_PATH.'/head.php');

// 아이콘 선택기
na_script('iconpicker');

// 테마 메뉴 불러오기(string)
$menu_json = na_file_var_load(G5_THEME_PATH.'/storage/menu-'.$mode.'-raw.php');
$menu_json = ($menu_json) ? stripslashes($menu_json) : '""';

// 저장폴더 권한 체크
@include_once(NA_PATH.'/theme/save.inc.php');

?>
<?php if(IS_DEMO) { ?>
	<div class="alert alert-warning" role="alert">
		본 페이지는 테마 적용 후 사이트 좌측상단의 테마 설정(<i class="fa fa-desktop"></i> 아이콘)에서 볼 수 있습니다.
	</div>
<?php } ?>

<section class="f-de font-weight-normal">
	<div class="row">
		<div class="col-sm-6">
			<ul class="list-group">
				<li class="list-group-item bg-primary text-white">작성 후 반드시 하단의 "<b class="font-weight-bold">Save</b>"을 누르셔야 저장됩니다.</li>
				<li class="list-group-item">서브 메뉴는 무한 생성이 가능하나 실제 출력은 <b class="font-weight-bold">2차</b>까지만 됩니다.</li>
			</ul>

			<div style="margin-top:-1px">
				<ul id="myEditor" class="sortableLists list-group"></ul>
			</div>

			<div class="form-group">
				<form id="fmenutree" name="fmenutree" method="post" action="./menu_update.php">
					<input type="hidden" name="mode" value="<?php echo $mode ?>">
					<div style="display:none;">	
						<textarea id="out" name="menu_json" class="form-control" cols="50" rows="10"></textarea>
					</div>
					<p class="text-center pt-3">
						<button type="button" id="btnSave" class="btn btn-primary btn-lg en">Save</button>
					</p>
				</form>
			</div>
		</div>
		<div class="col-sm-6">
			<form id="frmEdit">
				<ul class="list-group">
				<li class="list-group-item bg-primary text-white">메뉴 수정 후 반드시 "<b class="font-weight-bold">Update</b>"을 누르셔야 반영됩니다.</li>
				<li class="list-group-item">짧은 주소가 아닌 <b class="font-weight-bold">기존 파라메타 형태의 주소</b>를 입력해야 합니다.</li>
				<li class="list-group-item">
					<div class="form-group row mb-0">
						<label for="text" class="col-sm-2 col-form-label">메뉴</label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<button id="myEditor_icon" class="btn btn-secondary" data-placement="bottom" role="iconpicker"></button>
								</div>
								<input type="text" id="me_text" name="text" class="form-control item-menu" placeholder="메뉴명 입력">
							</div>
							<input type="hidden" id="me_icon" name="icon" class="item-menu">
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="form-group row mb-0">
						<label for="href" class="col-sm-2 col-form-label">링크</label>
						<div class="col-sm-10">
							<input type="text" id="me_href" name="href" class="form-control item-menu" placeholder="http://...">
							<p class="form-text f-sm text-muted mt-3">
								./로 시작하는 주소는 자동전환됨 ex) ./bbs/board.php?bo_table=
							</p>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="form-group row mb-0">
						<label for="target" class="col-sm-2 col-form-label">타켓</label>
						<div class="col-sm-10">
							<select id="me_target" name="target" class="custom-select item-menu">
								<option value="_self">Self</option>
								<option value="_blank">Blank</option>
								<option value="_top">Top</option>
							</select>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="form-group row mb-0">
						<label for="device" class="col-sm-2 col-form-label">기기</label>
						<div class="col-sm-10">
							<select id="me_device" name="device" class="custom-select item-menu">
								<option value="">모두</option>
								<option value="pc">PC</option>
								<option value="mo">모바일</option>
							</select>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="form-group row mb-0">
						<label for="line" class="col-sm-2 col-form-label">구분</label>
						<div class="col-sm-10">
							<input type="text" id="me_line" name="line" class="form-control item-menu" placeholder="메뉴 항목 구분 라인명 입력">
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="form-group row mb-0">
						<label for="line" class="col-sm-2 col-form-label">나눔</label>
						<div class="col-sm-10">
							<select id="me_sp" name="sp" class="custom-select item-menu">
								<option value="">미사용</option>
								<option value="1">사용</option>
							</select>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="form-group row mb-0">
						<label for="line" class="col-12 col-sm-2 col-form-label">보임</label>
						<div class="col-6 col-sm-5">
							<select id="me_limit" name="limit" class="custom-select item-menu">
								<option value="">모두 보임</option>
								<option value="1">지정 등급 이상 회원만</option>
							</select>
						</div>
						<div class="col-6 col-sm-5">
							<div class="input-group">
								<input type="text" id="me_grade" name="grade" class="form-control item-menu" value="0">
								<div class="input-group-append">
									<div class="input-group-text">등급</div>
								</div>
							</div>
						</div>
					</div>
				</li>
				</ul>
			</form>
			<div class="text-center pt-3">
				<button type="button" id="btnUpdate" class="btn btn-success en" disabled>
					<i class="fa fa-refresh" arial-hidden="true"></i> Update
				</button>
				<a id="btnSearch" href="<?php echo na_theme_href('menu') ?>" class="btn btn-info btn-setup en" role="button">
					<i class="fa fa-search" arial-hidden="true"></i> Search
				</a>
				<button type="button" id="btnAdd" class="btn btn-danger en">
					<i class="fa fa-plus" arial-hidden="true"></i> Add
				</button>
			</div>
		</div>
	</div>
</section>

<script src="<?php echo NA_THEME_ADMIN_URL ?>/jquery-menu-editor.js"></script>
<script>
	$(document).ready(function () {
		// menu items
		var strjson = <?php echo $menu_json;?>;

		//icon picker options
		var iconPickerOptions = {searchText: "Buscar...", labelHeader: "{0}/{1}"};
		
		//sortable list options
		var sortableListOptions = {
			placeholderCss: {'background-color': "#f5f5f5"}
		};

		var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions});
		editor.setForm($('#frmEdit'));
		editor.setUpdateButton($('#btnUpdate'));
		
		$('#btnSave').on('click', function () {
			var str = editor.getString();
			$("#out").text(str);
			$("#fmenutree").submit();
		});

		$('#btnUpdate').on('click', function () {
			var reg = /^javascript/; 
			if(reg.test($('#href').val())){ 
				alert('링크에 자바스크립트문을 입력할 수 없습니다.');
				$('#href').focus();
			} else {
				editor.update();
			}
		});

		$('#btnAdd').on('click', function () {
			var reg = /^javascript/; 
			if(reg.test($('#href').val())){ 
				alert('링크에 자바스크립트문을 입력할 수 없습니다.');
				$('#href').focus();
			} else {
				editor.add();
			}
		});
		
		// Menu Load
		editor.setData(strjson);
	});
</script>

<?php
include_once('../tail.php');
?>