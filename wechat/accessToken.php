<?php
	require_once "network.php";
	/*
	 * accessToken的处理逻辑:
	 * 每次需要accessToken时,先从数据库里获取并判断是否过期,如果过期,重新获取,没有过期,直接返回.
	 * 
	 */
	 
	//获取新的accessToken,该方法不需要外部调用
	function getNewAccessToken(){
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx31325261f851fbc6&secret=52fb515ca1e83954c116953f69eeb869";
		
		//发起get请求
		$jsonStr = httpGet($url);
		
		//解码json串
		$obj = json_decode($jsonStr);
		
		return $obj->access_token;
	}

	//获取accessToken,该方法是外部需要token时调用的方法
	function getAccessToken(){
		//连接数据库
		$mysqli = new mysqli("qsbmcrhtztqj.mysql.sae.sina.com.cn","wyl_wechat01","wyl2314926967","wyl","10472");
		
		if($mysqli->connect_error){
			exit("数据库连接失败");
		}
		
		$mysqli->set_charset("utf8");
		
		/*
		 * 第一次使用token:判断查询结果数组元素个数,如果为0,请求新的toke,插入数据库,将token返回.
		 * 之后使用token:
		 * 		过期:重新请求新的token,更新数据库数据,将token返回
		 * 		没过期:直接将token返回
		 */
		$selectSql = "select * from access_token";
		
		$res = $mysqli->query($selectSql);
		
		$arr = mysqli_fetch_all($res,MYSQLI_NUM);
		
		if(count($arr) == 0){
			//请求新的token,并插入数据库
			$newToken = getNewAccessToken();
			//获取时间戳   单位:s
			$time = time();
			
			$insertSql = "insert into access_token (token,time) values ('{$newToken}','{$time}')";
			
			if(!$mysqli->query($insertSql)){
				exit("插入数据失败");
			}
			return $newToken;
		}else{
			//判断token是否过期
			$obj = $arr[0];
			
			//取到时间戳字段
			$time = $obj[1];
			//获取当前时间戳
			$now = time();
			if($now - $time > 7100){
				//token已过期,重新获取toke,更新数据库,返回新的token
				$token = getNewAccessToken();
				$updateStr = "update access_token set token='{$token}',time='{$now}'";
				if(!$mysqli->query($updateStr)){
					exit("更新数据失败");
				}
				return $token;
			}else{
				//token未过期
				return $obj[0];
			}
		}
		
	}

?>