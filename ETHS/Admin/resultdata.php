<?php
// to remove header errors
ob_start();

// this php file include code for connecting to the database
include '../con_mysql.php';
$con = new dbconn();
$con->getcon();
// this includes all classes and functions
include 'adminclass.php';

//display messages when add/update/delete are successful
function displayMessage()
{

	if(isset($_GET['status']) && $_GET['status']==1)
	{
		echo"<font color='green'><h3>You have successfully added a record</h3></font>";
	}
	elseif(isset($_GET['status']) && $_GET['status']==2)
	{
		echo"<font color='green'><h3>You have successfully updated a record</h3></font>";
	}	
	elseif(isset($_GET['status']) && $_GET['status']==3)
	{
		echo"<font color='green'><h3>You have successfully deleted a record</h3></font>";
	}		
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>Add/Edit Examination Examination Results</title>


<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
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
	color:#FFFFFF
}

.style7 {color: #000000;
		font-size: 20px}


-->
</style>
<script type="text/javascript">
<!--
// Checks for emptyfields
function emptyField() 
	{	
		if (document.resdata.grade[document.resdata.grade.selectedIndex].text 
			== "" || 
			document.resdata.stid.value.length<1  ||
			document.resdata.sbid.value.length<1 )
		{
			alert("Please Fill All The Details (Attendance is not Compulsory)");
			return false;
		}
		else return true;
	}
function emptyDel() 
	{	
		if (document.resdata.stdid[document.resdata.stdid.selectedIndex].text == "SELECT" ||
			document.resdata.subjid[document.resdata.subjid.selectedIndex].text	== "SELECT")
		{
			alert("Please Select a Student ID and the Subject ID to Delete");
			return false;
		}
		else return true;
	}
function emptyGet() 
	{	
		if (document.resdata.stdid[document.resdata.stdid.selectedIndex].text == "SELECT" ||
			document.resdata.subjid[document.resdata.subjid.selectedIndex].text == "SELECT")
		{
			alert("Please Select a Student ID and the Subject ID to Get Details");
			return false;
		}
		else return true;
	}
//-->	
</script>
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
    <p class="style7"> <strong> <h2>Add/Edit Examination Results</h2></strong> </p>
   
    <form name="resdata" action="<?php $_SERVER['PHP_SELF'];?>" method="post" >
    <table>
  	<tr>
  	<td><b>Select Student ID:</b><br /><em>(Only for Updating/Deleting)</em></td>
  	<td><select size="4" name="stdid" id="select" class="style3" >
  	<option selected="0">SELECT</option>
<?php
	//get student id's in the database
  	$get_stdId = "SELECT id FROM user WHERE type = 'stud'";
	$get_stdId_res = mysql_query($get_stdId);
	while($row = mysql_fetch_array($get_stdId_res))
	{
		echo "<option>$row[id]</option>";
	}
	echo "</select>";
?>
	<tr><td><b>Select Subject ID:</b><br /><em>(Only for Updating/Deleting)</em></td>
  	<td><select size="4" name="subjid" id="select2" class="style3" >
  	<option selected="0" >SELECT</option>
<?php
	//get subject id's in the database
  	$get_subjId = "SELECT subjId FROM subject";
	$get_subjId_res = mysql_query($get_subjId);
	while($row = mysql_fetch_array($get_subjId_res))
	{
		echo "<option>$row[subjId]</option>";
	}
	echo "</select></tr>";


	if(isset($_POST['btnadd']))
	{
		$add = new Examination();
		$add->addResults();
	}
	elseif(isset($_POST['btnupdate']))
	{
		$update = new Examination();
		$update->updateResults();

	}
	?>
	<tr>
	<td></td>
	<td>
	<input type="submit" name="btnget" value="Get Data" class="style3" 
	onclick="return emptyGet()"/>
	<input type="submit" name="btnclrdata" value="Clear Data" class="style3" />
	<input type="submit" name="btndeldata" value="Delete Record" class="style3" 
	onclick="return emptyDel()"/>
	</td>
	</tr>
<?php
	if( isset($_POST['btnget']) && isset($_POST['stdid']) && isset($_POST['subjid']) )
	{
		//get details in database
		$getstdid = $_POST['stdid'];
		$getsubjid = $_POST['subjid'];
		$get_details = "SELECT grade,att_percnt FROM result 
						WHERE r_stdId='$getstdid' AND r_subjId='$getsubjid'";
		$get_details_res = mysql_query($get_details);
		$getgrade = mysql_result($get_details_res,0,'grade') 
		
		// give an error message if selected data not in database
		or die ("<br /><font color='red'>
		Error, Selected Subject Grade for the Student is NOT in the database</font><br />
		<a href='resultdata.php'><b> Go Back</b></a>");
		$getatt = mysql_result($get_details_res,0,'att_percnt');
	}
	elseif( isset($_POST['btndeldata']) &&  $_POST['stdid']!="" && $_POST['subjid']!="" )
	{
		$delete = new Examination();
		$delete->deleteResults();
	}
	elseif( isset($_POST['btnclrdata']))
	{
		//clears form data to get an empty form
		header("Location:resultdata.php");
	}
	mysql_close();

?>

	<tr><td><br /></td></tr>
	<tr>
  	<td><b>Student ID:</b></td>
  	<td><input type="text" name="stid" class="style3" maxlength="6" size="6" 
	value="<?php //get student id 
	  if(isset($_POST['btnget']) &&  $_POST['stdid']!="SELECT" && $_POST['subjid']!="SELECT") echo $getstdid;
	   	   ?>" /> </td>
  	</tr>
  	<tr>
  	<td><b>Subject ID:</b></td>
  	<td><input type="text" name="sbid" class="style3" maxlength="6" size="6" 
	value="<?php //get subject id 
	  if(isset($_POST['btnget']) &&  $_POST['stdid']!="SELECT" && $_POST['subjid']!="SELECT") echo $getsubjid;
	   	   ?>" /> </td>
  	</tr>
  	<tr>
  	<td><b>Grade:</b></td>
  	<td>
	<select name="grade" class="style3" >
  	<option>
	<?php //get grade 
	  if(isset($_POST['btnget']) &&  $_POST['stdid']!="SELECT" && $_POST['subjid']!="SELECT") 		echo $getgrade;
	   	   ?> </option>
    <option>A+</option>
    <option>A</option>
    <option>A-</option>
    <option>B+</option>
	<option>B</option>
	<option>B-</option>
	<option>C+</option>
	<option>C</option>
	<option>D+</option>
	<option>D</option>
	<option>F</option> </select></td>
  	</tr>
  	<tr>
  	<td><b>Attendance(%):</b></td>
  	<td><input type="text" name="att" class="style3" maxlength="3" size="3" 
	value="<?php //get attendance % 
	  if(isset($_POST['btnget']) &&  $_POST['stdid']!="SELECT" && $_POST['subjid']!="SELECT") echo $getatt;
	   elseif(isset($_POST['btnclrdata'])) echo "";
	   ?>" /> </td>
  	</tr>
  	<tr><td></td>
  	<td><input type="submit" name="btnadd" value="Add" class="style3" 
	  onclick="return emptyField()"/>
  	<input type="submit" name="btnupdate" value="Update" class="style3" 
	  onclick="return emptyField()"/>
  	<input type="reset" name="btnclear" value="Clear" class="style3" /></td>
	</tr>
	</table>
	</form>
	
	<?php
	}
		displayMessage();
		
		ob_end_flush();
	?>
	
	<a href="results.php">View Examination Results</a><br />
	<a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
</div>

<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>
