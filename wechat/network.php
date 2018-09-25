<?php
//把网络请求封装成函数, 写到该文件中, 如果需要使用网络请求, 就导入该文件
//使用php来发送请求

//通过curl的方式发送请求(微信公众号推荐的方式)

function httpGet($url) {
	//A.初始化curl请求
	$curl = curl_init();
	//B.配置请求	
	//1.返回的数据以文件流的形式返回
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	//2.超时时间
	curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	//3.请求的url
	curl_setopt($curl, CURLOPT_URL, $url);
	//如果需要支持https请求
	//4.开启ssl验证
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	//5.支持所有主机的https请求, 2代表所有
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	//C.执行请求, 并获取响应数据
	$response = curl_exec($curl);
	//D.断开请求
	curl_close($curl);
	//E.返回数据
	return $response;
}

function httpPost($url, $data, $isJson = false) {
	//A.初始化curl请求
	$curl = curl_init();
	//B.配置请求	
	//1.返回的数据以文件流的形式返回
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	//2.超时时间
	curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	//3.请求的url
	curl_setopt($curl, CURLOPT_URL, $url);
	//4.请求的参数(application/x-www-form-urlencoded)
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	//如果参数类型不是application/x-www-form-urlencoded, 需要修改contentype
	if ($isJson) {
	  curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type:application/json"));
	}
	//如果需要支持https请求
	//5.开启ssl验证
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	//6.支持所有主机的https请求, 2代表所有
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	//C.执行请求, 并获取响应数据
	$response = curl_exec($curl);
	//D.断开请求
	curl_close($curl);
	//E.返回数据
	return $response;
}

?>