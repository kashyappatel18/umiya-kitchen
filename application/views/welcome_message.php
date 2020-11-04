<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to cloud8in</title>

	<style type="text/css">
		body,input{
			font-family: "calibri";
		}
	</style>

	
	</style>
</head>
<body>
<h1>cloud8in</h1>
	<form>
		<label>Username</label><br>
		<input type="text" name="user_name" id="user_name"/><br>
		<label>Password</label><br>
		<input type="password" name="user_pass" id="user_pass"/><br>
		<input type="checkbox" name="remember_me" id="remember_me" />
		<label>Remember Me</label><br>
		<input type="submit" name="login_submit" id="login_submit" value="Sign In"/>
	</form>
<p>Welcome to cloud8in accounting system.</p>
</body>
</html>