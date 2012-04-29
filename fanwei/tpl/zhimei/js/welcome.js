var darenIndex = 1;
var shareTimer;
var autoTimer = null;
FANWE.INDEX_SHARE_WIDTH = 415;
var jsonUrl = SITE_PATH+"services/service.php?m=index&a=share&p=";
var isHasNextPage = true;
var DIVID = 0;
jQuery(function($){
	
	$('.rightbox').live('mouseover', function(){
		$(this).children(".pin").children(".modify").addClass("modifyhover");
		$(this).children(".pin").children(".modify").children(".actions").show();
	});
	
	$('.rightbox').live('mouseout', function(){
		$(this).children(".pin").children(".modify").removeClass("modifyhover");
		$(this).children(".pin").children(".modify").children(".actions").hide();
	});
	
	
	
	 $(window).resize(function() {
		 //updateDiv();
     });
	 
	$(window).scroll(function(){
		if($(this).scrollTop()>61){
			$('#header-2').addClass('topfixed');
		} 
		else 
		{
			$('#header-2').removeClass('topfixed');
		}
		
		if ($(document.documentElement).scrollTop() > 0 || $(document.body).scrollTop() > 0) {
            $("#backtotop").show();
            $("#backtotop").die().live("click",
            function() {
                $("body,html").animate({
                    scrollTop: 0
                },
                500)
            })
        } else {
            $("#backtotop").hide()
        }
		
		onscroll();
	});
});

function onscroll() {
    if (isHasNextPage) {
        scrollEvent();
    }
}

function scrollEvent() {
if (CURRENT_PAGE <= 10 ) {
    var f = $(document).scrollTop();
    var b = document.documentElement.clientHeight;
    var a = parseInt(f + b);
    var c = Math.min.apply(Math, colArray);
   
    var e = parseInt(c + $("#" + contentID).offset().top);
   
    if (a > e) 
        if (autoTimer !== null) {
            return
        }
    	autoTimer = setTimeout(function() {
    		CURRENT_PAGE = CURRENT_PAGE + 1;
    		loadShareData();
    		autoTimer = null
    },
    300)
    
    }
}

function UpdateUserFollow(obj,result)
{
	if(result.status == 1)
	{
		$(obj).before('<img src="'+ TPL_PATH +'images/best_follow_ok.gif" class="ufollow">');
		$(obj).remove();
	}
}

function loadShareData()
{	
	var query = new Object();
	if(CURRENT_PAGE == 1)
	{
		$("#firstload").show();
	}
	else
	{
		$("#imloading").show();	
	}
	var linkurl = jsonUrl + CURRENT_PAGE;
	$.ajax({ 
			url: linkurl,
			type:"POST",
			data:query,
			cache:true,
			dataType:'json',
			success:function(result){
				if(result.status == 1)
				{
					var list = result.list;
					var len = list.length;
					var xhtml = "";
					
					if(CURRENT_PAGE == 1)
					{
						$("#imloading").hide();
			            var heightArray = [];
			            w = document.documentElement.clientWidth - 17;
			            var h = document.documentElement.clientHeight;
			            
			            columns = Math.floor((w + marginLeft) / (divWidth + marginLeft));
			            freeLeft = 0;
			            columns = Math.max(columns, 4);
			            var contentWidth = columns * 236 - 14 + "px";
			            document.getElementById(contentID).style.width = contentWidth;
			            document.getElementById("topchannel").style.width = contentWidth;
			            document.getElementById("topsysmenu").style.width = contentWidth;
			            document.getElementById("footer-p").style.width = contentWidth;
			            for (var i = 0; i < columns; i++) {
				            heightArray[i] = 0
				        }
			            document.getElementById(contentID).style.height = Math.max.apply(Math, heightArray) + "px";
					}
					else
					{
						$("#firstload").hide();
						var w = document.documentElement.clientWidth;
				        columns = Math.floor((w + marginLeft) / (divWidth + marginLeft));
				        freeLeft = 0;
				        columns = Math.max(columns, 4);
				        var contentWidth = columns * 235 - 13 + "px";
				        document.getElementById(contentID).style.width = contentWidth;
				        var heightArray = colArray;
					}
					
					for(var i=0;i<len; i++)
					{
						var rows = Math.min.apply(Math, heightArray);
		                var cols = inArray(rows, heightArray);
		                var _le = freeLeft + divWidth * cols + marginLeft * (cols) + "px";
		                var _to = rows + "px";
						xhtml = initData(DIVID,list[i].share_id,list[i].share_url,list[i].share_img,list[i].content,list[i].relay_count,list[i].collect_count,list[i].u_url,list[i].avt,list[i].user_name,list[i].is_album,list[i].album_title,list[i].album_url,_le,_to);
						
						$("#content").append(xhtml);
						heightArray[cols] += (parseInt(document.getElementById(DIVID).offsetHeight) + marginTop);
						
						DIVID = DIVID + 1;
					}
					colArray = heightArray;
					document.getElementById("content").style.height = Math.max.apply(Math, heightArray) + "px";
					
					if($("#footer").css("display") == "none")
						$("#footer").show();
				}
				else
				{
					$("#footer").removeClass("fixedfooter").show();
					isHasNextPage = false;
					$("#imloading").hide();
					$("#imloading_none").show();
				}
			},
			error:function(){
				
			}
	});
}
function initData(DIVID,share_id,share_url,share_img,content,zf_count,xh_count,u_url,avt,user_name,is_album,album_title,album_url,_le,_to)
{
	var xhtml = "";
	var str1 = '';
	var str2 = '';
	var str3 = '';
	var str4 = '';
	var str5 = '';
	var str6 = '';
	var str7 = '';
	var str8 = '';
	var str9 = ''; 
	var str10 = '';
	var str11 = '';
	str1 = '<div id="'+DIVID+'" dataid="'+share_id+'" columns="'+DIVID+'" class="imBoard rightbox" style="left: '+_le+'; top: '+_to+'; "><div class="pin"><div class="modify"><div class="actions" style="display: none; ">';
	str2 = "<a href='javascript:;' class='button forward-btn png' onclick='$.Relay_Share("+share_id+");'>转发</a>";
    str3 = "<a href='"+share_url+"' class='button comment-btn png'>评论</a>";	
    str4 = "<a href='javascript:;' class='button favourite-btn png' onclick=$.Fav_Share("+share_id+",this,32,'#"+DIVID+"');>喜欢</a></div>"; 
    str5 = '<div class="show-img"><a href="'+share_url+'" target="_blank"><img class="picUrl" src="'+share_img+'" /></a></div>';   
    str6 = '<div class="title-sign"><p class="contentsms">'+content+'</p><p class="quantity" style="display:;"><span style="display:inline-block;"><span>转发</span><span class="reshareNum">'+zf_count+'</span></span>&nbsp;';  
    str7 = '<span style="display:inline-block;"><span class="pointsNum">·</span><span>喜欢</span><span class="likeNum">'+xh_count+'</span></span></p></div>';
    str8 = '<ul class="comentMain"><li class="hover cf"><div class="uhead" style="height:30px;"><a href="'+u_url+'"><img src="'+avt+'"><br /></a></div>';
    str9 = '<div class="uinfo"><p><a href="'+u_url+'" class="gray">'+user_name+'</a>';
	if(is_album == 1)
	{
		str10 = '分享到 <a href="'+album_url+'" class="gray">'+album_title+'</a>';
	}
    str11 = '</p></div></li></ul></div></div></div>'; 
    xhtml = str1+str2+str3+str4+str5+str6+str7+str8+str9+str10+str11;
	return xhtml;
}
function  inArray(a, b) {
    for (var c = 0,
    d = b.length; c < d; c++) if (b[c] === a) return c;

    return - 1
}
function updateDiv(){
    var q;
    var f = [];
    var g = document.documentElement.clientWidth - 17;
    var u = document.documentElement.clientHeight;
    var a = Math.max(Math.floor((g + marginLeft) / (divWidth + marginLeft)), 4);
    var o = 0;
    var l = a * 236 - 14 + "px";
    if (document.getElementById(contentID)) {
        document.getElementById(contentID).style.width = l
    }
    document.getElementById("topchannel").style.width = l;
    document.getElementById("topsysmenu").style.width = l;
    document.getElementById("footer-p").style.width = l;
    if (columnCount > a) {
        a = columnCount
    }
    for (var s = 0; s < a; s++) {
        f[s] = 0
    }
    
    q = getElements("content");
    for (var r = 0,
    t = q.length; r < t; r++) {
        var e = Math.min.apply(Math, f);
        var c = inArray(e, f);
        q[r].setAttribute("columns", c);
        q[r].style.left = o + divWidth * c + marginLeft * c + "px";
        q[r].style.top = e + "px";
        f[c] += (parseInt(q[r].offsetHeight) + marginTop); 
    }
    colArray = f;
    
    document.getElementById(contentID).style.height = Math.max.apply(Math, f) + "px"
}

function getElements(f) {
    var b;
    var a = document.getElementById(f).children;
    var d = [];
    for (var e = 0,
    c = a.length; e < c; e++) {
        if (a[e] != document.getElementById("leftLabel") && a[e] != document.getElementById("rightLabel1") && a[e] != document.getElementById("rightLabel2") && a[e] != document.getElementById("rightLabel3") && a[e] != document.getElementById("rightLabel4")) {
            d.push(a[e])
        }
    }
    b = d;
    return b
}



