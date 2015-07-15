<?php
// to remove header errors
ob_start();

// this php file include code for connecting to the database
include 'con_mysql.php';
$con = new dbconn();
$con->getcon();

// this includes all classes and functions
include 'class.php';

function displayError()
	{
		// display an error if reg.no or password is incorrect
		if(isset($_GET['err']) && $_GET['err']==1)
		{
			echo("<table border=0 bgcolor='#000000'><tr><td><font color='YELLOW'>".
			"Incorrect Registration Number or Password"."</td></tr></font></table>");
		}
	}

// if an user is already logged in, user can't aceess login page
if(isset($_SESSION['users']))
	{
		header('Location:home.php');
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>Examination Task Handling System: Login Page</title>


<style type="text/css">
<!--
body {
	background-image: url(Images/background.jpg);
	background-repeat:repeat-x;
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
	background-color:#666699;
	color:#FFFFFF
}
.style4{
	color:#000000
}

.style7 {color: #000000;
		font-size: 18px}
.style8 {
	text-decoration: blink;
	font-weight: bold;
	color: #000000;
	font-style: italic;
	font-size: 24px
}
.style11 {
	color: #000000;
	font-size: 18px;
	font-weight: bold;
-->
</style>
<script type="text/javascript">
<!--
// Checks for emptyfields
function emptyField() 
	{	
		if (document.form1.pass.value.length<1 || document.form1.reg.value.length<1) 
		{
			alert("Please Enter Registration Number and Password");
			return false;
		}
		else return true;
	}	

//-->
</script>


</head>

<body>

<img src="Images/logo.jpg" width="100%" height="92"/>
<p class="style8" align="center">  WELCOME! </p>
<br /><br />
<table border="0"  align="center">
  <tr>
   <td width="350"><img src="Images/main.jpg" width="350" height="200"/>
   <p align="justify"> You can use this system to view your Examination Timetable and Results, view GPA, view your Rank in your batch etc. Also it consists of a Discussion Forum where you can discuss subject matters and also able to upload/download files.</p></td>
<td></td>
    <td>
    
    
<?php

//gets the reg.no and password entered in the text box
if(isset($_POST['stdLogin']))
{
	$login = new Login();
	$login->login();
}

else {

?>
	<br />
    
    <p class="style7">Enter your Registration Number and Password to Login to the system
	</p><br />
    <form id="form1" name="form1" method="post" action="<?php $_SERVER['PHP_SELF'];?>"  		onsubmit="return emptyField()">
  <table border="0">
  	<tr>
  		<td class="style11"><b>Select (Student/Lecturer)</b> </td>
		<td>  <select name="select" id="select" class="style3">
   				 <option>Student</option>
   				 <option>Lecturer</option>
			 </select>
	 	</td>
	</tr>
	<tr><td><br /></td></tr>
	<tr>
    	<td class="style11"><strong>Registration No:</strong></td>
    	<td><input type="text" maxlength="6"  size="6" name="reg" id="" class="style3" />
    	  <span class="style4"><em>eg. S05001 or L001</em></span></td>
   </tr>
   <tr><td><br /></td></tr>
    <tr>
       <td class="style11"><strong>Password </strong></td>
       <td><input type="password" name="pass" id="pass" class="style3"/></td>
    </tr>
    <tr><td><br /></td></tr>
     <tr>
     	<td></td>
       <td><input name="stdLogin" type="submit" class="style3" value="Login" />
       <input name="clear" type="reset" class="style3" value="Clear" />	</td>
     </tr>
    </table>
  </form>   <br />
       <?php
		displayError();
		?>
	</td>
   </tr>
</table>

<br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>
<?php
}
ob_end_flush();
?>
