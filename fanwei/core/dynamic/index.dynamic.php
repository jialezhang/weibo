<?php
//首页动态内容的函数

/**
 * 获取今日达人
 */
function getIndexTodayDaren()
{
	$args['today_daren'] = FS('Daren')->getIndexTodayDaren();
	return tplFetch('inc/index/today_daren',$args);
}

/**
 * 正在分享
 */
function getNewShare()
{
	$args['shares'] = FS('Share')->getNewShare();
	return tplFetch('inc/index/new_share',$args);
}

/**
 * 最新活动,热门主题
 */
function getHotTopic()
{
	$cache_file = getTplCache('inc/index/hot_topic',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['new_events'] = FS('Event')->getHotNewEvent(3);
		$args['hot_topics'] = FS('Topic')->getHotTopicList(0,0,3);
	}

	return tplFetch('inc/index/hot_topic',$args,'',$cache_file);
}

/**
 * 分类最近7天热门分享
 */
function getDayCateShare()
{
	$args = array();
	$cache_file = getTplCache('inc/index/cate_share',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['cate_list'] = FS('Share')->getIndexShareHotTags();
	}

	return tplFetch('inc/index/cate_share',$args,'',$cache_file);
}

/**
 * 分类最新的主题
 */
function getIndexTopic()
{
	global $_FANWE;
	$args = array();
	$cache_file = getTplCache('inc/index/new_topic',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$res = FDB::query('SELECT fid,thread_count FROM '.FDB::table('forum').' WHERE parent_id = 0');
		while($data = FDB::fetch($res))
		{
			$_FANWE['cache']['forums']['all'][$data['fid']]['thread_count'] = $data['thread_count'];
		}

		$args['new_list'] = FS('Topic')->getImgTopic('new',7,4);
		$args['ask_list'] = FS('Ask')->getImgAsk('new',2,1);
	}

	return tplFetch('inc/index/topics',$args,'',$cache_file);
}

/**
 * 分类最新的主题
 */
function getDarenLists()
{
	$args['daren_list'] = FS('Daren')->getDarens();
	
	return tplFetch('inc/index/daren_list',$args);
}

/**
 * 搭配秀列表
 */
function getDapeiLists()
{
	$args = array();
	$cache_file = getTplCache('inc/index/dapei_list',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['dapei_list'] = FS('Share')->getPhotoListByType("dapei");
	}
	return tplFetch('inc/index/dapei_list',$args,'',$cache_file);
}
/**
 * 晒货列表
 */
function getLookLists()
{
	$args = array();
	$cache_file = getTplCache('inc/index/look_list',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['look_list'] = FS('Share')->getPhotoListByType("look");
	}
	return tplFetch('inc/index/look_list',$args,'',$cache_file);
}
?>