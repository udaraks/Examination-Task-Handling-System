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
<title>Rankings According to GPA</title>

<style type="text/css">
<!--
body {
	background-image: url(Images/background.jpg);	
	background-repeat:repeat;
	width:100%;
	font-family:arial;
}
body,td,th {
	color: #000000;
}
.style2 {font-size: 12px}
-->
.style4 {
	background-image: url(Images/input.jpg);	
	background-repeat:repeat;
	}
.style5 {
	background-color:black;
	color:#FFFFFF
	}
.style6 {
	background-color:#666699;
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

function emptyType() 
	{	
		if (document.frmresult.type[document.frmresult.type.selectedIndex].text 
			== "SELECT" ||
			document.frmresult.batch1[document.frmresult.batch1.selectedIndex].text 
			== "SELECT")
		{
			alert("Please Select a Subject Type and a Batch");
			return false;
		}
		else return true;
	}
	
function emptyComb() 
	{	
		if (document.frmresult.comb[document.frmresult.comb.selectedIndex].text 
			== "SELECT" ||
			document.frmresult.batch2[document.frmresult.batch2.selectedIndex].text 
			== "SELECT")
		{
			alert("Please Select a Combination and a Batch");
			return false;
		}
		else return true;
	}
	
function emptyOverall() 
	{	
		if (document.frmresult.batch3[document.frmresult.batch3.selectedIndex].text 
			== "SELECT")
		{
			alert("Please Select a Batch to See Overall Rankings");
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
    <td width="329" valign="top" ><a href="home.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('home','','Buttons/home3.jpg',1)"><img src="Buttons/home2.jpg" alt="Home Page " name="home" width="180" height="40" border="0" id="home" /></a><br />
<a href="tt.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('tt','','Buttons/tim2.jpg',1)"><img src="Buttons/tim1.jpg" alt="Examination Time table " name="tt" width="180" height="40" border="0" id="tt" /></a><br />
<a href="special.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('special','','Buttons/special3.jpg',1)"><img src="Buttons/special2.jpg" alt="Apply for Special Online" name="special" width="180" height="40" border="0" id="special" /></a><br />
<a href="results.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('results','','Buttons/res3.jpg',1)"><img src="Buttons/res2.jpg" alt="Examination Results" name="results" width="180" height="40" border="0" id="results" /></a><br />
<a href="ranks.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('rank','','Buttons/ran3.jpg',1)"><img src="Buttons/ran2.jpg" alt="Rankings by results" name="rank" width="180" height="40" border="0" id="rank" /></a><br /> 
<a href="forum.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forum','','Buttons/for3.jpg',1)"><img src="Buttons/for2.jpg" alt="Discussion Forum" name="forum" width="180" height="40" border="0" id="forum" /></a><br />
<a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('logout','','Buttons/log3.jpg',1)"><img src="Buttons/log2.jpg" alt="Log Out" name="logout" width="180" height="40" border="0" id="logout" /></a></td>
    <td><h2>RANKINGS</h2>
<?php 
//if session is not set then access will be denied
if(!isset($_SESSION['users']))
{
	echo("<p><font color='#FF0000'>"."Access Denied,"."<br />". "You are not
	 allowed to access the content until you login"."<br /></font></p>");
	echo("<a href='index.php'>Login Here</a></td></tr></table>");
}

else
{
?>
    <p>In this page you can check rankings according to GPA.</p>
    <p>You can check rankings according to following given criterias.</p>
    
<form method="post" name="frmresult" action="<?php $_SERVER['PHP_SELF'];?>">
<table border="0">
<tr><td>
<strong>Subject Type </strong></td>
<td><select name="type" class="style6" >
	<option>SELECT</option>
<?php
	//get subject types
	$gettype = "SELECT distinct subjType FROM subject";
	$gettype_res = mysql_query($gettype);
	while($row = mysql_fetch_array($gettype_res))
	{
		echo "<option>$row[subjType]</option>";
	}
	echo "</select> ";
?>
</td>
<td>
<strong>Batch</strong><select name="batch1" class="style6" >
	<option>SELECT</option>
<?php
	//get batches
	$gettype = "SELECT distinct year FROM student";
	$gettype_res = mysql_query($gettype);
	while($row = mysql_fetch_array($gettype_res))
	{
		echo "<option>$row[year]</option>";
	}
	echo "</select> ";
?>
</td>
<td>
<input type='submit' value='Check Rankings' name ='btncheck1' class='style6' 
	align="center" onclick="return emptyType()" />
</td>
<tr>
<td>	
<strong>Combination </strong></td>
<td><select name="comb" class="style6" >
	<option>SELECT</option>
<?php
	//get combinations
	$getcomb = "SELECT distinct combiNo FROM student";
	$getcomb_res = mysql_query($getcomb);
	while($row = mysql_fetch_array($getcomb_res))
	{
		echo "<option>$row[combiNo]</option>";
	}
	echo "</select> ";
?>
</td>
<td>
<strong>Batch</strong><select name="batch2" class="style6" >
	<option>SELECT</option>
<?php
	//get batches
	$gettype = "SELECT distinct year FROM student";
	$gettype_res = mysql_query($gettype);
	while($row = mysql_fetch_array($gettype_res))
	{
		echo "<option>$row[year]</option>";
	}
	echo "</select> ";
?>
</td>
<td>
<input type='submit' value='Check Rankings' name ='btncheck2' class='style6' 
	align="center" onclick="return emptyComb()"/>
</td></tr>	</table>
<p align="center" ><strong>Batch</strong>
<select name="batch3" class="style6" >
	<option>SELECT</option>
<?php
	// get batches
	$gettype = "SELECT distinct year FROM student";
	$gettype_res = mysql_query($gettype);
	while($row = mysql_fetch_array($gettype_res))
	{
		echo "<option>$row[year]</option>";
	}
	echo "</select> ";
?>
<input type='submit' value='Check Overall Rankings' name ='btnoverall' class='style6' 
	align="center" onclick="return emptyOverall()" /></p>
    
</form>
</td>
  </tr>
</table> 
<?php
	if(isset($_POST['btncheck1']))
	{
		$rank = new Examination();
		$rank->checkRankByType();
	}
	elseif(isset($_POST['btncheck2']))
	{
		$rank = new Examination();
		$rank->checkRankByCombination();
	}
	elseif(isset($_POST['btnoverall']))
	{
		$rank = new Examination();
		$rank->checkOverallRank();
	}
}
	mysql_close();
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
