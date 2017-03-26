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
	<ul>
		<li><a href="protected_register.php">Cash Register</a></li>
		<li><a href="protected_add_item.php">Add Item</a></li>
		<li><a href="protected_restock.php">Restock</a></li>
		<li><a href="protected_lookup.php">Item Lookup</a></li>
		<li><a href="protected_reports.php">Reports</a></li>
		<li><a href="protected_inventory.php">Inventory</a></li>
		<div style="float:right;"><li><a href="protected_admin.php">Admin</a></li></div>
		<div style="float:right;"><li><a href="mt_api/logout.php"> <?php echo 'Logout ' . $_SESSION['username']; ?></a></li></div>
	</ul>