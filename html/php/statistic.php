<?php
	session_start();
	$name = $_SESSION['user'];

	if ($name != "hechuan") {
		$response="没有权限";
		echo $response;
		die();
	}

	$sdate=$_GET["s"];
	$edate=$_GET["e"];

	$con=mysql_connect('localhost','hechuan','sqlchuan');
	if (!$con) {
		die("could not connect: ".mysql_error());
	}
	mysql_select_db('web',$con);

	$command="select * from works where date>='$sdate' and date<='$edate';";
	$res=mysql_query($command);
	
	$response="";
	while($row = mysql_fetch_array($res)) {
		$response=sprintf("%s\n姓名：%s\n本周工作：\n%s\n下周计划：\n%s\n",
		   	$response, $row['user'], $row['works'], $row['plan']);
	}
	mysql_close($con);

	$response=trim($response);

	echo $response;
?>
