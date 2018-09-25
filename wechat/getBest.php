<?php
	$id = $_REQUEST["id"];
	//连接数据库
	$mysqli = new mysqli("qsbmcrhtztqj.mysql.sae.sina.com.cn","wyl_wechat01","wyl2314926967","wyl","10472");
	
	if($mysqli->connect_error){
		exit("数据库连接失败");
	}
	
	$mysqli->set_charset("utf8");
	
	$sqlStr = "select * from users where id = '{$id}'";
	
	$res = $mysqli->query($sqlStr);
	
	$obj = $res->fetch_object();
	
	//获取最好分数和当前分数
	$score = $obj->score;
	$best = $obj->best;
	
	$sqlStr1 = "select * from users where best>{$best}";
	
	$res1 = $mysqli->query($sqlStr1);
	
	$rank = $res1->num_rows + 1;
	
	$arr = array("best"=>$best,"score"=>$score,"rank"=>$rank);
	
	echo json_encode($arr);
	
	$mysqli->close();
?>