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
<title>Upload/Download/Delete Files</title>

<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat;
	width:100%;
	font-family:arial;
}
body,td,th {
	color: #000000;
}
.style2 {font-size: 12px}
.style3 {
	background-color:#666699;
	color:#FFFFFF
	}
.style4 {
	background-image: url(../Images/input.jpg);	
	background-repeat:repeat;
	}
.style5 {
	background-color:#000000;
	color:#FFFFFF
	}



-->

</style>
<script type="text/javascript">
<!--
function emptyField() 
	{	
		if (document.frmupload.userfile.value.length<1) 
		{
			alert("Please Select a File to Upload");
			return false;
		}
		else return true;
	}
//-->
</script>
</head>
<body>

<p><img src="../Images/logoforum.jpg" width="100%" height="92"/> </p>
<div align="center">

<?php
//if session is not set then access will be denied
if(!isset($_SESSION['admin']))
{
	echo("<td><p><font color='#FF0000'>"."Access Denied,"."<br>". "You are not allowed to 			access the content until you login"."<br /></font></p>");
	echo("<a href='index.php'>Login Here</a></td></table>");
}
else
{
	//when  the upload button is clicked and file size is greater than zero bytes
	if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
	{
		$fileName=$_FILES['userfile']['name'];
		
		//get extension
		$ext = substr($fileName, strrpos($fileName, '.') + 1);
		
		//check whether .exe .zip .rar files are attached
		if ($ext == 'exe' || $ext == 'zip' || $ext == 'rar')
		{
			echo "<td><b><font color='red'>You are not allowed to upload 
			<em> '.exe', '.rar' , '.zip'</em>
			 files.</font><br/><br/>
			<a href='uploadfile.php'>Go Back</a></b></td></table> ";
		} 
		
		// checks for size of the file
		else if($_FILES['userfile']['size'] > 15*1024*1024)
		{
			echo("<td><b><font color='red'>File size exceeds the limit of <em>15MB</em>.
			 You are not allowed to upload</font><br/>
			<a href='uploadfile.php'>Go Back</a></b></td></table>");
		}
		
		else
		{
			$upload = new Forum();
			$upload->uploadFile();
		}
	}
	else
	{
?>	
	<h2>UPLOAD/DOWNLOAD FILES</h2>
	To upload a file select the file and click upload <br /><em>(The file size should be <b>less than 15MB</b>, also <b>.exe, .zip, .rar files are not allowed</b> to be uploaded</em><br /><br />
    
    <form name="frmupload" method="post" enctype="multipart/form-data" >
	<input name="userfile" type="file" id="userfile" />
	<input name="upload" type="submit"  id="upload" 
	value="Upload"  onclick="return emptyField()"/> <br />
	<p>Below you can see already uploaded files. Just click on the file name to download	   </p>
	
	<b>Select a File ID to Delete</b>
	<select name="file" class="style3">
	<?php
		//get file id's
		$getfileid = "SELECT id from upload";
		$getfileid_res = mysql_query($getfileid);
		while($row=mysql_fetch_array($getfileid_res))
		{
			echo "<option> $row[id] </option>";
		}
		
		if(isset($_POST['delfile']))
		{
			$delfile = new Forum();
			$delfile->deleteFile();	
		}
		 
	?>
	</select> 
	<input type="submit" value="Delete" name="delfile"  class="style3"/>
	</form> </p>
    <a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
<br />

<?php
	$showupload = new Forum();
	$showupload->displayUploadedFiles(); 
	}
}
?>

<br /><br />
<p class="style2">
  <marquee>
    <em><strong>::Designed and
      Developed by Udara Senanayake::</strong></em>
  </marquee>

</p>
</body>
</html>