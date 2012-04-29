<?php
global $FANWE;
$share_id = $_FANWE['request']['share_id'];
$share = FS("Share")->getShareById($share_id);
$album_id = FDB::resultFirst("select album_id from ".FDB::table("album_share")." where share_id = ".$share_id);
$album = FS("Album")->getAlbumById($album_id,false);
$share_img = FDB::fetchFirst('SELECT photo_id, img FROM '.FDB::table('share_photo').' WHERE share_id = '.$share_id);
$content_count = count($share['content']);
FanweService::instance()->cache->loadCache('albums');
$login_modules = getLoginModuleList();
include template('services/user/editshare');
display();
?>