<?php
	global $_FANWE;
	if(!$_FANWE['uid'])
		exit;
	$id = $_FANWE['request']['id'];
	FanweService::instance()->cache->loadCache('albums');
	$album = FS("Album")->getAlbumById($id);
	include template('services/user/editalbum');
	display($cache_file);
?>