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
<title>Add/Edit Examination Time Table</title>


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
	background-image: url(../Images/input.jpg);	
	background-repeat:repeat;
	}
.style3 {
	background-color:#666699;
	color:#FFFFFF
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
		if (document.gettype.type.selectedIndex == 0 )
		{
			alert("Please Select a Subject Type");
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
    <p class="style7"> <strong> <h2>Examination Time Table</h2></strong> </p><br />
    To Add/Edit Examination Time Table <a href="examttdata.php"><b><em>CLICK HERE</em> </b></a>
	 <br /><br />
    <a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
  <table border="0">
    <tr>
    <td><b><em>Select Subject Type:</em></b></td>
    <form name='gettype' method='post' action="<?php $_SERVER['PHP_SELF'];?>">
    <td><select name="type" class="style3">
    <option>SELECT</option>
<?php
	// get subject types
	$gettype = "SELECT distinct subjType FROM subject";
	$gettype_res = mysql_query($gettype);
	while($row = mysql_fetch_array($gettype_res))
	{
		echo "<option>$row[subjType]</option>";
	}
	echo "</select>";
				
?>
	</td>
	<td>
	<input type='submit' value='Check Exam Time Table' name ='btncheck' class='style3' 
	onclick="return emptyId()"/></td><br />
	</tr></table>
    
    </form>
   

<?php
	if(isset($_POST['type']))
	{
		$tt = new Examination();
		$tt->checkSchedule();		
	}

}
mysql_close();
 ?>    
</div>
<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>
