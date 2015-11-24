<?php
class Yy_Upmp_Upmp{
	public static function getUpmpTn($orderNumber,$orderDescription,$totalPrice,$mer_front_end_url,$deadtime,$notify_url){
		//需要填入的部分
		$req['version']     		= Yy_Upmp_Config::$version; // 版本号
		$req['charset']     		= Yy_Upmp_Config::$charset; // 字符编码
		$req['transType']   		= "01"; // 交易类型
		$req['merId']       		= Yy_Upmp_Config::$mer_id; // 商户代码
		$req['backEndUrl']      	= $notify_url; // 通知URL
		$req['frontEndUrl']     	= $mer_front_end_url; // 前台通知URL(可选)
		$req['orderDescription']	= $orderDescription;// 订单描述(可选)
		$req['orderTime']   		= date("YmdHis"); // 交易开始日期时间yyyyMMddHHmmss
		$req['orderTimeout']   		= ""; // 订单超时时间yyyyMMddHHmmss(可选)
		$req['orderNumber'] 		= $orderNumber; //订单号(商户根据自己需要生成订单号)
		$req['orderAmount'] 		= $totalPrice; // 订单金额
		$req['orderCurrency'] 		= "156"; // 交易币种(可选)
		$req['reqReserved'] 		= "虹桥医游网"; // 请求方保留域(可选，用于透传商户信息)
		
		// 保留域填充方法
		$merReserved['Merchant']   		= "虹桥医游网";
		$req['merReserved']   		= Yy_Upmp_Service::buildReserved($merReserved); // 商户保留域(可选)
		
		$resp = array ();
		$validResp = Yy_Upmp_Service::trade($req, $resp);
		
		// 商户的业务逻辑
		if ($validResp){
			//var_dump($req);exit;
			// 服务器应答签名验证成功
			//print_r($resp);exit;
			return $resp['tn'];
		}else {
			// 服务器应答签名验证失败
			//print_r($resp);
		}
	}
}
