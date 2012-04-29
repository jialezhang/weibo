<?php
// +----------------------------------------------------------------------
// | 方维购物分享网站系统 (Build on ThinkPHP)
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: awfigq <awfigq@qq.com>
// +----------------------------------------------------------------------
/**
 +------------------------------------------------------------------------------
 * 会员模型
 +------------------------------------------------------------------------------
 */
class UserModel extends CommonModel
{
	public $_validate = array(
		array('user_name','require','{%USER_NAME_REQUIRE}'),
		array('user_name','','{%USER_NAME_EXIST}',0,'unique'),
		array('email','require','{%EMAIL_REQUIRE}'),
		array('email','','{%EMAIL_EXIST}',0,'unique'),
		array('password','require','{%PASSWORD_REQUIRE}',0,'',1),
		array('password','confirm_password','{%CONFIRM_ERROR}',0,'confirm',1),
	);
	
	protected $_auto = array( 
		array('password','md5',3,'function'),
		array('reg_time','gmtTime',1,'function'),
		array('reg_time','strZTime',2,'function'),
	);
	
	public function deleteUser($ids)
	{
		vendor("common");
		@set_time_limit(0);
		if(function_exists('ini_set'))
			ini_set('max_execution_time',0);
			
		$id_arr = explode(',',$ids);
		$ids = implode(',',$id_arr);
		if(empty($ids))
			return false;
			
		//==================添加第三方整合会员添加 chenfq 2011-10-14================
		foreach($id_arr as $uid)
		{
			$user = $this->getById($uid);
			$user_field = fanweC('INTEGRATE_FIELD_ID');
			$integrate_id = intval($user[$user_field]);

			if ($integrate_id > 0){	
				FS("Integrate")->adminInit(fanweC('INTEGRATE_CODE'),fanweC('INTEGRATE_CONFIG'));				
				FS("Integrate")->delUser($integrate_id);
				//exit;
			}
		}		
		//==================添加第三方整合会员添加chenfq 2011-10-14================
		
		$condition = array ('uid' => array('in',$id_arr));
		if(false !== $this->where($condition)->delete())
		{
			D('AskPost')->where($condition)->delete();
			D('AskThread')->where($condition)->delete();
			D('ForumPost')->where($condition)->delete();
			D('ForumThread')->where($condition)->delete();
			D('ManageLog')->where($condition)->delete();
			D('SecondGoods')->where($condition)->delete();
			D('ShareComment')->where($condition)->delete();
			M()->query('DELETE FROM '.C("DB_PREFIX").'share_category 
				WHERE share_id IN (SELECT share_id FROM '.C("DB_PREFIX").'share 
				WHERE uid IN ('.$ids.'))');
			M()->query('DELETE FROM '.C("DB_PREFIX").'share_match 
				WHERE share_id IN (SELECT share_id FROM '.C("DB_PREFIX").'share 
				WHERE uid IN ('.$ids.'))');
			M()->query('DELETE FROM '.C("DB_PREFIX").'share_tags 
				WHERE share_id IN (SELECT share_id FROM '.C("DB_PREFIX").'share 
				WHERE uid IN ('.$ids.'))');

			$res = FDB::query('SELECT share_id FROM '.FDB::table('share').' WHERE uid IN ('.$ids.')');
			while($data = FDB::fetch($res))
			{
				$key = getDirsById($data['share_id']);
				clearCacheDir('share/'.$key);
				clearDir(PUBLIC_ROOT.'./upload/share/'.$key,true);
			}
			
			D('Share')->where($condition)->delete();
			D('ShareGoods')->where($condition)->delete();
			D('SharePhoto')->where($condition)->delete();
			D('UserAttention')->where($condition)->delete();
			D('UserAuthority')->where($condition)->delete();
			D('UserCount')->where($condition)->delete();
			
			//删除喜欢收藏
			$list = M()->query('SELECT uid,COUNT(uid) AS ccount FROM '.C("DB_PREFIX").'user_collect 
				WHERE c_uid IN ('.$ids.') GROUP BY uid');
			foreach($list as $data)
			{
				M()->query('UPDATE '.C("DB_PREFIX").'user_count 
					SET collects = collects - '.$data['ccount'].' 
					WHERE uid = '.$data['uid']);
			}
			M()->query('DELETE FROM '.C("DB_PREFIX").'user_collect 
				WHERE c_uid IN ('.$ids.')');
				
			//删除粉丝关注
			$list = M()->query('SELECT uid FROM '.C("DB_PREFIX").'user_follow 
				WHERE f_uid IN ('.$ids.') GROUP BY uid');
			foreach($list as $data)
			{
				M()->query('UPDATE '.C("DB_PREFIX").'user_count 
					SET fans  = fans  - 1 
					WHERE uid = '.$data['uid']);
			}
			$list = M()->query('SELECT f_uid FROM '.C("DB_PREFIX").'user_follow 
				WHERE uid IN ('.$ids.') GROUP BY f_uid');
			foreach($list as $data)
			{
				M()->query('UPDATE '.C("DB_PREFIX").'user_count 
					SET fans  = follows  - 1 
					WHERE uid = '.$data['f_uid']);
			}
			M()->query('DELETE FROM '.C("DB_PREFIX").'user_follow 
				WHERE f_uid IN ('.$ids.')');
			M()->query('DELETE FROM '.C("DB_PREFIX").'user_follow 
				WHERE uid IN ('.$ids.')');
			
			D('UserDaren')->where($condition)->delete();
			D('UserMedal')->where($condition)->delete();
			D('UserMeTags')->where($condition)->delete();
			M()->query('DELETE FROM '.C("DB_PREFIX").'user_msg WHERE author_id IN ('.$ids.')');
			D('UserMsgRel')->where($condition)->delete();
			D('UserNotice')->where($condition)->delete();
			D('UserProfile')->where($condition)->delete();
			D('UserStatistics')->where($condition)->delete();
			D('UserStatus')->where($condition)->delete();
			
			foreach($id_arr as $uid)
			{
				$this->deleteUserAvatar($uid);
			}
			
			return true;
		}
		else
			return false;
	}
	
	public function deleteUserAvatar($uid)
	{
		$types = array(
			's'=>'small',
			'm'=>'middle',
			'b'=>'big',
		);
		$avatar_path = $this->getUserAvatarPath($uid);
		foreach($types as $type)
		{
			@unlink($avatar_path['path'].'_'.$type.'.jpg');
		}
		$this->deleteUserAvatarDir($uid);
	}
	
	public function deleteUserAvatarDir($uid)
	{
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		@rmdir(FANWE_ROOT.'public/upload/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/');
	}
	
	public function getUserAvatarPath($uid)
	{
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		$arr['path'] = FANWE_ROOT.'public/upload/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2);
		$arr['url'] = __ROOT__.'/public/upload/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2);
		return $arr;
	}
}
?>