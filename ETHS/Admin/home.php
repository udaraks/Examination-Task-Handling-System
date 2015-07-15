<?php
session_start();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>Examination Task Handling System: Administrator's Main Page</title>


<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat-x;
	width:100%;
	font-size:  18px;
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
	background-color:#000000;
	color:#ffffff
}
.style4{
	color:#FFFFFF
}
.style5 {font-size: 16px}
.style6 {
	background-image: url(../Images/admin1.jpg);	
	background-repeat:repeat;
	
}
.style7 {color: #000000;
		font-size: 20px}
.style8 {
	background-image: url(../Images/admin2.jpg);	
	background-repeat:repeat;
	
}
.style9 {
	background-image: url(../Images/admin3.jpg);	
	background-repeat:repeat;
	
}
.style10 {
	background-image: url(../Images/admin4.jpg);	
	background-repeat:repeat;
	
}

-->
</style>

</head>

<body>
<div>
<img src="../Images/logo.jpg" width="100%" height="92"/>

<?php
//if session is not set then access will be denied
if(!isset($_SESSION['admin']))
{
	echo("<p align='center'><font color='#FF0000' size='3'>"."Access Denied,"."<br />". 
	"You are not allowed to access the content until you login"."<br />
	<a href='index.php'>Login Here</a></font></p>");
		
}
else
{
?>
<br />
<p class="style7" > <strong>  WELCOME! ADMINISTRATOR</strong> </p>
<table border="0" width="100%">
<tr><th></th>
<th class="style3">Main</th>
<th class="style3">Examination</th>
<th class="style3">Forum</th>
<th class="style3">Reports</th>
</tr>
<tr><td width="200">

<img src="../Images/Administrator.jpg" height="150" width="150"/></td>

<td class="style6">

  	<a href="student.php" class="style5"><img src="../Images/link.png" />Add/Edit Student Details</a>
	<br /><br />
	<a href="lecturer.php" class="style5"><img src="../Images/link.png" />Add/Edit Lecturer Details</a>
	<br /><br />
	<a href="subject.php" class="style5"><img src="../Images/link.png" />Add/Edit Subject Details</a>
	
</td>
<td class="style8">

	<a href="examtt.php" class="style5"><img src="../Images/link.png" />Add/Edit Exam Time Table Data</a>
	<br /><br />
	<a href="results.php" class="style5"><img src="../Images/link.png" />Add/Edit Exam Results</a>
	
</td>
<td class="style9">

	<a href="forum.php" class="style5"><img src="../Images/link.png" />Add/Delete Forum Data</a><br /><br />
	<a href="uploadfile.php" class="style5"><img src="../Images/link.png" />Upload/Download/Delete Files</a>
</td>

<td class="style10">
<a href="viewstudent.php" class="style5"><img src="../Images/link.png" />View Student Details</a>
	<br />
<a href="viewlecturer.php" class="style5"><img src="../Images/link.png" />View Lecturer Details</a>
	<br />
<a href="viewsubject.php" class="style5"><img src="../Images/link.png" />View Subject Details</a><br />
<a href="viewexamtt.php" class="style5"><img src="../Images/link.png" />View Exam Time Table</a>
<br />
<a href="viewresults.php" class="style5"><img src="../Images/link.png" />View Exam Results</a>
	</td>

</tr>

</table><br />
	<a href="changepass.php">Change Admin Password</a> <br /><br />
	<a href="logout.php">Logout</a>

</div>
<br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>
<?php
}
?>