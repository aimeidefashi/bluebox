<?php
namespace Common\Model;
use Common\Model\CommonModel;
class GoodsTypeModel extends CommonModel{

	private $redis_key_arr=array(
		'goods_type_info_id' => 'goods_type_info_id_',
	);   

	//单条信息key前缀
	//自动验证
	// protected $_validate = array(
	// 		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
	// 		array('ad_name', 'require', '广告名称不能为空！', 1, 'regex', 3),
	// );
	
	// protected function _before_write(&$data) {
	// 	parent::_before_write($data);
	// }
	public function get_goods_type_list () {
		
		$redis_key = $redis_key_arr['goods_type_info_id'] . $type_id;
		$redis_key = md5($this->get_cache_flag_val() . $redis_key);
		$res = S($redis_key);
		if ($res === false) {
			$res = $this->select();
			if ($res !== false)
				S($redis_key, $res);
		}
		return $res;
	}

	/*
	 * 增加商品分类记录
	 */
	public function add_data($data)
	{
		$res = $this->add($data);
		$this->reset_cache_flag_val();
		return $res;
	}

	/*
	 * 更新商品分类信息
	*/
	public function save_data($data)
	{
		$redis_key = $redis_key_arr['goods_type_info_id'] . $data['id'];
		$redis_key = md5($this->get_cache_flag_val() . $redis_key);
		$condition['id'] = $data['id'];
		$res = $this->where($condition)->save($data);
		if ($res !== false) {
			S($redis_key, null);
		}
		return $res;

	}

}