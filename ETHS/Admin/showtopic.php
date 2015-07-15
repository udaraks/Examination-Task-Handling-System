<?php
// this php file include code for connecting to the database
include '../con_mysql.php';
$con = new dbconn();
$con->getcon();
// this includes all classes and functions
include 'adminclass.php';

//if there isn't such topic goback to forum
if (!$_GET['topic_id']) 
{
	header("Location: forum.php");
	exit;
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>Add/Delete Forum Data</title>


<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat;
	width:100%;
	font-size:  20px;
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
.style4 {
	background-image: url(../Images/input3.jpg);	
	background-repeat:repeat;
	}
.style5{
	background-color:#000000;
	color:#FFFFFF
}

.style7 {color: #000000;
		font-size: 20px}


-->
</style>

</head>

<body>
<div align="center">
<img src="../Images/logoforum.jpg" width="100%" height="92"/>
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
    <p class="style7"> <strong> <h2>DISCUSSION FORUM</h2></strong> </p>
    <br /><br />
    <a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
    
    
<?php
	$show = new Forum();
 	$show->showTopic();
}
 ?> 
 <br /><br />
<a href="forum.php"><strong><em>Go Back to the topic list</em></strong></a>
 	
</div>
<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>

</body>
</html>