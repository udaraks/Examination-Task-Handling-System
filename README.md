This file describes how to install and use the software.


First of all check whether Apache.MySQL and PHP are already installed. 
If not install them first. Then follow the procedure given below.


======================
Creating the database
======================

To load the contents of the "System\Database\university.sql" file into MySQL, use the following procedure:

1. Goto Command Prompt
2. Change directory to where the university.sql file is located
3. Then issue this command:
	mysql -u username –p password
(where username and password are your root username and password
in MYSQL)
4. Load the contents of university.sql using following command
	mysql> SOURCE university.sql;
5. You will see quite a bit of output as mysql reads queries from the
university.sql file and executes them.

Now you have successfully created the database


====================
Copying System files
====================

All the system files are inside “System\ETHS”. This folder should be copied to the document directory 
of the Apache server. i.e.‘htdocs’ folder in Apache installation path.


=====================
Other Configurations:
=====================


Goto "ETHS\con_mysql.php" – Database Connection
-----------------------------------------------

In this php file, mysql_connect('localhost','root','') is used to connect to the
mysql server where 'localhost' is the server, 'root' is the username and ' ' is the
password. Change them according to your settings.


Goto "php.ini" in PHP folder
--------------------------
• post_max_size = 20M
• upload_max_filesize = 20M

Goto "my.ini" in MySQL folder
---------------------------
• key_buffer = 16M
• max_allowed_packet = 16M (appears in two places)



Now you are ready to use the system. You can test the system by running on localhost.

Create domains relevant to administrator,lecturer or student logins on the intranet. 
Then login and use the system.



--------------------
© Udara K. Senanayake
--------------------


