<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * 主平台公共控制器
 */
class Common extends Controller
{
	/**
	 * 修改状态值
	 * @return [type] [description]
	 */
	public function status()
	{
		$data = input('get.');

        // 验证
        $controller = request()->controller();
        $validate = validate($controller);
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }

        $msg = ($data['status'] == -1 ) ? '删除' : '状态修改';
        $saveData = ['status' => intval($data['status'])];
        $where = ['id' => intval($data['id'])];
        $result = model($controller)->where($where)->update($saveData);
        if($result === false){
            $this->error($msg . '失败，请重试');
        }
        else{
        	$this->success($msg . '成功');
        }
	}
}