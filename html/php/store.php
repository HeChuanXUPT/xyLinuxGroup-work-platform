<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/common.css">
		<script type="text/javascript" src="../js/common.js"></script>
	</head>
	<body>
		<?php
			session_start();
			$name = $_SESSION['user'];
			$work_done=$_POST["work_done"];
			$work_done=trim($work_done);
			$work_plan=$_POST["work_plan"];
			$work_plan=trim($work_plan);
			
			$con=mysql_connect('localhost','hechuan','sqlchuan');
			if (!$con) {
				die("could not connect: ".mysql_error());
			}
			mysql_select_db('web',$con);

			if($_SESSION['norecord']) { // empty
				// insert
				$command="insert into works values('$name', CURDATE(), '$work_done', '$work_plan');";
				mysql_query($command);
			}else {
				// update
				$command="update works set works='$work_done', plan='$work_plan' where user='$name' and date=CURDATE();";
				mysql_query($command);
			}
			mysql_close($con);
		?>
		<div class='msg'>
			<h1>提交成功</h1>
			<button class='hc_btn' onclick='goback()'>返 回</button>
		</div>
	</body>
</html>
