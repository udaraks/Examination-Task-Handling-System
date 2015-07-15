<?php
/**
 * @author S.R.U.K.Senanayake
 * @copyright 2009
 * This file includes all the main classes,functions for student's and lecturer's pages
 */

class Examination
{
	//This function calculates and displays GPA
	function checkGPA()
	{
		$stdId = $_SESSION['users']['regno'];
		$type = $_POST['type'];
		$level = $_POST['level'];
		
		//calculate GPA according to subject type & level
		if($type == "ALL" && $level == "ALL")
		{
			$sql = "SELECT gp,credits FROM result, assign, subject	WHERE grade = as_grade 
					AND r_stdId = '$stdId' AND r_subjId = subjId";
			
		}
		elseif($type != "ALL" && $level == "ALL")
		{
			$sql = "SELECT gp,credits FROM result, assign, subject	WHERE grade = as_grade 
					AND r_stdId = '$stdId' AND r_subjId = subjId AND subjType = '$type'";
		}
		elseif($type == "ALL" && $level != "ALL")
		{
		$sql = "SELECT gp,credits FROM result, assign, subject WHERE grade = as_grade 
					AND r_stdId = '$stdId' AND r_subjId = subjId AND subLevel = '$level'";
		}
		else
		{
		$sql = "SELECT gp,credits FROM result, assign, subject WHERE grade = as_grade 
				AND r_stdId = '$stdId' AND r_subjId = subjId
				AND subLevel = '$level' AND subjType = '$type';";
		}
		$result = mysql_query($sql) or die('Query failed. ' . mysql_error());
		$totalgp = 0;
		$totalcredits =0;
		while($row = mysql_fetch_assoc($result))
		{
			$gp = $row['gp'];
			$credits =	$row['credits'];
			$totalgp = $totalgp + $gp*$credits;
			$totalcredits = $totalcredits + $credits;
		}
		$gpa = round($totalgp/$totalcredits,3);
		$gpa = number_format($gpa,3);
		
		//find whether student has failed any subject (Then no class awarded)
		$getfailsubj = "SELECT grade FROM result WHERE r_stdId = '$stdId'
						AND (grade = 'F' OR grade = 'D'	OR grade = 'D+'	) ";
		$getfailsubj_res = mysql_query($getfailsubj);
		
		// get the Class 
		if($type == "ALL" && $level == "ALL")
		{
			//if a student has failed even in one subject student will not get a class
			if(mysql_num_rows($getfailsubj_res)>0) $class = "Pass";
			
			//give class according to gpa
			elseif($gpa >= 3.75) $class = "First Class";
			elseif($gpa >= 3.30) $class = "Second Upper Class";
			elseif($gpa >= 2.75) $class = "Second Lower Class";
			else $class = "Pass";
		}
		
		echo "<p align='center'><b><i>$type</i></b> Courses in <b><i>$level</i></b> 
				Level/Levels</p>";
		echo "<table align='center'><tr>
			<th class='style6' width=50%>GPA = $gpa";
		
		if(isset($class))
		{	
			echo " &nbsp;=>&nbsp; $class &nbsp;</th>"; //display class
		}
		echo "</table>";
	}
	
	//This function finds ranks of students according to GPA
	function checkOverallRank()
	{
		$batch = $_POST['batch3'];
		
		//create a table to display 
		echo "<p align='center'><b>Overall Rankings for <i>$batch</i> Batch</b> </p>";
		echo("<font face='Times New Roman'><table width=50% align='center'><tr>
			<th class='style5'>Rank </th>
			<th class='style5'>Student Id </th>
			<th class='style5'>Student Name</th>
			<th class='style5'>GPA</th>
			<th class='style5'>Credits</th>");
			
		//select students to calculate GPA of each student 
		$sql = "SELECT distinct r_stdid,name,gpa,totalcredits 
				FROM user,student,result WHERE type = 'stud'
				AND stdId = r_stdid AND year = '$batch' AND r_stdid = id
				ORDER BY gpa DESC,totalcredits DESC";
		$sql_res = mysql_query($sql) or die('Query failed. ' . mysql_error());
		
		while($stdarray = mysql_fetch_array($sql_res))
		{
			// query to calculte GPA
			$calgpa = "SELECT gp,credits FROM result, assign, subject WHERE grade = as_grade 					AND r_stdId = '$stdarray[r_stdid]' AND r_subjId = subjId;";
					
			$resultgpa = mysql_query($calgpa) or die('Query failed. ' . mysql_error());
	
			$totalgp = 0;
			$totalcredits =0;
			while($row = mysql_fetch_assoc($resultgpa))
			{
				$gp = $row['gp'];
				$credits =	$row['credits'];
				$totalgp = $totalgp + $gp*$credits;
				$totalcredits = $totalcredits + $credits;
			}
			$gpa = round($totalgp/$totalcredits,3);
			$gpa = number_format($gpa,3);
			
			//if GPA has changed update it 
			if($stdarray['gpa'] != $gpa || $stdarray['totalcredits'] != $totalcredits)
			{
				$updategpa = "UPDATE student SET gpa='$gpa' , totalcredits='$totalcredits'
							WHERE stdId='$stdarray[r_stdid]';";
				$updategpa_res = mysql_query($updategpa);
			}
		}
		
		//query to display the data
		//important to use another query since database may be updated 
		$display = mysql_query($sql) or die('Query failed. ' . mysql_error());
		$rank=0;
		while($stdarray = mysql_fetch_array($display))
		{
			$rank = $rank +1; // get the rank
			echo "<tr><td class='style4' align='center'>$rank</td>
				<td class='style4' align='center'>$stdarray[r_stdid]</td>
				<td class='style4' >$stdarray[name]</td>
				<td class='style4' align='center'><b><font color='yellow'>"
				.number_format($stdarray['gpa'],3)."</font></b></td>
				<td class='style4' align='center'>$stdarray[totalcredits]</td></tr>";
		}
		echo "</table></font>";
	}
	
	function checkRankByCombination()
	{
		$batch = $_POST['batch2'];
		$comb = $_POST['comb'];
		
		//create a table to display
		echo "<p align='center'><b>Rankings for <i>$comb</i> Combination - 
			<i>$batch</i> Batch</b>
				 </p>";
		echo("<font face='Times New Roman'><table width=50% align='center'><tr>
			<th class='style5'>Rank </th>
			<th class='style5'>Student Id </th>
			<th class='style5'>Student Name</th>
			<th class='style5'>GPA</th>
			<th class='style5'>Credits</th>");

		//select students to calculate GPA of each student 
		$sql = "SELECT id,name,gpa,totalcredits FROM user,student WHERE type = 'stud'
		AND stdId = id AND year = '$batch' AND combiNo='$comb' 
		ORDER BY gpa DESC,totalcredits DESC";
		$sql_res = mysql_query($sql) or die('Query failed. ' . mysql_error());
		
		while($stdarray = mysql_fetch_array($sql_res))
		{
			// query to calculte GPA according to combination
			$calgpa = "SELECT gp,credits,combiNo FROM result,assign,subject,student
						WHERE grade = as_grade AND r_stdId = '$stdarray[id]' 
						AND r_subjId = subjId AND r_stdId = stdId AND combiNo = '$comb';";
					
			$resultgpa = mysql_query($calgpa) or die('Query failed. ' . mysql_error());
	
			$totalgp = 0;
			$totalcredits =0;
			while($row = mysql_fetch_assoc($resultgpa))
			{
				$gp = $row['gp'];
				$credits =	$row['credits'];
				$totalgp = $totalgp + $gp*$credits;
				$totalcredits = $totalcredits + $credits;
			}
			$gpa = round($totalgp/$totalcredits,3);
			$gpa = number_format($gpa,3);
			
			//if GPA has changed update it 
			if($stdarray['gpa'] != $gpa || $stdarray['totalcredits'] != $totalcredits)
			{
				$updategpa = "UPDATE student SET gpa='$gpa' WHERE stdId='$stdarray[id]';";
				$updategpa_res = mysql_query($updategpa);
			}
		}
		
		//query to display the data 
		//important to use another query since database may be updated 
		$display = mysql_query($sql) or die('Query failed. ' . mysql_error());
		$rank=0;
		while($stdarray = mysql_fetch_array($display))
		{
			$rank = $rank +1; // get the rank
			echo "<tr><td class='style4' align='center'>$rank</td>
				<td class='style4' align='center'>$stdarray[id]</td>
				<td class='style4' >$stdarray[name]</td>
				<td class='style4' align='center'><b><font color='yellow'>"
				.number_format($stdarray['gpa'],3)."</font></b></td>
				<td class='style4' align='center'>$stdarray[totalcredits]</td></tr>";
		}
		echo "</table></font>";
	}
	
	function checkRankByType()
	{
		$batch = $_POST['batch1'];
		$type = $_POST['type'];
		
		//create a table to display
		echo "<p align='center'><b>Rankings for <i>$type</i> - 
			<i>$batch</i> Batch</b>
				 </p>";
		echo("<font face='Times New Roman'><table width=50% align='center'><tr>
			<th class='style5'>Rank </th>
			<th class='style5'>Student Id </th>
			<th class='style5'>Student Name</th>
			<th class='style5'>GPA</th>
			<th class='style5'>Credits</th>");

		//select students to calculate GPA of each student 
		$sql = "SELECT distinct r_stdid,name,gpa,totalcredits 
				FROM user,student,subject,result 
				WHERE type = 'stud'	AND stdId = r_stdid AND year = '$batch' 
				AND subjType='$type' AND r_subjId = subjId AND r_stdid = id
				ORDER BY gpa DESC,totalcredits DESC";
		$sql_res = mysql_query($sql) or die('Query failed. ' . mysql_error());
		
		while($stdarray = mysql_fetch_array($sql_res))
		{
			// query to calculte GPA according to combination
			$calgpa = "SELECT gp,credits,subjType FROM result,assign,subject,student
						WHERE grade = as_grade AND r_stdId = '$stdarray[r_stdid]' 
						AND r_subjId = subjId AND r_stdId = stdId AND subjType = '$type';";
					
			$resultgpa = mysql_query($calgpa) or die('Query failed. ' . mysql_error());
	
			$totalgp = 0;
			$totalcredits =0;
			while($row = mysql_fetch_assoc($resultgpa))
			{
				$gp = $row['gp'];
				$credits =	$row['credits'];
				$totalgp = $totalgp + $gp*$credits;
				$totalcredits = $totalcredits + $credits;
			}
			$gpa = round($totalgp/$totalcredits,3);
			$gpa = number_format($gpa,3);
			
			//if GPA has changed update it 
			if($stdarray['gpa'] != $gpa || $stdarray['totalcredits'] != $totalcredits)
			{
				$updategpa = "UPDATE student SET gpa='$gpa' , totalcredits='$totalcredits'
							WHERE stdId='$stdarray[r_stdid]';";
				$updategpa_res = mysql_query($updategpa);
			}
		}
		
		//query to display the data 
		//important to use another query since database may be updated 
		$display = mysql_query($sql) or die('Query failed. ' . mysql_error());
		$rank=0;
		while($stdarray = mysql_fetch_array($display))
		{
			$rank = $rank +1; // get the rank
			echo "<tr><td class='style4' align='center'>$rank</td>
				<td class='style4' align='center'>$stdarray[r_stdid]</td>
				<td class='style4'>$stdarray[name]</td>
				<td class='style4' align='center'><b><font color='yellow'>"
				.number_format($stdarray['gpa'],3)."</font></b></td>
				<td class='style4' align='center'>$stdarray[totalcredits]</td></tr>";
		}
		echo "</table></font>";
	}
	
	function checkResultByLecturer()
	{
		$subjid = $_POST['subjid'];
		$year = $_POST['year'];
		
		//get exam results according to subject id & year
		if($subjid != "SELECT")
		{
			$query = "SELECT r_stdId,r_subjId,name,year,subjName, grade, att_percnt
			FROM result, subject,user,student WHERE r_subjId = subjId 
			AND r_subjId = '$subjid' AND r_stdId = stdId AND year = '$year'
			AND r_stdId = id ORDER BY r_stdId;";
		}
		
		$result1=mysql_query($query); // to get subject Name
		$getinfo=mysql_fetch_array($result1);
		echo "<p align='center'>Examination Results for  
		<b><em>$subjid - $getinfo[subjName]</em>
		</b> Course  <b><em>$getinfo[year]</em></b> Batch</p>";
		
		//calculate passrate
		$total = "SELECT grade,year FROM result,student 
			WHERE r_subjId = '$subjid' AND year='$getinfo[year]'
			 AND r_stdId = stdId;";
		$res_total=mysql_query($total);
		$total_no=mysql_num_rows($res_total);
			
		$fail="SELECT grade,year FROM result,student WHERE r_subjId = '$subjid'
					AND (grade = 'F' OR grade = 'D'	OR grade = 'D+'	) 
					AND year='$getinfo[year]' AND r_stdId = stdId;";
		$res_fail=mysql_query($fail);
		$fail_no = mysql_num_rows($res_fail);
					
		$PassRate = round(((($total_no - $fail_no)/$total_no)*100),2)."%";
		echo " <p align='center'>Pass Rate: <b><i>$PassRate</i></b> </p>";
		
		//create a table to display	
		echo("<font face='Times New Roman'><table width=50% align='center'><tr>
		<th class='style5'>Student Id </th>
		<th class='style5'>Student Name</th>
		<th class='style5'>Grade</th>
		<th class='style5' width=10%>Attendance(%)</th>");
		
		$result2=mysql_query($query);
		while($row=mysql_fetch_array($result2))
		{
			echo "<tr><td class='style4' align='center'>$row[r_stdId]</td>
			<td class='style4' align='center'>$row[name]</td>
			<td class='style4' align='center'>$row[grade]</td>
			<td class='style4' align='center'>$row[att_percnt]</td>
			</tr>";
		}
		echo("</table></font>");
	}
	
	function checkResultByStudent()
	{
		$stdId = $_SESSION['users']['regno'];
		$type = $_POST['type'];
		$level = $_POST['level'];
		
		//get exam results according to subject type & level
		if($type == "ALL" && $level == "ALL")
		{
			$query = "SELECT r_subjId, subjName, grade, att_percnt,lectEmail,name,credits
					FROM result, subject,lecturer,user
					WHERE r_subjId = subjId AND lectName = name AND lectId = id
					AND r_stdId = '$stdId' ORDER BY r_subjId;";
		}
		elseif($type != "ALL" && $level == "ALL")
		{
		
			$query = "SELECT r_subjId, subjName, grade, att_percnt,lectEmail,name,credits
					FROM result, subject,lecturer,user
					WHERE r_subjId = subjId  AND lectName = name AND lectId = id
					AND r_stdId = '$stdId' AND subjType = '$type' ORDER BY r_subjId;";
		}
		elseif($type == "ALL" && $level != "ALL")
		{
			$query = "SELECT r_subjId, subjName, grade, att_percnt,lectEmail,name,credits
					FROM result, subject,lecturer,user
					WHERE r_subjId = subjId  AND lectName = name AND lectId = id
					AND r_stdId = '$stdId' AND subLevel = '$level' ORDER BY r_subjId";
				}
		else
		{
			$query = "SELECT r_subjId, subjName, grade, att_percnt,lectEmail,name,credits
					FROM result, subject,lecturer,user
					WHERE r_subjId = subjId  AND lectName = name AND lectId = id
					AND r_stdId = '$stdId' AND subLevel = '$level' AND subjType = '$type'
					ORDER BY r_subjId;";
		}
		$result=mysql_query($query);
		
		//create a table to display
		echo "<p align='center'>Examination Results for <b><em>$type</em></b> Courses and 
		<b><em>$level</em></b> Level/Levels</p>";
		
		echo("<font face='Times New Roman'><table width=90% align='center'><tr>
		<th class='style5' width=10%>Course Id </th>
		<th class='style5'>Course</th>
		<th class='style5' width=5%>Credits</th>
		<th class='style5' width=5%>Grade</th>
		<th class='style5' width=10%>Attendance(%)</th>
		<th class='style5' width=10%>Avg. Pass Rate</th>
		<th class='style5' width=30%>Lecturer</th></tr>");
		
		while($row=mysql_fetch_array($result))
		{
			//calculate passrate
			$total = "SELECT grade FROM result WHERE r_subjId = '$row[r_subjId]';";
			$res_total=mysql_query($total);
			$total_no=mysql_num_rows($res_total);
			
			$fail="SELECT grade FROM result WHERE r_subjId = '$row[r_subjId]'
					AND (grade = 'F' OR grade = 'D'	OR grade = 'D+'	) ;";
			$res_fail=mysql_query($fail);
			$fail_no=mysql_num_rows($res_fail);
			
			$PassRate = round(((($total_no - $fail_no)/$total_no)*100),2)."%";
			echo "<tr><td class='style4' align='center'>$row[r_subjId]</td>
			<td class='style4'>$row[subjName]</td>
			<td class='style4' align='center'>$row[credits]</td>
			<td class='style4' align='center'>$row[grade]</td>
			<td class='style4' align='center'>$row[att_percnt]</td>
			<td class='style4' align='center'>$PassRate</td>
			<td class='style4'>
			<a href='mailto:$row[lectEmail]'><b>Email</b></a> - $row[name]</td></tr>";
		}
		echo("</table></font>");
	}
	
	//This function calculates statistics of results 
	function checkResultStatistics()
	{
		$subjid2 = $_POST['subjid2'];
				
		//get some results statistics
		if($subjid2 != "SELECT")
		{
			$query = "SELECT distinct year,r_subjId,subjName
			FROM student,result, subject WHERE r_subjId = subjId 
			AND r_subjId = '$subjid2' AND r_stdId = stdId ORDER BY year;";
		}
		
		$result1=mysql_query($query); // to get subject Name
		$getinfo=mysql_fetch_array($result1);
		
		//display statistics in a table
		echo "<p align='center'>Statistics for &nbsp; 
		<b><em>$subjid2 - $getinfo[subjName]</em>
		</b> Course </p>";
		
		echo("<font face='Times New Roman'><table align='center'><tr>
		<th class='style5' width=10%>Batch</th>
		<th class='style5' width=10%>Pass Rate</th>
		<th class='style5' width=5%># A+</th>
		<th class='style5' width=5%># A
		<th class='style5' width=5%># A-
		<th class='style5' width=5%># B+
		<th class='style5' width=5%># B
		<th class='style5' width=5%># B-
		<th class='style5' width=5%># C+
		<th class='style5' width=5%># C
		<th class='style5' width=5%># Fail
		</th>");
		
		$result2=mysql_query($query);
		while($row=mysql_fetch_array($result2))
		{
			//calculate passrate
			$total = "SELECT grade,year FROM result,student 
				WHERE r_subjId = '$subjid2' AND year='$row[year]'
				 AND r_stdId = stdId;";
			$res_total=mysql_query($total);
			$total_no=mysql_num_rows($res_total);
				
			$fail="SELECT grade,year FROM result,student WHERE r_subjId = '$subjid2'
						AND (grade = 'F' OR grade = 'D'	OR grade = 'D+'	) 
						AND year='$row[year]' AND r_stdId = stdId;";
			$res_fail=mysql_query($fail);
			$fail_no = mysql_num_rows($res_fail);
						
			$PassRate = round(((($total_no - $fail_no)/$total_no)*100),2)."%";
			
			// get counts of grades
			$countgrade = "SELECT grade FROM result,student WHERE r_subjId = '$subjid2' 
						AND year='$row[year]' AND r_stdId = stdId";
			$countgrade_res=mysql_query($countgrade);
			
			$Aplus=0; $A=0; $Amin=0; $Bplus=0; $B=0; $Bmin=0; $Cplus=0; $C=0; $F=0;
			while($rowcount = mysql_fetch_array($countgrade_res))
			{
				if($rowcount['grade'] == 'A+')
				{
					$Aplus = $Aplus +1;
				}
				elseif($rowcount['grade'] == 'A')
				{
					$A = $A +1;
				}
				elseif($rowcount['grade'] == 'A-')
				{
					$Amin = $Amin +1;
				}
				elseif($rowcount['grade'] == 'B+')
				{
					$Bplus = $Bplus +1;
				}
				elseif($rowcount['grade'] == 'B')
				{
					$B = $B +1;
				}
				elseif($rowcount['grade'] == 'B-')
				{
					$Bmin = $Bmin +1;
				}
				elseif($rowcount['grade'] == 'C+')
				{
					$Cplus = $Cplus +1;
				}
				elseif($rowcount['grade'] == 'C')
				{
					$C = $C +1;
				}
				else
				{
					$F = $F +1;
				}
			}
			
			echo "<tr><td class='style4' align='center'>$row[year]</td>
			<td class='style4' align='center'>$PassRate</td>
			<td class='style4' align='center'>$Aplus </td>
			<td class='style4' align='center'>$A</td>
			<td class='style4' align='center'>$Amin</td>
			<td class='style4' align='center'>$Bplus</td>
			<td class='style4' align='center'>$B</td>
			<td class='style4' align='center'>$Bmin</td>
			<td class='style4' align='center'>$Cplus</td>
			<td class='style4' align='center'>$C</td>
			<td class='style4' align='center'>$F</td>
			</tr>";
		}
		echo("</table></font>");
	}
	
	function checkSchedule()
	{
		$type = $_POST['type'];
		$level = $_POST['level'];
		
		//get exam schedule according to subject type & level
		if($type == "ALL" && $level == "ALL")
		{
			$get_details = "SELECT exam.subjId,subjName, 
						date_format(examStart, '%M %D %W %Y') AS fmt_examDate,
						date_format(examStart,'%r') AS fmt_examStart,
						date_format(examFinish, '%r') AS fmt_examFinish
						FROM exam, subject  WHERE exam.subjId = subject.subjId
						ORDER BY examStart ";
		}
		elseif($type != "ALL" && $level == "ALL")
		{
			$get_details = "SELECT exam.subjId,subjName, 
						date_format(examStart, '%M %D %W %Y') AS fmt_examDate,
						date_format(examStart,'%r') AS fmt_examStart,
						date_format(examFinish, '%r') AS fmt_examFinish
						FROM exam, subject  WHERE exam.subjId = subject.subjId
						AND subjType = '$type' ORDER BY subjId";
		}
		elseif($type == "ALL" && $level != "ALL")
		{
			$get_details = "SELECT exam.subjId,subjName,  
						date_format(examStart, '%M %D %W %Y') AS fmt_examDate,
						date_format(examStart,'%r') AS fmt_examStart,
						date_format(examFinish, '%r') AS fmt_examFinish
						FROM exam, subject  WHERE exam.subjId = subject.subjId
						AND subLevel = '$level' ORDER BY examStart";
		}
		else
		{
			$get_details = "SELECT exam.subjId,subjName,
						date_format(examStart, '%M %D %W %Y') AS fmt_examDate,
						date_format(examStart,'%r') AS fmt_examStart,
						date_format(examFinish, '%r') AS fmt_examFinish
						FROM exam, subject  WHERE exam.subjId = subject.subjId
						AND subLevel = '$level' AND subjType = '$type' 
						ORDER BY examStart";
		}
		
		$get_details_res = mysql_query($get_details);
		
		//display timetable
		echo "<p align='center'>Time Table for <b><em>$type</em></b> Courses and 
		<b><em>$level</em></b> Level/Levels</p>";
		echo "<font face='Times New Roman'><table width=80% align='center'><tr>
		<th class='style5'>Subject Id</th>
		<th class='style5'>Subject Name</th>
		<th class='style5' width=25%>Exam Date</th>
		<th class='style5' width=25% >From - To</th></tr>";
		
		while($row=mysql_fetch_array($get_details_res))
		{
			echo "<tr>
			<td align ='center' class='style4'>$row[subjId]</td>
			<td class='style4'>$row[subjName]</td>
			<td align class='style4'>$row[fmt_examDate]</td>
			<td align ='center' class='style4'>$row[fmt_examStart] - $row[fmt_examFinish]
			</td></tr>";
		}
		echo "</table></font>";		
	}
}


class Forum
{
	function addTopic()
	{
		if(isset($_POST['addtopic']))	
		{
		    if(isset($_SESSION['users']['stdName'])) // add a topic when a student logins 
		    {
		    	$std = $_SESSION['users']['stdName'];
		    	
	    		//add slashes to avoid errors when using '," etc
   				$topic = addslashes($_POST['topic_title']);
   				$post = addslashes($_POST['post_text']);
		    	$add_topic = "INSERT INTO forum_topic VALUES ('', '$topic',
		 					now(), '$std')";
		 											
				$add_post = "INSERT INTO forum_post VALUES ('', LAST_INSERT_ID(),
		 					'$post',now(), '$std',0)";
		    }
		    
		    // add a topic when a lecturer logins
		    else if(isset($_SESSION['users']['lectName'])) 
		    {
		    	$lect = $_SESSION['users']['lectName'];
		    	
		    	//add slashes to avoid errors when using ',"" etc
   				$topic = addslashes($_POST['topic_title']);
   				$post = addslashes($_POST['post_text']);
				$add_topic = "INSERT INTO forum_topic VALUES ('', '$topic',
		 					now(), '$lect')";
		 				 				   			
				$add_post = "INSERT INTO forum_post VALUES ('', LAST_INSERT_ID(),
		 					'$post',now(), '$lect',0)";
		    }
		    
		    $topic_title = $_POST['topic_title'];
		  	mysql_query($add_topic) or die('Query failed. ' .mysql_error());
		  	mysql_query($add_post) or die('Query failed. ' .mysql_error());
			echo("The<strong> ".$topic_title."</strong> topic has been created. 
			<br /><br /> Redirecting to the main page of the forum...");
			header("refresh:1; url='forum.php'");
		}
		mysql_close();
	}
	
	function displayAllTopics()
	{
		//get the topics
		$get_topics = "SELECT topic_id, topic_title,
					date_format(topic_create_time, '%b %e %Y at %r') AS
					 fmt_topic_create_time,	topic_owner 
					 FROM forum_topic ORDER BY topic_create_time DESC";
		$get_topics_res = mysql_query($get_topics) or die('Query failed '.mysql_error());
		
		if (mysql_num_rows($get_topics_res) < 1) //when there are no topics
		{
	     	echo "<p><strong><em><h2>No topics exist in the forum.</h2></em></strong></p>";
		} 
		else 
		{
			//display topics in a table
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
				<td class='style4' width=50%><img src='Images/topic.png'>
				<a href=\"showtopic.php?topic_id=$topic_id\">
		        <strong>$topic_title</strong></a><br>
		        Created on $topic_create_time by <b><em>$topic_owner</b></em></td>
		        <td class='style4' align=center>$num_posts</td>
		        <td class='style4' align=center>$num_views</td>
		        <td class='style4' width=40%>By <b><em>$post_owner</b></em> 
				on $post_create_time </td>
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
						
		// add a reply by  a student 
		if(isset($_SESSION['users']['stdName'])) 
		{
			$std = $_SESSION['users']['stdName'];
			$reply = addslashes($_POST['reply_text']);
			$add_post = "INSERT INTO forum_post VALUES ('', '$_POST[topic_id]',
	      				'$reply', now(), '$std','$num_views');";
		}
		
		// add a reply by  a lecturer 
		else if(isset($_SESSION['users']['lectName'])) 
		{
			$lect = $_SESSION['users']['lectName'];
			$reply = addslashes($_POST['reply_text']);
			$add_post = "INSERT INTO forum_post VALUES ('', '$_POST[topic_id]',
	      				'$reply', now(), '$lect','$num_views');";
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
		     $get_posts = "SELECT post_id, post_text,views, 
							date_format(post_create_time,'%b %e %Y at %r') AS
						  fmt_post_create_time, post_owner 
						  FROM forum_post WHERE topic_id = $_GET[topic_id]
						  ORDER BY post_create_time ASC";
	  
	   		 $get_posts_res = mysql_query($get_posts) or 
							die("Query failed ".mysql_error());
	
		     //show topic info in a table
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
		         // Inserts HTML line breaks before all newlines in a string (nl2br)
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
		if(mysql_num_rows($result2) == 0)
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
					 </a></b.</td>
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
			
		//file goes to a tmp place to open it and extract the content
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content); // to escape the content
		fclose($fp);
	
		//add slashes to escape the content
  		$fileName = addslashes($fileName);
		
		// add file to the database
		if(isset($_SESSION['users']['stdName'])) // by  a student 
		{
			$std = $_SESSION['users']['stdName'];
			$stdId = $_SESSION['users']['regno'];
			$query = "INSERT INTO upload (name,size,type,content, 
						uploaderId, uploader, upload_time ) 
					VALUES ('$fileName','$fileSize','$fileType','$content','$stdId',
					'$std',now())";
		}
		else if(isset($_SESSION['users']['lectName']))  // by a lecturer
		{
			$lect = $_SESSION['users']['lectName'];
			$lectId = $_SESSION['users']['regno'];
			$query = "INSERT INTO upload (name,size,type,content, 
							uploaderId, uploader ,upload_time) ".
					"VALUES ('$fileName','$fileSize','$fileType','$content','$lectId',
					'$lect',now())";
		}
		mysql_query($query) or die('Query failed '.mysql_error());
					
		echo "<br /><td>File <strong>$fileName</strong> uploaded successfully<br />
		<br />
		Redirecting...</td></table>";
		header("refresh:1; url='uploadfile.php'");
	}
}


class Login
{
	function login() 
	{
		// get input data
		$regno = $_POST['reg'];
		$pass =  sha1($_POST['pass']); 
		$select = $_POST['select'];
		
		//get details in database
		$sql = "SELECT id,name,pass,type FROM user ;";
		$result = mysql_query($sql) or die('Query failed. ' . mysql_error());

		//iterates through the array
		while($row = mysql_fetch_assoc($result))
		{
			if($_POST['select'] == 'Student') // for a student
			{ 
			
				//allow students to login if reg.no & password entered are in the database
				if( ($row['id']==ucfirst($regno) || $row['id']==$regno) && 
				$row['pass']==$pass && $row['type']=="stud")
				{
					$_SESSION['users']['regno']=$regno;
					$_SESSION['users']['stdName']=$row['name'];
					$_SESSION['users']['pass']=$row['pass'];
					header("Location:home.php");
				}
				
				//if not disply an error code
				else 
				{
					header("Location:index.php?err=1");
				}	
			}
			else
			{
				//allow lecturers to login if reg.no & password entered are in the database
				if( ($row['id']==ucfirst($regno) || $row['id']==$regno) && 
				$row['pass']==$pass && $row['type']=="lect")
				{
					$_SESSION['users']['regno']=$regno;
					$_SESSION['users']['lectName']=$row['name'];
					$_SESSION['users']['pass']=$row['pass'];
					header("Location:home.php");
				}
				
				//if not disply an error code
				else 
				{
					header("Location:index.php?err=1");
				}
			}
		}
		mysql_close(); // close connection
	}
}


class Password
{
	function changeUserPassword()
	{
		// get entered passwords
		$pass = sha1($_POST['pass']);		
		$pass1 = sha1($_POST['pass1']);
		$pass2 = sha1($_POST['pass2']);
		$id = $_SESSION['users']['regno'];

		// check whether passwords are equal and if so add them to database
 		if(($pass1==$pass2) && isset($_SESSION['users']['stdName']) && 
		 	$pass==$_SESSION['users']['pass'])
		{
			$query = "UPDATE user SET pass='$pass1' WHERE id = '$id'";
			mysql_query($query) or die("Query failed ".mysql_error());
			echo "You have changed your password successfully"	;
			header("refresh:2; url='home.php'");		
		}
		elseif($pass1==$pass2 && isset($_SESSION['users']['lectName'])&& 
				$pass==$_SESSION['users']['pass'])
		{
			$lectName = $_SESSION['users']['lectName'];
			$query = "UPDATE user SET pass='$pass1' WHERE id = '$id'";
			mysql_query($query) or die("Query failed ".mysql_error());
			echo "You have changed your password successfully"	;
			header("refresh:2; url='home.php'");
		}
		
		//display errors
		elseif($pass!=$_SESSION['users']['pass'])
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


class SpecialApp
{
	//This function submits the special application to relevant Department Head
	function sendApp()
	{
		$stdid = $_SESSION['users']['regno'];
		
		//check whether student already in 3rd or 4th year
		$validate1 = "SELECT r_subjId FROM result,subject,student WHERE r_stdId='$stdid' 
					AND subLevel = '300' AND r_subjId=subjId ;";
		$validate1_res = mysql_query($validate1);
		
		//check whether student is still in 1st year
		$validate2 = "SELECT r_subjId FROM result,subject,student WHERE r_stdId='$stdid' 
					AND subLevel = '200' AND r_subjId=subjId ;";
		$validate2_res = mysql_query($validate2);
		
		if( mysql_num_rows($validate1_res) < 1 && mysql_num_rows($validate2_res) > 0 )
		{
	  		//get details
			$sql = "SELECT r_stdId, name, subjId, subjName, grade 
					FROM result, subject, user
					WHERE subjId = r_subjId
					AND id = r_stdId AND (subLevel = '100' OR subLevel = '200') ";
				
			$result = mysql_query($sql) or die('Query failed. ' . mysql_error());
			$message1="";
			
			while($row = mysql_fetch_assoc($result))
			{
				// get the subject names and grades of the student
				if($row['r_stdId']==ucfirst($stdid) || $row['r_stdId']==$stdid)
				{
					//input subjects and grades to a variable
					$sub=$row['subjName'];
					$subid=$row['subjId'];
					$grade=$row['grade'];
					
					$message1=$message1."\n".$subid."  -  ".$sub."  -  ".$grade;			
				}
			}
			
			//calculate the overall gpa
			$sql2 = "SELECT gp,credits FROM result, assign, subject	WHERE grade = as_grade 
					AND r_stdId = '$stdid' AND r_subjId = subjId
					 AND (subLevel = '100' OR subLevel = '200')";
			$result2 = mysql_query($sql2) or die('Query failed. ' . mysql_error());
			$totalgp = 0;
			$totalcredits =0;
			while($row2 = mysql_fetch_assoc($result2))
			{
				$gp = $row2['gp'];
				$credits =	$row2['credits'];
				$totalgp = $totalgp + $gp*$credits;
				$totalcredits = $totalcredits + $credits;
				
			}
			$gpa = round($totalgp/$totalcredits,3);
			$gpa = number_format($gpa,3);
			
	 		// sending the special application through email
	    	if(isset($_POST['btnSubmit']))
	    	{
	    		//calculate special subject gpa
				$sql3 = "SELECT gp,credits	FROM result, assign,subject	
						WHERE grade = as_grade
						 AND r_subjId = subjId AND subjType = '$_POST[spec_sub]' 
						 AND r_stdId = '$stdid' AND (subLevel = '100' OR subLevel = '200')";
				$result3 = mysql_query($sql3) or die('Query failed. ' . mysql_error());
				
				$totalgp2= 0;
				$totalcredits2=0;
					
				while($row3 = mysql_fetch_assoc($result3))
				{
					$gp = $row3['gp'];
					$credits =	$row3['credits'];
					$totalgp2 = $totalgp2 + $gp*$credits;
					$totalcredits2 = $totalcredits2 + $credits;
				}
				
				//check for credit requirements except for Maths
				if($totalcredits2 < 16 && $_POST['spec_sub'] != 'Mathematics')
				{
					echo "<br/><font color='red'><b>You haven't got enough special subject
					 credits (16 minimum)</b></font>";
				}
				
				//check for Maths credit requirement
				elseif($totalcredits2 < 32 && $_POST['spec_sub'] == 'Mathematics')
				{
					echo "<br/><font color='red'><b>You haven't got enough special subject
					 credits (32 minimum for Mathematics)</b></font>";
				}
				
				else
				{
					$gpasubj = round($totalgp2/$totalcredits2,3);
					$gpasubj = number_format($gpasubj,3);
					
					//allow to apply only if gpa of special subject is atleast 2.5
					if($gpasubj >= 2.5)
					{
						//attach all info to the mail
						$stdname = $_SESSION['users']['stdName'];
						date_default_timezone_set('Asia/Colombo');
						$todayis = date("l dS \of F Y h:i:s A");
						$subjct = $_POST['spec_sub'];
						$addr = $_POST['addr'];
						$tel = $_POST['tel'];
						$sch = $_POST['sch'];
						$year = $_POST['year'];
						$zscore = $_POST['zscore'];
						$subj1 = $_POST['subj1']; $grade1 = $_POST['grade1'];
						$subj2 = $_POST['subj2']; $grade2 = $_POST['grade2'];
						$subj3 = $_POST['subj3']; $grade3 = $_POST['grade3'];
						$subj4 = $_POST['subj4']; $grade4 = $_POST['grade4'];
						
						//create the message
						$message = "$stdid - $stdname
						Special Subject: $subjct\n 
						Address: $addr
						Telephone No: $tel\n
						School: $sch 
						A/Level passing year: $year      Zscore: $zscore\n
						$subj1 - $grade1
						$subj2 - $grade2
						$subj3 - $grade3 
						$subj4 - $grade4
						$message1\n
						Overall GPA = $gpa
						$subjct GPA = $gpasubj";
						
						$from = "From: $stdname\n ";
						
						//mail sccording to selected special subject
						switch($_POST['spec_sub'])
						{
							case 'Physics': $email="physics@pdn.ac.lk";
							break;
							case 'Chemistry': $email="headchem@pdn.ac.lk";
							break;
							case 'Mathematics': $email="wbd@pdn.ac.lk";
							break;
							case 'Geology': $email="geology@pdn.ac.lk";
							break;
							case 'Botany': $email="nkba@pdn.ac.lk";
							break;
							case 'Zoology': $email="hdzoology@pdn.ac.lk";
							break;
							case 'Computer Science': $email="salukak@pdn.ac.lk";
							break;
							case 'Molecular Biology': $email="psam@pdn.ac.lk";
							break;
							case 'Biology': $email="hdzoology@pdn.ac.lk";
							break;
						}
						
						//send the mail
						mail($email,"Special Application",$message,$from);
						echo "<p align='center'>YOU HAVE SUCCESSFULLY SUBMITTED 
						YOUR APPLICATION </p>
						<p align='center'>Date: $todayis </p> <br />";
						header("refresh:3; url='home.php'");
					}
					
					else
					{
						echo "<br/><font color='red'><b>Your Special Subject GPA is not
						 sufficient to Apply for Special</b></font>";
					}
				}
			}
		}
		
		else
		{
			echo "<br/><font color='red'><b>You are not eligible to apply for special.
			</b></font> ";
		}
		mysql_close();
	}
	
}
?>