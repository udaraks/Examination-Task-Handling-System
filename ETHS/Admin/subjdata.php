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
<title>Add/Edit Subject Details</title>


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
		if (document.subjdata.id.value.length<1 || 
			document.subjdata.name.value.length<1 || 
			document.subjdata.level[document.subjdata.level.selectedIndex].text 
			== "SELECT LEVEL" ||
			document.subjdata.type[document.subjdata.type.selectedIndex].text 
			== "SELECT TYPE")
		{
			alert("Please Fill All The Details");
			return false;
		}
		else return true;
	}
function emptyRegNo_Del() 
	{	
		if (document.subjdata.subjid.selectedIndex == 0 )
		{
			alert("Please Select a Subject ID to Delete");
			return false;
		}
		else return true;
	}
function emptyRegNo_Get() 
	{	
		if (document.subjdata.subjid.selectedIndex == 0 )
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
	"You are not allowed to access the content until you login"."<br /></p>
	<a href='index.php'>Login Here</a></font>");
		
}
else
{
?>
    <p class="style7"> <strong> <h2>Add/Edit Subject Details</h2></strong> </p>
	<br /><br />
   
    <form name="subjdata" action="<?php $_SERVER['PHP_SELF'];?>" method="post" >
    <table>
    <td><b>Select Subject ID:</b></td>
  	<td><select name="subjid" id="select" class="style3">
  	<option>SELECT</option>
<?php
	//get subject id's in the database
	
  	$get_subjId = "SELECT subjId FROM subject";
	$get_subjId_res = mysql_query($get_subjId);
	while($row = mysql_fetch_array($get_subjId_res))
	{
		echo "<option>$row[subjId]</option>";
	}
	echo "</select>";
	
	if(isset($_POST['btnadd']))
	{
		$add = new Subject();
		$add->addDetails();
	}
	elseif(isset($_POST['btnupdate']))
	{
		$update = new Subject();
		$update->updateDetails();

	}
	elseif( isset($_POST['btnget']) && $_POST['subjid']!="SELECT" )
	{
		//get subject details in database
		$subid = $_POST['subjid'];
		$get_details = "SELECT subjName,credits,subjType,subLevel,lectName FROM subject 
						WHERE subjId='$subid'";
		$get_details_res = mysql_query($get_details);
		$getsubname = mysql_result($get_details_res,0,'subjName');
		$getcredits = mysql_result($get_details_res,0,'credits');
		$gettype = mysql_result($get_details_res,0,'subjType');
		$getlevel = mysql_result($get_details_res,0,'subLevel');
		$getlecname = mysql_result($get_details_res,0,'lectName');		
	}
	elseif( isset($_POST['btndeldata']) && $_POST['subjid']!="SELECT" )
	{
		$delete = new Subject();
		$delete->deleteDetails();
	}
	elseif( isset($_POST['btnclrdata']))
	{
		//clears form data to get an empty form
		header("Location:subjdata.php");
	}
	
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
	  value="<?php //get subject id 
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $subid;
   		?>" /> </td>
  	</tr>
  	<tr>
  	<td><b>Subject Name:</b></td>
  	<td><input type="text" name="name" class="style3" size="50" 
	  value="<?php //get subject name 
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $getsubname;
	   	   ?>" />
 	</td>
 	</tr>
 	<tr>
  	<td><b>No. of Credits:</b></td>
  	<td><select name="credits" class="style3">
	  <option><?php //get subject credits 
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $getcredits;
	   	   ?> </option>
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
    <option>6</option>
    </select>
 	</td>
 	</tr>
   	<tr>
  	<td><b>Lecturer In Charge:</b></td>
  	<td><select name="lect" class="style3" size="3">
  	
	<?php 
	//get lectnames in database
	$lectname = "SELECT name FROM user WHERE type = 'lect' ORDER BY name;";
	$lectname_res = mysql_query($lectname);
		
	//if get button is clicked select the lecturer name for the selected subject
	if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") 
	{
		echo"<option selected='true'>";
		echo $getlecname;
		echo"</option>" ;
	 	
	 	while($row2 = mysql_fetch_array($lectname_res))
		{
			echo "<option>$row2[name]</option>";
		}
	}
	//else just display lecturer name list
	else
	{
		while($row3 = mysql_fetch_array($lectname_res))
		{
			echo "<option selected='true'>$row3[name]</option>";
		}
	}
	mysql_close();
 ?>
 	</select>
	 </td>
  	</tr>
  	<tr>
  	<tr>
  	<td><b>Subject Level:</b></td>
  	<td><select name="level" class="style3" >
  	<option><?php //get level
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $getlevel;
	  else echo "SELECT LEVEL";
	  ?></option>
    <option>100</option>
    <option>200</option>
    <option>300</option>
    <option>400</option>
	</td>
  	</tr>
  	<tr>
  	<td><b>Subject Type:</b></td>
  	<td><select name="type" class="style3" >
  	<option><?php //get TYPE
	  if(isset($_POST['btnget']) && $_POST['subjid']!="SELECT") echo $gettype;
	  else echo "SELECT TYPE";
	  ?></option>
    <option>Basic Computing</option>
    <option>Biology</option>
    <option>Botany</option>
    <option>Chemistry</option>
    <option>Computer Science</option>
    <option>Economics</option>
  	<option>Geology</option>
  	<option>Management</option>
  	<option>Mathematics</option>
  	<option>Molecular Biology &amp; Biotechnology</option>
  	<option>Physics</option>
  	<option>Statistics</option>
  	<option>Zoology</option>
  	</select>
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
	<br />
	<?php
		displayMessage();
	?>
	<a href="subject.php">View Subject Details</a><br /><br />
	<a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
</div>

<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>

</body>
</html>