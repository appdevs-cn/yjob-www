<?php
/**
 * 74cms 微信支付
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

 if(!defined('IN_QISHI'))
 {
 	die('Access Denied!');
 }
 //获取安装代码
function pay_info()
{
$arr['p_introduction']="微信支付简短描述：";
$arr['notes']="微信支付详细描述：";
$arr['fee']="微信支付交易手续费：";
return $arr;
}
?>