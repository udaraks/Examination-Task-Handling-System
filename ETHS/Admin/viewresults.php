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
<title>View Exam Results</title>


<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat;
	width:100%;
	font-family:arial;
	font-size:  20px;
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
.style4 {
	background-image: url(../Images/input.jpg);	
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
<script type="text/javascript" >
<!--
function emptyId() 
	{	
		if (document.getid.stdid.selectedIndex == 0 )
		{
			alert("Please Select a Student ID");
			return false;
		}
		else return true;
	}
//-->
</script>
</head>

<body>
<div align="center">
<img src="../Images/logo.jpg" width="100%" height="92"/>
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
    <p class="style7"> <strong> <h2>Examination Results</h2></strong> </p><br />
    
	 <br />
    <a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
  <table border="0">
    <tr>
    <td><b><em>Select Student ID:</em></b></td>
    <form name='getid' method='post' action="<?php $_SERVER['PHP_SELF'];?>">
    <td><select name="stdid" class="style3">
    <option>SELECT</option>
<?php
	//get student id's
	$getids = "SELECT stdId FROM student";
	$getids_res = mysql_query($getids);
	while($row = mysql_fetch_array($getids_res))
	{
		echo "<option>$row[stdId]</option>";
	}
	echo "</select>";
				
?>
	</td>
	<td>
	<input type='submit' value='Check Results' name ='btncheck' class='style3' 
	onclick="return emptyId()"/></td><br />
	</tr></table>
    
    </form>
   

<?php
	if(isset($_POST['stdid']))
	{
		$result = new Examination();
		$result->checkResult();		
	}

}
 ?>    
</div>
<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>

</body>
</html>
