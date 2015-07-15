<?php
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
<title>Add/Edit Exam Time Table Data</title>


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
		if (document.ttdata.id.value.length<1 || 
			document.ttdata.estart.value == "00:00" || 
			document.ttdata.efinish.value == "00:00" || 
			document.ttdata.year[document.ttdata.year.selectedIndex].text 
			== "YEAR" ||
			document.ttdata.month[document.ttdata.month.selectedIndex].text 
			== "MONTH" ||
			document.ttdata.day[document.ttdata.day.selectedIndex].text 
			== "DAY")
		{
			alert("Please Fill All The Details Properly");
			return false;
		}
		else return true;
	}
function emptyRegNo_Del() 
	{	
		if (document.ttdata.subjid.selectedIndex == 0 )
		{
			alert("Please Select a Subject ID to Delete");
			return false;
		}
		else return true;
	}
function emptyRegNo_Get() 
	{	
		if (document.ttdata.subjid.selectedIndex == 0 )
		{
			alert("Please Select a Subject ID to Get Details");
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
	"You are not allowed to access the content untill you login"."<br /></p>
	<a href='index.php'>Login Here</a></font>");
		
}
else
{

?>
    <p class="style7"> <strong> <h2>Add/Edit Exam Time Table Data</h2></strong> </p>
	<br /><br />
   
    <form name="ttdata" action="<?php $_SERVER['PHP_SELF'];?>" method="post" >
    <table>
  	<tr>
  	<td><b>Select Subject ID:</b></td>
  	<td><select name="subjid" id="select" class="style3">
  	<option>SELECT</option>
<?php
	//get subject id's in the database
  	$get_subjId = "SELECT subjId FROM exam";
	$get_subjId_res = mysql_query($get_subjId);
	while($row = mysql_fetch_array($get_subjId_res))
	{
		echo "<option>$row[subjId]</option>";
	}
	echo "</select>";
	
	if(isset($_POST['btnadd']) )
	{
		$add = new Examination();
		$add->addTimeTableData();
	}
	elseif(isset($_POST['btnupdate']))
	{
		$update = new Examination();
		$update->updateTimeTableData();

	}
	elseif( isset($_POST['btnget']) && $_POST['subjid']!="SELECT" )
	{
		//get timetable details in database
		$subjid = $_POST['subjid'];
		$get_details = "SELECT date_format(examStart, '%m') AS month,
						date_format(examStart, '%Y') AS year,
						date_format(examStart, '%e') AS day,
						date_format(examStart,'%H:%i') AS fmt_examStart,
						date_format(examFinish,'%H:%i') AS fmt_examFinish
 						FROM exam WHERE subjId='$subjid'";
		$get_details_res = mysql_query($get_details);
		$getyear= mysql_result($get_details_res,0,'year');
		$getmonth= mysql_result($get_details_res,0,'month');
		$getday= mysql_result($get_details_res,0,'day');
		$getestart= mysql_result($get_details_res,0,'fmt_examStart');
		$getefinish = mysql_result($get_details_res,0,'fmt_examFinish');
	}
	elseif( isset($_POST['btndeldata']) && $_POST['subjid']!="SELECT" )
	{
		$delete = new Examination();
		$delete->deleteTimeTableData();
	}
	elseif( isset($_POST['btnclrdata']))
	{
		//clears form data to get an empty form
		header("Location:examttdata.php");
	}
	mysql_close();
}
	?>
	<input type="submit" name="btnget" value="Get Data" class="style3" 
	onclick="return emptyRegNo_Get()"/>
	<input type="submit" name="btnclrdata" value="Clear Data" class="style3" />
	<input type="submit" name="btndeldata" value="Delete Record" class="style3" 
	onclick="return emptyRegNo_Del()"/>
	</td>
	</tr>
	<tr>
	<td><em>(Only for Updating/Deleting)<a></em></td>
	</tr>
	<tr><td><br /></td></tr>
	<tr>
  	<td><b>Subject ID:</b></td>
  	<td><input type="text" name="id" class="style3"  maxlength="6" size="6" 
	  value="<?php //get reg no 
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $subjid;
   		?>" /> </td>
  	</tr>
   <tr>
   <td><b>Exam Date</b></td>
    <td><select name="year" class="style3" >
  	<option><?php //get year
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $getyear;
	  else echo "YEAR";
	  ?></option>
	<option>2008</option>
	<option>2009</option>
	<option>2010</option>
	<option>2011</option>
	</select>
	
	<select name="month" class="style3" >
  	<option><?php //get month
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $getmonth;
	  else echo "MONTH";
	  ?></option>
	  <?php
	  for($i=1;$i<13;$i++)
	  {
	  	echo "<option>$i</option>";
	  }
	  ?>
	</select>
	
	<select name="day" class="style3" >
  	<option><?php //get day
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $getday;
	  else echo "DAY";
	  ?></option>
	  <?php
	  for($i=1;$i<32;$i++)
	  {
	  	echo "<option>$i</option>";
	  }
	  ?>
	</select>
	<b>From: </b><input type="text" name="estart" class="style3" size="5" maxlength="5"
	  value="<?php //get exam start time
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $getestart;
	   	else echo "00:00";   ?>" />
   <b>To: </b>
  	<input type="text" name="efinish" class="style3" size="5" maxlength="5"
	  value="<?php //get exam finish time 
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $getefinish;
	   	else echo "00:00";   ?>" /> <em>[Time in 24hrs (eg, 16:00)]</em>
 	</td>
 	<tr><td><br /></td></tr>
  	<tr><td></td>
  	<td><input type="submit" name="btnadd" value="Add" class="style3" 
	  onclick="return emptyField()"/>
  	<input type="submit" name="btnupdate" value="Update" class="style3" 
	  onclick="return emptyField()"/>
  	<input type="reset" name="btnclear" value="Clear" class="style3" /></td>
	</tr>
	</table>
	</form>
	<br />
	<?php
		displayMessage();
	?>
	<a href="examtt.php">View Time Table</a><br /><br />
	<a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
</div>

<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>