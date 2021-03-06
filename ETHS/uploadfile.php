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
<title>Upload/Download Files</title>

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
.style4 {
	background-image: url(Images/input.jpg);	
	background-repeat:repeat;
	}
.style5 {
	background-color:#000000;
	color:#FFFFFF
	}
.style6 {
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
<body onload="MM_preloadImages('Buttons/tim2.jpg','Buttons/special3.jpg','Buttons/res3.jpg','Buttons/log3.jpg','Buttons/ran3.jpg','Buttons/for3.jpg')">

<p><img src="Images/logoforum.jpg" width="100%" height="92"/> </p>

<table border="0">
  <tr>
    <td width="329"><a href="home.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('home','','Buttons/home3.jpg',1)"><img src="Buttons/home2.jpg" alt="Home Page " name="home" width="180" height="40" border="0" id="home" /></a><br />
<a href="tt.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('tt','','Buttons/tim2.jpg',1)"><img src="Buttons/tim1.jpg" alt="Examination Time table " name="tt" width="180" height="40" border="0" id="tt" /></a><br />
<a href="special.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('special','','Buttons/special3.jpg',1)"><img src="Buttons/special2.jpg" alt="Apply for Special Online" name="special" width="180" height="40" border="0" id="special" /></a><br />
<a href="results.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('results','','Buttons/res3.jpg',1)"><img src="Buttons/res2.jpg" alt="Examination Results" name="results" width="180" height="40" border="0" id="results" /></a><br />
<a href="ranks.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('rank','','Buttons/ran3.jpg',1)"><img src="Buttons/ran2.jpg" alt="Rankings by results" name="rank" width="180" height="40" border="0" id="rank" /></a><br /> 
<a href="forum.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('forum','','Buttons/for3.jpg',1)"><img src="Buttons/for2.jpg" alt="Discussion Forum" name="forum" width="180" height="40" border="0" id="forum" /></a><br />
<a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('logout','','Buttons/log3.jpg',1)"><img src="Buttons/log2.jpg" alt="Log Out" name="logout" width="180" height="40" border="0" id="logout" /></a></td>
    
    <p>
<?php
//if session is not set then access will be denied
if(!isset($_SESSION['users']))
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
		
		//check whether .exe files are attached
		if ($ext == 'exe' || $ext == 'zip' || $ext == 'rar')
		{
			echo "<td><b><font color='red'>You are not allowed to upload 
			<em> '.exe, .rar, .zip '</em> files.<br/><br/>
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
	<td><h2>UPLOAD/DOWNLOAD FILES</h2><br />
	To upload a file select the file and click upload <br /><em>(The file size should be <b>less than 15MB</b>, also <b>.exe, .zip, .rar files are not allowed</b> to be uploaded</em><br /><br />
    
    <form name="frmupload" method="post" enctype="multipart/form-data"  >
	<input name="userfile" type="file" id="userfile" />

	<input name="upload" type="submit"  id="upload" onclick="return emptyField()"
	value="Upload" />
	<br />
	<p>Below you can see already uploaded files. Just click on the file name to download	   </p>
	<b>Select a File ID <em>(Uploaded By You)</em> to Delete</b>
	<select name="file" class="style6">
	<?php
		//get file id's 
		$usrid = $_SESSION['users']['regno'];
		$getfileid = "SELECT id from upload WHERE uploaderId = '$usrid' ";
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
	<input type="submit" value="Delete" name="delfile"  class="style6"/>
	</form> </p>
	</td>
  </tr>
</table>
<br />

<p>

<?php
	$showupload = new Forum();
	$showupload->displayUploadedFiles(); 
	}
}
?>

</p>
<p class="style2">
  <marquee>
    <em><strong>::Designed and
      Developed by Udara Senanayake::</strong></em>
  </marquee>

</p>
</body>
</html>
