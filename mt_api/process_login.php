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
include("$_SERVER[DOCUMENT_ROOT]/MT_Kestrel/mt_api/config.php");
include("$_SERVER[DOCUMENT_ROOT]/MT_Kestrel/mt_api/security_fucntions.php");

// Connect to our DB
	$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
 
    if (login($email, $password, $mysqli) == true) {
        // Login success
		header('Location: ../protected_register.php');
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
	