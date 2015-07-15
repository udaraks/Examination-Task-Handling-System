<?php
/**
 * @author S.R.U.K.Senanayake
 * @copyright 2009
 * This file includes all the main classes,functions for administrator's pages
 */

class Examination
{
	//This function adds results to the system
	function addResults()
	{
		//add results
		$stdid = $_POST['stid'];
		$subjid = $_POST['sbid'];
		$grade = $_POST['grade'];
		$att = $_POST['att'];
		
		//check whether the data thats going to be added are in database
		$getdata = "SELECT r_stdId,r_subjId FROM result WHERE r_stdId = '$stdid' 
					AND r_subjId = '$subjid';";
		$getdata_res = mysql_query($getdata);
		if (mysql_num_rows($getdata_res) < 1) //if no such data then add 
		{
			$put_details ="INSERT INTO result VALUES('$stdid','$subjid','$grade','$att')";
			$put_details_res = mysql_query($put_details);
			header("Location:resultdata.php?status=1");
			header("refresh:1; url='resultdata.php'");
		}
		else
		{
			echo "<font color='red'>You have already added data of selected
			 <b>Student ID = $stdid and Subject ID = $subjid</b> ,
			  you are allowed only to update or delete</font>";
		}
	}
	
	//This function adds time table data to the system
	function addTimeTableData()
	{
		//add timetable data
		$subjid = $_POST['id'];
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$estart = $_POST['estart'];
		$efinish = $_POST['efinish'];
		
		//check whether the data thats going to be added are in database
		$getdata = "SELECT subjId FROM exam WHERE subjId = '$subjid';";
		$getdata_res = mysql_query($getdata);
		if (mysql_num_rows($getdata_res) < 1) //if no such data then add 
		{
			$put_details ="INSERT INTO exam VALUES('$subjid','$year-$month-$day $estart',
							'$year-$month-$day $efinish')";
			$put_details_res = mysql_query($put_details);
			header("Location:examttdata.php?status=1");
			header("refresh:1; url='examttdata.php'");
		}
		else
		{
			echo "<font color='red'>You have already added schedule to selected
			 <b>Subject ID = $subjid</b>, you are allowed only to update or delete
			 </font></br>";
		}
	}
	
	//This function is used to check results
	function checkResult()
	{
		$stdid = $_POST['stdid'];
		
		//get result details
		$get_details = "SELECT r_subjId,grade,att_percnt,subjName,subLevel 
						FROM result,subject
						 WHERE r_stdId='$stdid' AND r_subjId=subjId ORDER BY subLevel
						 ,r_subjId";
		$get_details_res = mysql_query($get_details);
		
		//view them in a table
		echo "<br />Results for <b><em>$stdid</em></b>";
		echo "<font face='Times New Roman'><table align ='center' width=60%><tr>
		<th class='style5'>Subject Level</th>
		<th class='style5'>Subject Id</th>
		<th class='style5'>Subject Name</th>
		<th class='style5'>Grade</th>
		<th class='style5'>Attendance (%)</th></tr>";
		
		while($row=mysql_fetch_array($get_details_res))
		{
			echo "<tr>
			<td align ='center' class='style4'>$row[subLevel]</td>
			<td align ='center' class='style4'>$row[r_subjId]</td>
			<td class='style4'>$row[subjName]</td>
			<td align ='center' class='style4'>$row[grade]</td>
			<td align ='center' class='style4'>$row[att_percnt]</td></tr>";
		}
		echo "</table></font>";		
		mysql_close();
	}
	
	//This function is used to check timetable
	function checkSchedule()
	{
		$type = $_POST['type'];
		
		//get exam schedule according to subject type
		$get_details = "SELECT exam.subjId,  
						date_format(examStart, '%M %D %W %Y') AS fmt_examDate,
						date_format(examStart,'%r') AS fmt_examStart,
						date_format(examFinish, '%r') AS fmt_examFinish, subjType
						FROM exam, subject  WHERE exam.subjId = subject.subjId
						AND subjType = '$type' ORDER BY fmt_examDate";
		$get_details_res = mysql_query($get_details);
		
		//view it on a table
		echo "<p align='center'>Time Table for <b><em>$type</em></b></p>";
		echo "<font face='Times New Roman'><table width=50%><tr>
		<th class='style5'>Subject Id</th>
		<th class='style5'>Exam Date</th>
		<th class='style5'>From - To</th></tr>";
		
		while($row=mysql_fetch_array($get_details_res))
		{
			echo "<tr>
			<td align ='center' class='style4'>$row[subjId]</td>
			<td align ='center' class='style4'>$row[fmt_examDate]</td>
			<td align ='center' class='style4'>$row[fmt_examStart] - $row[fmt_examFinish]
			</td></tr>";
		}
		echo "</table></font>";		
	}
	
	function deleteResults()
	{
		//delete a record in database
		$getsubjid = $_POST['subjid'];
		$getstdid = $_POST['stdid'];
		$del_details = "DELETE FROM result WHERE r_subjId='$getsubjid' 
						AND r_stdId='$getstdid'";
		$del_details_res = mysql_query($del_details);
		header("Location:resultdata.php?status=3");
		header("refresh:1; url='resultdata.php'");
	}
	
	function deleteTimeTableData()
	{
		//delete a record in database
		$getsubjid = $_POST['subjid'];
		$del_details = "DELETE FROM exam WHERE subjId='$getsubjid'";
		$del_details_res = mysql_query($del_details);
		header("Location:examttdata.php?status=3");
		header("refresh:1; url='examttdata.php'");
	}
	
	function updateResults()
	{
		//update a record
		$subjid = $_POST['sbid'];
		$stdid = $_POST['stid'];
		$grade = $_POST['grade'];
		$att = $_POST['att'];
		$put_details = "UPDATE result SET grade = '$grade',att_percnt = '$att' 
						WHERE r_stdId='$stdid' 
						AND r_subjId='$subjid'";
		$put_details_res = mysql_query($put_details);
		header("Location:resultdata.php?status=2");
		header("refresh:1; url='resultdata.php'");
	}
	
	function updateTimeTableData()
	{
		//update a record
		$subjid = $_POST['id'];
		$year= $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$estart = $_POST['estart'];
		$efinish = $_POST['efinish'];
		$put_details = "UPDATE exam SET examStart = '$year-$month-$day $estart',
						examFinish = '$year-$month-$day $efinish'
						WHERE subjId='$subjid'";
		$put_details_res = mysql_query($put_details);
		header("Location:examttdata.php?status=2");
		header("refresh:1; url='examttdata.php'");
	}
	
}


class Forum
{
	function addTopic()
	{
		if(isset($_POST['addtopic']))	
		{
 			// add a topic when a admin logins 
		    if(isset($_SESSION['admin']['uname'])) 
		    {
		    	$admin = $_SESSION['admin']['uname'] ;
		    	
		    	//add slashes to avoid errors when using ',"" etc
   				$topic = addslashes($_POST['topic_title']);
   				$post = addslashes($_POST['post_text']);
		    	$add_topic = "INSERT INTO forum_topic VALUES ('', '$topic',
		 					now(), '$admin')";
		 											
				$add_post = "INSERT INTO forum_post VALUES ('', LAST_INSERT_ID(),
		 					'$post',now(), '$admin',0)";
		   }
			$topic_title = $_POST['topic_title'];
		  	mysql_query($add_topic) or die('Query failed. ' .mysql_error());
		  	mysql_query($add_post) or die('Query failed. ' .mysql_error());
			echo("The<strong> ".$topic_title."</strong> topic has been created. 
			<br /><br /> Redirecting to the main page of the forum...");
			header("refresh:2; url='forum.php'");
		}
		mysql_close();
	}
	
	function displayAllTopics()
	{
		//get the topics
		$get_topics = "SELECT topic_id, topic_title,
		date_format(topic_create_time, '%b %e %Y at %r') AS fmt_topic_create_time,
		topic_owner FROM forum_topic ORDER BY topic_create_time DESC";
		$get_topics_res = mysql_query($get_topics) or die('Query failed '.mysql_error());
		
		if (mysql_num_rows($get_topics_res) < 1) //when there are no topics
		{
			echo "<p><strong><em><h2>No topics exist in the forum.</h2></em></strong></p>";
		} 
		else 
		{
			//create a table to display forum
			echo("<font face='Times New Roman'><table align='center'>
			<tr>
			<th class='style5'>TOPIC TITLE</th>
			<th class='style5'># of POSTS</th>
			<th class='style5'># of VIEWS</th>
			<th class='style5'>LAST POST</th>
			</tr>");
			
	  		while ($topic_info = mysql_fetch_array($get_topics_res)) 
	  		{
	  			//get topic items
		        $topic_id = $topic_info['topic_id'];
		        $topic_title = $topic_info['topic_title'];
		        $topic_create_time = $topic_info['fmt_topic_create_time'];
		        $topic_owner = $topic_info['topic_owner'];
		        
		        //get needed info
		        $get_info = "SELECT post_owner,
		        			date_format(post_create_time, '%b %e %Y at %r') AS
						    fmt_post_create_time
							FROM forum_post WHERE topic_id = $topic_id 
							ORDER BY post_create_time DESC";
		        $get_info_res = mysql_query($get_info)
		        				      or die("Query Failed" . mysql_error());
		        				      
      			//who created the last post
		  		$post_owner = mysql_result($get_info_res,0,'post_owner');
		  		//last post created time
		  		$post_create_time = mysql_result($get_info_res,0,'fmt_post_create_time');
		        		
	      		$getcount = "SELECT COUNT(post_id),views 
				  			FROM forum_post WHERE topic_id = $topic_id";
	  			$getcount_res = mysql_query($getcount)
		        				      or die("Query Failed" . mysql_error()); 
		        				      
	      		//get no. of posts in the topic
		        $num_posts = mysql_result($getcount_res,0,'count(post_id)');
		        //get no. of views of the topic
		  		$num_views = mysql_result($getcount_res,0,'views');
		  		
		        //show topic information
		        echo("<tr>
				<td class='style4' width=50%><img src='../Images/topic.png'>
				<a href=\"showtopic.php?topic_id=$topic_id\">
		        <strong>$topic_title</strong></a><br>
		        Created on $topic_create_time by <em><b>$topic_owner</b></em></td>
		        <td class='style4' align=center>$num_posts</td>
   		        <td class='style4' align=center>$num_views</td>
		        <td class='style4' width=40%>By <em><b>$post_owner</b></em>
				 on $post_create_time </td></form>
		        </tr>");
			}
			echo("</table></font>");
			mysql_close();
		}
	}
	
	function replyToPost()
	{
		// get the number of views of the relevant topic to be inserted 
		// when a new post is made for that topic
		$get_num = "SELECT views FROM forum_post WHERE topic_id = '$_POST[topic_id]'";
		$get_num_res = mysql_query($get_num)
						or die("Query Failed " . mysql_error());
		$num_views = mysql_result($get_num_res,0,'views');	
						
		// add a reply by  an admin 
		if(isset($_SESSION['admin']['uname'])) 
		{
			$admin = $_SESSION['admin']['uname'];
			$reply = addslashes($_POST['reply_text']);
			$add_post = "INSERT INTO forum_post VALUES ('', '$_POST[topic_id]',
	      				'$reply', now(), '$admin','$num_views')";
		}
		mysql_query($add_post) or die("Query failed ".mysql_error());
		
		//redirect user to topic
		header("Location: showtopic.php?topic_id='$_POST[topic_id]'");
		mysql_close();
	}
	
	function showTopic()
	{
	 	//verifying the existance of the topic
		$verify_topic = "SELECT topic_title,topic_id FROM forum_topic WHERE
						topic_id = $_GET[topic_id]";
	    $verify_topic_res = mysql_query($verify_topic)
	     					or die("Query failed ".mysql_error());
	 
	    if (mysql_num_rows($verify_topic_res) < 1) 
		{
		   	//error message when the topic does not exist
		     echo("<p><em><strong>You have selected an invalid topic.
		     Please try again</a>.</strong></em></p>");
	    }
		else
		{
	 	     //get the topic title
		     $topic_title = mysql_result($verify_topic_res,0,'topic_title');
		  
		     //gather the posts
		     $get_posts = "SELECT post_id, post_text,views, date_format(post_create_time,
		         '%b %e %Y at %r') AS fmt_post_create_time, post_owner FROM
		          forum_post WHERE topic_id = $_GET[topic_id]
		          ORDER BY post_create_time ASC";
	  
	   		 $get_posts_res = mysql_query($get_posts) or 
							die("Query failed ".mysql_error());
	
		     //create a table to display 
		     echo("<p><h3><u>TOPIC :-  <strong><em>$topic_title</em></strong></u></h3></p>
		     <font face='Times New Roman'>
			 <table width=100% cellpadding=3 cellspacing=1 border=1>
		     <tr>
		     <th class='style5'>AUTHOR</th>
		     <th class='style5'>POST</th>
		     </tr>");
		     
			 while ($posts_info = mysql_fetch_array($get_posts_res)) 
			 {
		         $post_id = $posts_info['post_id'];
		         $post_text = nl2br($posts_info['post_text']);
		         $post_create_time = $posts_info['fmt_post_create_time'];
		         $post_owner = $posts_info['post_owner'];
		         
		         // Count no. of views of a topic
	       		 $views = $posts_info['views'];				
		    	 $views = $views + 1;
		         $sql = mysql_query("UPDATE forum_post SET views = '$views' 
				 		WHERE topic_id = $_GET[topic_id];");
		  
		  
		         //display post details
		         echo("<tr>
		         <td class='style4'width=35% valign=top>$post_owner<br>[$post_create_time]
				 </td>
		         <td class='style4'width=65% valign=top>$post_text<br><br>
		          <a href=\"replytopost.php?post_id=$post_id\"><strong>REPLY TO
		          POST</strong></a></td>
		         </tr>");
		     }
		      //close the table
		     echo( "</table></font>");
		     mysql_close();
	     }
  
	}
	
	function displayUploadedFiles()
	{
		//get the files from the database
		$query2 = "SELECT id,name,size,type,uploaderId,uploader,
		date_format(upload_time, '%b %e %Y at %r') AS fmt_upload_time FROM upload 
		ORDER BY upload_time DESC";
		$result2 = mysql_query($query2) or die('Query failed '.mysql_error());
		if(mysql_num_rows($result2) == 0) //if there are no files
		{
			echo "<h3>No files in the database</h3> <br>";
		}
		else
		{
			//create a table to display 
			echo("<font face='Times New Roman'><table width='100%'>
			     <tr>
			     <th class='style5'>File ID</th>
			     <th class='style5'>File Name</th>
			     <th class='style5'>Type</th>
			     <th class='style5'>Size (Bytes)</th>
			     <th class='style5'>Uploaded By</th></tr>");
			     
			while(list($id,$name,$size,$type,$uploaderId,$uploader,$fmt_upload_time)
									 = mysql_fetch_array($result2))
			{
		
				echo("<tr>
				  	 <td class='style4' align='center'>$id</td>
					 <td class='style4'><b><a href=\"download.php?id=$id\">$name
					 </a></b></td>
					 <td class='style4'>$type</td>
					 <td class='style4' align='center'>$size</td>
					 <td class='style4'>
					 <em>$uploader [$uploaderId]</em> on $fmt_upload_time</td>
					 </tr>"); 
			}
			echo("</table></font>");
			mysql_close();
		}
	}
	
	function deleteFile()
	{
		//delete a file in database
		$fileid = $_POST['file'];
		$del_details = "DELETE FROM upload WHERE id='$fileid'";
		$del_details_res = mysql_query($del_details);
		$refresh = "ALTER TABLE upload  auto_increment = 1";
		$refresh_res = mysql_query($refresh);
		header("refresh:1; url='uploadfile.php'");
	}
	
	function uploadFile()
	{
		//get file info
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
			
		//file goes to a tmp place
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content); // to escape the content
		fclose($fp);
	
		//add slashes to escape the content
		$fileName = addslashes($fileName);
				
		// add file to the database
		if(isset($_SESSION['admin']['uname'])) 
		{
			$admin = $_SESSION['admin']['uname'];
			$adminid = $_SESSION['admin']['id'];
			$query = "INSERT INTO upload (name,size,type,content, 
						uploaderId, uploader, upload_time ) 
					VALUES ('$fileName','$fileSize','$fileType','$content','$adminid',
					'$admin',now())";
					
			mysql_query($query) or die('Query failed '.mysql_error());
			echo "<br /><td>File <strong>$fileName</strong> uploaded successfully<br />
			<br />
			Redirecting...</td></table>";
			header("refresh:1; url='uploadfile.php'");
		}
	}
}


class Lecturer
{
	function addDetails()
	{
		//add lecturer details
		$dept = $_POST['dept'];
		$id = $_POST['id'];
		$name = $_POST['name'];
		$pass = sha1($_POST['pass']);
		$email = $_POST['email'];
		
		//check whether the data thats going to be added are in database
		$getdata = "SELECT lectId FROM lecturer WHERE lectId = '$id';";
		$getdata_res = mysql_query($getdata);
		if (mysql_num_rows($getdata_res) < 1) //if no such data then add 
		{
			$put_details1 ="INSERT INTO user VALUES('$id','$name','$pass','lect')";
			$put_details_res1 = mysql_query($put_details1);
			$put_details2 = "INSERT INTO lecturer VALUES('$id','$email','$dept')";
			$put_details_res2 = mysql_query($put_details2);
			header("Location:lectdata.php?status=1");
			header("refresh:1; url='lectdata.php'");
		}
		else
		{
			echo "<font color='red'>You have already added data of selected
			 <b>Lecturer ID = $id</b>, you are allowed only to update or delete</font></br>";
		}
	}
	
	function deleteDetails()
	{
		//delete a lecturer record in database
		$getid = $_POST['regno'];
		$del_details = "DELETE FROM user WHERE id='$getid'";
		$del_details_res = mysql_query($del_details);
		header("Location:lectdata.php?status=3");
		header("refresh:1; url='lectdata.php'");
	}
	
	function updateDetails()
	{
		//update lecturer details
		$dept = $_POST['dept'];
		$id = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$put_details1 = "UPDATE lecturer SET lectEmail = '$email', department = '$dept' 
						WHERE lectId='$id'";
		$put_details_res1 = mysql_query($put_details1);
		$put_details2 = "UPDATE user SET name = '$name' WHERE id='$id'";
		$put_details_res2 = mysql_query($put_details2);
		header("Location:lectdata.php?status=2");
		header("refresh:1; url='lectdata.php'");
	}
	
	function updatePass()
	{
		//change  password of a lecturer
		$id = $_POST['id'];
		$pass = sha1($_POST['pass']);
		$put_pass = "UPDATE user SET pass = '$pass' WHERE id='$id'";
		$put_pass_res = mysql_query($put_pass);
		header("Location:lectdata.php?status=2");
		header("refresh:1; url='lectdata.php'");
	}
	
	function viewDetails()
	{
		$dept = $_POST['dept'];
		
		//get lecturer details
		$get_details = "SELECT lectId,name,lectEmail FROM lecturer,user
						 WHERE lectId=id AND department='$dept' ";
		$get_details_res = mysql_query($get_details);
		
		//create a table to display 
		echo "<p align='center'><b>Department -: <em>$dept</em></b></p>";
		echo "<font face='Times New Roman'><table width=50% align='center'><tr>
		<th class='style5'>Id</th>
		<th class='style5'>Name</th>
		<th class='style5'>Email</th></tr>";
		
		while($row=mysql_fetch_array($get_details_res))
		{
			echo "<tr>
			<td align ='center' class='style3'>$row[lectId]</td>
			<td class='style3'>$row[name]</td>
			<td class='style3'>$row[lectEmail]</td></tr>";
		}
		echo "</table></font>";
		mysql_close();		
	}
}


class Login
{
	//This function is used in the login page of the admin
	function login() 
	{
		// get input data
		$uname = $_POST['uname'];
		$pass = sha1($_POST['pass']);
		$sql = "SELECT id,name,pass FROM user WHERE type='admin' ;";
		$result = mysql_query($sql) or die('Query failed. ' . mysql_error());

		//if uname and passwrd are correct assign them to session variables
		while($row = mysql_fetch_assoc($result))
		{
			if($uname == $row['name'] && $pass == $row['pass'])
			{
				$_SESSION['admin']['uname'] = $uname;
				$_SESSION['admin']['pass'] = $pass;
				$_SESSION['admin']['id'] = $row['id'];
				header('Location:home.php');
			}
			else 
			{
				header("Location:index.php?err=1"); //display an error number
			}	
		}
		mysql_close(); // close connection
	}
}


class Password
{
	function changeAdminPassword()
	{
		// get entered passwords
		$pass = sha1($_POST['pass']);//current password
		$pass1 = sha1($_POST['pass1']);//new password
		$pass2 = sha1($_POST['pass2']);// new password
		
		// check whether passwords are equal and if so add them to database
 		if($pass1==$pass2 && $pass==$_SESSION['admin']['pass'])
		{
			$uname = $_SESSION['admin']['uname'];
			$query = "UPDATE user SET pass='$pass1' 
					WHERE name = '$uname'";
			mysql_query($query) or die("Query failed ".mysql_error());
			echo "<p align='center'>You have changed your password successfully</p>";
			header("refresh:2; url='home.php'");		
		}
		
		//display errors
		elseif($pass!=$_SESSION['admin']['pass'])
		{
			header("Location:changepass.php?err=1");
		}
		else
		{
			header("Location:changepass.php?err=2");
		}
		mysql_close();		
	}
}

class Student
{
	function addDetails()
	{
		//add student details
		$year = $_POST['year'];
		$id = $_POST['id'];
		$name = $_POST['name'];
		$pass = sha1($_POST['pass']);
		$cno = $_POST['cno'];
				
		//check whether the data thats going to be added are in database
		$getdata = "SELECT stdId FROM student WHERE stdId = '$id';";
		$getdata_res = mysql_query($getdata);
		if (mysql_num_rows($getdata_res) < 1) //if no such data then add 
		{
			$put_details1 ="INSERT INTO user VALUES('$id','$name','$pass','stud')";
			$put_details_res1 = mysql_query($put_details1);
			$put_details2 = "INSERT INTO student VALUES('$id','$cno','$year','','')";
			$put_details_res2 = mysql_query($put_details2);
			header("Location:stddata.php?status=1");
			header("refresh:1; url='stddata.php'");
		}
		else
		{
			echo "<font color='red'>You have already added data of selected
			 <b>Student ID = $id</b>, you are allowed only to update or delete</font></br>";
		}
	}
	
	function deleteDetails()
	{
		//delete a student record in database
		$getid = $_POST['regno'];
		$del_details = "DELETE FROM user WHERE id='$getid'";
		$del_details_res = mysql_query($del_details);
		header("Location:stddata.php?status=3");
		header("refresh:1; url='stddata.php'");
	}
	
	function updateDetails()
	{
		//update student details
		$year = $_POST['year'];
		$id = $_POST['id'];
		$name = $_POST['name'];
		$cno = $_POST['cno'];
		
		$put_details1 = "UPDATE student SET combiNo = '$cno', year = '$year' 
						WHERE stdId='$id'";
		$put_details_res1 = mysql_query($put_details1);
		$put_details2 = "UPDATE user SET name = '$name' WHERE id='$id'";
		$put_details_res2 = mysql_query($put_details2);
		header("Location:stddata.php?status=2");
		header("refresh:1; url='stddata.php'");
	}
	
	function updatePass()
	{
		//change password of a student
		$id = $_POST['id'];
		$pass = sha1($_POST['pass']);
		$put_pass = "UPDATE user SET pass = '$pass' WHERE id='$id'";
		$put_pass_res = mysql_query($put_pass);
		header("Location:stddata.php?status=2");
		header("refresh:1; url='stddata.php'");
	}
	
	function viewDetails()
	{
		//get student details
		$year = $_POST['year'];
		$get_details = "SELECT stdId,name,combiNo FROM student,user
						 WHERE year=$year AND stdId=id";
		$get_details_res = mysql_query($get_details);
		
		echo "<p align='center'><b>Registration Year :- <i>$year</i></b></p>";
		echo "<font face='Times New Roman'><table width=50% align='center'><tr>
		<th class='style5'>Reg.No</th>
		<th class='style5'>Name</th>
		<th class='style5' >Combination</th></tr>";
		
		while($row=mysql_fetch_array($get_details_res))
		{
			echo "<tr>
			<td align ='center' class='style3'>$row[stdId]</td>
			<td class='style3'>$row[name]</td>
			<td align ='center' class='style3'>$row[combiNo]</td></tr>";
		}
		echo "</table></font>";		
		mysql_close();
	}
}


class Subject
{
	function addDetails()
	{
		//add subject details
		$type = $_POST['type'];
		$id = $_POST['id'];
		$name = $_POST['name'];
		$credits = $_POST['credits'];
		$lect = $_POST['lect'];
		$level = $_POST['level'];
		
		//check whether the data thats going to be added are in database
		$getdata = "SELECT subjId FROM subject WHERE subjId = '$id';";
		$getdata_res = mysql_query($getdata);
		if (mysql_num_rows($getdata_res) < 1) //if no such data then add 
		{
			$put_details ="INSERT INTO subject 
						VALUES('$id','$name','$credits','$type','$lect','$level')";
			$put_details_res = mysql_query($put_details);
			header("Location:subjdata.php?status=1");
			header("refresh:1; url='subjdata.php'");
		}
		else
		{
			echo "<font color='red'>You have already added data of selected
			 <b>Subject ID = $id</b>, you are allowed only to update or delete</font></br>";
		}
	}
	
	function deleteDetails()
	{
		//delete a subject record in database
		$getid = $_POST['subjid'];
		$del_details = "DELETE FROM subject WHERE subjId='$getid'";
		$del_details_res = mysql_query($del_details);
		header("Location:subjdata.php?status=3");
		header("refresh:1; url='subjdata.php'");
	}
	
	function updateDetails()
	{
		//update subject details
		$type = $_POST['type'];
		$id = $_POST['id'];
		$name = $_POST['name'];
		$credits = $_POST['credits'];
		$lect = $_POST['lect'];
		$level = $_POST['level'];
		$put_details = "UPDATE subject SET subjName = '$name', lectName = '$lect',
						credits = '$credits',subjType = '$type',subLevel = '$level' 
						WHERE subjId='$id'";
		$put_details_res = mysql_query($put_details);
		header("Location:subjdata.php?status=2");
		header("refresh:1; url='subjdata.php'");
	}
	
	function viewDetails()
	{
		$subj = $_POST['subj'];
		
		//get subject details
		$get_details = "SELECT subjId,subjName,subjType,credits,lectName FROM subject
						 WHERE subjType='$subj' ";
		$get_details_res = mysql_query($get_details);
		
		//create a table to display 
		echo "<p align='center'><b>Subject Type :- <i>$subj</i></b></p>";
		echo "<font face='Times New Roman'><table align='center' width=50%><tr>
		<th class='style5'>Subject Id</th>
		<th class='style5'>Subject Name</th>
		<th class='style5'>Credts</th>
		<th class='style5'>Lecturer in Charge</th></tr>";
		
		while($row=mysql_fetch_array($get_details_res))
		{
			echo "<tr>
			<td align ='center' class='style3'>$row[subjId]</td>
			<td class='style3'>$row[subjName]</td>
			<td align ='center' class='style3'>$row[credits]</td>
			<td class='style3'>$row[lectName]</td></tr>";
		}
		echo "</table></font>";
		mysql_close();		
	}
}
?>