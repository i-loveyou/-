<?php
	//获取前台传来的数据
	$id = $_REQUEST["id"];
	$name = $_REQUEST["name"];
	$head = $_REQUEST["head"];
	$score = $_REQUEST["score"];
	
	//连接数据库
	$mysqli = new mysqli("qsbmcrhtztqj.mysql.sae.sina.com.cn","wyl_wechat01","wyl2314926967","wyl","10472");
	
	if($mysqli->connect_error){
		exit("数据库连接失败");
	}
	
	$mysqli->set_charset("utf8");
	
	/*
	 * 首先判断该用户是否是第一次玩游戏,如果是,做的是插入数据操作;如果不是第一次,做的是更新数据操作
	 */
	$sqlStr = "select * from users where id = '{$id}'";
	$res = $mysqli->query($sqlStr);
	
	if($res->num_rows ==0){
		//插入数据操作
		$insertStr = "insert into users (id,name,head,score,best) values ('{$id}','{$name}','{$head}',{$score},{$score})";
		$mysqli->query($insertStr);
	}else{
		//更新数据操作
		$obj = $res->fetch_object();
		$best = $obj->best;
		if($score > $best){
			//同时更新最好分数与当前分数
			$updateStr = "update users set score={$score},best={$score} where id = '{$id}'";
		}else{
			//只更新当前分数
			$updateStr = "update users set score={$score} where id = '{$id}'";
		}
		$mysqli->query($updateStr);
	}
	$mysqli->close();
	echo 1;
?>