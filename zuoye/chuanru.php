<?php
	$mysqli = new mysqli("localhost","root","","wyldb");
	
	if($mysqli->connect_error){
		exit("连接数据库失败");
	}
	
	$mysqli->set_charset("utf8");
	
	$sql = "select * from students";
	
	$res = $mysqli->query($sql);
	
	$arr = mysqli_fetch_all($res,MYSQLI_ASSOC);
	
	$jsonStr = json_encode($arr);
	
	echo $jsonStr;
	
	$mysqli->close();
?>