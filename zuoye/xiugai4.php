<?php
	$id = $_REQUEST["id"];
	$school = $_REQUEST["school"];
	
	$mysqli = new mysqli("localhost","root","","wyldb");
	
	if($mysqli->connect_error){
		exit("数据库连接失败");
	}
	
	$mysqli->set_charset("utf8");
	
	$sql = "update students set school = '{$school}' where id = '{$id}'";
	
	$res = $mysqli->query($sql);

	if($res){
		echo 1;
	}else{
		echo 0;
	}
	

	$mysqli->close();
?>