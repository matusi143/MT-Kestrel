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
/**
 * Database configuration
 */
define('DB_USERNAME', 'web_frontend');
define('DB_PASSWORD', 'Password_1');
define('DB_HOST', 'localhost');
define('DB_NAME', 'kestrel_20170423');

/**
 * Security and roles
 */
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!

/**
 * Localization US Eastern is -5
 */
define('UTC_OFFSET', '-5 hours');

/**
 * Logging and Debugging
 */
 define("debug_mode", 1);
 
/**
 * URL definitions
 */
define('ADD_ITEM_URL', 'protected_add_item.php');
define('RESTOCK_URL', 'protected_restock.php');
define('INVENTORY_URL', 'protected_inventory.php');
define('LOOKUP_URL', 'protected_lookup.php');
define('REGISTER_URL', 'protected_register.php');
define('REPORTS_URL', 'protected_reports.php');
 
/**
 * Table definitions
 */
define('PRODUCT_TABLE', '`UPC`,
                `NAME`,
                `DESC`,
                `PRICE`,
				`LOCATION`,
				`QTY`,
				`ACTIVE`,
				`DEPT`,
				`TAXABLE`');
				
define('TXN_TABLE', '`UPC`,
				`TYPE`,
                `COST`,
                `QTY`,
                `TXN_TIME`,
				`CLERK`,
				`LOCATION`,
				`WHSLER`,
				`PRICE`,
				`TAXABLE`,
				`DEPT`');
				
define('DEPTARTMENT_TABLE', '`ID`,
				`DEPT_LOCATION`,
                `DEPT_NUM`,
                `DEPT_NAME`,
                `TAX1`,
				`TAX2`');
?>
