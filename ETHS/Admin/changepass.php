<?php
// this php file include code for connecting to the database
include '../con_mysql.php';
$con = new dbconn();
$con->getcon();

// this includes all classes and functions
include 'adminclass.php';

function passError()
{
	// display error if password is wrong	
	if(isset($_GET['err']) && $_GET['err']==1)
	{
		echo"<br /><font color='red'>Current Password you entered is incorrect</font>";
	}
	// display an error if passwords don't match
	elseif(isset($_GET['err']) && $_GET['err']==2)
	{
		echo"<br /><font color='red'>Passwords you entered do not match</font>";
	}		
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>Change Administrator's Password</title>


<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat-x;
	width:100%;
	font-family:arial;
	font-size:  18px;
}
table {
	font-size:  18px;
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
	color:#FFFFFF
}

.style7 {color: #000000;
		font-size: 22px}

-->
</style>
<script type="text/javascript">
<!--
// Checks for emptyfields
function emptyField() 
	{	
		if (document.changepass.pass1.value.length<1 || 
			document.changepass.pass2.value.length<1) {
			alert("Please Fill Both Passwords");
			return false;
		}
		else return true;
	}
//-->	
</script>
</head>

<body>

<img src="../Images/logo.jpg" width="100%" height="92"/>
<br /><br /><br />
	<?php
  
    //if session is not set then access will be denied
	if(!isset($_SESSION['admin']))
	{
	echo("<p><font color='#FF0000'>"."Access Denied,"."<br>". 
		"You are not allowed to access the content until you login"."<br></font></p>");
		echo("<a href='index.php'>Login Here</a>");
		
	}
	else
	{
	   	if(isset($_POST['newpass']))
		{
			$change = new Password();
			$change->changeAdminPassword(); 
		}
		else
		{

	
	?>
    <p class="style7" align="center"> <strong> Change Password</strong> </p><br />
    <table border="0" align="center">
    <tr>
    <form name="changepass" method="post" action="<?php $_SERVER['PHP_SELF'];?>"
	onSubmit="return emptyField()">
	<td><strong>Current Password</strong></td>
    <td><input type="password" name="pass" class="style3" /></td>
   	</tr>
    <tr>
    <td><strong>New Password</strong></td>
    <td><input type="password" name="pass1" class="style3" /></td>
    </tr>
    <tr>
    <td><strong>Re-enter New Password</strong></td>
    <td><input type="password" name="pass2"  class="style3"/></td>
    </tr>
    <tr>
    <td></td>
    <td><input type="submit" name="newpass"  class="style3" value="Submit"/>
    <input type="reset" value="Clear"  name="clear" class="style3"/></td></tr>
    </form>
    </table>
    <p align="center">
	<?php
	
		passError();
		}
	}
	?>
	<br />
	<a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
	</p>
  	
</div>
<br /><br /><br /><br /><br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>
