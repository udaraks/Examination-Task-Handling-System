<?php
	// this php file include code for connecting to the database
	include 'con_mysql.php';
	$con = new dbconn();
	$con->getcon();
	

	// if there is no download id then redirect to upload/download page page
	if (!$_GET['id']) 
	{
		header("Location: uploadfile.php");
		exit;
	}
	
	//get file id
	$id    = $_GET['id'];
	$query = "SELECT name,type,size,content " .
	         "FROM upload WHERE id = '$id'";
	
	$result = mysql_query($query) or die('Query failed '.mysql_error());
	list($name,$type,$size,$content) = mysql_fetch_array($result);
	                    
	if (mysql_num_rows($result) < 1) 
	{
	   	//error message when the file does not exist
	     echo("<td><p><em><strong>Such a file does not exist </br><a href='uploadfile.php'>
		 Go Back</a>.</strong></em></p></td></tr></table>");
    }
	else
	{
		// tells the browser how large the file is
		header("Content-length: $size");
		//tells the browser what kind of file it tries to download
		header("Content-type: $type");
		// tells the browser to save this downloaded file under the specified name
		header("Content-Disposition: attachment;filename= $name");
		
		echo $content;
		mysql_close();
		exit;
	}
?>
