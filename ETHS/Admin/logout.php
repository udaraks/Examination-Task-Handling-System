<?php
// to remove header errors
ob_start();
/**
 * @author S.R.U.K.Senanayake
 * @copyright 2009
 */
session_start();
session_destroy();
unset($_SESSION['admin']);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>Logging Out</title>
<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat-x;
	width:100%;
	font-family:arial;
}
-->
</style>
</head>

<body>
<img src="../Images/logo.jpg" width="100%" height="92"/>
<br /><br />
<font color="green" size="5" >
<?php
//display logout message and goback to login
echo "<p align='center'>You have successfully Logged Out</p>";
header("refresh:1; url=index.php");

ob_end_flush();
?>
</font>
</body>
</html>