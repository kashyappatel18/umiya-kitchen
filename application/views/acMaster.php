<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Create Account</title>

	<style type="text/css">
		body,input{
			font-family: "calibri";
		}
	</style>

	
	</style>
</head>
<body>
<h1>{{title}}</h1>
	<form>
		<label>Select Head for Account</label><br>
		<select>
			<option>Bank's Current Accounts</option>
			<option>Bank Loans</option>
			<option>Investor</option>
			<option>Employee</option>
			<option>Customers</option>
			<option>Seller</option>
			<option>Commision</option>
			<option>Postage</option>
			<option>Printing and Stationary</option>
			<option>Furniture and Fixture</option>
		</select><br>
		<label>Account Name</label><br>
		<input type="text" name="acName" id="acName"/><br><br>
		<input type="submit" name="login_submit" id="login_submit" value="Transmit"/>
		<input type="reset" name="rset" id="rset" value="Cancle" />
	</form>
<p>Welcome to cloud8in accounting system.</p>
</body>
</html>