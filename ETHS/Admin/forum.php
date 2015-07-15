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
<title>Add/Delete Forum Data</title>


<style type="text/css">
<!--
body {
	background-image: url(../Images/background.jpg);
	background-repeat:repeat;
	width:100%;
	font-size:  20px;
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
.style4 {
	background-image: url(../Images/input2.jpg);	
	background-repeat:repeat;
	}
.style5{
	background-color:#000000;
	color:#FFFFFF
}

.style7 {color: #000000;
		font-size: 20px}


-->
</style>
<script type="text/javascript" >
<!--
function emptyTopic() 
	{	
		if (document.deltopic.topic.selectedIndex == 0 )
		{
			alert("Please Select Topic Title to Delete");
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
	//deleting a topic
	if(isset($_POST['btndel']))
	{
		$topicname = addslashes($_POST['topic']);
		$deltopic ="DELETE FROM forum_topic WHERE topic_title='$topicname'";
		$deltopic_res = mysql_query($deltopic);	
		header("Location:forum.php");
	}
?>
    <p class="style7"> <strong> <h2>DISCUSSION FORUM</h2></strong> </p><br />
    To Add a Topic <a href="addtopic.php"><strong><em>CLICK HERE</em></strong></a><br /><br />
    <a href="home.php"><img src="../Images/home.png" alt="Go Back To Home" /></a>
    <table border="0">
    <tr>
    <td><b><em>Select Topic</em></b></td>
    <form name='deltopic' method='post' action="<?php $_SERVER['PHP_SELF'];?>">
    <td><select name="topic" class="style3">
    <option>SELECT</option>
<?php
	//get topics
	$gettopics = "SELECT topic_title FROM forum_topic";
	$gettopics_res = mysql_query($gettopics);
	while($row = mysql_fetch_array($gettopics_res))
	{
		echo "<option>$row[topic_title]</option>";
	}
	echo "</select>";
				
?>
	</td>
	<td>
	<input type='submit' value='Delete' name ='btndel' class='style3' 
	alt='Delete this topic' onclick="return emptyTopic()"/></td><br /><br />
	</tr></table>
    
    </form>
    
<?php
	$topics = new Forum();
	$topics->displayAllTopics();
}
 ?> 

 	
</div>
<br /><br /><br /><br />
<marquee>
     <p class="style2">::Designed and
       Developed by Udara Senanayake::        </p>
</marquee>



</body>
</html>
