<?php
// this php file include code for connecting to the database
include '../con_mysql.php';
$con = new dbconn();
$con->getcon();
// this includes all classes and functions
include 'adminclass.php';
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>View Lecturer Details</title>


<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat;
	width:100%;
	font-family:arial;
}
.style1 {color: #FFFFFF}
body,td,th {
	color: #000000;
}
.style2 {
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
}
.style3 {
	background-image: url(../Images/input.jpg);	
	background-repeat:repeat;
	}
.style4{
	color:#FFFFFF
}
.style5{
	background-color:#000000;
	color:#FFFFFF
}
.style6 {
	background-color:#666699;
	color:#FFFFFF
}
.style7 {color: #000000;
		font-size: 20px}


-->
</style>

</head>

<body>
<img src="../Images/logo.jpg" width="100%" height="92"/>
<div align="center">

<br />
<?php
//if session is not set then access will be denied
if(!isset($_SESSION['admin']))
{
	echo("<p><font color='#FF0000' size='4'>Access Denied,<br />". 
	"You are not allowed to access the content until you login"."<br /></p>
	<a href='index.php'>Login Here</a></font>");
		
}
else
{

?>
    <p class="style7"> <strong> <h2>Lecturer Details</h2></strong> </p><br /><br />
    <br />
    <form name="selectdeptmnt" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
    <em><b>Select Department:</b></em>
    <select name="dept" id="select" class="style6">
    <option>Botany</option>
    <option>Chemistry</option>
  	<option>Geology</option>
  	<option>Management/Economics</option>
  	<option>Mathematics</option>
  	<option>Molecular Biology &amp; Biotechnology</option>
  	<option>Physics</option>
  	<option>Statistics &amp; Computer Science</option>
  	<option>Zoology</option>
  	</select>
  	<input type="submit" name="btncheck" value="Check Details" class="style6" />
	<br /><br />
	</form>
	<a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
</div>
<?php
	if(isset($_POST['dept']))
	{	
		$view = new Lecturer();
		$view->viewDetails();
	}
}
?>
<br />
<br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>

</body>
</html>
