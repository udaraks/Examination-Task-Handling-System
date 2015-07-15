<?php 
// to remove header errors
ob_start();

// this php file include code for connecting to the database
include 'con_mysql.php';
$con = new dbconn();
$con->getcon();

// this includes all classes and functions
include 'class.php';

//goback to forum if there isn't such post id
if (!$_GET['post_id'])
{
	header("Location: forum.php");
	exit;
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="S.R.U.K.Senanayake" />
<title>Reply to the post</title>

<style type="text/css">
<!--
body {
	background-image: url(Images/background.jpg);
	background-repeat:repeat-x;
	width:100%;
	font-family:arial;
}
body,td,th {
	color: #000000;
}
.style2 {font-size: 12px}
.style3 {	font-size: 24px;
	font-weight: bold;
}
.style4 {
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
		if (document.frmreply.reply_text.value.length<1)
	    {
			alert("Please Enter a reply");
			return false;
		}
		else return true;
	}
//-->
</script>
</head>
<body onLoad="MM_preloadImages('Buttons/tim2.jpg','Buttons/special3.jpg','Buttons/res3.jpg','Buttons/log3.jpg','Buttons/ran3.jpg','Buttons/for3.jpg')">

<p><img src="Images/logoforum.jpg" width="100%" height="92"/> </p>

<table border="0">
  <tr>
    <td width="329"><a href="home.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('home','','Buttons/home3.jpg',1)"><img src="Buttons/home2.jpg" alt="Home Page " name="home" width="180" height="40" border="0" id="home" /></a><br />
<a href="tt.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('tt','','Buttons/tim2.jpg',1)"><img src="Buttons/tim1.jpg" alt="Examination Time table " name="tt" width="180" height="40" border="0" id="tt" /></a><br />
<a href="special.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('special','','Buttons/special3.jpg',1)"><img src="Buttons/special2.jpg" alt="Apply for Special Online" name="special" width="180" height="40" border="0" id="special" /></a><br />
<a href="results.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('results','','Buttons/res3.jpg',1)"><img src="Buttons/res2.jpg" alt="Examination Results" name="results" width="180" height="40" border="0" id="results" /></a><br />
<a href="ranks.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('rank','','Buttons/ran3.jpg',1)"><img src="Buttons/ran2.jpg" alt="Rankings by results" name="rank" width="180" height="40" border="0" id="rank" /></a><br /> 
<a href="forum.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('forum','','Buttons/for3.jpg',1)"><img src="Buttons/for2.jpg" alt="Discussion Forum" name="forum" width="180" height="40" border="0" id="forum" /></a><br />
<a href="logout.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('logout','','Buttons/log3.jpg',1)"><img src="Buttons/log2.jpg" alt="Log Out" name="logout" width="180" height="40" border="0" id="logout" /></a></td>
    <td><p class="style3">DISCUSSION FORUM</p>
    <?php
    //if session is not set then access will be denied
    if(!isset($_SESSION['users']))
	{
		echo("<p><font color='#FF0000'>"."Access Denied,"."<br>". "You are not allowed to 			access the content until you login"."<br></font></p>");
		echo("<a href='index.php'>Login Here</a>");
	}
	else
	{
	?>
      <p>Feel free to discuss any problems, share your ideas and attach any related subject materials in this forum. </p>
      <p>Also
        you can add information about higher studies and some future job opportunities etc.</p>
      <p>You can see the posted topics below. Click on the topic to view posts.</p>
      <ul>
        <li><strong>To add a new topic <a href="addtopic.php"><em> CLICK HERE</em></a></strong></li>
        <li><strong>To upload a file <a href="uploadfile.php"><em> CLICK HERE</em></a> </strong>  </li>
      </ul>
      </td>
  </tr>
</table>
<p></p>
<?php
	if(!isset($_POST['replypost']))
	{
		//verify topic and post
		$verify = "SELECT ft.topic_id, ft.topic_title FROM
		forum_post AS fp LEFT JOIN forum_topic AS ft ON
		fp.topic_id = ft.topic_id WHERE fp.post_id = $_GET[post_id]";
		 
		$verify_res = mysql_query($verify) or die("Query failed1 ".mysql_error());
		
		if (mysql_num_rows($verify_res) < 1) 
		{
			//this post or topic does not exist
			header("Location: forum.php");
			exit;
		} 
		else 
		{
			//get the topic id and title
			$topic_id = mysql_result($verify_res,0,'topic_id');
			$topic_title = mysql_result($verify_res,0,'topic_title');
		
?> 
<div align="center">
<form name="frmreply" action="<?php $_SERVER['PHP_SELF']?>" method="post" onsubmit="return emptyField()">
        
        <strong>Post your reply below: </strong><br />
          <br />
          <textarea name="reply_text" cols='50' rows='8' class="style4"></textarea>
          
       
    
  <input type="hidden" name="topic_id" value="<?php echo($topic_id);?>" />
  
  
         <br />
        
  <input name="replypost" type="submit" class="style4" value="Post" />
        <input name="clear" type="reset" class="style4" value="Clear" />
</form> </div>
<a href="forum.php"><em><strong>Go Back to the topic list</strong></em></a>
<br />
<br /><br /><br />
<p class="style2">
  <marquee>
    <em><strong>::Designed and
      Developed by Udara Senanayake::</strong></em>
  </marquee>

</p>
</body>
</html>
<?php
			
		}
	
	} 
	else
	{
		$reply = new Forum();
		$reply->replyToPost();
	}	

}

ob_end_flush();

?>