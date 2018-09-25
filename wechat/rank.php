<?php
	//连接数据库
	$mysqli = new mysqli("qsbmcrhtztqj.mysql.sae.sina.com.cn","wyl_wechat01","wyl2314926967","wyl","10472");
	
	if($mysqli->connect_error){
		exit("数据库连接失败");
	}
	
	$mysqli->set_charset("utf8");
	
	//对数据通过best字段降序排序并取前5条数据
	$sqlStr = "select * from users order by best desc limit 5";
	
	$res = $mysqli->query($sqlStr);
	
	$arr = mysqli_fetch_all($res,MYSQLI_ASSOC);
	
	echo json_encode($arr);
	
	$mysqli->close();
?>