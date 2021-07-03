<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "classes/$class.php";
}
require_once 'user/ip.php';
$activity=new text_activity();
$blogs=new blogs($activity);
$share=new share($activity);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ViVinam: About Us</title>
	<?php require_once 'link.php'; ?>
	<style type="text/css">
		body{
			font-family: arial, Helvetica, sans-serif;
			margin: 0;
			background-color: #deade2;
		}
		.about-row{
			max-width: 1000px;
			margin: 0 auto;
		}
		.about-column{
			width: 100%;
			display:block;
			margin-bottom: 16px;
			padding: 0 8px;
		}
		.card{
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
			margin: 8px;
			background-color: #f1f1f1;
			line-height: 20px;
		}
		.about-section{
			padding: 50px;
			text-align: center;
			background-color: #474e5d;
			color: #ffff;
		}
		.container{
			padding: 6px 16px;

		}
		.container::after ,.about-row::after{
			content: "";
			clear: both;
			display: table;
		}
		.title{color: grey;
			margin: 0 auto;
			font-size: 0.9em;
		}
		.button{
			border:none;
			outline:0;
			display:inline-block;
			padding:8px;
			background-color:#333;
			text-align: center;
			cursor: pointer;
			width: 100%;
		}
		.button:hover{
			background-color: #5555
		}
		
		.r-middle{
			padding: 10px;
			background-color: #434544;
			color: #f1f1f1;
		}
		.team{
			background-color:rgb(67, 69, 68);
			overflow: hidden;
			color: #321443;
		}
		.team h2{
			color: #bb9dcc;
			text-align: center;
		}
		.own{
			max-width: 1200px;
			background-color:rgb(67, 69, 68);
			color: #f1f1f1;
			margin: 30px auto;
		}
		.own-cont{
			display: flex;
			flex-direction: column;
			flex-wrap: nowrap;
		}
		.own-left ,.own-right{
			width: 100%;
			display: block;
			/*float: left;*/
		}
		.own-left{
			padding:5px;
			font-size: 0.8em;
		}
		.own-right{
			width: 100%;
			font-size: 0.8em;
		}
		.own-right .own-img > .image{
			/*position: relative;*/
		}
		.own-bio{
			/*position: absolute;*/
			bottom: 0;
			width: 100%;
			font-family: initial;
			background: rgb(0,0,0);
			background: rgba(0, 0, 0, 0.95);
			color: rgb(176, 129, 239);
			padding: 3px 5px;
		}
		.own-bio .name{
			font-size: 1.7em;
			padding: 3px 0;
		}
		.own-bio .founder{
			font-size: 1.3em;
			padding: 5px 0;
		}
		.own-bio .post-bio{
			padding: 5px 0;
		}
		.own-right img{
			vertical-align: middle;
			width: 100%;
		}
		@media screen and (min-width: 500px){
			.about-column{
			float: left;
			width: 50%;
			}
		}
		@media screen and (max-width: 650px){
			.about-column{
				width: 100%;
				display:block;
			}
		}
		@media screen and (min-width: 700px){
			.own-cont{
			flex-direction: row;
			}
			.own-left ,.own-right{
				width: 40%;
				float: left;
				font-size: 0.9em;
			}
			.own-left{
				padding:10px;
			}
			.own-right{
				width: 60%;			
			}
		}
		@media screen and (min-width: 1000px){
			.own-right .own-img > .image{
				position: relative;
			}
			.own-left ,.own-right{
				font-size: 1em;
			}
			.own-bio{
				padding: 3px 10px;
				position: absolute;
			}
			.about-column{
			width: 25%;
			}
		}
	</style>
</head>
<body>
<?php require_once 'topn.php'; ?>
<div class="row">
	<div class="r-middle">
		<div class="r-middle-contianer">
			<h2>About Us</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum
			</p>
		</div>
		<h2>Our vision</h2>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>
	</div>
</div>
<div class="own">
	<div class="own-cont">
		<div class="own-left" >
			<h4>About Arvind Pakrash</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<p>
				B.Sc Computer Science <br />
				PHP, HTML, CSS, JAVASCRIPT, JQUERY, MYSQL, JSON, AJAX, LARAVEL(BASIC)
			</p>
			<p>
				<h4>Contact:</h4>
				<address>
					Email:<strong> arvindparkash1999@gmail.com</strong><br />
					<strong> arvindparkash0404@gmail.com</strong> <br /><br />
					Mobile No:  7982019952 <br />
				</address>
			</p>
		</div>
		<div class="own-right" >
			<div class="own-img">
				<div class="image">
					<img src="dataimage/sonu.jpg" width="100" />
					<div class="own-bio">
						<span class="name">Arvind Parkash</span><br /> 
						<span class="founder">Founder of vivinam</span><br />
						<div class="post-bio">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="team">
	<h2>Our Hardworking team </h2>
<div class="about-row">
	<div class="about-column">
		<div class="card">
		<img src="dataimage/sonu.jpg" alt="Sone" style="width:100%" />
			<div class="container">
				<div>
					<span>Parkash Arvind</span><br />
					<div class="title">Co-Founder</div>
					<span>parkash@gmail.com</span>
				</div>
			</div>
		</div>
	</div>
	<div class="about-column">
		<div class="card">
		<img src="dataimage/sonu.jpg" alt="Sone" style="width:100%" />
			<div class="container">
				<div>
					<span>Sonu Parkash</span><br />
					<div class="title">Co-Founder</div>
					<span>sonu@gmail.com</span>
				</div>
			</div>
		</div>
	</div>
	<div class="about-column">
		<div class="card">
		<img src="dataimage/sonu.jpg" alt="Sone" style="width:100%" />
			<div class="container">
				<div>
					<span>Rahul Parkash</span><br />
					<div class="title">PHP Developerr</div>
					<span>rahul@gmail.com</span>
				</div>
			</div>
		</div>
	</div>
	<div class="about-column">
		<div class="card">
		<img src="dataimage/sonu.jpg" alt="Sone" style="width:100%" />
			<div class="container">
				<div>
					<span>Sonu</span><br />
					<div class="title">Designer</div>
					<span>sonu1999@gmail.com</span>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php
require_once 'footer.php';
?>
</body>
</html>