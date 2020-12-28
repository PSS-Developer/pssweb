<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 헤더,테일 사용안함
if(isset($tset['page_sub']) && $tset['page_sub']) {
	// 배경이미지
	if($tset['bg_img'] && $tset['bg_img'] != 'none')
		include_once(G5_THEME_PATH.'/_background.php');

	// 테마설정
	if ($is_admin == 'super' || IS_DEMO)
		include_once(NA_THEME_ADMIN_PATH.'/theme_admin_menu.php');

	include_once(G5_THEME_PATH.'/tail.sub.php');
	return;
}

?>
		<?php if(!$is_index) { ?>
			<?php if($tset['scol']) { ?>
					</div>
					<div class="col-md-<?php echo $tset['scol'] ?><?php echo ($tset['sloc'] == 'left') ? ' order-md-1' : '';?> na-col">
						<?php @include_once(G5_THEME_PATH.'/side/'.$tset['sfile'].'.php') ?>
					</div>
				</div>
			<?php } ?>
			</div><!-- .nt-container -->
		<?php } ?>
		</div><!-- .nt-body -->

		<footer id="nt_footer" class="f-sm font-weight-normal">
			<div class="<?php echo ($tset['ftstyle'] == 'wide') ? '' : 'nt-container'; ?> px-0 px-sm-4 px-xl-0">
				<nav class="nt-links clearfix py-2 border-top border-bottom">
					<div class="nt-container px-xl-0">
						<ul class="float-md-left d-none d-md-block">
							<li><a href="<?php echo get_pretty_url('content', 'company') ?>">사이트 소개</a></li> 
							<li><a href="<?php echo get_pretty_url('content', 'privacy') ?>">개인정보처리방침</a></li>
							<li><a href="<?php echo get_pretty_url('content', 'noemail') ?>">이메일 무단수집거부</a></li>
							<li><a href="<?php echo get_pretty_url('content', 'disclaimer') ?>">책임의 한계와 법적고지</a></li>
						</ul>
						<ul class="float-md-right text-center text-md-left">
							<li><a href="<?php echo get_pretty_url('content', 'provision') ?>">이용약관</a></li> 
							<li><a href="<?php echo get_pretty_url('content', 'guide') ?>">이용안내</a></li>
							<li><a href="<?php echo G5_BBS_URL ?>/qalist.php">문의하기</a></li>
							<li><a href="<?php echo get_device_change_url() ?>"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일'; ?>버전</a></li>
						</ul>
					</div>
				</nav>

				<div class="nt-container py-4 px-xl-0">
					<ul class="d-flex justify-content-center flex-wrap">
						<li class="px-3">
							<b><?php echo $default['de_admin_company_name'] ?></b>
						</li>
						<li class="px-3">
							대표 : <?php echo $default['de_admin_company_owner'] ?>
						</li>
						<li class="px-3">
							<?php echo $default['de_admin_company_addr'] ?>
						</li>
						<li class="px-3">
							전화 : <?php echo $default['de_admin_company_tel'] ?>
						</li>
						<li class="px-3">
							사업자등록번호 : <?php echo $default['de_admin_company_saupja_no'] ?>
						</li>
						<li class="px-3">
							<a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp" target="_blank">사업자정보확인</a>
						</li>
						<li class="px-3">
							통신판매업신고 : <?php echo $default['de_admin_tongsin_no'] ?>
						</li>
						<li class="px-3">
							개인정보관리책임자 : <?php echo $default['de_admin_info_name'] ?>
						</li>
						<li class="px-3">
							이메일 : <?php echo $default['de_admin_info_email'] ?>
						</li>
					</ul>
				</div>

				<div class="text-center px-3 pb-4">
					<strong><?php echo $config['cf_title'] ?> <i class="fa fa-copyright"></i></strong>
					<span>All rights reserved.</span>
				</div>

			</div>
		</footer>
	</div><!-- .wrapper -->
</div>

<?php
// 배경이미지
if($tset['bg_img'] && $tset['bg_img'] != 'none')
	include_once(G5_THEME_PATH.'/_background.php');

// 사이드바
echo na_widget('sidebar');

if ($config['cf_analytics'])
    echo $config['cf_analytics'];

?>
<!-- } 하단 끝 -->

<?php if(!G5_IS_MOBILE) { // PC에서만 실행 ?>
<script>
// 컨텐츠 영역 최소 높이
$(document).ready(function() {
	na_content_height('nt_body', 'nt_header', 'nt_footer');
	$(window).resize(function() {
		na_content_height('nt_body', 'nt_header', 'nt_footer');
	});
});
</script>
<?php } ?>

<!-- Nariya <?php echo NA_VERSION ?> -->

<?php
// 테마설정
if ($is_admin == 'super' || IS_DEMO)
	include_once(NA_THEME_ADMIN_PATH.'/theme_admin_menu.php');

include_once(G5_THEME_PATH.'/tail.sub.php');
?>