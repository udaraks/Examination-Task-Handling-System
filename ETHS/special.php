<?php
// to remove header errors
ob_start();

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
<title>Apply for Special</title>

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
.style3 {font-size: 12px}
.style2 {
	background-color:#666699;
	color:#FFFFFF
	}
-->
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


// Checks for emptyfields
function emptyField() 
	{	
		if (document.frmsp.addr.value.length<1
		 || document.frmsp.sch.value.length<1 
		 || document.frmsp.year[document.frmsp.year.selectedIndex].text == ""
		 || document.frmsp.zscore.value == "0.0000")
		{
			alert("Please fill out all the fields");
			return false;
		}
		else if(document.frmsp.subj1.value.length<1 
		 || document.frmsp.subj2.value.length<1 
		 || document.frmsp.subj4.value.length<1)
		 {
			alert("Please fill out your A/Level Results");
			return false;
		 }
		 
		//check whether user has entered a valid number
		else if (isNaN(parseInt(document.frmsp.tel.value)) || 
				document.frmsp.tel.value.length<10) {
			alert("The phone number you entered is not valid, it should contain only 10 numbers");
		 	return false;
		}
		
		//check zscore
		else if (isNaN(parseInt(document.frmsp.zscore.value)) ||
				document.frmsp.zscore.value>4)  {
			alert("Zscore should be less than or equal to 4.000");
		 	return false;
		}
		
		else return true;
	}
	

//-->
</script>
</head>
<body onload="MM_preloadImages('Buttons/tim2.jpg','Buttons/special3.jpg','Buttons/res3.jpg','Buttons/log3.jpg','Buttons/ran3.jpg','Buttons/for3.jpg')">

<p><img src="Images/logo.jpg" width="100%" height="92" /></p>
<table border="0">
  <tr>
    <td valign="top" width="329"><a href="home.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('home','','Buttons/home3.jpg',1)"><img src="Buttons/home2.jpg" alt="Home Page " name="home" width="180" height="40" border="0" id="home" /></a><br />
<a href="tt.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('tt','','Buttons/tim2.jpg',1)"><img src="Buttons/tim1.jpg" alt="Examination Time table " name="tt" width="180" height="40" border="0" id="tt" /></a><br />
          <a href="special.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('special','','Buttons/special3.jpg',1)"><img src="Buttons/special2.jpg" alt="Apply for Special Online" name="special" width="180" height="40" border="0" id="special" /></a><br />
          <a href="results.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('results','','Buttons/res3.jpg',1)"><img src="Buttons/res2.jpg" alt="Examination Results" name="results" width="180" height="40" border="0" id="results" /></a><br />
          <a href="ranks.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('rank','','Buttons/ran3.jpg',1)"><img src="Buttons/ran2.jpg" alt="Rankings by results" name="rank" width="180" height="40" border="0" id="rank" /></a><br /> 
          <a href="forum.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forum','','Buttons/for3.jpg',1)"><img src="Buttons/for2.jpg" alt="Discussion Forum" name="forum" width="180" height="40" border="0" id="forum" /></a><br />
        <a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('logout','','Buttons/log3.jpg',1)"><img src="Buttons/log2.jpg" alt="Log Out" name="logout" width="180" height="40" border="0" id="logout" /></a>
     </td>
    <td><h2>APPLY FOR SPECIAL</h2>
    <?php 
 	 //if session is not set then access will be denied
	if(!isset($_SESSION['users']))
	{
	echo("<p><font color='#FF0000'>"."Access Denied,"."<br />". "You are not allowed to
	 access the content until you login"."<br /></font></p>");
		echo("<a href='index.php'>Login Here</a>");
		
	}
	//if a lecturer logins deny access
	elseif(!isset($_SESSION['users']['stdName']))
	{
	echo("<p><font color='#FF0000'>"."Access Denied,"."<br>". "Only Students can access
	 this page"."<br></font></p>");
	}
	
	else
	{
		$special = new SpecialApp();
		$special->sendApp();
		
		if(!isset($_POST['btnSubmit']))
    	{		  	
	?>

	<p>If you want to apply for special, fill the form below and click submit,  which will be submited to the Head of the Department of the relevant subject. Your name, registration number and past exam results will be attached automaically. <br />
	<b><font color="maroon" >ONLY submit this form if you have finished 2nd year successfully.
	</font></b>
        </p>
        
      <strong>CRITERIA FOR SELECTION TO A SPECIAL DEGREE PROGRAM</strong>
  <br /><br />Students may apply to follow a special degree programme in any of the following principal subjects: <strong>Botany,Chemistry,Computer Science,Geology,Mathematics,Physics,Molecular Biology and Zoology.</strong>
  <p>The minimum requirements necessary to apply for selection to the special degree programme are:</p>
  <ol>
    <li>Atleast a <b>GPA of 2.5</b> from 100 and 200 levels in the selected subject of specialization.</li>
    <li>Atleast <b>16 credits</b> for course units from the <b>subject of specialization</b> of which atleast <b>8 credits</b> should be at the <b>200 level</b>.</li>
    <li>In the case of <b>Mathematics</b>, at least <b>32 credits</b> fromm course units listed under mathematics of which atleast <b>16</b> should be obtained at the <b>200 level</b>.</li>
    <li>Atleast grade <b>C</b> for each of the <b>foundation courses</b> offered.</li>
    <li>For Special Degree in <b>Botany</b>, course units from <b>Biology I</b> can be counted as 100 level course units under Botany and similarly for <b>Zoology</b>, course units from <b>Biology I or Biology II</b> can be counted.</li>
  </ol></td>
  </tr>
</table>


<form action="<?php $_SERVER['PHP_SELF']?>" method="post" name="frmsp" onsubmit="return emptyField()">
  <table border="0">
<tr>
  <td>Special Subject</td>
  <td><label>
    <select name="spec_sub" id="select" class="style2">
    <option>Physics</option>
    <option>Chemistry</option>
    <option>Mathematics</option>
    <option>Botany</option>
    <option>Molecular Biology </option>
    <option>Biology</option>
    <option>Geology</option>
    <option>Computer Science</option>
    </select>
  </label></td>
</tr>
	<td>Address</td>
    <td><input name="addr" type="text" size="50"  maxlength="50" class="style2" /></td>    
</tr>
<tr>
	<td>Tel. No.</td>
    <td><input name="tel" type="text" size="10"  maxlength="10" class="style2"/></td>    
</tr>


</table>
<p></p>
<div><table border="0">
  <p>
  <tr>
  	<td>School</td>
    <td><input name="sch" type="text" size="40"  maxlength="40" class="style2"/></td>
  </tr>
  <tr>
  <td>Year of passing the G.C.E.(A/L) Examination</td>
  <td><select name="year" class="style2">
  	<option></option>
  	<option>2003</option>
    <option>2004</option>
    <option>2005</option>
    <option>2006</option>
    <option>2007</option>
    <option>2008</option>
    <option>2009</option>
    <option>2010</option>
    </select>
  </td>
  <td>  Z Score</td>
  <td><input name="zscore" type="text" size="6"  maxlength="6" value="0.0000" class="style2"/></td>
</tr></p> </table>
    <p>&nbsp;</p>
    <table border="0">
  <tr>
  <th>Subject</th>
  <th>Grade</th>
  </tr>
  <tr>
  <td><input name="subj1" type="text" size="15"  maxlength="15" value="Physics" class="style2"/></td>
  <td><select name="grade1" class="style2">
  <option>A</option>
  <option>B</option>
  <option>C</option>
  <option>S</option>
  </select>
  </td>
  </tr> 
  <tr>
  <td><input name="subj2" type="text" size="15"  maxlength="15" value="Chemistry" class="style2" /></td>
  <td><select name="grade2" class="style2">
  <option>A</option>
  <option>B</option>
  <option>C</option>
  <option>S</option>
  </select></td>
  </tr>
  <tr>
  <td><select name="subj3" class="style2">
  <option>Biology</option>
  <option>Combined Maths</option>
  </select>
  </td>
  <td><select name="grade3" class="style2">
  <option>A</option>
  <option>B</option>
  <option>C</option>
  <option>S</option>
  </select></td>
  </tr>
  <tr>
  <td><input name="subj4" type="text" size="15"  maxlength="15" value="General English" class="style2"/></td>
  <td><select name="grade4" class="style2">
  <option>A</option>
  <option>B</option>
  <option>C</option>
  <option>S</option>
  </select></td>
  </tr>
  </table></p>
  <p>
  
    <input name="btnSubmit" type="submit" class="style2" value="Submit" class="style2"/>
    <input name="btnReset" type="reset" class="style2"  value="Clear" class="style2"/>
  </p>
</div>
</form>
<p></p>
<marquee>
        <span class="style3">:: <em><strong>Designed and
        Developed by Udara Senanayake :</strong></em>:</span> 
</marquee>
<?php 
		}
	}

ob_end_flush();
?>
</body>
</html>
