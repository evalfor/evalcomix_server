						function getHTTPObject(){
							if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
							else if (window.XMLHttpRequest) return new XMLHttpRequest();
							else {
								alert("Your browser does not support AJAX.");
								return null;
							}
						}
	
						function setOutput(){
							if(httpObject.readyState == 4){
								document.body.innerHTML = httpObject.responseText;
							}
						}
	
						// Implement business logic
	
						function doWork(url, valores){
							httpObject = getHTTPObject();
							if (httpObject != null) {
								httpObject.open("POST", url, true);
								httpObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
								httpObject.send(valores);
								httpObject.onreadystatechange = setOutput;
							}
						}	
						var httpObject = null;
					