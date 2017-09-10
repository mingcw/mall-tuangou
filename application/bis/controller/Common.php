<?php
namespace app\bis\controller;
use think\Controller;

/**
 * 商户模块公共控制器
 */
class Common extends Controller
{
	// 已登录商户session
	public $bis;

	protected function _initialize()
    {
        // 商户登录判断
        $isLogin = $this->isLogin();
        if(!$isLogin){
        	$this->redirect('login/index');
        }
    }

    /**
     * 是否已登录
     * @return boolean [description]
     */
    public function isLogin()
    {
    	$bis = $this->getLoginBis();
    	if($bis && $bis->id){
    		return true;
    	}
    	return false;
    }

    /**
     * 获取已登录商户session
     * @return [type] [description]
     */
    public function getLoginBis(){
    	if(!$this->bis){
    		$this->bis = session('bisAccount');
    	}
    	return $this->bis;
    }
}