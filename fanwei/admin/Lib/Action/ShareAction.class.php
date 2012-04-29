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
 * 分享
 +------------------------------------------------------------------------------
 */
class ShareAction extends CommonAction
{
	public function index()
	{
		$where = '';
		$parameter = array();
		$keyword = trim($_REQUEST['keyword']);
		$uname = trim($_REQUEST['uname']);
		$type = trim($_REQUEST['type']);
		$share_data = !isset($_REQUEST['share_data']) ? 'img' : trim($_REQUEST['share_data']);
		$cate_id = intval($_REQUEST['cate_id']);
		$status = !isset($_REQUEST['status']) ? 0 : intval($_REQUEST['status']);
		$inner_sql = '';
		
		if($share_data == 'img')
		{
			$this->assign("share_data",$share_data);
			$where .= " WHERE s.share_data IN ('goods','photo','goods_photo')";
		}
		else
		{
			$this->assign("share_data",$share_data);
			$parameter['share_data'] = $share_data;
			$where .= " WHERE s.share_data = '$share_data'";
		}
			
		
		if(!empty($keyword))
		{
			$this->assign("keyword",$keyword);
			$parameter['keyword'] = $keyword;
			if($share_data != 'default')
			{
				$match_key = segmentToUnicodeA($keyword,'+');
				$where.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
				$inner_sql .= 'INNER JOIN '.C("DB_PREFIX").'share_match AS sm ON sm.share_id = s.share_id ';
			}
			else
			{
				$where .= " AND s.content LIKE '%".mysqlLikeQuote($keyword)."%'";
			}
		}

		if(!empty($uname))
		{
			$this->assign("uname",$uname);
			$parameter['uname'] = $uname;
			$match_key = segmentToUnicodeA($uname,'+');
			$where.=" AND match(u.user_name_match) against('".$match_key."' IN BOOLEAN MODE) ";
		}

		if(!empty($type) && $type != 'all')
		{
			$this->assign("type",$type);
			$parameter['type'] = $type;
			$where .= " AND s.type = '$type'";
		}

		if($cate_id != 0)
		{
			$this->assign("cate_id",$cate_id);
			$parameter['cate_id'] = $cate_id;

			if($cate_id > 0)
			{
				$child_ids = D('GoodsCategory')->getChildIds($cate_id,'cate_id');
				$child_ids[] = $cate_id;

				$where .= " AND sc.cate_id IN (".implode(',',$child_ids).")";
			}
			else
				$where .= " AND sc.cate_id IS NULL";
		}
		
		if($status  != -1)
		{
			$this->assign("status",$status);
			$parameter['status'] = $status;
			$where .= " AND s.status = $status";
		}

		$model = M();

		$sql = 'SELECT COUNT(DISTINCT s.share_id) AS scount
			FROM '.C("DB_PREFIX").'share AS s
			LEFT JOIN '.C("DB_PREFIX").'share_category AS sc ON sc.share_id = s.share_id 
			LEFT JOIN '.C("DB_PREFIX").'user AS u ON u.uid = s.uid 
			'.$inner_sql.$where;

		$count = $model->query($sql);
		$count = $count[0]['scount'];

		$sql = 'SELECT s.share_id,LEFT(s.content,80) AS content,u.user_name,s.create_time,s.collect_count,s.relay_count,			s.comment_count,s.type,s.share_data,GROUP_CONCAT(DISTINCT gc.cate_name SEPARATOR \'<br/>\') AS cate_name,s.status 
			FROM '.C("DB_PREFIX").'share AS s 
			LEFT JOIN '.C("DB_PREFIX").'user AS u ON u.uid = s.uid 
			LEFT JOIN '.C("DB_PREFIX").'share_category AS sc ON sc.share_id = s.share_id 
			LEFT JOIN '.C("DB_PREFIX").'goods_category AS gc ON gc.cate_id = sc.cate_id 
			'.$inner_sql.$where.' GROUP BY s.share_id';
		$this->_sqlList($model,$sql,$count,$parameter,'s.share_id');
		
		$root_id = D('GoodsCategory')->where('is_root = 1')->getField('cate_id');
		$root_id = intval($root_id);
		$root_ids = D('GoodsCategory')->getChildIds($root_id,'cate_id');
		$root_ids[] = $root_id;
		
		$cate_list = D('GoodsCategory')->where('cate_id not in ('.implode(',',$root_ids).')')->order('sort asc')->findAll();
		$cate_list = D('GoodsCategory')->toFormatTree($cate_list,'cate_name','cate_id','parent_id');
		$this->assign("cate_list",$cate_list);
		
		$this->display ();
	}
	
	function edit()
	{
		Vendor('common');
		$id = $_REQUEST ['share_id'];
		$share = D ("Share")->getById ( $id );
		if(!$share)
		{
			$this->error(L("NO_SHARE"));
		}
		$share['share_photo'] = FDB::fetchAll("select photo_id,img from ".FDB::table("share_photo")." where share_id = ".$share['share_id']);
		$share['share_goods'] = FDB::fetchAll("select goods_id,img,name,url,price from ".FDB::table("share_goods")." where share_id = ".$share['share_id']);
		$share['parent_share'] = FDB::fetchFirst("select u.user_name,s.share_id,s.content,s.uid,s.collect_count,s.relay_count,s.comment_count,s.create_time,s.type,s.title from ".FDB::table("share")." as s left join ".FDB::table("user")." as u on u.uid = s.uid where s.share_id = ".$share['parent_id']);

		$share['share_tags'] = FDB::resultFirst("select group_concat(tag_name SEPARATOR ' ') from ".FDB::table("share_tags")." where share_id = ".$share['share_id']);


		$root_id = D('GoodsCategory')->where('is_root = 1')->getField('cate_id');
		$root_id = intval($root_id);
		$root_ids = D('GoodsCategory')->getChildIds($root_id,'cate_id');
		$root_ids[] = $root_id;
		
		$category = D('GoodsCategory')->where('cate_id not in ('.implode(',',$root_ids).')')->order('sort asc')->findAll();
		$category = D('GoodsCategory')->toFormatTree($category,'cate_name','cate_id','parent_id');
		
		$share_category = FDB::fetchAll("select c.cate_id,c.cate_name from ".FDB::table("share_category")." as sc left join ".FDB::table("goods_category")." as c on sc.cate_id = c.cate_id where sc.share_id = ".$share['share_id']);

		$this->assign ( 'category', $category );
		$this->assign ( 'share_category', $share_category );
		$this->assign ( 'share', $share );
		$this->display ();
	}

	public function remove()
	{
		//删除指定记录
		error_reporting(E_ALL);
		Vendor('common');
		$result = array('isErr'=>0,'content'=>'');
		$id = $_REQUEST['id'];
		if(!empty($id))
		{
			$share_ids = explode ( ',', $id );
			D('Share')->removeHandler($share_ids);
			$this->saveLog(1,$id);
		}
		else
		{
			$result['isErr'] = 1;
			$result['content'] = L('ACCESS_DENIED');
		}
		die(json_encode($result));
	}

	public function removePhoto()
	{
		$photo_id = intval($_REQUEST['photo_id']);
		$photo_data = D("SharePhoto")->where("photo_id=".$photo_id)->find();
		D("SharePhoto")->where("photo_id=".$photo_id)->delete();
		//开始同步data
		$this->init_share_data($photo_data['share_id']);
		$err = D()->getDbError();
		if($err)
		{
			$result['isErr'] = 1;
			$result['content'] = $err;
		}
		else
		{
            Vendor('common');
			if($photo_data['base_id'] == 0)
			{
				$count = D("SharePhoto")->where("base_id=".$photo_id)->count();
				if($count == 0)
					deleteShareImg(FANWE_ROOT.$photo_data['img']);
			}
            
            $share_id = $photo_data['share_id'];
			deleteCache('share/'.getDirsById($share_id).'/imgs');
            deleteCache('share/'.getDirsById($share_id).'/detail');
			FS('Share')->updateShareCache($share_id,'imgs');
			$result['isErr'] = 0;
		}
		die(json_encode($result));
	}

	public function removeGoods()
	{
		$goods_id = intval($_REQUEST['goods_id']);
		$goods_data = D("ShareGoods")->where("goods_id=".$goods_id)->find();
		D("ShareGoods")->where("goods_id=".$goods_id)->delete();
		//开始同步data
		$this->init_share_data($goods_data['share_id']);
		$err = D()->getDbError();
		if($err)
		{
			$result['isErr'] = 1;
			$result['content'] = $err;
		}
		else
		{
            Vendor('common');
			if($goods_data['base_id'] == 0)
			{
				$count = D("ShareGoods")->where("base_id=".$goods_id)->count();
				if($count == 0)
					deleteShareImg(FANWE_ROOT.$goods_data['img']);
			}
            
            $share_id = $goods_data['share_id'];
			deleteCache('share/'.getDirsById($share_id).'/imgs');
            deleteCache('share/'.getDirsById($share_id).'/detail');
			FS('Share')->updateShareCache($share_id,'imgs');
			$result['isErr'] = 0;
		}
		die(json_encode($result));
	}

	public function update() {
		vendor("common");
		//B('FilterString');
		$name=$this->getActionName();
		$model = D ( $name );
		if (false === $data = $model->create ()) {
			$this->error ( $model->getError () );
		}
		
		$old_share = D ("Share")->getById($id);
		
		// 更新数据
		$list=$model->save();
		$id = $data[$model->getPk()];
		if (false !== $list) {
			$share = D ("Share")->getById($id);
			$rec_data = array();
			$rec_data['title'] = $share['title'];
			$rec_data['content'] = $share['content'];
			
			switch($share['type'])
			{
				case 'ask':
					D('AskThread')->where("share_id = '$id'")->save($rec_data);
					if($old_share['title'] !=  $share['title'])
						FS("Ask")->updateTopicRec($share['rec_id'],$share['title']);
				break;

				case 'ask_post':
					if($old_share['content'] !=  $share['content'])
						D('AskPost')->where("share_id = '$id'")->save($rec_data);
				break;

				case 'bar':
					D('ForumThread')->where("share_id = '$id'")->save($rec_data);
					if($old_share['title'] !=  $share['title'])
						FS("Topic")->updateTopicRec($share['rec_id'],$share['title']);
					FS("Topic")->updateTopicCache($share['rec_id']);
				break;

				case 'bar_post':
					if($old_share['content'] !=  $share['content'])
						D('ForumPost')->where("share_id = '$id'")->save($rec_data);
				break;
				
				case 'ershou':
					$rec_data1 = array();
					$rec_data1['name'] = $share['title'];
					$rec_data1['content'] = $share['content'];
					D('SecondGoods')->where("share_id = '$id'")->save($rec_data1);
				break;
			}
			
			$tags = ($_REQUEST['tags']);
			$tags = explode(" ",$tags);

            FS('Share')->updateShareTags($data['share_id'],array('user'=>implode(' ',$tags)));

			//更新分类
			$cates_arr = explode(",",$_REQUEST['share_cates']);
			foreach($cates_arr as $k=>$v)
			{
				$cates[] = intval($v);
			}

			FDB::query("delete from ".FDB::table("share_category")." where share_id = ".$data['share_id']);
			foreach($cates as $cate_id)
			{
				if(intval($cate_id) > 0)
                {
                    FDB::query("insert into ".FDB::table("share_category")."(`share_id`,`cate_id`) values($data[share_id],$cate_id)");
                }
			}
            FS('Share')->deleteShareCache($data['share_id']);
			//成功提示
			$this->saveLog(1,$id);
			//$this->assign ( 'jumpUrl', Cookie::get ( '_currentUrl_' ) );
			$this->success (L('EDIT_SUCCESS'));
		} else {
			//错误提示
			$this->saveLog(0,$id);
			$this->error (L('EDIT_ERROR'));
		}
	}
	
	public function comments()
	{
		if(isset($_REQUEST['share_id']))
			$share_id = intval($_REQUEST['share_id']);
		else
			$share_id = intval($_SESSION['share_comment_share_id']);
		
		$_SESSION['share_comment_share_id'] = $share_id;
		
		$this->assign ( 'share_id', $share_id );
		
		$where = 'WHERE sc.share_id = ' . $share_id;
		$parameter = array();
		$uname = trim($_REQUEST['uname']);

		if(!empty($uname))
		{
			$this->assign("uname",$uname);
			$parameter['uname'] = $uname;
			$match_key = segmentToUnicodeA($uname,'+');
			$where.=" AND match(u.user_name_match) against('".$match_key."' IN BOOLEAN MODE) ";
		}

		$model = M();
		
		$sql = 'SELECT COUNT(DISTINCT sc.comment_id) AS pcount 
			FROM '.C("DB_PREFIX").'share_comment AS sc 
			LEFT JOIN '.C("DB_PREFIX").'user AS u ON u.uid = sc.uid 
			'.$where;

		$count = $model->query($sql);
		$count = $count[0]['pcount'];

		$sql = 'SELECT sc.comment_id,LEFT(sc.content,80) AS content,u.user_name,sc.create_time,sc.share_id  
			FROM '.C("DB_PREFIX").'share_comment AS sc 
			LEFT JOIN '.C("DB_PREFIX").'user AS u ON u.uid = sc.uid 
			'.$where.' GROUP BY sc.comment_id';
		$this->_sqlList($model,$sql,$count,$parameter,'sc.comment_id',false,'returnUrl1');
		
		$this->display ();
		return;
	}
	
	public function editComment()
	{
		$model = D('ShareComment');
		Cookie::set ( '_currentUrl_',NULL );
		$id = $_REQUEST [$model->getPk ()];
		$vo = $model->getById($id);

		$this->assign ( 'vo', $vo );
		$this->display ();
	}
	
	public function updateComment()
	{
		$model = D('ShareComment');
		if (false === $data = $model->create ()) {
			$this->error ( $model->getError () );
		}
		// 更新数据
		$list=$model->save ();
		$id = $data['comment_id'];
		if (false !== $list) {
			//成功提示
			Vendor("common");
			$share_id = D('ShareComment')->where("comment_id = '$id'")->getField('share_id');
			$key = getDirsById($share_id);
			clearCacheDir('share/'.$key.'/commentlist');
			$this->saveLog(1,$id);
			$this->assign ( 'jumpUrl', Cookie::get ( '_currentUrl_' ) );
			$this->success (L('EDIT_SUCCESS'));
		} else {
			//错误提示
			$this->saveLog(0,$id);
			$this->error (L('EDIT_ERROR'));
		}
	}
	
	public function removeComment()
	{
		//删除指定记录
		$result = array('isErr'=>0,'content'=>'');
		$id = $_REQUEST['id'];
		if(!empty($id))
		{
			$model = D('ShareComment');
			$pk = 'comment_id';
			$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
			$count = $model->where( $condition )->count();
			$comments = $model->where($condition)->findAll();
			if(false !== $model->where($condition)->delete())
			{
				Vendor("common");
				$share_id = $_REQUEST['share_id'];
				$key = getDirsById($share_id);
				clearCacheDir('share/'.$key.'/commentlist');
				D('Share')->where("share_id = '$share_id'")->setDec('comment_count',$count);
				FS('Share')->updateShareCache($share_id,'comments');
				$this->saveLog(1,$id);
			}
			else
			{
				$this->saveLog(0,$id);
				$result['isErr'] = 1;
				$result['content'] = L('REMOVE_ERROR');
			}
		}
		else
		{
			$result['isErr'] = 1;
			$result['content'] = L('ACCESS_DENIED');
		}

		die(json_encode($result));
	}
	
	public function dapei()
	{
		$where = '';
		$parameter = array();
		$keyword = trim($_REQUEST['keyword']);
		$uname = trim($_REQUEST['uname']);
		$type = trim($_REQUEST['type']);
		$share_data = !isset($_REQUEST['share_data']) ? 'img' : trim($_REQUEST['share_data']);
		$cate_id = intval($_REQUEST['cate_id']);
		$status = !isset($_REQUEST['status']) ? 0 : intval($_REQUEST['status']);
		$inner_sql = '';
		
		$where .= " WHERE sp.type = 'dapei'";

		if(!empty($keyword))
		{
			$this->assign("keyword",$keyword);
			$parameter['keyword'] = $keyword;
			$match_key = segmentToUnicodeA($keyword,'+');
			$where.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
			$inner_sql .= 'INNER JOIN '.C("DB_PREFIX").'share_match AS sm ON sm.share_id = s.share_id ';
		}

		if(!empty($uname))
		{
			$this->assign("uname",$uname);
			$parameter['uname'] = $uname;
			$match_key = segmentToUnicodeA($uname,'+');
			$where.=" AND match(u.user_name_match) against('".$match_key."' IN BOOLEAN MODE) ";
            $like_name = mysqlLikeQuote($uname);
            $where .= ' AND u.user_name LIKE \'%'.$like_name.'%\'';
		}

		$model = M();

		$sql = 'SELECT COUNT(DISTINCT s.share_id) AS scount
			FROM '.C("DB_PREFIX").'share_photo AS sp
			INNER JOIN '.C("DB_PREFIX").'share AS s ON s.share_id = sp.share_id 
			LEFT JOIN '.C("DB_PREFIX").'user AS u ON u.uid = s.uid 
			'.$inner_sql.$where;

		$count = $model->query($sql);
		$count = $count[0]['scount'];

		$sql = 'SELECT s.share_id,LEFT(s.content,80) AS content,u.user_name,s.create_time,s.collect_count,s.relay_count,			s.comment_count,s.type,s.share_data,s.status,s.is_best 
			FROM '.C("DB_PREFIX").'share_photo AS sp  
			INNER JOIN '.C("DB_PREFIX").'share AS s ON s.share_id = sp.share_id 
			LEFT JOIN '.C("DB_PREFIX").'user AS u ON u.uid = s.uid 
			'.$inner_sql.$where.' GROUP BY s.share_id';
		$this->_sqlList($model,$sql,$count,$parameter,'s.share_id');
		
		$this->display ();
	}
	
	public function look()
	{
		$where = '';
		$parameter = array();
		$keyword = trim($_REQUEST['keyword']);
		$uname = trim($_REQUEST['uname']);
		$type = trim($_REQUEST['type']);
		$share_data = !isset($_REQUEST['share_data']) ? 'img' : trim($_REQUEST['share_data']);
		$cate_id = intval($_REQUEST['cate_id']);
		$status = !isset($_REQUEST['status']) ? 0 : intval($_REQUEST['status']);
		$inner_sql = '';
		
		$where .= " WHERE sp.type = 'look'";

		if(!empty($keyword))
		{
			$this->assign("keyword",$keyword);
			$parameter['keyword'] = $keyword;
			$match_key = segmentToUnicodeA($keyword,'+');
			$where.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
			$inner_sql .= 'INNER JOIN '.C("DB_PREFIX").'share_match AS sm ON sm.share_id = s.share_id ';
		}

		if(!empty($uname))
		{
			$this->assign("uname",$uname);
			$parameter['uname'] = $uname;
			$match_key = segmentToUnicodeA($uname,'+');
			$where.=" AND match(u.user_name_match) against('".$match_key."' IN BOOLEAN MODE) ";
            $like_name = mysqlLikeQuote($uname);
            $where .= ' AND u.user_name LIKE \'%'.$like_name.'%\'';
		}

		$model = M();

		$sql = 'SELECT COUNT(DISTINCT s.share_id) AS scount
			FROM '.C("DB_PREFIX").'share_photo AS sp
			INNER JOIN '.C("DB_PREFIX").'share AS s ON s.share_id = sp.share_id 
			LEFT JOIN '.C("DB_PREFIX").'user AS u ON u.uid = s.uid 
			'.$inner_sql.$where;

		$count = $model->query($sql);
		$count = $count[0]['scount'];

		$sql = 'SELECT s.share_id,LEFT(s.content,80) AS content,u.user_name,s.create_time,s.collect_count,s.relay_count,			s.comment_count,s.type,s.share_data,s.status,s.is_best 
			FROM '.C("DB_PREFIX").'share_photo AS sp  
			INNER JOIN '.C("DB_PREFIX").'share AS s ON s.share_id = sp.share_id 
			LEFT JOIN '.C("DB_PREFIX").'user AS u ON u.uid = s.uid 
			'.$inner_sql.$where.' GROUP BY s.share_id';
		$this->_sqlList($model,$sql,$count,$parameter,'s.share_id');
		
		$this->display ();
	}

	private function init_share_data($share_id)
	{
		$photo_count = D("SharePhoto")->where("share_id=".$share_id)->count();
		$goods_count = D("ShareGoods")->where("share_id=".$share_id)->count();
		if($photo_count==0&&$goods_count==0)
		{
			$share_data = "default";
		}
		elseif($photo_count==0&&$goods_count>0)
		{
			$share_data = "goods";
		}
		elseif($photo_count>0&&$goods_count==0)
		{
			$share_data = "photo";
		}
		else
		{
			$share_data = "goods_photo";
		}
		D("Share")->where("share_id=".$share_id)->setField("share_data",$share_data);
	}
}

function getCommentCount($count,$share_id)
{
	if($count>0)
		return "(".$count.")&nbsp;&nbsp; <a href='".u("Share/comments",array("share_id"=>$share_id))."'>".l("CHECK_COMMENT")."</a>";
	else
		return $count;
}
?>