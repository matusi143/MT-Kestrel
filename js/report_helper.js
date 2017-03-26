/*
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
*/

function total_current_inventory() {
	var posting = $.post("mt_api/basic_reports/inventory_report.php", {});
	posting.done(function( data )
    {
		var dept_names = new Array();
		var dept_values = new Array();
		var record_array = data.split(" => ");
		dept_values.push(parseFloat(record_array[4].split(" ")[0]));
		dept_names.push(record_array[3].split(" ")[0]);
		dept_values.push(parseFloat(record_array[6].split(" ")[0]));
		dept_names.push(record_array[5].split(" ")[0]);
		dept_values.push(parseFloat(record_array[8].split(" ")[0]));
		dept_names.push(record_array[7].split(" ")[0]);
		dept_values.push(parseFloat(record_array[10].split(" ")[0]));
		dept_names.push(record_array[9].split(" ")[0]);
		dept_values.push(parseFloat(record_array[12].split(" ")[0]));
		dept_names.push(record_array[11].split(" ")[0]);
		dept_values.push(parseFloat(record_array[14].split(" ")[0]));
		dept_names.push(record_array[13].split(" ")[0]);
		dept_values.push(parseFloat(record_array[16].split(" ")[0]));
		dept_names.push(record_array[15].split(" ")[0]);
	
	var ctx = document.getElementById("myChart");
	var myChart = new Chart(ctx, {
		type: 'doughnut',
		options: {
        title: {
            display: true,
            text: 'Current Wholesale Inventory'
        }
		},
		data: {
			labels: dept_names,
			datasets: [{
			backgroundColor: [
				"#2ecc71",
				"#3498db",
				"#95a5a6",
				"#9b59b6",
				"#f1c40f",
				"#e74c3c",
				"#34495e"
			],
			data: dept_values
			}]
	}
	});
	});
}
