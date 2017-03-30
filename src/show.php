<?php
	if(@$_GET["flag"] == 1){
		if(($connection = mysql_connect("localhost","pma","******")) == FALSE){
			die("could not connect to database now<a href = '/signUp'>back<a>");
		}
		if(mysql_select_db("USER",$connection) == FALSE){
			die("could not select database now<a href = '/signUp'>back<a>");
		}
		$sql =  sprintf("SELECT * FROM `Teris` ORDER BY score DESC");
		$result = mysql_query($sql);
		if($result == FALSE){
			die("could not query database now");
		}
		//if(mysql_num_rows($result) == 1){
		//	$row = mysql_fetch_assoc($result);
		//	if($_POST["pass"] == $row["pass"]){
		print(" RANK ---USER--- SCORE");
		print("<br/><br/>");
		for($i = 0;$i < 10;$i++){
			$row = mysql_fetch_assoc($result);
			if($row){
				print($i+1);
				print(" --- ");
				print($row["username"]);
				print(" --- ");
				print($row["score"]);
				print("</br>");	
			}
			else{
				break;
			}
		}
	}	
?>