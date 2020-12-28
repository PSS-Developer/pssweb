// Nariya Menu
(function($) {
	$.fn.nariya_menu = function(e) {

		var subname = '.sub-slide';
		var submenu = $(this).find(subname).parent();

		submenu.each(function(e){

			var targetmenu = $(this).children(subname + ":eq(0)");

			$(this).hover(
				function(e){
					if (targetmenu.queue().length <= 1) {
						targetmenu.slideDown(300, 'swing');
					}
				},
				function(e){
					targetmenu.hide();
				}
			) //end hover

			$(this).click(function(){
				targetmenu.hide();
			})
		}); //end submenu.each()
	}
}(jQuery));

// Submit 할 때 폼속성 검사
function na_wrestSubmit(f) {
    wrestMsg = "";
    wrestFld = null;

    var attr = null;

    // 해당폼에 대한 요소의 개수만큼 돌려라
    for (var i=0; i<f.elements.length; i++) {
        var el = f.elements[i];

        // Input tag 의 type 이 text, file, password 일때만
        // 셀렉트 박스일때도 필수 선택 검사합니다. select-one
        if (el.type=="text" || el.type=="hidden" || el.type=="file" || el.type=="password" || el.type=="select-one" || el.type=="textarea") {
            if (el.getAttribute("required") != null) {
                wrestRequired(el);
            }

            if (el.getAttribute("minlength") != null) {
                wrestMinLength(el);
            }

            var array_css = el.className.split(" "); // class 를 공백으로 나눔

            el.style.backgroundColor = wrestFldDefaultColor;

            // 배열의 길이만큼 돌려라
            for (var k=0; k<array_css.length; k++) {
                var css = array_css[k];
                switch (css) {
                    case "required"     : wrestRequired(el); break;
                    case "trim"         : wrestTrim(el); break;
                    case "email"        : wrestEmail(el); break;
                    case "hangul"       : wrestHangul(el); break;
                    case "hangul2"      : wrestHangul2(el); break;
                    case "hangulalpha"  : wrestHangulAlpha(el); break;
                    case "hangulalnum"  : wrestHangulAlNum(el); break;
                    case "nospace"      : wrestNospace(el); break;
                    case "numeric"      : wrestNumeric(el); break;
                    case "alpha"        : wrestAlpha(el); break;
                    case "alnum"        : wrestAlNum(el); break;
                    case "alnum_"       : wrestAlNum_(el); break;
                    case "telnum"       : wrestTelNum(el); break; // 김선용 2006.3 - 전화번호 형식 검사
                    case "imgext"       : wrestImgExt(el); break;
                    default :
                        if (/^extension\=/.test(css)) {
                            wrestExtension(el, css); break;
                        }
                } // switch (css)
            } // for (k)
        } // if (el)
    } // for (i)

    // 필드가 null 이 아니라면 오류메세지 출력후 포커스를 해당 오류 필드로 옮김
    // 오류 필드는 배경색상을 바꾼다.
    if (wrestFld != null) {
        // 경고메세지 출력
        alert(wrestMsg);

        if (wrestFld.style.display != "none") {
            var id = wrestFld.getAttribute("id");

            // 오류메세지를 위한 element 추가
            var msg_el = document.createElement("strong");
            msg_el.id = "msg_"+id;
            msg_el.className = "msg_sound_only";
            msg_el.innerHTML = wrestMsg;
            wrestFld.parentNode.insertBefore(msg_el, wrestFld);

            var new_href = document.location.href.replace(/#msg.+$/, "")+"#msg_"+id;

            document.location.href = new_href;

            //wrestFld.style.backgroundColor = wrestFldBackColor;
            if (typeof(wrestFld.select) != "undefined")
                wrestFld.select();
            wrestFld.focus();
        }
        return false;
    }

    return true;
}

function na_win(id, url, width, height) {
	window.open(url, id, "width=" + width + ",height=" + height +",scrollbars=1");
	return false;
}

// iframe에서 모달창 닫기용
window.closeClipModal = function() {
	$('#clipModal').modal('hide');
}

function na_iframe(url) {

	$('#clipModal').on('show.bs.modal', function () {

		var iframe_height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

		$("#clipView").html('<iframe id="clipContent" src="' + url + '"></iframe>');
		$('#clipContent').height(parseInt(iframe_height * 0.85)); // 85%
	});

	$('#clipModal').modal('show');
}

function na_nav(id, target, css) {

	var nav = $("#" + id);
	var height = nav.height();

	if(height > 25) {
		$("#" + target).height(height);
		nav.addClass(css);
	}
}

function na_clip(id, clip) {

	var url = g5_url + '/nariya/theme/clip_' + id + '.php';

	if(clip) {
		url += '?clip=1';
	}

	na_iframe(url);
}

function na_setup(href, clip) {
	if(clip) {
		na_iframe(href);
	} else {
		na_win('setup', href, 800, 800);
	}
}

function na_page(id, url, opt) {

	$("#" + id).load(url, function() {
		if(typeof is_SyntaxHighlighter != 'undefined'){
			SyntaxHighlighter.highlight();
		}
	});

	if(typeof(window["comment_box"]) == "function"){
		switch(id) {
			case 'itemcomment'	: comment_box('', 'c'); break;
			case 'viewcomment'	: comment_box('', 'c'); break;
		}
		document.getElementById("btn_submit").disabled = false;
	}

	if(opt) {
	   $('html, body').animate({
			scrollTop: $("#" + id).offset().top - 60
		}, 500);
	}
}

function na_comment_new(id, url, count) {
	var href = url + '&count=' + count + '&cnew=1';
	$.post(href, function(data) {
		if(data) {
			alert(data);
			return false;
		} else {
			na_page(id, url);
		}
	});
}

function na_delete(id, href, url) {
	if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
		$.post(href, function(data) {
			if(data) {
				alert(data);
				return false;
			} else {
				na_page(id, url); 
			}
		});
	}
}

function na_comment(id) {
	var str;
	var c_url;
	if(id == 'viewcomment') {
		c_url = g5_url + '/nariya/bbs/comment_write.php';
	} else {
		c_url = g5_url + '/nariya/shop/itemcomment_write.php';
	}

	var f = document.getElementById("fviewcomment");
	var url = document.getElementById("comment_url").value;

	if(na_wrestSubmit(f)) {
		if (fviewcomment_submit(f)) {
			$.ajax({
				url : c_url,
				type : 'POST',
				cache : false,
				data : $("#fviewcomment").serialize(),
				dataType : "html",
				success : function(data) {
					if(data) {
						alert(data);
						return false;
					} else {
						if(url) {
							na_page(id, url);
						}
						document.getElementById("btn_submit").disabled = false;
						document.getElementById("wr_content").value = "";
						if(!g5_is_member) {
							$("#captcha_reload").trigger("click");
							$("#captcha_key").val('');
						}
					}
				},
				error : function(request,status,error){
					alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
					return false;
				}
			});
		}
	}
}

function na_comment_submit() {
	var f = document.getElementById("fviewcomment");
	if (na_wrestSubmit(f)) {
		if (fviewcomment_submit(f)) {
			$("#fviewcomment").submit();
			if(!g5_is_member) {
				$("#captcha_reload").trigger("click");
				$("#captcha_key").val('');
			}
		}
	}

	return false;
}

function na_comment_sort(id, url, sort) {
	var href = url + '&page=0&cob=' + sort;

	na_page(id, href);
}

function na_comment_onKeyDown(opt) {
	if(event.keyCode == 13) {
		if(opt) {
			na_comment('viewcomment');
		} else {
			na_comment_submit();
		}
	}
}

function na_good(bo_table, wr_id, act, id, opt) {

	var	href = g5_url + '/nariya/bbs/good.php?bo_table=' + bo_table + '&wr_id=' + wr_id + '&good=' + act;
	if(opt) {
		href += '&opt=1';
	}
	$.post(href, function(data) {
		if(data.error) {
			alert(data.error);
			return false;
		} else if(data.success) {
			alert(data.success);
			$("#"+id).text(number_format(String(data.count)));
		}
	}, "json");
}

function na_shingo(bo_table, wr_id, c_id) {

	var	href = g5_url + '/nariya/extend/bbs/shingo.php?bo_table=' + bo_table + '&wr_id=' + wr_id + '&c_id=' + c_id;

	if (confirm("한번 신고하면 취소할 수 없습니다.\n\n정말 신고하시겠습니까?")) {
		$.post(href, function(data) {
			if(data) {
				alert(data);
			}
		});
	}

	return false;
}

// SNS
function na_sns(id, url) {
	switch(id) {
		case 'facebook'		: window.open(url, "win_facebook", "menubar=0,resizable=1,width=600,height=400"); break;
		case 'twitter'		: window.open(url, "win_twitter", "menubar=0,resizable=1,width=600,height=400"); break;
		case 'googleplus'	: window.open(url, "win_googleplus", "menubar=0,resizable=1,width=600,height=600"); break;
		case 'naverband'	: window.open(url, "win_naverband", "menubar=0,resizable=1,width=410,height=540"); break;
		case 'naver'		: window.open(url, "win_naver", "menubar=0,resizable=1,width=450,height=540"); break;
		case 'kakaostory'	: window.open(url, "win_kakaostory", "menubar=0,resizable=1,width=500,height=500"); break;
		case 'tumblr'		: window.open(url, "win_tumblr", "menubar=0,resizable=1,width=540,height=600"); break;
		case 'pinterest'	: window.open(url, "win_pinterest", "menubar=0,resizable=1,width=800,height=500"); break;
	}
    return false;
}

function na_textarea(id, mode) {
	var textarea_height = $('#'+id).height();
	if(mode == 'down') {
		$('#'+id).height(textarea_height + 50);
	} else if(mode == 'up') {
		if(textarea_height - 50 > 50) {
			$('#'+id).height(textarea_height - 50);
		}
	} else {
		$('#'+id).height(mode);
	}
}

function na_sly_size(id) {
	var sly_list = $('#' + id + ' .sly-list'); 
	var sly_size = sly_list.width();
	
	sly_list.css('min-width', (sly_size + 10) + 'px');

	return sly_size;
}

function na_sly(id, size) {
	var sly_wrap = $('#' + id + ' .sly-wrap');
	var sly_size = sly_wrap.width() - 10;

	if(size > sly_size) {
		$('#' + id + ' .sly-btn').addClass('d-inline-block');
	} else {
		$('#' + id + ' .sly-btn').removeClass('d-inline-block');
	}

	sly_wrap.sly('reload');
}

function na_content_height(cid, hid, tid) {
	var hsize = 0;
	var tsize = 0;

	if(hid) {
		hsize = $('#'+hid).height();
	}

	if(tid) {
		tsize = $('#'+tid).height();
	}

	$('#'+cid).css('min-height', $(window).height() - hsize - tsize);
}

var na_leave = function(href) {
    if(confirm("정말 회원에서 탈퇴 하시겠습니까?")) {
        document.location.href = href;
	}
	return false;
}

$(function(){
	$(document).on('click', '.remember-me', function(){
		if($(this).is(":checked")) {
			if(!confirm("자동로그인을 사용하시면 다음부터 회원아이디와 패스워드를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?")) {
				$(this).attr("checked", false);
				return false;
			}
		}
    });

	$(document).on('click', '.leave-me', function(){
		na_leave(this.href);
		return false;
    });

	$(document).on('click', '.win_image', function(){
		na_win('win_image', this.href, 800, 800);
		return false;
    });
});
