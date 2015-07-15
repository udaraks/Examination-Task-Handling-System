<?php
// this php file include code for connecting to the database
include 'con_mysql.php';
$con = new dbconn();
$con->getcon();

// this includes all classes and functions
include 'class.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>Examination Results</title>

<style type="text/css">
<!--
body {
	background-image: url(Images/background.jpg);	
	background-repeat:repeat;
	width:100%;
	height: 100%;
	font-family:arial;
}
body,td,th {
	color: #000000;
}
.style2 {font-size: 12px}
-->
.style4 {
	background-image: url(Images/input.jpg);	
	background-repeat:repeat-x;
	}
.style5 {
	background-color:black;
	color:#FFFFFF
	}
.style6 {
	background-color: #666699;
	color:#FFFFFF
	}


</style>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function emptyField() 
	{	
		if (document.frmresult.year[document.frmresult.year.selectedIndex].text 
			== "SELECT" ||
			document.frmresult.subjid[document.frmresult.subjid.selectedIndex].text 
			== "SELECT")
		{
			alert("Please Select a Course ID and  a Batch");
			return false;
		}
		else return true;
	}
function emptyId() 
	{	
		if (document.frmresult.subjid2[document.frmresult.subjid2.selectedIndex].text 
			== "SELECT")
		{
			alert("Please Select a Course ID to see Statistics");
			return false;
		}
		else return true;
	}
//-->
</script>
</head>
<body onload="MM_preloadImages('Buttons/tim2.jpg','Buttons/special3.jpg','Buttons/res3.jpg','Buttons/log3.jpg','Buttons/ran3.jpg','Buttons/for3.jpg')">

<p><img src="Images/logo.jpg" width="100%" height="92"/> </p>

<table border="0">
  <tr>
    <td width="329"><a href="home.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('home','','Buttons/home3.jpg',1)"><img src="Buttons/home2.jpg" alt="Home Page " name="home" width="180" height="40" border="0" id="home" /></a><br />
<a href="tt.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('tt','','Buttons/tim2.jpg',1)"><img src="Buttons/tim1.jpg" alt="Examination Time table " name="tt" width="180" height="40" border="0" id="tt" /></a><br />
<a href="special.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('special','','Buttons/special3.jpg',1)"><img src="Buttons/special2.jpg" alt="Apply for Special Online" name="special" width="180" height="40" border="0" id="special" /></a><br />
<a href="results.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('results','','Buttons/res3.jpg',1)"><img src="Buttons/res2.jpg" alt="Examination Results" name="results" width="180" height="40" border="0" id="results" /></a><br />
<a href="ranks.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('rank','','Buttons/ran3.jpg',1)"><img src="Buttons/ran2.jpg" alt="Rankings by results" name="rank" width="180" height="40" border="0" id="rank" /></a><br /> 
<a href="forum.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forum','','Buttons/for3.jpg',1)"><img src="Buttons/for2.jpg" alt="Discussion Forum" name="forum" width="180" height="40" border="0" id="forum" /></a><br />
<a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('logout','','Buttons/log3.jpg',1)"><img src="Buttons/log2.jpg" alt="Log Out" name="logout" width="180" height="40" border="0" id="logout" /></a></td>
    <td><h2>EXAMINATION RESULTS</h2>
<?php 
//if session is not set then access will be denied
if(!isset($_SESSION['users']))
{
	echo("<p><font color='#FF0000'>"."Access Denied,"."<br />". "You are not
	 allowed to access the content until you login"."<br /></font></p>");
	echo("<a href='index.php'>Login Here</a></td></tr></table>");
}

if(isset($_SESSION['users']['stdName'])) // for  a student 
{
?>
    <p>In this page you can see your past results with more details and also you can calculate your GPA values.</p>
    <p>To check your subject wise and overall GPA,  <a href="gpa.php"><strong><em>CLICK HERE</em></strong></a></p>
    <p>You can filter your results by the following given conditions.</p>
    
    <form method="post" name="frmresult" action="<?php $_SERVER['PHP_SELF'];?>">
<table border="0">
<tr>
<td><strong>Course Level</strong><select name="level" class="style6" >
	<option>ALL</option>
 <?php
 	//get course levels
	$stdid = $_SESSION['users']['regno'];
	$getlevel = "SELECT distinct subLevel FROM subject,result WHERE r_stdId = '$stdid'
				AND r_subjId = subjId";
	$getlevel_res = mysql_query($getlevel);
	while($row = mysql_fetch_array($getlevel_res))
	{
		echo "<option>$row[subLevel]</option>";
	}
	echo "</select> ";
?>

<strong>Subject Type</strong><select name="type" class="style6" >
	<option>ALL</option>
<?php
	//get subject types
	$stdid = $_SESSION['users']['regno'];
	$gettype = "SELECT distinct subjType FROM subject,result WHERE r_stdId = '$stdid'
				AND r_subjId = subjId";
	$gettype_res = mysql_query($gettype);
	while($row = mysql_fetch_array($gettype_res))
	{
		echo "<option>$row[subjType]</option>";
	}
	echo "</select> ";
?>
<input type='submit' value='Check Exam Results' name ='btncheck1' class='style6' 
	align="center" /><br /><br />
<p align="center">
<strong>Course ID</strong><select name="subjid2" class="style6" >
	<option>SELECT</option>
<?php
	//get course id's
	$getcourse = "SELECT r_subjid FROM result WHERE r_stdId = '$stdid'";
	$getcourse_res = mysql_query($getcourse);
	while($row = mysql_fetch_array($getcourse_res))
	{
		echo "<option>$row[r_subjid]</option>";
	}
	echo "</select> ";
?>
<input type='submit' value='Statistics' name ='btnstat1' class='style6' 
	align='center' onclick='return emptyId()'/> </p>	
</td>
    </tr>
    </table>
</form>
<?php
echo "
</td>
  </tr>
</table> ";

	if(isset($_POST['btncheck1']))
	{
		$res = new Examination();
		$res->checkResultByStudent();
	}
		elseif(isset($_POST['btnstat1']))
	{
		$res = new Examination();
		$res->checkResultStatistics();
	}
	
}

else if(isset($_SESSION['users']['lectName'])) // for  a lecturer 
{
?><br />
	<p>In this page you can see examination results of students
	  of the relevant subjects and some statistics.</p>
	  
	  Click on check results to see the results and to get statistics click on statistics button.
	  
<form method="post" name="frmresult" action="<?php $_SERVER['PHP_SELF'];?>">
<table border="0">
<tr><td>
<strong>Course ID</strong><select name="subjid" class="style6" >
	<option>SELECT</option>
<?php
	//get course id's
	$getcourse = "SELECT distinct r_subjid FROM result";
	$getcourse_res = mysql_query($getcourse);
	while($row = mysql_fetch_array($getcourse_res))
	{
		echo "<option>$row[r_subjid]</option>";
	}
	echo "</select> ";
?>
<strong>Batch</strong><select name="year" class="style6" >
	<option>SELECT</option>
<?php
	//get batches
	$getbatch = "SELECT distinct year FROM student";
	$getbatch_res = mysql_query($getbatch);
	while($row = mysql_fetch_array($getbatch_res))
	{
		echo "<option>$row[year]</option>";
	}
	echo "</select> ";
?>
<input type='submit' value='Check Exam Results' name ='btncheck2' class='style6' 
	align="center" onclick="return emptyField()" />
<p align="center">
<strong>Course ID</strong><select name="subjid2" class="style6" >
	<option>SELECT</option>
<?php
	//get course id's
	$getcourse = "SELECT distinct r_subjid FROM result";
	$getcourse_res = mysql_query($getcourse);
	while($row = mysql_fetch_array($getcourse_res))
	{
		echo "<option>$row[r_subjid]</option>";
	}
	echo "</select> ";
?>
<input type='submit' value='Statistics' name ='btnstat2' class='style6' 
	align="center" onclick="return emptyId()"/>
</p>	

</form>
</td>
  </tr>
</table> 
</td>
  </tr>
</table>
<?php
	if(isset($_POST['btncheck2']))
	{
		$res = new Examination();
		$res->checkResultByLecturer();
	}
	
	elseif(isset($_POST['btnstat2']))
	{
		$res = new Examination();
		$res->checkResultStatistics();
	}
	
}
	mysql_close();
	echo("</table>");
?>
<br /><br />
<p>
  <marquee>
    <span class="style2"><em><strong>::Designed and
      Developed by Udara Senanayake::</strong></em></span> 
  </marquee>
</p>
</body>
</html>
