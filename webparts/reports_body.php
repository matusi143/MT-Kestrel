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
<script src="js/Chart.bundle.min.js"></script>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="javascript:void(0)" onclick="total_current_inventory()">Inventory</a>
  <a href="#">Daily Sales</a>
  <a href="#">Weekly Sales</a>
  <a href="#">Monthly Sales</a>
</div>

<div id="main">
<div id="chart_area">
<div class="container">
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Reports</span>
  <div>
    <canvas id="myChart" width="100" height="100"></canvas>
  </div>
</div>
</div>
</div>

<script src="js/jquery-3.3.1.min.js"></script>  
<script src="js/report_helper.js"></script>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
</script>