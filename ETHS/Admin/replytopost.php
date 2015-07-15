<?php 
// to remove header errors
ob_start();

// this php file include code for connecting to the database
include '../con_mysql.php';
$con = new dbconn();
$con->getcon();

// this includes all classes and functions
include 'adminclass.php';

//if there isn't such post id goto forum'
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
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat-x;
	width:100%;
	font-size:  20px;
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
<body>

<p><img src="../Images/logoforum.jpg" width="100%" height="92"/> </p>
<div align="center">
<p class="style3">DISCUSSION FORUM</p><br />

<?php
//if session is not set then access will be denied
if(!isset($_SESSION['admin']))
{
	echo("<p><font color='#FF0000'>"."Access Denied,"."<br>". "You are not allowed to 			access the content until you login"."<br></font></p>");
	echo("<a href='index.php'>Login Here</a>");
}
else
{
?>
   
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

<form name="frmreply" action="<?php $_SERVER['PHP_SELF']?>" method="post" onsubmit="return emptyField()">
        
        <strong>Post your reply below: </strong><br />
          <br />
          <textarea name="reply_text" cols='50' rows='8' class="style4"></textarea>
          
       
    
  <input type="hidden" name="topic_id" value="<?php echo($topic_id);?>" />
  
  
         <br />
        
  <input name="replypost" type="submit" class="style4" value="Post" />
        <input name="clear" type="reset" class="style4" value="Clear" />
</form>
<br />
<a href="forum.php"><em><strong>Go Back to the topic list</strong></em></a>
 </div>
<br />
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
<br /><br /><br />
<p class="style2">
  <marquee>
    <em><strong>::Designed and
      Developed by Udara Senanayake::</strong></em>
  </marquee>

</p>
</body>
</html>
