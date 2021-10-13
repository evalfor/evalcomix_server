function display(){
	var div = document.getElementById('teacherdiv');
	var select = document.getElementById('role').value;
	if(select == '1') {
		div.style.display = "block";
	}
	else {
		div.style.display = "none";
	}
} 
 
