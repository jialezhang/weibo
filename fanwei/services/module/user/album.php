<?php
	global $_FANWE;
	if(!$_FANWE['uid'])
		exit;
	FanweService::instance()->cache->loadCache('albums');
	$cache_file = getTplCache('services/user/album');
	if(!@include($cache_file))
	{	
		$login_modules = getLoginModuleList();
		include template('services/user/album');
	}
	display($cache_file);
?>