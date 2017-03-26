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

var total = 0;
var subtotal = 0;
var tax = 0;
var tax_rate1 = 0.0;
var tax_rate2 = 0.0;

document.getElementById('entry').onsubmit = enter;

function enter() {
  var entry = document.getElementById('newEntry').value;
  
  var posting = $.post( "mt_api/upc_lookup.php", {UPC: entry, LOCATION: '1'});
  posting.done(function( data )
         {
			 var record_array = data.split(" => ");
			 var name = record_array[2].split("  ")[0];
			 var desc = record_array[3].split("  ")[0];
			 var price = parseFloat(record_array[4].split(" ")[0]);
			 var dept_num = record_array[8].split(" ")[0];
			 var posting2 = $.post( "mt_api/dept_lookup.php", {DEPT_NUM: dept_num, LOCATION: '1'});
			 posting2.done(function( data )
				{
					var record_array2 = data.split(" => ");
					var tax_rate1 = parseFloat(record_array2[5].split(" ")[0]);
					var tax_rate2 = parseFloat(record_array2[6].split(" ")[0]);
					var dept_name = record_array2[4].split("  ")[0];
					currency = currencyFormat(price);
					tax += price * tax_rate1;
					subtotal += price;
					total += price * (1 + tax_rate1);
					document.getElementById('entries').innerHTML += '<tr><th>' + name + '</th><th>' + currency + '</th></tr><tr><th>' + desc +  '</th><th>' + dept_name + '</th></tr>';
					document.getElementById('subtotal').innerHTML = currencyFormat(subtotal);
					document.getElementById('total').innerHTML = currencyFormat(total);
					document.getElementById('tax').innerHTML = currencyFormat(tax);
					document.getElementById('newEntry').value = '';
				});
		 });
  return false;
}

function currencyFormat(number) {
  var currency = parseFloat(number);
  currency = currency.toFixed(2);
  currency = '$' + currency;
  return currency;
}