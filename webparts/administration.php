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
<h2>What would you like to administer?</h2>

<ul>
		<li><a href="javascript:void(0)" onclick="departments()">Departments & Taxes</a></li>
		<li><a href="u">User Accounts</a></li>
		<li><a href="l">Locations</a></li>
</ul>
<div id="top_form">
<!-- Dynamic Form Div -->
</div>
<div id="body_div">
<!-- Dynamic Form Div -->
</div>
<script type="text/javascript">
function departments() {
        var div = document.getElementById('top_form');
		div.innerHTML = div.innerHTML + '<form id="dept_locate_form" name="dept_locate_form" method="POST" action="mt_api/admin_handlers.php">Location:</td><td><select id="LOCATION" name="LOCATION" required><option value="1">1 - 1593 Central Ave</option><option value="2">2 - Store 2 TDB</option></select></td><input type="submit"  value="Submit"></form>';
    }

function dept_locate() {
      $('dept_locate_form').on('submit', function (e) {
        e.preventDefault();
         $.ajax({
          type: 'post',
		  dataType: 'text',
          url: 'mt_api/admin_handler.php',
          data: $('dept_locate_form').serialize(),
          success: function(data) 
		  {
            var div = document.getElementById('body_div');
			div.innerHTML = div.innerHTML + data;
		  }
         });
      });
  };
</script>



