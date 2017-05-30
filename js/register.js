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
var qty = 1;
var dpt = 0;
var clk = 0;
var prc = 0;
var dsc = 0; 

document.getElementById('entry').onsubmit = enter;

function enter() {
  var entry = document.getElementById('newEntry').value;
  var keypad_command = document.getElementById('command_queue').value;
  
  // if entry is blank (i.e. there is no UPC value to look up need to use system UPC 99999999999999 and rely on manual input logic)
  if (entry){
	  var posting = $.post( "mt_api/upc_lookup.php", {UPC: entry, LOCATION: '1'});
  }
  else{
	  var entry = 99999999999999;
	  var posting = $.post( "mt_api/upc_lookup.php", {UPC: entry, LOCATION: '1'});
  }
    
  posting.done(function( data )
         {
			 // Read in and process any keypad commands (QTY# DPT# CLK# PRC$ DSC%)
			 var keypad_array = keypad_command.split(" ");
			 var arrayLength = keypad_array.length;
			 for (var i = 0; i < arrayLength; i++)
			 {
				//Check for QTY (quantity) values
				var patt = new RegExp("QTY#");
				if (patt.test(keypad_array[i]))
				{
					var qty_array = keypad_array[i].split("#");
					qty = qty_array[1];
				}
				
				//Check for DSC% (discount) values
				var patt = new RegExp("DSC%");
				if (patt.test(keypad_array[i]))
				{
					var dsc_array = keypad_array[i].split("%");
					dsc = dsc_array[1];
				}
				
				//Check for DPT# (department) values
				var patt = new RegExp("DPT#");
				if (patt.test(keypad_array[i]))
				{
					var dpt_array = keypad_array[i].split("#");
					dpt = dpt_array[1];
				}
				
				//Check for CLK# (clerk) values
				var patt = new RegExp("CLK#");
				if (patt.test(keypad_array[i]))
				{
					var clk_array = keypad_array[i].split("#");
					clk = clk_array[1];
				}
				
				//Check for PRC$ (price) values
				var patt = new RegExp("PRC$");
				if (patt.test(keypad_array[i]))
				{
					var prc_array = keypad_array[i].split("$");
					prc = prc_array[1];
				}
			 }

			 // Split UPC record into appropriate fields
			 var record_array = data.split(" => ");
			 var name = record_array[2].split("  ")[0];
			 var desc = record_array[3].split("  ")[0];
			 var price = parseFloat(record_array[4].split(" ")[0]);
			 var dept_num = record_array[8].split(" ")[0];
			 
			 // Look up department number to get tax information
			 var posting2 = $.post( "mt_api/dept_lookup.php", {DEPT_NUM: dept_num, LOCATION: '1'});
			 posting2.done(function( data )
				{
					var record_array2 = data.split(" => ");
					var tax_rate1 = parseFloat(record_array2[5].split(" ")[0]);
					var tax_rate2 = parseFloat(record_array2[6].split(" ")[0]);
					var dept_name = record_array2[4].split("  ")[0];
					currency = currencyFormat(price);
					tax += price * tax_rate1;
					subtotal += price * qty;
					total += price * (1 + tax_rate1) * qty;
					document.getElementById('entries').innerHTML += '<tr><th>' + name + '  ' + qty + '@</th><th>' + currency + '</th></tr><tr><th>' + desc +  '</th><th>' + dept_name + '</th></tr>';
					document.getElementById('subtotal').innerHTML = currencyFormat(subtotal);
					document.getElementById('total').innerHTML = currencyFormat(total);
					document.getElementById('tax').innerHTML = currencyFormat(tax);
					document.getElementById('newEntry').value = '';
					
					// prepare transaction data for local storage
					var current_item = [entry + "@@@" + qty + "@@@" + name + "@@@" + price + "@@@" + desc + "@@@" + dept_num + "@@@" + dept_name];
										
					// record information to session storage register
					if (sessionStorage.register_session) {
						SaveDataToSessionStorage(current_item);
					} else {
						current_item.push(JSON.parse(sessionStorage.getItem('register_session')));
						sessionStorage.setItem('register_session', JSON.stringify(current_item));
					}
					
					// debugger
					//if (debug_mode >= 1){
						document.getElementById("product_qty").innerHTML = "Data: " + JSON.parse(sessionStorage.getItem('register_session')) + " -- end.";
					//}
					
					
					// reset possible command queue inputs
					qty = 1;
					dpt = 0;
					clk = 0;
					prc = 0;
					dsc = 0; 
					document.getElementById('command_queue').value = '';
				});
		 });
		 document.getElementById('newEntry').value = 'UPC NOT IN SYSTEM!';
  return false;
}

// make sure register body calls are correct with payment method
function checkout(el) {
	var keypad_command = document.getElementById('command_queue').value;
	var payment_method = $(el).attr('id');
	
	// confirm keypad_command is only a dollar value and does not contain other values if so, clear input and alert.
	if(isNaN(keypad_command)){
		document.getElementById('command_queue').value = '';
		alert(keypad_command + " is not a number");
	}
	else{
		document.getElementById('entries').innerHTML += '<tr><th>' + payment_method + '</th><th>-' + currencyFormat(keypad_command) + '</th></tr>';
		var payment_amount = keypad_command * -1.0;
		total += payment_amount;
		document.getElementById('total').innerHTML = currencyFormat(total);
		
		if (total >= 0){
			document.getElementById('total').innerHTML = currencyFormat(total);
		}
		else if (total <= 0){
			// print change due
			document.getElementById('entries').innerHTML += '<tr><th> Change Paid: </th><th>-' + currencyFormat(total) + '</th></tr>';
			var total = 0;
			document.getElementById('total').innerHTML = currencyFormat(total);
			// submit data to register table and reduce inventory product and trx tables
			// print receipt
		}
		else {
			// do nothing
		}
	}	
}

function currencyFormat(number) {
  var currency = parseFloat(number);
  currency = currency.toFixed(2);
  currency = '$' + currency;
  return currency;
}

function SaveDataToSessionStorage(new_data)
{
    var working_data = [];
    working_data = JSON.parse(sessionStorage.getItem('register_session'));
    working_data.push(new_data);
    sessionStorage.setItem('register_session', JSON.stringify(working_data));
}