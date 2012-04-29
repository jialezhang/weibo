<?php
$cache_file = getTplCache('services/user/share');
FanweService::instance()->cache->loadCache('albums');

if(!@include($cache_file))
{
	$login_modules = getLoginModuleList();
	include template('services/user/share');
}
display($cache_file);
?>