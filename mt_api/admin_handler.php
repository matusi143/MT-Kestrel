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
	//Important includes
	include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/mt_api/config.php");
	date_default_timezone_set('UTC');
	
	// Connect to our DB
	$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
	if ($mysqli->connect_errno) {
		echo "Error: Failed to make a MySQL connection, here is why: \n";
		echo "Errno: " . $mysqli->connect_errno . "\n";
		echo "Error: " . $mysqli->connect_error . "\n";
		
		// You might want to show them something nice, but we will simply exit
		exit;
	}
	
	// Run query to get the field that is going to be updated.
	//$sql = "SELECT * FROM `departments` WHERE `LOCATION`=$LOCATION";
	$sql = "SELECT * FROM `departments`";
	if (!$result = $mysqli->query($sql)) {
    // Oh no! The query failed. 
    echo "Sorry, the website is experiencing problems.";

    // Again, do not do this on a public site, but we'll show you how
    // to get the error information
    echo "Error: Our query failed to execute and here is why: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
	}

echo "<table border='1' cellpadding='10'>";
echo "<tr> <th>Department Name</th> <th>Tax Rate 1</th> <th>Tax Rate 2</th> <th></th> <th></th></tr>";

// loop through results of database query, displaying them in the table
while($row = $result->fetch_assoc()) {
	echo "<tr>";
	echo '<td>' . $row['dept_name'] . '</td>';
	echo '<td>' . $row['tax1'] . '</td>';
	echo '<td>' . $row['tax2'] . '</td>';
	echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>';
	echo '<td><a href="delete.php?id=' . $row['id'] . '">Delete</a></td>';
	echo "</tr>";
}

echo "</table>";
?>
<p><a href="new.php">Add a new department </a></p>


