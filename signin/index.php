<?php
	
	session_start();

	if(isset($_SESSION['username'])){
		header("Location: ../index.php");
	}

?><!DOCTYPE html>
<html>
<head>

	<title>Sign in to Playability</title>
	<link rel="stylesheet" type="text/css" media="screen" href="style.css" >
	<script src="scripts/jquery.js" type="text/javascript"></script>
	<script src="scripts/script.js" type="text/javascript"></script>

</head>
<body id="login">

	<section id="box">
	
		<h1>PLAYABILITY</h1>
		
		<div id="signin">
		
			<form class="signin">
			
				<p><label for="username">Username</label></p>
				<input type="text" name="username" value="" class="username" />
				
				<p><label for="password">Password</label></p>
				<input type="password" name="password" value="" class="password" />
			
				<a class="submit"><span>Sign In</span></a>
			</form>
		
			<span class="signup_text">Not a member? <a class="signup_link" href="#signup">Sign Up</a></span>
			<div class="clear"></div>
		</div>
		
		<div id="signup">
		<span class="close">close</span>
			<form class="signup">
			
				<p><label for="username">Username</label></p>
				<input type="text" name="username" value="" class="username" />
				
				<p><label for="email">Email</label></p>
				<input type="email" name="email" value="" class="email" />
				
				<p><label for="password">Password</label></p>
				<input type="password" name="password" value="" class="password" />
				
				<p><label for="confirm">Password Confirm</label></p>
				<input type="password" name="confirm" value="" class="confirm" />
			
				<p><label for="code">Beta Code</label></p>
				<input type="text" name="code" value="" class="code" />
			
				<a class="submit"><span>Sign Up</span></a>
			</form>
		
			<div class="clear"></div>
		</div>
		
		<span class="bottom_text"><a href="../about">About playability</a><strong>&middot;</strong><a href="http://twitter.com/zaksoup">Follow us on twitter</a></span>
	
	</section>

</body>
</html>