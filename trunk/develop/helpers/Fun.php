<?php
namespace app\helpers;
use yii;
class Fun {
	/**
	 * 校验手机格式
	 * @param  string  $mobile 手机号码
	 * @return boolean
	 */
	public static function isMobile($mobile) {
	    if (!is_numeric($mobile)) {
	        return false;
	    }
	    return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
	 }

	/**
	 * 当前路由校验
	 * @param  [type]  $route 路由
	 * @return boolean        是否是当前路由
	 */
	// public static  function isActiveRoute($route)
	// {
	//     $module     = Yii::$app->controller->module->id;
	//     $controller = Yii::$app->controller->id;
	//     $action     =  Yii::$app->controller->action->id;
	//     if(  is_array($item)  ){
	//         if(  $rout === $action  )return true;
	//         if(  $rout === $controller.'/'.$action  )return true;
	//         if(  $rout === $module.'/'.$controller.'/'.$action  )return true;
	//     }
	//     return false;
	// }

	/**
     * 当前路由判断
     * @param  [type]  $route 路由
     * @return boolean        是否是当前路由
     */
    public static  function isActiveRoute($route)
    {
        if(  is_array($route)  )$route = $route[0];
        $_route = '/'.Yii::$app->requestedRoute;
        $separator = '/';
        $action = Yii::$app->controller->action->id;
        $controller = Yii::$app->controller->id;
        $module = Yii::$app->controller->module->id;
        if(  $route === '*'  )return true;        
        if(  $route == $controller.$separator.$action  )return true;
        if(  $route == $separator.$module )return true;
        if(  $route == $separator.$module.$separator.$controller  )return true;
        if(  $route == $separator.$module.$separator.$controller.$separator.$action  )return true;

        return false;
    }



}