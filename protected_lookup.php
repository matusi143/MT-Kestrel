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
include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/webparts/header.php");

sec_session_start();

// Connect to our DB
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(login_check($mysqli) == true) {
    echo '<title>Item Lookup - MT Kestrel</title>';
	echo '</head>';
	echo '<body>';
	include("webparts/navigation.php");
	
	//Insert secure content here...
	include("webparts/lookup.php");
} else {
	echo '<h2>Oops!</h2><br>';
	echo "<span class=\"error\">You are not authorized to access this page.</span> Please <a href=\"index.php\">login</a>.";
}
include("webparts/footer.php");
?>