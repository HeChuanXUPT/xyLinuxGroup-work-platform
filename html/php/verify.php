<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/common.css">
		<script type="text/javascript" src="../js/common.js"></script>
	</head>

	<body>
		<?php
		$name=$_POST["name"];
		$name=trim($name);
		$con=mysql_connect("localhost","hechuan","sqlchuan");
		if(!$con){
			die("could not connect: ".mysql_error());
		}
		mysql_select_db("web",$con);
		$command="select pwd from passwd where user=\"$name\"";
		$res=mysql_query($command);
		$row=mysql_fetch_array($res);
		mysql_close($con);
		if(!$row) {
			echo '<div class="msg"><h2>没有该用户</h2>';
		} else if($row[0] != $_POST["password"]) {
			echo '<div class="msg"><h2>密码错误</h2>';
		} else {
			session_start();
			$_SESSION['user']=$name;
			if ($name == 'hechuan')
				echo '<script>location.assign("../workspace/admin.php")</script>';
			else
				echo '<script>location.assign("../workspace/user.php")</script>';
		}
		?>
		<button class='hc_btn' onclick='goback()'>返 回</button></div>
	</body>
</html>
