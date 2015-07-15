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
<title>Add a Topic</title>


<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);	
	background-repeat:repeat-x;
	width:100%;
	font-family:arial;
	font-size:  20px;
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
.style4 {
	background-color:#666699;
	color:#FFFFFF
}
.style5{
	background-color:#000000;
	color:#FFFFFF
}

.style7 {color: #000000;
		font-size: 20px}
a:link {
	color: #B7AEFF;
}
a:visited {
	color: #FF6600;
}

-->
</style>
<script type="text/javascript">
<!--
function emptyField() 
	{	
		if (document.frmpost.topic_title.value.length<1 || 
		document.frmpost.post_text.value.length<1) {
			alert("Please Enter the Topic Title and the Description");
			return false;
		}
		else return true;
	}	
//-->
</script>
</head>

<body>
<div align="center">
<img src="../Images/logoforum.jpg" width="100%" height="92"/>
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
		if(isset($_POST['addtopic']))
		{
			$add = new Forum();
			$add->addTopic();
		
		}
		else
		{
	?>
	  <h2>ADD A TOPIC</h2> <br />
      
      <form name="frmpost" action="<?php $_SERVER['PHP_SELF']?>" method="post" 
	  onsubmit="return emptyField()">
        <p><strong>Title of the topic: </strong> 
        <input name="topic_title" type="text" class="style4" size="40" maxlength="100"/>
        </p><br />
        <p><strong>Description: </strong><br />
          <textarea name="post_text" cols='50' rows='8' class="style4"></textarea>
        </p> 
        <br/>
        <input name="addtopic" type="submit" class="style4" value="Post To Forum" />
        <input name="clear" type="reset" class="style4" value="Clear" />
      </form>
<?php
		}
}
?> 	
<br />
<a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
</div>
<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>
