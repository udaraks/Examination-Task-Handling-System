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
<title>Add/Edit Lecturer Details</title>


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
		if (document.lectdata.id.value.length<1 || 
			document.lectdata.name.value.length<1 || 
			document.lectdata.dept[document.lectdata.dept.selectedIndex].text 
			== "SELECT DEPARTMENT")
		{
			alert("Please Fill All The Details (email is not compulsory)");
			return false;
		}
		
		else if(document.lectdata.email.value.length>0 &&
				(document.lectdata.email.value.indexOf("@") == -1 ||
				document.lectdata.email.value.indexOf(".") == -1) )
		{
			alert("Email Address is not valid");
			return false;
		}
		
		else return true;
	}
function errorPass() 
	{	
		if (document.lectdata.pass.value.length<1 ||
			document.lectdata.pass2.value.length<1)
		{
			alert("Please Enter a Password and Confirm it");
			return false;
		}
		
		else if(document.lectdata.pass.value!= document.lectdata.pass2.value)
		{
			alert("Passwords don't match");
			return false;
		}
		else return true;
	}
function emptyRegNo_Del() 
	{	
		if (document.lectdata.regno.selectedIndex == 0 )
		{
			alert("Please Select a Lecturer ID to Delete");
			return false;
		}
		else return true;
	}
function emptyRegNo_Get() 
	{	
		if (document.lectdata.regno.selectedIndex == 0 )
		{
			alert("Please Select a Lecturer ID to Get Details");
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
    <p class="style7"> <strong> <h2>Add/Edit Lecturer Details</h2></strong> </p>
	<br /><br />
   
    <form name="lectdata" action="<?php $_SERVER['PHP_SELF'];?>" method="post" >
    <table>
  	<tr>
  	<td><b>Select Lecturer ID:</b></td>
  	<td><select name="regno" id="select" class="style3">
  	<option>SELECT</option>
<?php
	//get lecturer id's in the database
  	$get_lectId = "SELECT id FROM user WHERE type = 'lect'";
	$get_lectId_res = mysql_query($get_lectId);
	while($row = mysql_fetch_array($get_lectId_res))
	{
		echo "<option>$row[id]</option>";
	}
	echo "</select>";
	
	if(isset($_POST['btnadd']) && $_POST['dept']!="SELECT DEPARTMENT")
	{
		$add = new Lecturer();
		$add->addDetails();
	}
	elseif(isset($_POST['btnupdate']))
	{
		$update = new Lecturer();
		$update->updateDetails();
	}
	elseif(isset($_POST['btnupdatepass']))
	{
		$update = new Lecturer();
		$update->updatePass();
	}
	elseif( isset($_POST['btnget']) && $_POST['regno']!="SELECT" )
	{
		//get lecturer details in database
		$getid = $_POST['regno'];
		$get_details = "SELECT name,pass,lectEmail,department FROM lecturer,user 
						WHERE lectId='$getid' AND id='$getid'";
		$get_details_res = mysql_query($get_details);
		$getname = mysql_result($get_details_res,0,'name');
		$getpass = mysql_result($get_details_res,0,'pass');
		$getemail = mysql_result($get_details_res,0,'lectEmail');
		$getdept = mysql_result($get_details_res,0,'department');		
	}
	elseif( isset($_POST['btndeldata']) && $_POST['regno']!="SELECT" )
	{
		$delete = new Lecturer();
		$delete->deleteDetails();
	}
	elseif( isset($_POST['btnclrdata']))
	{
		//clears form data to get an empty form
		header("Location:lectdata.php");
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
  	<td><b>Lecturer ID:</b></td>
  	<td><input type="text" name="id" class="style3"  maxlength="4" size="4" 
	  value="<?php //get reg no 
	  if(isset($_POST['btnget']) && $_POST['regno']!="SELECT") echo $getid;
   		?>" /> </td>
  	</tr>
  	<tr>
  	<td><b>Lecturer Name:</b></td>
  	<td><input type="text" name="name" class="style3" size="30" 
	  value="<?php //get name 
	  if(isset($_POST['btnget']) && $_POST['regno']!="SELECT") echo $getname;
	   	   ?>" />
 	</td></tr>
   	<tr>
  	<td><b>Email Address:</b></td>
  	<td><input type="text" name="email" class="style3" size="30" 
	value="<?php //get email address 
	  if(isset($_POST['btnget']) && $_POST['regno']!="SELECT") echo $getemail;
	   	   ?>" /> </td>
  	</tr>
  	<tr>
  	<td><b>Department:</b></td>
  	<td><select name="dept" class="style3" >
  	<option><?php //get department
	  if(isset($_POST['btnget']) && $_POST['regno']!="SELECT") echo $getdept;
	  else echo "SELECT DEPARTMENT";
	  ?></option>
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
  	</tr>
  	<tr><td></td>
  	<td><input type="submit" name="btnadd" value="Add" class="style3" 
	  onclick="return emptyField(),errorPass()"/>
  	<input type="submit" name="btnupdate" value="Update" class="style3" 
	  onclick="return emptyField()"/>
  	<input type="reset" name="btnclear" value="Clear" class="style3" /><br /><br /></td>
	</tr>
	<tr>
  	<td><b>Password:</b></td>
  	<td><input type="password" name="pass" class="style3" size="10"
	  value="<?php //get password 
	  if(isset($_POST['btnget']) && $_POST['regno']!="SELECT") echo $getpass;
	   	   ?>" /> 
   </td></tr>
   <tr>
   	<td><b>Confirm Password:</b></td>
  	<td><input type="password" name="pass2" class="style3" size="10"
	  value="<?php //get password 
	  if(isset($_POST['btnget']) && $_POST['regno']!="SELECT") echo $getpass;
	   	   ?>" /> 
   <input type="submit" name="btnupdatepass" value="Change Password" class="style3" 
	  onclick="return emptyField(),errorPass()"/></td>
  	</tr>
	</table>
	</form>
	<br />
	<?php
		displayMessage();
	?>
	<a href="lecturer.php">View Lecturer Details</a><br /><br />
	<a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
</div>

<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>
