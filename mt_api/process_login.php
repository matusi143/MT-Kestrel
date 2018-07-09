<!-- 
    Copyright 2016, 2017 Musto Technologies LLC http://www.mustotechnologies.com
	
	-- GPLv3 License --
	This file is part of MT Kestrel.

    MT Kestrel is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    MT Kestrel is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with MT Kestrel as the COPYING.txt file.  If not, 
	see <http://www.gnu.org/licenses/>.
-->
<?php
include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/mt_api/config.php");
include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/mt_api/security_fucntions.php");

// $connect to our DB
$connect = mysqli_connect($db_host_name, $db_user_name, $db_password, $database);

if (mysqli_connect_errno()) {
    die('<p>Failed to connect to MySQL, send this message to support: '.mysqli_connect_error().'</p>');
} 

sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
 
    if (login($email, $password, $connect) == true) {
        // Login success
		header('Location: ../protected_register.php', true, 301);
    } else {
        // Login failed 
        echo "<!DOCTYPE html>";
		echo "<html>";
		echo "<head>";
		echo "<meta charset=\"UTF-8\">";
		echo "<title>Login Failure</title>";
		echo "</head>";
		echo "<body>";
		echo "<span class=\"error\">Your credentials are incorrect.</span> Please <a href=\"../index.php\">login</a>.";
		echo "</body>";
		echo "</html>";
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}

?>
	