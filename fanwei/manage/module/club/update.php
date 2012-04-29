<?php
$id = intval($_FANWE['request']['tid']);
if($id == 0)
	exit;

if(!checkAuthority('club','edit'))
	exit;

$manage_lock = checkIsManageLock('club',$id);
if($manage_lock !== false)
	exit;
	
$old = FS('Topic')->getTopicById($id);
if(empty($old))
{
	deleteManageLock('club',$id);
	exit;
}

$share_id = $old['share_id'];
$topic = array(
	'title'=>htmlspecialchars(trim($_FANWE['request']['title'])),
	'content'=>htmlspecialchars(trim($_FANWE['request']['content'])),
	'fid'=>$_FANWE['request']['fid'],
	'is_best'=> isset($_FANWE['request']['is_best']) ? intval($_FANWE['request']['is_best']) : 0,
	'is_top'=>isset($_FANWE['request']['is_top']) ? intval($_FANWE['request']['is_top']) : 0,
	'is_event'=>isset($_FANWE['request']['is_event']) ? intval($_FANWE['request']['is_event']) : 0,
);
FDB::update('forum_thread',$topic,'tid = '.$id);

$match_content = $topic['title'];
$match_content .= preg_replace("/\[[^\]]+\]/i","",$topic['content']);
$res = FDB::query('SELECT name FROM '.FDB::table('share_goods').' WHERE share_id = '.$share_id);
while($data = FDB::fetch($res))
{
	$match_content .= $data['name'];
}

$res = FDB::query('SELECT tag_name  FROM '.FDB::table('share_tags').' WHERE share_id = '.$share_id);
while($data = FDB::fetch($res))
{
	$match_content .= $data['tag_name '];
}

$share_match = array();
$share_match['content_match'] = segmentToUnicode(clearSymbol($match_content));
FDB::update("share_match",$share_match,'share_id = '.$share_id);

$share = array();
$share['title'] = $topic['title'];
$share['content'] = $topic['content'];
FDB::update("share",$share,'share_id = '.$share_id);
createManageLog('club','edit',$id,lang('manage','manage_edit_success'));

deleteManageLock('club',$id);
$msg = lang('manage','manage_edit_success');
include template('manage/tooltip');
display();
?>