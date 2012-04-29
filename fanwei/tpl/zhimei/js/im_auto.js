jQuery(function($){
	
	
});









/*var timer = null;
var autoLayout = {
    columnCount: 4,
    divWidth: 222,
    marginTop: 14,
    marginLeft: 14,
    colArray: [],
    freeLeft: 0,
    rightLoad: true,
    defaults: {
        contentID: "",
        rightLoad: true,
        leftID: null,
        rightID: null,
        linkUrl: "",
        noText: "",
        loadingID: "",
        callBack: null
    },
    numbers: 0,
    isHasNextPage: true,
    pageAuto: false,
    searchPage: false,
    loading: true,
    divId: 0,
    init: function(options, sta, dataObj) {
        var _jsonUrl, freeLeft, columns, w;
        if (typeof options == "object") {
            $("#footer").hide();
            if (document.getElementById("firstload")) {
                $("#imloading").css({
                    visibility: "hidden"
                });
                document.getElementById("firstload").style.display = "block"
            }

            $.extend(autoLayout.defaults, options);
            var opts = autoLayout.defaults;
            if (!opts.rightLoad) {
                autoLayout.rightLoad = false
            }
            w = document.documentElement.clientWidth - 17;

			
            var h = document.documentElement.clientHeight;
			
            var objDiv;
            var heightArray = [];
            columns = Math.floor((w + autoLayout.marginLeft) / (autoLayout.divWidth + autoLayout.marginLeft));
            freeLeft = 0;
            columns = Math.max(columns, 4);
            var contentWidth = columns * 236 - 14 + "px";
            document.getElementById(opts.contentID).style.width = contentWidth;
            document.getElementById("topchannel").style.width = contentWidth;
            document.getElementById("topsysmenu").style.width = contentWidth;
            document.getElementById("footer-p").style.width = contentWidth;
            if (autoLayout.pageAuto) {
                columns = Math.max(columns, 4);
                var _widthPage = autoLayout.divWidth * (columns - 1) + autoLayout.marginLeft * (columns - 1) - 17 + "px";
                if (!autoLayout.searchPage) {
                    $(".sheet").css({
                        marginLeft: freeLeft + "px",
                        width: _widthPage
                    })
                }
                document.getElementById("content").style.width = contentWidth;
                document.getElementById("topsysmenu").style.width = contentWidth;
                document.getElementById("topchannel").style.width = contentWidth;
                document.getElementById("footer-p").style.width = contentWidth
            }
			
            for (var i = 0; i < columns; i++) {
                heightArray[i] = 0
            }
            if (document.getElementById(opts.leftID)) {
                var leftBoard = document.getElementById(opts.leftID);
                leftBoard.style.display = "block";
                leftBoard.style.left = freeLeft + "px";
                leftBoard.style.top = heightArray[0] + "px";
                heightArray[0] = (leftBoard.offsetHeight + autoLayout.marginTop)
            }
            if (opts.rightID) {
                for (var le = 0,
                rightLen = opts.rightID.length; le < rightLen; le++) {
                    var rightBoard = document.getElementById(opts.rightID[le]);
                    rightBoard.style.display = "block";
                    rightBoard.style.left = freeLeft + autoLayout.divWidth * (columns - 1) + autoLayout.marginLeft * (columns - 1) + "px";
                    rightBoard.style.top = heightArray[columns - 1] + "px";
                    var marginTop;
                    if (rightBoard.style.marginTop) {
                        marginTop = parseInt(rightBoard.style.marginTop)
                    } else {
                        marginTop = 0
                    }
                    heightArray[columns - 1] += (rightBoard.offsetHeight + autoLayout.marginTop + marginTop)
                }
            }
            if (!autoLayout.rightLoad) {
                heightArray.splice(heightArray.length - 1, 1)
            }
            document.getElementById(autoLayout.defaults.contentID).style.height = Math.max.apply(Math, heightArray) + "px";
            _jsonUrl = opts.linkUrl
        } else {
            w = document.documentElement.clientWidth;
            columns = Math.floor((w + autoLayout.marginLeft) / (autoLayout.divWidth + autoLayout.marginLeft));
            freeLeft = 0;
            columns = Math.max(columns, 4);
            var contentWidth = columns * 235 - 13 + "px";
            document.getElementById(autoLayout.defaults.contentID).style.width = contentWidth;
            var heightArray = autoLayout.colArray;
            _jsonUrl = options;
            $("#imloading").css({
                visibility: ""
            })
        }
		
        if (!sta) {
            $.ajax({
                type: "GET",
                url: _jsonUrl,
                dataType: "json",
                async: true,
                success: function(json) {
                    $("#imloading").css({
                        visibility: ""
                    });
                    initContent(json)
                }
            })
        } else {
            initContent(dataObj)
        }
        function initContent(json) {
            autoLayout.loading = false;
            var _jsonMain = eval(json);
            var picBoard = _jsonMain.result;
            if (picBoard.length == 0) {
                $("#" + autoLayout.defaults.noText).show()
            } else {
                $("#" + autoLayout.defaults.noText).hide()
            }
            if (picBoard.length == 0) {
                $("#imloading").css({
                    visibility: "hidden"
                });
                if (autoLayout.defaults.callBack) {
                    autoLayout.defaults.callBack()
                }
                $("#footer").remove("fixedfooter").show();
                autoLayout.isHasNextPage = false;
                if (document.getElementById("firstload")) {
                    document.getElementById("firstload").style.display = "none"
                }
                return
            }
            for (var j = 0,
            len = picBoard.length; j < len; j++) {
                var picWidth = _getWidth(picBoard[j].mediumZoom);
                var picHeight = _getHeight(picBoard[j].mediumZoom);
                var bestContent = "";
                var comentContent = "";
                var shareContent = "";
                var likeDefaultContent, isAndLike;
                if (picBoard[j].newComment.length > 0) {
                    comentContent = _getComment(picBoard[j].newComment)
                }
                picBoard[j].likeStatus ? likeDefaultContent = '<a  to="' + picBoard[j].id + '" class="button favourite-btn unfavourite-btn">取消</a>': likeDefaultContent = '<a  to="' + picBoard[j].id + '" class="button favourite-btn png">喜欢</a>';
                picBoard[j].isMe || picBoard[j].isBoardOwner ? isAndLike = '<a  to="' + picBoard[j].id + '" class="button edit-btn png">编辑</a>': isAndLike = likeDefaultContent;
                if (picBoard[j].isOriginal) {
                    shareContent = ['<li class="hover cf"><div class="uhead" style="height:30px;"><a href="/profile/' + picBoard[j].userId + '"><img src="' + uri("IMAGE", picBoard[j].avatarTiny) + '" /></a></div>', '<div class="uinfo"><p><a href="/profile/' + picBoard[j].userId + '" class="gray">' + picBoard[j].nickName + '</a> 分享到 <a href="/board/' + picBoard[j].userId + "/" + picBoard[j].boardId + '" class="gray">' + picBoard[j].boardName + "</a></p></div></li>"].join("")
                } else {
                    shareContent = ['<li class="hover cf"><div class="uhead" style="height:30px;"><a href="/profile/' + picBoard[j].userId + '"><img src="' + uri("IMAGE", picBoard[j].avatarTiny) + '" /></a></div>', '<div class="uinfo"><p><a href="/profile/' + picBoard[j].userId + '" class="gray">' + picBoard[j].nickName + '</a> 转发到 <a href="/board/' + picBoard[j].userId + "/" + picBoard[j].boardId + '" class="gray">' + picBoard[j].boardName + "</a></p></div></li>"].join("")
                }
                var ikes, _reshare, _comment;
                parseInt(picBoard[j].reshareCount) == 0 ? _reshare = '<span style="display:none;"><span>转发</span><span class="reshareNum" >0</span></span>': _reshare = '<span style="display:inline-block;"><span>转发</span><span class="reshareNum">' + picBoard[j].reshareCount + "</span></span>";
                parseInt(picBoard[j].commentCount) == 0 ? _comment = '<span style="display:none;"><span class="pointsNum">·</span><span>评论</span><span class="commentNum">0</span></span>': _comment = '<span style="display:inline-block;"><span class="pointsNum">·</span><span>评论</span><span class="commentNum">' + picBoard[j].commentCount + "</span></span>";
                parseInt(picBoard[j].likeCount) == 0 ? _likes = '<span style="display:none;"><span class="pointsNum">·</span><span>喜欢</span><span class="likeNum" >0</span></span>': _likes = '<span style="display:inline-block;"><span class="pointsNum">·</span><span>喜欢</span><span class="likeNum">' + picBoard[j].likeCount + "</span></span>";
                var dis = "";
                if (parseInt(picBoard[j].reshareCount) == 0 && parseInt(picBoard[j].commentCount) == 0 && parseInt(picBoard[j].likeCount) == 0) {
                    dis = "none"
                }
                var rows = Math.min.apply(Math, heightArray);
                var cols = $.inArray(rows, heightArray);
                var _le = freeLeft + autoLayout.divWidth * cols + autoLayout.marginLeft * (cols) + "px";
                var _to = rows + "px";
                
                autoLayout.numbers++;
				alert(parseInt(document.getElementById(autoLayout.divId).offsetHeight));
                heightArray[cols] += (parseInt(document.getElementById(autoLayout.divId).offsetHeight) + autoLayout.marginTop);
                var _thisBoard = $(document.getElementById(autoLayout.divId));
                if (_thisBoard.find(".commentNum").text() > 0) {
                    if (_thisBoard.find(".commentNum").parent().prev().css("display") == "none") {
                        _thisBoard.find(".commentNum").siblings(".pointsNum").hide()
                    }
                }
                if (_thisBoard.find(".likeNum").text() > 0) {
                    if (_thisBoard.find(".likeNum").parent().prev().css("display") == "none" && _thisBoard.find(".likeNum").parent().prev().prev().css("display") == "none") {
                        _thisBoard.find(".likeNum").siblings(".pointsNum").hide()
                    }
                }
                _thisBoard.hover(function() {
                    $(this).find(".modify").addClass("modifyhover");
                    $(this).find(".actions").show();
                    $(this).find(".comentMain").find(".uinfo").find("a").removeClass().addClass("blue")
                },
                function() {
                    $(this).find(".modify").removeClass("modifyhover");
                    $(this).find(".actions").hide();
                    $(this).find(".uinfo").find("a").removeClass().addClass("gray")
                });
                autoLayout.divId++
            }
            $("#imloading").css({
                visibility: "hidden"
            });
            if (!_jsonMain.hasNextPage) {
                autoLayout.isHasNextPage = false;
                $("#imloading").css({
                    visibility: ""
                }).find("div").removeClass("loading").addClass("notmore").text("没有更多内容了")
            }
            autoLayout.colArray = heightArray;
            document.getElementById(autoLayout.defaults.contentID).style.height = Math.max.apply(Math, heightArray) + "px";
            $(".maskDiv").css({
                height: $("body").height()
            });
            $("#footer").removeClass("fixedfooter").show();
            if (document.getElementById("firstload")) {
                document.getElementById("firstload").style.display = "none"
            }
            autoLayout.loading = true;
            function _getWidth(url) {
                var item = url.split("/");
                var imgName = item[item.length - 1];
                var size = imgName.split(".");
                var sizeWidth = size[size.length - 3];
                return sizeWidth
            }
            function _getHeight(url) {
                var item = url.split("/");
                var imgName = item[item.length - 1];
                var size = imgName.split(".");
                var sizeHeight = size[size.length - 2];
                return sizeHeight
            }
            function _getComment(json) {
                var commentHtml = [];
                for (var m = 0; m < json.length; m++) {
                    var ask = "";
                    if (loginUser.id != json[m].userId) {
                        ask = '<a class="gray">回复</a>'
                    }
                    xHtml = ['<li class="cf"><div class="uhead" style="height:30px;"><a href="/profile/' + json[m].userId + '"><img src="' + uri("IMAGE", json[m].avatarTiny) + '" /></a></div>', '<div class="uinfo"><p><a href="/profile/' + json[m].userId + '" class="gray">' + json[m].userName + "</a></p>", '<p class="recoment" commentId="' + json[m].id + '">' + json[m].comment + "&nbsp;" + ask + "</p></div></li>"].join("");
                    commentHtml[m] = xHtml
                }
                return commentHtml.join("")
            }
        }
    },
    updateDiv: function() {
        var k = autoLayout.defaults;
        var q;
        var f = [];
        var g = document.documentElement.clientWidth - 17;
        var u = document.documentElement.clientHeight;
        var a = Math.max(Math.floor((g + autoLayout.marginLeft) / (autoLayout.divWidth + autoLayout.marginLeft)), 4);
        var o = 0;
        var l = a * 236 - 14 + "px";
        if (document.getElementById(autoLayout.defaults.contentID)) {
            document.getElementById(autoLayout.defaults.contentID).style.width = l
        }
        document.getElementById("topchannel").style.width = l;
        document.getElementById("topsysmenu").style.width = l;
        document.getElementById("footer-p").style.width = l;
        if (autoLayout.columnCount > a) {
            a = autoLayout.columnCount
        }
        for (var s = 0; s < a; s++) {
            f[s] = 0
        }
        if (document.getElementById(k.leftID)) {
            var n = document.getElementById(k.leftID);
            n.style.left = "0px";
            n.style.top = f[0] + "px";
            f[0] = (n.offsetHeight + autoLayout.marginTop)
        }
        if (k.rightID) {
            for (var m = 0,
            d = k.rightID.length; m < d; m++) {
                var p = document.getElementById(k.rightID[m]);
                p.style.left = o + autoLayout.divWidth * (a - 1) + autoLayout.marginLeft * (a - 1) + "px";
                p.style.top = f[a - 1] + "px";
                var b;
                if (p.style.marginTop) {
                    b = parseInt(p.style.marginTop)
                } else {
                    b = 0
                }
                f[a - 1] += (p.offsetHeight + autoLayout.marginTop + b)
            }
        }
        if (!autoLayout.rightLoad) {
            f.splice(f.length - 1, 1)
        }
        q = autoLayout.getElements(k.contentID);
        for (var r = 0,
        t = q.length; r < t; r++) {
            if (q[r] == document.getElementById("leftLabel") || q[r] == document.getElementById("rightLabel1") || q[r] == document.getElementById("rightLabel2") || q[r] == document.getElementById("rightLabel3")) {
                continue
            } else {
                var e = Math.min.apply(Math, f);
                var c = $.inArray(e, f);
                q[r].setAttribute("columns", c);
                q[r].style.left = o + autoLayout.divWidth * c + autoLayout.marginLeft * c + "px";
                q[r].style.top = e + "px";
                f[c] += (parseInt(q[r].offsetHeight) + autoLayout.marginTop)
            }
        }
        if (autoLayout.pageAuto) {
            a = Math.max(a, 4);
            var v = autoLayout.divWidth * (a - 1) + autoLayout.marginLeft * (a - 1) - 17 + "px";
            if (!autoLayout.searchPage) {
                $(".sheet").css({
                    marginLeft: o + "px",
                    width: v
                })
            }
            document.getElementById("content").style.width = l;
            document.getElementById("topsysmenu").style.width = l;
            document.getElementById("topchannel").style.width = l;
            document.getElementById("footer-p").style.width = l
        }
        autoLayout.colArray = f;
        document.getElementById(k.contentID).style.height = Math.max.apply(Math, f) + "px"
    },
    debounceFunc: function(d, a, b) {
        var e;
        return function c() {
            var h = this,
            g = arguments;
            function f() {
                if (!b) {
                    d.apply(h, g)
                }
                e = null
            }
            if (e) {
                clearTimeout(e)
            } else {
                if (b) {
                    d.apply(h, g)
                }
            }
            e = setTimeout(f, a || 30)
        }
    },
    reshareCountIncr: function(a) {
        var h = $("div[dataid|=" + a + "]").parent().attr("id");
        var f = autoLayout.getElements(h);
        for (var d = 0,
        e = f.length; d < e; d++) {
            if ($(f[d]).attr("dataid") == a) {
                $(f[d]).find(".reshareNum").html(parseInt($(f[d]).find(".reshareNum").text()) + 1);
                if ($(f[d]).find(".reshareNum").parent().css("display") == "none") {
                    if ($(f[d]).find(".reshareNum").parent().next().css("display") == "none" && $(f[d]).find(".reshareNum").parent().next().next().css("display") == "none") {
                        $(f[d]).find(".reshareNum").parent().parent().show();
                        var b = 20;
                        var g = $(f[d]).attr("columns");
                        var j = parseInt($(f[d]).css("top"));
                        c(autoLayout.defaults.contentID, g, b, j)
                    }
                    $(f[d]).find(".reshareNum").parent().show()
                }
            }
        }
        function c(r, n, p, q) {
            var m = autoLayout.getElements(r);
            for (var o = m.length; o--;) {
                var l = $(m[o]).attr("columns");
                var k = parseInt($(m[o]).css("top"));
                if (l == n && k > q) {
                    $(m[o]).css({
                        top: k + p
                    })
                }
            }
            autoLayout.colArray[n] += p;
            document.getElementById(autoLayout.defaults.contentID).style.height = Math.max.apply(Math, autoLayout.colArray) + "px"
        }
    },
    getElements: function(f) {
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
    },
    updateHeight: function(h, d, f, g) {
        var c = autoLayout.getElements(h);
        for (var e = c.length; e--;) {
            var b = $(c[e]).attr("columns");
            var a = parseInt($(c[e]).css("top"));
            if (b == d && a > g) {
                $(c[e]).css({
                    top: a + f
                })
            }
        }
        autoLayout.colArray[d] += f;
        document.getElementById(autoLayout.defaults.contentID).style.height = Math.max.apply(Math, autoLayout.colArray) + "px"
    },
    eachAction: function(jsonUrl) {
        var _thisBoard = $(".imBoard");
		
        _thisBoard.find("a.forward-btn").die().live("click",
        function() {
            if (typeof loginUser.id == "undefined" || loginUser.id == "") {
                var _path = window.location.pathname;
                window.location.href = "/login?flag=4&p=" + _path;
                return
            }
            var _id = $(this).attr("to");
            var _userId = $(this).attr("userId");
            var _title = $(this).parent().parent().parent().find(".contentsms").text();
            var _pic = $(this).parent().parent().parent().find(".picUrl").attr("src");
            reshare({
                id: _id,
                userId: _userId,
                title: _title,
                mediumZoom: _pic
            })
        });
        _thisBoard.find(".edit-btn").die().live("click",
        function() {
            editShare.edit($(this).attr("to"))
        });
        _thisBoard.find(".comment-btn").die().live("click",
        function() {
            openComment($(this), 0)
        });
        _thisBoard.find(".recoment .blue").die().live("click",
        function() {
            openComment($(this).parent().parent().parent().parent(), $(this).parent().attr("commentid"), $(this).parent().prev().find("a").text())
        });
        _thisBoard.find(".commentSubmit").die().live("click",
        function() {
            submitComment($(this))
        });
        _thisBoard.find(".commentClose").die().live("click",
        function() {
            closeComment($(this))
        });
        _thisBoard.find(".favourite-btn").die().live("click",
        function() {
            if (typeof loginUser.id == "undefined" || loginUser.id == "") {
                var _path = window.location.pathname;
                window.location.href = "/login?flag=4&p=" + _path;
                return
            }
            var ajaxObj = $(this);
            var likeId = ajaxObj.attr("to");
            var txt = ajaxObj.text();
            var newTxt, ajaxUrl, likesNum;
            if (txt == "喜欢") {
                newTxt = "取消";
                ajaxUrl = uri("URI_ADD_LIKE_AJAX", likeId);
                ajaxObj.addClass("unfavourite-btn");
                likesNum = parseInt(ajaxObj.parent().parent().find(".likeNum").text()) + 1
            } else {
                newTxt = "喜欢";
                ajaxUrl = uri("URI_ADD_UNLIKE_AJAX", likeId);
                ajaxObj.removeClass("unfavourite-btn");
                likesNum = parseInt(ajaxObj.parent().parent().find(".likeNum").text()) - 1
            }
            $.ajax({
                type: "POST",
                url: ajaxUrl,
                dataType: "json",
                data: "text",
                success: function(data) {
                    if (eval(data)) {
                        ajaxObj.html(newTxt);
                        var _par = ajaxObj.parent().parent();
                        ajaxObj.parent().parent().find(".likeNum").html(likesNum);
                        if (likesNum > 0) {
                            if (ajaxObj.parent().parent().find(".likeNum").parent().css("display") == "none") {
                                if (_par.find(".likeNum").parent().prev().css("display") == "none" && _par.find(".likeNum").parent().prev().prev().css("display") == "none") {
                                    ajaxObj.parent().parent().find(".likeNum").prev().prev().hide();
                                    _par.find(".likeNum").parent().parent().show();
                                    var addHeight = 24;
                                    var cols = ajaxObj.parent().parent().offsetParent().attr("columns");
                                    var docTop = parseInt(ajaxObj.parent().parent().offsetParent().css("top"));
                                    updateHeight(autoLayout.defaults.contentID, cols, addHeight, docTop)
                                }
                                ajaxObj.parent().parent().find(".likeNum").parent().show()
                            }
                        } else {
                            if (_par.find(".likeNum").parent().prev().css("display") == "none" && _par.find(".likeNum").parent().prev().prev().css("display") == "none") {
                                _par.find(".likeNum").parent().parent().hide();
                                var addHeight = -24;
                                var cols = ajaxObj.parent().parent().offsetParent().attr("columns");
                                var docTop = parseInt(ajaxObj.parent().parent().offsetParent().css("top"));
                                updateHeight(autoLayout.defaults.contentID, cols, addHeight, docTop)
                            }
                            ajaxObj.parent().parent().find(".likeNum").parent().hide()
                        }
                    }
                }
            })
        });
        $(window).resize(function() {
            autoLayout.debounceFunc(autoLayout.updateDiv(), 30, true)
        });
        if (autoLayout.loading) {
            $(window).scroll(function() {
                autoLayout.onscroll(jsonUrl)
            })
        }
        function openComment(obj, cid, userName) {
            var comThis = obj.parent().parent();
            if (typeof loginUser.id == "undefined" || loginUser.id == "") {
                var _path = window.location.pathname;
                window.location.href = "/login?flag=4&p=" + _path;
                return
            }
            var _textarea = comThis.find(".commentTextarea").eq(0);
            var _sta = true;
            if (comThis.find(".postcomment").css("display") == "block") {
                _sta = false
            }
            _textarea.keyup(function() {
                var _val = $(this).val();
                if (_val.indexOf("回复 " + $(this).attr("toName") + ":") == -1) {
                    $(this).attr("cid", 0)
                }
            });
            comThis.find(".postcomment").show();
            var _post = comThis.find(".postcomment");
            if (cid) {
                _textarea.attr("cid", cid);
                _textarea.attr("toName", userName);
                _textarea.focus().val("回复 " + userName + ":")
            } else {
                _textarea.attr("cid", 0);
                _textarea.focus()
            }
            comThis.find(".lightblue").text(comThis.find(".commentTextarea").val().length);
            if (comThis.find(".commentTextarea").val().length > 0) {
                comThis.find(".unpincomment").removeClass().addClass("commentSubmit pincomment")
            }
            var addHeight = _post.height() + 20;
            var cols = _post.offsetParent().attr("columns");
            var docTop = parseInt(_post.offsetParent().css("top"));
            if (_sta) {
                updateHeight(autoLayout.defaults.contentID, cols, addHeight, docTop)
            }
            var _objRea = comThis.offsetParent();
            $.fn.countNumber(_objRea.find(".commentTextarea"), {
                scroll: true,
                textareaid: _objRea.find(".lightblue"),
                numberid: 140,
                rowsize: 24,
                rowheight: 2,
                deflultheight: 28,
                buttonClass: "commentSubmit pincomment",
                buttonOff: "unpincomment",
                callback: function(addHeight) {
                    var cols = _objRea.attr("columns");
                    var docTop = parseInt(_objRea.css("top"));
                    updateHeight(autoLayout.defaults.contentID, cols, addHeight, docTop)
                }
            })
        }
        function submitComment(obj) {
            if ($(this).hasClass("unpincomment")) {
                return
            }
            $(this).removeClass().addClass("unpincomment").text("发送中");
            var _obj = obj,
            content;
            var _textObj = _obj.parent().parent().find(".commentTextarea");
            var user = loginUser;
            content = _obj.parent().parent().find(".commentTextarea").val();
            var _l = 0;
            if ($.trim(content).length == 0 || $.trim(content).length > 140) {
                im.window.alert("请输入评论内容！", "error");
                return
            }
            var parentObj = _obj.parent().parent().parent().parent().parent();
            var commentObj = parentObj.find(".comentMain");
            var cid = parentObj.find("commentTextarea").attr("cid");
            var boardPicId = parentObj.parent().parent().attr("dataid");
            var currHeight = 0;
            function filter(str) {
                str = str.replace(/&/g, "&amp;");
                str = str.replace(/</g, "&lt;");
                str = str.replace(/>/g, "&gt;");
                str = str.replace(/'/g, "&acute;");
                str = str.replace(/"/g, "&quot;");
                str = str.replace(/\|/g, "&brvbar;");
                return str
            }
            var url = "/comment/" + boardPicId;
            $.post(url, {
                comment: content,
                replyCommentId: cid,
                score: 0
            },
            function(data) {
                if (data == "") {
                    return
                }
                var xHtml = ['<li class="cf">', '<div class="uhead" style="width:30px;height:30px;"><a href="javascript:void(0);"><img src="' + uri("IMAGE", loginUser.avatarTiny) + '" /></a></div>', '<div class="uinfo">', '<p><a href="javascript:void(0);" class="gray">' + loginUser.nickname + "</a></p>", "<p>" + filter(content) + "</p>", "</div>", "</li>"].join("");
                commentObj.append(xHtml);
                parentObj.find(".commentTextarea").val("");
                parentObj.find(".lightblue").text(0);
                parentObj.find(".submit a").removeClass().addClass("unpincomment").text("提交");
                parentObj.find(".commentNum").html(parseInt(parentObj.find(".commentNum").text()) + 1);
                if (parentObj.find(".commentNum").parent().css("display") == "none") {
                    parentObj.find(".commentNum").parent().show();
                    if (parentObj.find(".commentNum").parent().prev().css("display") == "none" && parentObj.find(".commentNum").parent().next().css("display") == "none") {
                        parentObj.find(".commentNum").prev().prev().hide();
                        parentObj.find(".commentNum").parent().parent().show();
                        var addHeight = 24;
                        var cols = parentObj.offsetParent().attr("columns");
                        var docTop = parseInt(parentObj.offsetParent().css("top"));
                        updateHeight(autoLayout.defaults.contentID, cols, addHeight, docTop)
                    }
                }
                var liHeight = commentObj.find("li:last-child").height() + 16;
                var cols = parentObj.parent().parent().attr("columns");
                var docTop = parseInt(parentObj.parent().parent().css("top"));
                var currH = liHeight - currHeight + 1;
                updateHeight(autoLayout.defaults.contentID, cols, currH, docTop);
                if (parentObj.find(".commentTextarea").height() > 28) {
                    var pobj = parentObj.find(".commentTextarea");
                    var _h = pobj.height();
                    pobj.css({
                        height: "28px"
                    });
                    var _addHeight = 28 - _h;
                    var cols = parentObj.offsetParent().attr("columns");
                    var docTop = parseInt(parentObj.offsetParent().css("top"));
                    updateHeight(autoLayout.defaults.contentID, cols, _addHeight, docTop)
                }
            },
            "json")
        }
        function closeComment(obj) {
            var _par = obj.parent().parent();
            var addHeight = -parseInt(_par.height() + 19);
            var cols = _par.offsetParent().attr("columns");
            var docTop = parseInt(_par.offsetParent().css("top"));
            updateHeight(autoLayout.defaults.contentID, cols, addHeight, docTop);
            _par.hide()
        }
        function updateHeight(objs, col, diffHeight, bTop) {
            var objDiv = autoLayout.getElements(objs);
            for (var i = objDiv.length; i--;) {
                var colums = $(objDiv[i]).attr("columns");
                var docTop = parseInt($(objDiv[i]).css("top"));
                if (colums == col && docTop > bTop) {
                    $(objDiv[i]).css({
                        top: docTop + diffHeight
                    })
                }
            }
            autoLayout.colArray[col] += diffHeight;
            document.getElementById(autoLayout.defaults.contentID).style.height = Math.max.apply(Math, autoLayout.colArray) + "px"
        }
    },
    pageNum: 2,
    autoTimer: null,
    scrollEvent: function(d) {
        if (autoLayout.pageNum <= 10) {
            var f = $(document).scrollTop();
            var b = document.documentElement.clientHeight;
            var a = parseInt(f + b);
            var c = Math.min.apply(Math, autoLayout.colArray);
            var e = parseInt(c + $("#" + autoLayout.defaults.contentID).offset().top);
            if (a > e) {
                $("#imloading").css({
                    visibility: ""
                });
                if (autoLayout.autoTimer !== null) {
                    return
                }
                autoLayout.autoTimer = setTimeout(function() {
                    autoLayout.init(d + autoLayout.pageNum);
                    autoLayout.pageNum++;
                    autoLayout.autoTimer = null
                },
                300)
            }
        }
    },
    onscroll: function(a) {
        autoLayout.loading = false;
        if (autoLayout.isHasNextPage) {
            autoLayout.scrollEvent(a)
        }
    }
};
*/