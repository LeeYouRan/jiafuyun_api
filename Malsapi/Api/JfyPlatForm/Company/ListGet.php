<?php
/**
 * 默认接口服务类
 *
 * @author: Dm
 */
class Api_JfyPlatForm_Company_ListGet extends PhalApi_Api {
	
	public function getRules() {
		return array (
				 'Go' => array(
                     'loginName' => array('name' => 'login_name', 'type' => 'string',  'require' => false, 'desc' => '手机号码'),
                     'name' => array('name' => 'name', 'type' => 'string', 'require' => false, 'desc' => '公司名称'),
                     'isEnable' => array('name' => 'is_enable','type' => 'enum','range'=>array('y','n','all'), 'default'=>'all','require' => true, 'desc' => '是否禁用:y 是;n 否'),
                     'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default'=>1,'require' => true, 'desc' => '页码'),
                     'pageSize' => array('name' => 'page_size', 'type' => 'int', 'min' => 1,'default'=>20, 'require' => true, 'desc' => '每页显示'),
                     'orderby' => array('name' => 'orderby','type' => 'enum','range'=>array('id:asc','id:desc'), 'default'=>'id:asc','require' => true, 'desc' => '排序方式'),
            ),
		);
 	}

  /**
     * 平台获取服务商列表
     * #desc 用于平台获取服务商列表
     * #return int code 操作码，0表示成功
     */
    public function Go() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());

        $filter = array();
        if($this->isEnable != 'all'){
            $filter['is_enable'] = $this->isEnable;
        }
        if(!empty($this->loginName)){
            $filter['login_name'] = $this->loginName;
        }
        if(!empty($this->name)){
            $filter['name LIKE ?'] = '%'.$this->name.'%';
        }

        $domain = new Domain_Company_User();
        $list = $domain->getAllByPage($filter,$this->page,$this->pageSize,$this->orderby);
        $total = $domain->getCount($filter);

        $rs['list'] = $list;
        $rs['total'] = $total;

        return $rs;
    }

}
