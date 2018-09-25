<?php
	$id = $_REQUEST["id"];
	$name = $_REQUEST["name"];
	$age = $_REQUEST["age"];
	$sex = $_REQUEST["sex"];
	$school = $_REQUEST["school"];
	
	$mysqli = new mysqli("localhost","root","","wyldb");
	
	if($mysqli->connect_error){
		exit("数据库连接失败");
	}
	
	$mysqli->set_charset("utf8");
	
	$sql = "insert into students (id,name,age,sex,school,caozuo) values ('{$id}','{$name}','{$age}','{$sex}','{$school}','删除')";
	
	$res = $mysqli->query($sql);
	
	
	if($res){
		echo 1;
	}else{
		echo 0;
	}
	
	
	$mysqli->close();
?>