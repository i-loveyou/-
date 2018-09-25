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
	$headUrl = $infoObj->headimgurl;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<link rel="stylesheet" type="text/css" href="css/animate.min.css"/>
	<link rel="stylesheet" href="css/game.css" />
	<title>数钱游戏</title>
</head>
<body>
	<div class="wrap">
		<!--预加载页面-->
		<section class="preload">
				<!--进度-->
				<p class="progress">0%</p>
		</section>
		<!--page1-->
		<section class="page1">
			<img src="img/tiaozhan.png" alt="" />
			<img src="img/yingqu.png" alt="" />
			<img src="img/start_game.png" alt="" id="start"/>
			<img src="img/shou.png" alt="" />
			
			<!--选项卡-->
			<div class="menuBar">
				<img src="img/ranking.png" alt="" />
				<img src="img/activity_rule.png" alt="" />
				<img src="img/prize.png" alt="" />
				<img src="img/shiyong.png" alt="" />
			</div>
			<!--排行榜-->
			<div class="rank">
				<ul>
					<li>
						<img src="img/p1_first.png" alt="" />
						<img src="img/shizhong.png" alt="" class="clock"/>
						<p class="name">暂无</p>
						<p class="score">0分</p>
					</li>
					<li>
						<img src="img/p1_second.png" alt="" />
						<img src="img/shizhong.png" alt="" class="clock"/>
						<p class="name">暂无</p>
						<p class="score">0分</p>
					</li>
					<li>
						<img src="img/p1_third.png" alt="" />
						<img src="img/shizhong.png" alt="" class="clock"/>
						<p class="name">暂无</p>
						<p class="score">0分</p>
					</li>
					<li>
						<p>4</p>
						<img src="img/shizhong.png" alt="" class="clock"/>
						<p class="name">暂无</p>
						<p class="score">0分</p>
					</li>
					<li>
						<p>5</p>
						<img src="img/shizhong.png" alt="" class="clock"/>
						<p class="name">暂无</p>
						<p class="score">0分</p>
					</li>
					<!--关闭按钮-->
					<div class="closeBtn"></div>
				</ul>
			</div>
		</section>
		<!--page2-->
		<section class="page2">
			<div class="message">
				<img src="img/p2_txt1.png" alt="" />
			</div>
			<div class="score_time">
				<span class="count">0</span>
				<span class="count">0</span>
				<span class="count">0</span>
				<span class="time">20</span>
			</div>
			
			<!--游戏区域-->
			<div class="moneyRoom">
				<img src="img/p2_qian.jpg" alt="" />
			</div>
			
			<!--手-->
			<img src="img/p2_shou.png" alt="" class="shou"/>
			<!--墙-->
			<img src="img/p2_zhuan.png" alt="" class="qiang"/>
		</section>
		<!--page3-->
		<section class="page3">
			<img src="img/p3_acquire.png" alt="" />
			<p id="score">¥0</p>
			<p>没办法!你已经强的没有对手</p>
			<p id="best">我的辉煌战绩:0 排位:0</p>
			<img src="img/p3_again.png" alt="" id="again"/>
		</section>
	</div>
	<script type="text/javascript">
		<?
			echo "var nickName = '{$nickName}';";
			echo "var headUrl = '{$headUrl}';";
			echo "var openId = '{$openid}';";
		?>
	</script>
	<script src="js/zepto.min.js" type="text/javascript"></script>
	<script src="js/game.js"></script>
</body>
</html>