<?php
	session_start();
	if(@$_SESSION["authenticated"] == true){
		$name = $_SESSION["username"];
		echo "<div class = 'Log' ID = 'log' value = '1'>Hello,";
		echo $name;
		echo "</div>";
	}
	else{
		echo "<script>alert('You are not logged in, so you can not save your score.')</script>";
		echo "<div class ='Log' ID = 'log' value = '0'>You are not <a href = '/login'>log in</a></div>";
	}

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<title>Teris</title>
		<script src = "jquery.js"></script>
		<script type="text/javascript">
			function trailer(){
				//trailer:   TODO 
			};
			var map = {};
			map.o = [180,160];
			map.start = 0;
			map.pause = 0;
			map.startDot = [6,-1];
			map.sidelength = 20;
			map.row = 24;
			map.colomn = 12;
			map.score = 0;
			map.nextType = -1;
			map.matrix = Array(map.colomn);
			for(var i = 0;i < map.colomn; i++){
				map.matrix[i] = Array(map.row);
				for(var j = 0; j < map.row; j++){
					map.matrix[i][j] = 0;
				}
			}
			map.reload = function(){
				var i;
				var j;
				var tempY;
				var tempX;
				var realX;
				var realY;
				for(i = 0;i < 4; i++){
					tempX = cube.position[i][0];
					tempY = cube.position[i][1];
					map.matrix[tempX][tempY] = 1;
				}
				this.killLine();
				for(i = 0;i < map.colomn;i++){
					if(map.matrix[i][0] == 1){
						$("#stop").css("visibility","hidden");
						$("#start").css("visibility","visible");
						stop();
						return;
					}
				}
				for(i = 0; i < this.colomn; i++){
					for(j = 0; j< this.row; j++){
						if(this.matrix[i][j] == 1 && $("#"+i+"_"+j).length == 0){
							realX = map.o[0]+i*map.sidelength;	
							realY = map.o[1]+j*map.sidelength;
							$("#background").append("<div ID = '" + i +"_"+ j +"' class = 'Square' style = 'left:"+realX+"; top:"+realY+"; background:#808080;'></div>");
						}
						if(this.matrix[i][j] == 0 && $("#"+i+"_"+j).length == 1){
							$("#"+i+"_"+j).remove();
						}
					}
				}
			}
			map.killLine = function(){
				var i;
				var j;
				var k;
				var flag = 1;
				for(j = 0;j < this.row; j++){
					flag = 1;
					for(i = 0; i < this.colomn; i++){
						if(this.matrix[i][j] == 0){
							flag = 0;
							break;
						}
					}
					if(flag == 1){
						this.score += 100;
						$("#scoring").html("score:  "+map.score);
						for(i = 0; i < this.colomn; i++){
							this.matrix[i][j] = 0;
						}
						for(i = 0;i < this.colomn; i++){
							for(k = j-1; k == 0 || k > 0; k--){
								if(this.matrix[i][k] == 1){
									this.matrix[i][k] = 0;
									this.matrix[i][k+1] = 1;
								}
							}
						}
					}
				}
			}
			var cube ={};
			cube.color  = ["#00FFFF","#0000FF","#D2691E","#FFFF00","#7CFC00","#8B008B","#DC143C"];
			cube.centerDot = Array(2);
			cube.centerDot[0] = 0; //X
			cube.centerDot[1] = 0; //Y
			cube.getType = function(){
				this.state = 0;
				return  Math.floor(Math.random()*7);
			}
			cube.changeState = function(){
				this.state = Math.floor(Math.random()*4);
			}
			cube.getNowdot = function(){
				var x = this.centerDot[0];
				var y = this.centerDot[1];
				var s = this.state;
				switch(this.type){
					case 0:
						if(s == 0 || s == 2)
							this.position = [[x-2,y],[x-1,y],[x,y],[x+1,y]];
						else if(s == 1 || s ==3){
							this.position = [[x,y+1],[x,y],[x,y-1],[x,y-2]];
						}
						break;
					case 1:
						if(s == 0)
							this.position = [[x-1,y],[x,y],[x+1,y],[x+1,y+1]];
						else if(s == 1)
							this.position = [[x-1,y+1],[x,y+1],[x,y],[x,y-1]];
						else if(s == 2)
							this.position = [[x-1,y-1],[x-1,y],[x,y],[x+1,y]];
						else if(s == 3)
							this.position = [[x,y+1],[x,y],[x,y-1],[x+1,y-1]];
						break;
					case 2:
						if(s == 0)
							this.position = [[x-1,y+1],[x-1,y],[x,y],[x+1,y]];
						else if(s == 1)
							this.position = [[x-1,y-1],[x,y-1],[x,y],[x,y+1]];						
						else if(s == 2)
							this.position = [[x-1,y],[x,y],[x+1,y],[x+1,y-1]];
						else if(s == 3)
							this.position = [[x,y+1],[x,y],[x,y-1],[x+1,y+1]];
						break;
					case 3:
						this.position = [[x,y],[x-1,y+1],[x,y+1],[x-1,y]];
						break;
					case 4:
						if(s == 0 || s == 2)
							this.position = [[x-1,y+1],[x,y+1],[x,y],[x+1,y]];
						else if (s == 1 || s == 3)
							this.position = [[x-1,y],[x-1,y-1],[x,y],[x,y+1]];
						break;
					case 5:
						if (s == 0)
							this.position = [[x-1,y],[x,y],[x+1,y],[x,y+1]];
						else if(s == 1)
							this.position = [[x-1,y],[x,y],[x,y-1],[x,y+1]];
						else if(s == 2)
							this.position = [[x-1,y],[x,y],[x,y-1],[x+1,y]];
						else if(s == 3)
							this.position = [[x,y],[x,y-1],[x,y+1],[x+1,y]];
						break;
					case 6:
						if(s == 0 || s == 2)
							this.position = [[x-1,y],[x,y],[x,y+1],[x+1,y+1]];
						else if (s == 1 || s == 3)
							this.position = [[x-1,y],[x-1,y+1],[x,y],[x,y-1]];
						break;
				}
			}
			cube.getNextdot = function(){
				var x = 0;
				var y = 0;
				switch(this.nextType){
					case 0:
						this.nextPosition = [[x-2,y],[x-1,y],[x,y],[x+1,y]];
						break;
					case 1:
						this.nextPosition = [[x-1,y],[x,y],[x+1,y],[x+1,y+1]];
						break;
					case 2:
						this.nextPosition = [[x-1,y+1],[x-1,y],[x,y],[x+1,y]];
						break;
					case 3:
						this.nextPosition = [[x,y],[x-1,y+1],[x,y+1],[x-1,y]];
						break;
					case 4:
						this.nextPosition = [[x-1,y+1],[x,y+1],[x,y],[x+1,y]];
						break;
					case 5:
						this.nextPosition = [[x-1,y],[x,y],[x+1,y],[x,y+1]];
						break;
					case 6:
						this.nextPosition = [[x-1,y],[x,y],[x,y+1],[x+1,y+1]];
						break;
				}
			}
			cube.checkDown = function(){
				var tempX;
				var tempY;
				for(var i = 0;i < 4; i++){
					tempX = this.position[i][0];
					tempY = this.position[i][1] + 1;
					if(tempY == map.row || map.matrix[tempX][tempY] == 1)
						return false;
				}
				return true;
			}
			function moveDown(){
				if(cube.checkDown()){
					cube.centerDot[1]++;
					cube.getNowdot();
					display();
				}
				else{
					map.reload();
					cube.type = cube.nextType;
					cube.nextType = cube.getType();
					cube.getNextdot();
					displayNext();
					cube.centerDot[0] = map.startDot[0];
					cube.centerDot[1] = map.startDot[1];
					cube.getNowdot();
				}
			}
			cube.checkLeft = function(){
				var tempX;
				var tempY;
				for(var i = 0;i < 4; i++){
					tempX = this.position[i][0]-1;
					tempY = this.position[i][1];
					if(tempX < 0 || map.matrix[tempX][tempY] == 1)
						return false;
				}
				return true;
			}
			cube.moveLeft = function(){
				this.centerDot[0]--;
				this.getNowdot();
				display();
			}
			cube.checkRight = function(){
				var tempX;
				var tempY;
				for(var i = 0;i < 4; i++){
					tempX = this.position[i][0]+1;
					tempY = this.position[i][1];
					if(tempX > map.colomn-1 || map.matrix[tempX][tempY] == 1)
						return false;
				}
			return true;
			}		
			cube.moveRight = function(){
				this.centerDot[0]++;
				this.getNowdot();
				display();
			}
			cube.checkChange = function(){
				for(var i = 0;i < 4;i++){
					tempX = this.position[i][0];
					tempY = this.position[i][1];
					if(tempX > map.colomn-1 || tempX < 0 ){
						return false;
					}
				}
				return true;
			}
			cube.change = function(){
				var tempX;
				var tempY;
				var flag = 1;
				this.state = (this.state+1)%4;
				this.getNowdot();
				for(var i = 0; i < 4; i++){
					tempX = cube.position[i][0];
					tempY = cube.position[i][1];
					if(tempY < 0 || tempY == map.row ||(tempX > -1&& tempX < map.colomn && map.matrix[tempX][tempY] == 1)){
						flag = 0;
						break;
					}
				}
				if(flag == 1){
					if(this.checkChange()){
						display();
					}
					else{
						this.centerDot[0]--;
						this.getNowdot();
						if(this.checkChange()){
							display();
						}
						else{
							this.centerDot[0] += 2;
							this.getNowdot();
							if(this.checkChange()){
								display();
							}
							else{
								this.centerDot[0]++;
								this.getNowdot();
								display();
							}
						}
					}					
				}
				if(flag == 0){
					this.state = (this.state+3)%4;
					this.getNowdot();
				}
			}
			function display(){
				var realX;
				var realY;
				$("#arena").append("<div ID = 'next'>");
				for(var i = 0; i < 4; i++){
					realX = map.o[0]+cube.position[i][0]*map.sidelength;	
					realY = map.o[1]+cube.position[i][1]*map.sidelength;
					$("#next").append("<div class = 'Square' style = 'left:"+realX+"; top:"+realY+"; background:"+cube.color[cube.type]+";'></div>");
				}
				if($("#current").length == 1)
					$("#current").remove();
				$("#next").attr("ID","current");
			}
			function displayNext(){
				var realX;
				var realY;
				$("#NEXT").children().remove();
				for(var i = 0; i < 4; i++){
					realX = 190+cube.nextPosition[i][0]*map.sidelength;	
					realY = 270+cube.nextPosition[i][1]*map.sidelength;
					$("#NEXT").append("<div class = 'Square' style = 'left:"+realX+"; top:"+realY+"; background:"+cube.color[cube.nextType]+";'></div>");
				}
			}
			function initMouse(){
				$("#start").bind("click",function(){
					$("#start").css("visibility","hidden");
					$("#stop").css("visibility","visible");
					start();
				})
				$("#stop").bind("click",function(){
					if(map.pause == 0){
						$("#stop").css("visibility","hidden");
						$("#start").css("visibility","visible");
						stop();
					}
				})
				$("#pause").bind("click",function(){
					if(map.start == 1){
						$("#pause").css("visibility","hidden");
						$("#continue").css("visibility","visible");
						pause();	
					}
				})
				$("#continue").bind("click",function(){
					$("#continue").css("visibility","hidden");
					$("#pause").css("visibility","visible");
					Continue();
				})
				$("#board").bind("mouseover",function(){
					url = "show.php?flag=1";
					try{
						xhr = new XMLHttpRequest();
					}
					catch(e){
						xhr = new ActiveXObject("Microsoft.XMLHTTP");
					}
					if(xhr == null){
						alert("Your computer doesn't support Ajax");
					}
					$("#list").css("visibility","visible");
					xhr.onreadystatechange = handler;
					xhr.open("get",url,true);
					xhr.send(null);
				})
				$("#board").bind("mouseout",function(){
					$("#list").css("visibility","hidden");
				});
			}
			function handler(){
				if(xhr.readyState != 4){
					$("#list").html("Loading...");
				}
				if(xhr.readyState == 4){
					if(xhr.status == 200){
						var responde = xhr.responseText;
						$("#list").html(responde);
					}
				}
			}
			function initKeyboard(){
				$(document).keydown(function(event){  
				    if(event.keyCode == 37 && map.pause == 0) {  
				      	if(cube.checkLeft()) cube.moveLeft();  
				    }  
				    else if(event.keyCode == 39 && map.pause == 0) {  
				        if(cube.checkRight()) cube.moveRight();  
				    }  
				    else if(event.keyCode == 38 && map.pause == 0) {  
				        cube.change();  
				    }  
				    else if(event.keyCode == 40 && map.pause == 0){  
				        moveDown();  
				    }
				}); 
			}
			function start(){
				map.start = 1;
				map.score = 0;
				$("#scoring").html("score:  "+map.score);
				cube.type = cube.getType();
				cube.nextType = cube.getType();
				cube.getNextdot();
				displayNext();
				cube.centerDot[0] = map.startDot[0];
				cube.centerDot[1] = map.startDot[1];
				cube.getNowdot();
				f = setInterval(moveDown,600);
			}
			function stop(){
				map.start = 0;
				clearInterval(f);
				try{
					xhr = new XMLHttpRequest();
				}
				catch(e){
					xhr = new ActiveXObject("Microsoft.XMLHTTP");
				}
				if(xhr == null){
					alert("Your computer doesn't support Ajax");
				}
				var url = "submit.php";
				if(map.score != 0){
					if(window.confirm("Game Over\nDo you want to save this score?")){
						if($("#log").attr("value") == 1){
							url = url+"?score="+map.score;
							xhr.open("get",url,true);
							xhr.send(null);
						}
						else{
							alert("You must log in first!");
							//TODO;
						}
					}
					$("#current").remove();
					$("#background").children().remove();
					$("NEXT").children().remove();
					for(var i = 0;i < map.colomn; i++){
						for(var j = 0; j< map.row;j ++){
							map.matrix[i][j] = 0;
						}
					}
				}
			}
			function pause(){
				map.pause = 1;
				clearInterval(f);
			}
			function Continue(){
				map.pause = 0;
				f = setInterval(moveDown,600);
			}
		</script>
		<style>
			.Button{
				height: 40px;
				width: 100px; 
				background: black;
			    color: white;
			    float: left;
			    font-size: 26;
			    text-align: center;
			}
			.Screen{
				background: black;
				border-style: solid;
				border-width: 8px;
				border-color: silver;
				position: absolute; 
				top: 80px; 
				left:100px; 
				height:800px; 
				width:600px;
			}
			.Square{
				position: absolute;
				border-width: 1px;
				border-style: solid;
				border-color: white;
				height: 19px;
				width: 19px;
			}
			.Log{
				position:absolute;
				background: gray;
				color:white;
				height:40px;
				width:400px;
				left:600px;
				top:15px;
				font-size:23;
			}
			.verticalLine{
				position:absolute;
				height: 480px;
				width: 1px;
				background: white;
			}
			.horizontalLine{
				position:absolute;
				height: 1px;
				width: 240px;
				background: white;
			}
		</style>
	</head>
	<body style = "background: grey; width:600px;height:400px">
		<header ID = "header">
			<div style = "position: relative; left: 50px;">
				<div ID = "menu" class = "Button" style="background: #280000;">Menu</div>
				<div ID = "start" class = "Button">start</div>
				<div ID = "stop" class = "Button" style = "position: absolute; left:100; background: red; visibility:hidden;">stop</div>
				<div ID = "pause" class = "Button">pause</div>
				<div ID = "continue" class = "Button" style = "background:silver; font-size: 24; position: absolute; left:	200; visibility: hidden;">continue</div>
				<div ID = "board" class = "Button">board</div>
				<div ID = "list" style = "visibility:hidden; z-index:30;font-size:18;position:absolute; color:	white; background:#303030; top:40; left:300; width:200; height:500;">
				</div>
				<div ID = "log" ><!TODO></div>
			</div>
		</header>
		<div ID = "arena" class = "Screen" >
			<div ID = "teris" style = "position: absolute; color: white; top: 90; left: 210; font-size: 40;">T e r i s </div>
			<div ID = "line1" class = "horizontalLine" style = "top:160; left:180;"></div>
			<div ID = "line2" class = "verticalLine" style="top:160; left:180;"></div>
			<div ID = "line3" class = "horizontalLine" style = "top:640; left:180;"></div>
			<div ID = "line4" class = "verticalLine" style = "top:160; left:420;"></div>
			<div ID = "background"></div>
		</div>
		<div ID = "controller" class = "Screen" style = "left: 780px; top: 80px; width: 400px;">
			<p style = "position:absolute; top:120px; left:150px; color:white; font-size:25;">N E X T</p>
			<div ID = "line5" class = "horizontalLine" style = "left:100px; top:180px;width:200px;"></div>
			<div ID = "line6" class = "verticalLine" style = "left:100px; top:180px; height:200px"></div>
			<div ID = "line7" class = "horizontalLine" style = "left:100px; top:380px; width:200px"></div>
			<div ID = "line8" class = "verticalLine" style = "left:300px; top:180px; height:200px"></div>
			<div ID = "NEXT"></div>	
			<div ID = "scoring" class = "Button" style = "font-size: 30; width: 250px; margin-left:50; margin-top:500">scroe:  0</div>
			<div ID = "attention" class = "Button" style = "font-size: 18; width: 300px; margin-left:50; margin-top:10">Attention: if you want to save your score, please make sure you have logged in first.</div>
			<div ID = "introduction" style="margin-left:200; margin-top:700;color: white;">
				<p>
				Presented by Jason.
				</p>
			</div>
		</div>

		<script type="text/javascript">
			//$(document).ready(trailer());
			initMouse();
			initKeyboard();
		</script>
	</body>
</html>