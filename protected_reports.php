<?php
/*
    Copyright 2016 - 2018 Musto Technologies LLC http://www.mustotechnologies.com
	
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
*/
include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/mt_api/config.php");
include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/mt_api/security_fucntions.php");

sec_session_start();

// $connect to our DB
$connect = mysqli_connect($db_host_name, $db_user_name, $db_password, $database);

if (mysqli_connect_errno()) {
    die('<p>Failed to connect to MySQL, send this message to support: '.mysqli_connect_error().'</p>');
} 

if(login_check($connect) == true) {
	include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/webparts/header.php");
    echo '<title>Reports - MT Kestrel</title>';
	echo '</head>';
	echo '<body>';
	include("webparts/navigation.php");
	include("webparts/reports_body.php");
} else {
	include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/webparts/header.php");
	echo '<h2>Oops!</h2><br>';
	echo "<span class=\"error\">You are not authorized to access this page.</span> Please <a href=\"index.php\">login</a>.";
}
include("webparts/footer.php");
?>