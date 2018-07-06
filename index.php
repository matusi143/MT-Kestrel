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
 
sec_session_start();
 
if (login_check($connect) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
        <title>Secure Login: Log In</title>
        <link rel="stylesheet" href="css/style.css">
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/hashforms.js"></script> 
		<div style="text-align:center;">
		<svg id="logo" height="300" width="300" 
			xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" >
			<image x="0" y="0" height="300" width="300"  xlink:href="square_logo.svg" />
		</svg>
		</div>
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
		<br>
        <form action="mt_api/process_login.php" method="post" name="login_form">                      
            Email: <input type="text" name="email" id="email"/>
            Password: <input type="password" name="password" id="password"/>
            <input type="button" 
                   value="Login" 
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>
 
<?php
    if (login_check($connect) == true) {
        echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
        echo '<p>Do you want to change user? <a href="includes/logout.php">Log out</a>.</p>';
    } else {
        echo '<p>Currently logged ' . $logged . '.</p>';
        echo "<p>If you don't have a login, please <a href='account_create.php'>register</a></p>";
    }
?>      
<?php include("webparts/footer.php"); ?>