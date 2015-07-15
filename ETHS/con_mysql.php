<?php
// This file is used to connect to the database

// start the session
session_start(); 

class dbconn
{
	function getcon()
	{
		//connect to database
		$conn = mysql_connect('localhost','root','') or 
		die("Unable to connect to the server ".mysql_error());
		
		//select the database
		$uni = mysql_select_db('university',$conn) or 
		die("Unable to select the database ".mysql_error());
	}
}
?>