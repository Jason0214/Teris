<?php
	session_start();
	if(isset($_GET["score"])){
		if(($connection = mysql_connect("localhost","pma","******")) == FALSE){
			die("could not connect to database now<a href = '/signUp'>back<a>");
		}
		if(mysql_select_db("USER",$connection) == FALSE){
			die("could not select database now<a href = '/signUp'>back<a>");
		}
		$sql =  sprintf("INSERT INTO `Teris` (`username`, `score`,`time`) VALUES ('%s', '%s',NOW());",
			mysql_real_escape_string($_SESSION["username"]),mysql_real_escape_string($_GET["score"]));
		$result = mysql_query($sql);
		if($result == false){
			mysql_close($connection);
			die("something unexpected happened, try again.<a href = '/signUp'>back<a>");
		}
		else{
			mysql_close($connection);
			print "<script>alert('Your score have been stored successfully!')</script>;";
		}
	}
?>