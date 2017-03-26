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

function price35(f) {
  if(f.price_helper1.checked == true) {
    f.PRICE.value = parseFloat(f.COST.value * 1.35).toFixed(2);
  }
  else {
	f.PRICE.value = 0.00;
  }
}
function pricen30(f) {
  if(f.price_helper2.checked == true) {
    f.COST.value = parseFloat(f.PRICE.value / 1.30).toFixed(2);
  }
  else {
	  f.COST.value = 0.00;
  }
}