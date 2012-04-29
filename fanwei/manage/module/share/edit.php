<?php

$id = intval($_FANWE['request']['id']);
if($id == 0)
	exit;

if(!checkAuthority('share','edit')&&FDB::resultFirst("select uid from ".FDB::table("share")." where share_id = ".$id)!=$_FANWE['uid'])
	exit;

$manage_lock = checkIsManageLock('share',$id);
if($manage_lock === false)
	createManageLock('share',$id);

$share = FDB::fetchFirst("select share_id,title,content from ".FDB::table("share")." where share_id =".$id);

if(empty($share))
{
	deleteManageLock('share',$id);
	exit;
}

include template('manage/share/edit');
display();
?>