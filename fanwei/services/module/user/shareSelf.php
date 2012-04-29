<?php
	global $_FANWE;
	
	$is_root = false;
	
	$img_width = $_FANWE['request']['width'];
	$home_uid = $_FANWE['request']['home_uid'];
	
	
	$page = intval($_REQUEST['p']);
	$limit = (($page - 1)*10).","."10";
	$next_limit = ($page *10).","."1";
	
	
	
	$sql = 'SELECT *
			FROM '.FDB::table("share").'
			WHERE uid = '.$home_uid.' and share_data <> '." 'default'
			ORDER BY share_id DESC LIMIT ".$limit;
	
	
	$next_sql = 'SELECT *
			FROM '.FDB::table("share").'
			WHERE uid = '.$home_uid.' and share_data <> '." 'default' 
			ORDER BY share_id DESC LIMIT ".$next_limit;
	
	$hasNextPage = FDB::fetchAll($next_sql);
	if($hasNextPage)
	{
		$is_next = 1;
	}
	else 
	{
		$is_next = 0;
	}
	$share_list = FDB::fetchAll($sql);
	
	if($share_list)
	{
		$share_list = FS('Share')->getShareDetailList($share_list,false,false,false,true,2);
		$list = array();
		$current_user = array();
		$current_user['u_url'] = FU('u/index',array('uid'=>$_FANWE['uid']));
		$current_user['avt'] = avatar($_FANWE['uid'], 's', $is_src = 1);
		$i = 0;
		
		foreach($share_list as $k => $v)
		{
		$list[$i] = $v;
		$img = FDB::resultFirst("select img from ".FDB::table("share_photo")." where share_id = ".$v['share_id']." and img <> '' ");
		$img = getImgName($img,$img_width,999);
		$list[$i]['share_img'] = $img;
		$height_img = $_FANWE['site_url'].substr($img,2);
		$img_size = getimagesize($height_img);
		$height = $img_size[1];
		$list[$i]['avt'] = avatar($v['uid'], 's', $is_src = 1);
		$list[$i]['height'] = $height;
		$list[$i]['width'] = $img_width;
		$parent_id = FDB::resultFirst("select parent_id from ".FDB::table("share")." where share_id = ".$v['share_id']);
		if($parent_id == 0)
		{
			$list[$i]['isOriginal'] = 1;
		}
		else 
		{
			$list[$i]['isOriginal'] = 0;
		}
		$list[$i]['likeStatus'] = FS('Share')->getIsCollectByUid($v['share_id'],$_FANWE['uid'])?1:0;
		$list[$i]['isMe'] = $v['uid'] == $_FANWE['uid']?1:0;
		//分享评论
		$share_comments = FS('Share')->getShareCommentList($v['share_id'],'0,2');
		if($share_comments)
		{
			$share_comments_data = array();
			$idxj = 0;
			foreach($share_comments as $vv)
			{
				$share_comments_data[$idxj]['comment_id'] = $vv['comment_id'];
				$share_comments_data[$idxj]['parent_id'] = $vv['parent_id'];
				$share_comments_data[$idxj]['user_url'] = FU('u/index',array('uid'=>$vv['user']['uid']));
				$share_comments_data[$idxj]['user_name'] = $vv['user']['user_name'];
				$share_comments_data[$idxj]['avt'] = avatar($vv['uid'], 's', $is_src = 1);
				$share_comments_data[$idxj]['comment'] = cutStr($vv['content'],20);
				$idxj++;
			}
			$list[$i]['comments'] = $share_comments_data;
		}
		$list[$i]['share_url'] = FU('note/index',array('sid'=>$v['share_id']));
		$list[$i]['u_url'] = FU('u/index',array('uid'=>$v['uid']));
		$list[$i]['relay_count'] = FDB::resultFirst("select relay_count from ".FDB::table("share")." where share_id = ".$v['share_id']);
		$album_sql = "select a.id,a.title from  ".FDB::table('album_share')." as ah left join ".FDB::table('album')." as a on ah.album_id = a.id where ah.share_id = ".$v['share_id'];
		$album = FDB::fetchFirst($album_sql);
		if($album)
		{
			$list[$i]['album_title'] = $album['title'];
			$list[$i]['is_album'] = 1;
			$list[$i]['album_url'] = FU("album/show",array('id'=>$album['id']));
		}
		else {
			$list[$i]['album_title'] = "";
			$list[$i]['is_album'] = 0;
			$list[$i]['album_url'] = "";
		}
		$list[$i]['zf_count'] = 10;
		$list[$i]['xh_count'] = 20;
		
		$list[$i]['user_name'] = FDB::resultFirst("select user_name from ".FDB::table('user')." where uid =".$v['uid']);
		$i++;
		}
		outputJson(array('result'=>$list,'current_user'=>$current_user,'status'=>1,'hasNextPage'=>$is_next));
	}
	else {
		outputJson(array('status'=>0,'hasNextPage'=>$is_next));
	}
	
	
	
	
	
?>