<?php
namespace Common\Model;
use Common\Model\CommonModel;
class UserModel extends CommonModel{
	private $redis_key_arr=array(
		'user_info_id' => 'user_info_id_',
	);
	//自动验证
	// protected $_validate = array(
	// 		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
	// 		array('ad_name', 'require', '广告名称不能为空！', 1, 'regex', 3),
	// );
	
	// protected function _before_write(&$data) {
	// 	parent::_before_write($data);
	// }
	public function get_info_by_id ($user_id) {
		$redis_key = $redis_key_arr['user_info_id'] . $user_id;
		$redis_key = md5($redis_key);
		$res = S($redis_key);
		if ($res === false) {
			$condition['id'] = $user_id;
			$res = $this->where($condition)->find();
			if ($res !== false)
				clear_cache($data['id']);
		}
		return $res;
	}

	/*
	 * 增加微信用户
	 */
	public function add_data($data)
	{
		$res = $this->add($data);
		return $res;
	}

	/*
	 * 更新微信用户
	*/
	public function save_data($data)
	{
		$redis_key = $redis_key_arr['user_info_id'] . $data['id'];
		$redis_key = md5($redis_key);
		$condition['id'] = $data['id'];
		$res = $this->where($condition)->save($data);
		if ($res !== false) {
			clear_cache($data['id']);
		}
		return $res;

	}
	/*
	 * 改编商品状态
	*/
	protected function clear_cache($user_id)
	{
		$redis_key = $redis_key_arr['user_info_id'] . $user_id;
		S($redis_key, null);
		return $res;
	}

}