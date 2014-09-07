<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/common.css">
		<script type="text/javascript" src="../js/common.js"></script>
		<!-- calendar -->
		<script type="text/javascript" src="../plugin/calendar/js/jquery-1.3.1.min.js"></script>
		<script type="text/javascript" src="../plugin/calendar/js/jquery-ui-1.7.1.custom.min.js"></script>
		<script type="text/javascript" src="../plugin/calendar/js/daterangepicker.jQuery.js"></script>
		<link rel="stylesheet" href="../plugin/calendar/css/ui.daterangepicker.css" type="text/css" />
		<link rel="stylesheet" href="../plugin/calendar/css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" title="ui-theme" />
		<script>
			$(function(){
				$('#rangeA').daterangepicker({arrows:true});
			});
		</script>
		<!-- calendar end-->
	</head>
	<body>
		<h1 style='text-align:center;margin-top:50px;'>
		<?php 
			session_start();
			if(isset($_SESSION['user'])) {
				$name = $_SESSION['user'];
				echo $name, "的工作平台"."<br><br>";
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

		<div style="text-align:center;">
			<div style="position:absolute;left:5%;margin-top:25px;">
				<input type="text" id="rangeA" style="height:25px; display:block;"/>
				<script>
					var now=new Date();
					document.getElementById("rangeA").value=now.toLocaleDateString();
				</script><br>
				<button class='hc_btn' onclick="hc_getWorks()">统 计</button><br><br>
				<textarea class="text" id='hc_show_works' readonly="readonly" cols="50" rows="10" tabindex="5"></textarea>
			</div>
			<div>
				<form action="../php/store.php" method="post">
					本周工作：<br>
					<textarea name="work_done" class="text" cols="50" rows="10" tabindex="5"><?php echo $_SESSION['work_done'] ?></textarea><br><br>
					下周计划：<br>
					<textarea name="work_plan" class="text" cols="50" rows="10" tabindex="5"><?php echo $_SESSION['work_plan'] ?></textarea><br><br>
					<input class="hc_btn" type="submit" value="提 交">
				</form>
			</div>
		</div>
	</body>
</html>
<script>
function hc_getWorks(){
	var strDateRange = document.getElementById("rangeA").value;
	var strDates = strDateRange.split(" - ");
	if (!strDates[1]) {
		alert("请选择结束日期");
		return;
	}
	var strarray = strDates[0].split("/");
	var startDate = strarray[2] + "-" + strarray[0] + "-" + strarray[1];
	strarray = strDates[1].split("/");
	var endDate = strarray[2] + "-" + strarray[0] + "-" + strarray[1];

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","../php/statistic.php?s=" + startDate + "&e=" + endDate,true);
	xmlhttp.send();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var res=xmlhttp.responseText;
			document.getElementById("hc_show_works").value=res;
		}
	}

}
</script>
