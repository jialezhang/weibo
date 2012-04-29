<?php

$list = FS("Album")->getAlbumListByUid($_FANWE['uid']);
FanweService::instance()->cache->loadCache('albums');
$args = array(
	'list'=>&$list
);

$result['html'] = tplFetch('services/share/select_album',$args);

outputJson($result);
?>