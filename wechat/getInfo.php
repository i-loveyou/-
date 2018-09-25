<?php
	require_once "network.php";
	//获取code
	$code = $_GET["code"];
	//通过code获取网页授权的access_token
	$tokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx31325261f851fbc6&secret=52fb515ca1e83954c116953f69eeb869&code={$code}&grant_type=authorization_code";
	
	$tokenJson = httpGet($tokenUrl);
	
	$tokenObj = json_decode($tokenJson);
	
	//分别获取token和openid
	$at = $tokenObj->access_token;
	$openid = $tokenObj->openid;
	
	//拉取用户信息
	$infoStr = "https://api.weixin.qq.com/sns/userinfo?access_token={$at}&openid={$openid}&lang=zh_CN";
	
	$infoJson = httpGet($infoStr);
	$infoObj = json_decode($infoJson);
	
	//获取用户名,性别,头像url地址
	$nickName = $infoObj->nickname;
	$sex = $infoObj->sex == "1" ? "男" : "女";
	$headUrl = $infoObj->headimgurl;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>用户信息</title>
</head>
<body>
	<p><span>昵称:</span><?echo $nickName;?></p>
	<p><span>性别:</span><?echo $sex;?></p>
	<?
		echo "<img src='{$headUrl}'>";
	?>
</body>
</html>