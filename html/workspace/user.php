<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/common.css">
	</head>
	<body>
		<h1 style='text-align:center;margin-top:50px;'>
			<?php 
			session_start();
			if(isset($_SESSION['user'])) {
				$name = $_SESSION['user'];
				echo "<br><br>";
				echo $name, "的工作平台", "<br><br>";
				echo date("Y-m-d");

				$con=mysql_connect('localhost','hechuan','sqlchuan');
				if (!$con) {
					die("could not connect: ".mysql_error());
				}
				mysql_select_db('web',$con);
				$command="select * from works where user='$name' and date=CURDATE()";
				$res=mysql_query($command);
				$row=mysql_fetch_array($res);
				if(!$row) { // empty
					$_SESSION['norecord']=true;
					$_SESSION['work_done']='';
					$_SESSION['work_plan']='';
				}else{
					$_SESSION['norecord']=false;
					$_SESSION['work_done']=$row['works'];
					$_SESSION['work_plan']=$row['plan'];
				}
				mysql_close($con);
			}else {
				echo "bug";
				die();
			}
		?>
		</h1>

		<div style='text-align:center;'>
			<form action="../php/store.php" method="post">
				本周工作：<br>
				<textarea name="work_done" id="" class="text" cols="50" rows="10" tabindex="5"><?php echo $_SESSION['work_done'] ?></textarea><br><br>
				下周计划：<br>
				<textarea name="work_plan" id="" class="text" cols="50" rows="10" tabindex="5"><?php echo $_SESSION['work_plan'] ?></textarea><br><br>
				<input class="hc_btn" type="submit" value="提 交">
			</form>
		</div>
	</body>
</html>
