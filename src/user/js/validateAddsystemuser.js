function validateAddsystemuser () {
	usuario=document.getElementById('username').value;
	var patron = /^[A-Za-z0-9ü][A-Za-z0-9_\-.@]{2,90}$/
	
	if (usuario) {
		if(usuario.match(patron)) {
			document.getElementById('error-username').style.display = 'none';
			return true;
		}
		else {
			document.getElementById('error-username').style.display = 'block';
			return false;
		}
	}
	
	return true;
}

function validate_unmask(name,um) {
	password=document.getElementById(name);
	unmask1 = document.getElementById(um);
	if (document.getElementById(um).checked) {
		password.type = 'text';
	}
	else {
		password.type = 'password';
	}
}