<?php
// +----------------------------------------------------------------------
// | 方维购物分享网站系统 (Build on ThinkPHP)
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://fanwe.com All rights reserved.
// +----------------------------------------------------------------------

/**  
 * dynamic.func.php
 *
 * 模板动态内容处理函数
 *
 * @package function
 * @author awfigq <awfigq@qq.com>
 */
 
/**  
 * 直接输出内容 
 * @param mixed $value 内容
 * @return string
 */ 
function echoValue($value)
{
	return $value;
}

/**  
 * 动态脚本 
 * @return string
 */ 
function getScript()
{
	return tplFetch('inc/script');
}

/**  
 * 获取会员相关信息 
 * @return string
 */ 
function getUserInfo()
{
	return tplFetch('inc/common/user_info');
}

/**  
 * 获取hash码
 * @return string
 */ 
function getRHash()
{
	return FORM_HASH;
}

/**  
 * 获取随机码
 * @return string
 */ 
function getRandom()
{
	return random(8);
}

/**  
 * 广告位显示
 * @param array $args 广告位信息
 * @return string
 */ 
function advLayout($args)
{
	list($id,$count,$target) = explode(',',$args);
	unset($args);
	$ap = getAdvPosition($id,$count,$target);
	if(empty($ap))
		return '';
	
	$style = $ap['style'];
	unset($ap['style']);
	
	$cache_key = 'adv_position/'.$ap['id'];
	
	if($ap['is_flash'] == 1 && !empty($ap['flash_style']))
	{
		$args['adv_path'] = "./public/adflash/".$ap['flash_style'].".swf";
		$args['adv_pics']="";
		$args['adv_texts']="";
		$args['adv_links']="";
	
		$jg = '';
		foreach($ap['adv_list'] as $adv)
		{
			$args['adv_pics'].=$jg.$adv['code'];
			$args['adv_texts'].=$jg.$adv['desc'];
			$args['adv_links'].=$jg.$adv['url'];
			$jg = "|";
		}
	
		unset($ap['adv_list']);
		$args['adv_position'] = $ap;
	}
	else
	{
		$args['adv_list'] = $ap['adv_list'];
	}
	
	unset($ap);
	return tplString($style,$cache_key,$args);
}
?>