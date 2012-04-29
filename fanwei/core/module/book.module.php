<?php
class BookModule
{
	public function share()
	{
		BookModule::getShare();
	}
	
	private function getShare()
	{
		global $_FANWE;
		
		$kwy_word = urldecode($_FANWE['request']['kw']);
		
		$count_result = BookModule::searchInfo();
		if($count_result['user_count'] > 0)
		{
			$match_key = segmentToUnicode($kwy_word,'+');
			$user_sql = "SELECT u.*, uc.*, us.*, up.* FROM ".FDB::table('user')." u 
			LEFT JOIN ".FDB::table('user_count')." uc USING(uid)
			LEFT JOIN ".FDB::table('user_status')." us USING(uid)
			LEFT JOIN ".FDB::table('user_profile')." up USING(uid)
			WHERE match(u.user_name_match) against('".$match_key."' IN BOOLEAN MODE)  limit 10";
			$user_list = FDB::fetchAll($user_sql);
			if($user_list)
			{
				foreach($user_list as $k => $v)
				{
					$is_follow = FS("User")->getIsFollowUId($v['uid']);
					$user_list[$k]['is_follow'] = $is_follow;
				}
			}
		}
		$link_url = $_FANWE['site_url']."services/service.php?m=search&a=share&width=190&p=1&kwy_word=".$kwy_word;
		$json_url = $_FANWE['site_url']."services/service.php?m=search&a=share&width=190&kwy_word=".$kwy_word;
		include template('page/book/book_index');
		display();
	}
	
	private function searchInfo()
	{
		global $_FANWE;
		$kwy_word = urldecode($_FANWE['request']['kw']);
		if(!empty($kwy_word))
		{
			$match_key = segmentToUnicode($kwy_word,'+');
			$user_condition = " AND match(user_name_match) against('".$match_key."' IN BOOLEAN MODE) ";
			$share_condition = " AND match(share_content_match) against('".$match_key."' IN BOOLEAN MODE) ";
			$album_condition = " match(album_title_match) against('".$match_key."' IN BOOLEAN MODE) ";
		}
		
		//查找的会员数量
		$user_sql = "select count(*) from ".FDB::table("user")." where status = 1 ".$user_condition;
		$user_count = FDB::resultFirst($user_sql);
		
		//查找的专辑数量
		$album_sql = "select count(*) from ".FDB::table("album")." where ".$album_condition;
		
		$album_count = FDB::resultFirst($album_sql);
		
		//查找的分享数量
		$share_sql = "select count(*) from ".FDB::table("share")." where share_data <> 'default' ".$share_condition;
		$share_count = FDB::resultFirst($share_sql);
		
		$result = array();
		$result['user_count'] = $user_count;
		$result['album_count'] = $album_count;
		$result['share_count'] = $share_count;
		return $result;
	}
}
?>