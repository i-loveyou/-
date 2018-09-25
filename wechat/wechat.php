<?php
	require_once "network.php";
	function getSHA1($token, $timestamp, $nonce)
	{
		//将$token, $timestamp, $nonce 封装成数组
		$array = array($token, $timestamp, $nonce);
		//字典序排序
		sort($array, SORT_STRING);
		//拼接成字符串
		$str = implode($array);
		//进行sha1加密并返回
		return array(sha1($str));
	}
	
	//声明微信配置验证的函数
	function checkSign(){
		//获取微信发来的四个参数
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
		$echostr = $_GET["echostr"];
		//token
		$token = "wyl";
		$arr = getSHA1($token, $timestamp, $nonce);
		if($arr[0] == $signature){
			echo $echostr;
		}
	}
	
	//做判断,是需要验证配置信息还是要处理信息
	if(isset($_GET["echostr"])){
		//验证配置信息
		checkSign();
	}else{
		//处理消息
		responseMessage();
	}
	
	//处理消息并回复
	function responseMessage(){
		//获取post过来的xml数据包
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if(empty($postStr)){
			exit;
		}
		
		/*
		 * 将xml字符串转化成可以直接使用的xml对象
		 * simplexml_load_string(要解析的xml字符串,解析成的类型,如何处理节点里的内容)
		 */
		 $xmlObj = simplexml_load_string($postStr,"SimpleXMLElement",LIBXML_NOCDATA);
		 
		//将消息分成两类(普通消息和时间推送)
		if($xmlObj->MsgType == "event"){
			//推送消息
			switch ($xmlObj->EventKey) {
				case 'sendText':{
					sendTextMessage($xmlObj,"哈哈哈");
					break;
				}
				case 'sendImg':{
					sendImageMessage($xmlObj);
					break;
				}
				case 'sendVoice':{
					break;
				}
				case 'sendVideo':{
					sendVideoMessage($xmlObj);
					break;
				}
				case 'sendArticles':{
					sendArticlesMessage($xmlObj);
					break;
				}
			}
		}else{
			//普通消息
			switch($xmlObj->MsgType){
				case 'text':{
					tulingRobot($xmlObj);
					break;
				}
				case 'image':{
					sendSameImg($xmlObj);
					break;
				}
				case 'location':{
					sendWeather($xmlObj);
					break;
				}
			}
		}
	}
	
	//回复文本消息函数
	function sendTextMessage($obj,$content){
		//获取发送者与接收者
		$to = $obj->FromUserName;
		$from = $obj->ToUserName;
		//时间戳
		$time = time();
		
		$message = <<<MSG
		<xml><ToUserName><![CDATA[{$to}]]></ToUserName><FromUserName><![CDATA[{$from}]]></FromUserName><CreateTime>{$time}</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[{$content}]]></Content></xml>	
MSG;
		//回复消息
		echo $message;
	}
	
	//回复图片消息函数
	function sendImageMessage($obj){
		//获取发送者与接收者
		$to = $obj->FromUserName;
		$from = $obj->ToUserName;
		//时间戳
		$time = time();
		
		$message = <<<MSG
		<xml><ToUserName><![CDATA[{$to}]]></ToUserName><FromUserName><![CDATA[{$from}]]></FromUserName><CreateTime>{$time}</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[n3m4LFUAduHx4Gpk6JIkxD_1l0niMMuOlUPX9yLLfDUA6kEp-II2T6n95Hjl6IQN]]></MediaId></Image></xml>
MSG;
	echo $message;
	}
	
	//回复语音消息函数
	function sendVideoMessage($obj){
		//获取发送者与接收者
		$to = $obj->FromUserName;
		$from = $obj->ToUserName;
		//时间戳
		$time = time();
		
		$message = <<<MSG
		<xml><ToUserName><![CDATA[{$to}]]></ToUserName><FromUserName><![CDATA[{$from}]]></FromUserName><CreateTime>{$time}</CreateTime><MsgType><![CDATA[video]]></MsgType><Video><MediaId><![CDATA[1jD38OqqmnVYf43HodTwO8hn2-ivX91gHJGNtdPwGWvnmLjJe8JaXnbYECtkksGO]]></MediaId><Title><![CDATA[北极熊]]></Title><Description><![CDATA[北极熊游览记]]></Description></Video></xml>
MSG;
	echo $message;
	}
	
	//回复图文消息
	function sendArticlesMessage($obj){
		//获取发送者与接收者
		$to = $obj->FromUserName;
		$from = $obj->ToUserName;
		//时间戳
		$time = time();
		$message = <<<MSG
		<xml><ToUserName><![CDATA[{$to}]]></ToUserName><FromUserName><![CDATA[{$from}]]></FromUserName><CreateTime>{$time}</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>2</ArticleCount><Articles><item><Title><![CDATA[啦啦啦1号]]></Title><Description><![CDATA[啦啦啦1号就位]]></Description><PicUrl><![CDATA[http://f.hiphotos.baidu.com/image/pic/item/8694a4c27d1ed21bfb91c832a66eddc450da3f89.jpg]]></PicUrl><Url><![CDATA[https://www.baidu.com/]]></Url></item><item><Title><![CDATA[啦啦啦2号]]></Title><Description><![CDATA[啦啦啦2号就位]]></Description><PicUrl><![CDATA[http://f.hiphotos.baidu.com/image/pic/item/6159252dd42a283441d4d0dc50b5c9ea14cebff3.jpg]]></PicUrl><Url><![CDATA[https://www.baidu.com/]]></Url></item></Articles></xml>
MSG;
		echo $message;
	}
	
	//机器人对话
	function tulingRobot($obj){
		//获取到用户输入的文本信息
		$content = $obj->Content;
		
		$url = "http://www.tuling123.com/openapi/api?key=d8aab395bb02478faa67830b4fc53cbc&info={$content}";
		
		$jsonStr = httpGet($url);
		
		$jsonObj = json_decode($jsonStr);
		
		$resText = $jsonObj->text;
		
		sendTextMessage($obj,$resText);
	}
	
	//回复相同图片的方法
	function sendSameImg($obj){
		//获取发送者与接收者
		$to = $obj->FromUserName;
		$from = $obj->ToUserName;
		//时间戳
		$time = time();
		//获取mediaID
		$mediaId = $obj->MediaId;
		
		$message = <<<MSG
		<xml><ToUserName><![CDATA[{$to}]]></ToUserName><FromUserName><![CDATA[{$from}]]></FromUserName><CreateTime>{$time}</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[{$mediaId}]]></MediaId></Image></xml>
MSG;
	echo $message;
	}
	
	//回复地理位置的天气状况
	function sendWeather($obj){
		//获取经纬度
		$lx = $obj->Location_X;
		$ly = $obj->Location_Y;
		
		$url = "https://api.seniverse.com/v3/weather/now.json?key=mlfy5bolrupe7b7s&location={$lx}:{$ly}&language=zh-Hans&unit=c";
		
		//发起网络请求
		$jsonStr = httpGet($url);
		
		//解码
		$jsonObj = json_decode($jsonStr);
		
		$name = $jsonObj->results[0]->location->name;
		$weather = $jsonObj->results[0]->now->text;
		$temperature = $jsonObj->results[0]->now->temperature;
		
		//拼接成字符串
		$allInfo = "城市:{$name},天气:{$weather},温度:{$temperature}°C";
		
		sendTextMessage($obj,$allInfo);
	}
?>