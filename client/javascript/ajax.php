<?php
	session_start();
					include_once('../tool.php');
					$toolObj = $_SESSION['tool'];
					$tool = unserialize($toolObj);
				?>		
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
	
						function doWork(tag, url, valores){
							httpObject = getHTTPObject();
							if (httpObject != null) {
								httpObject.open("POST", url, true);
								httpObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
								httpObject.send(valores);
								httpObject.onreadystatechange = function(){
									if(httpObject.readyState == 4){
										document.getElementById(tag).innerHTML = httpObject.responseText;
									}
								}
							}
						}	
						var httpObject = null;
					
						function sendPost(tag, vars){
							var cadena = vars + "&titulo="+document.getElementById("titulo").value;
							var tam = document.getElementById("mainform").elements.length;
							for (i=1; i < tam; i++) {						
								if(document.getElementById("mainform").elements[i].id != '' && document.getElementById("mainform").elements[i].id != 'addDim' && document.getElementById("mainform").elements[i].id != 'addSubDim' && document.getElementById("mainform").elements[i].id != 'addAtr')
								cadena += "&" + document.getElementById("mainform").elements[i].id + "=" + document.getElementById("mainform").elements[i].value;
							}
							//alert(cadena);
						/*
							var cadena = null;
							var titulo = document.getElementById("titulo").value;
							var numdim = document.getElementById("numdimensiones").value;
							var valtotal = document.getElementById("valtotal").checked;
							var numvalores = document.getElementById("numvalores").value;
							cadena = vars + "&titulo=" + titulo + "&numdim=" + numdim + "&valtotal=" + valtotal + "&numvalores=" + numvalores;
			*/
			<?php
		/*	
			$dimension = $tool->get_dimension();
			foreach($dimension as $dim => $value){
				echo '
							if(document.getElementById("dimension'.$dim.'")){
								var dimension'.$dim.' = document.getElementById("dimension'.$dim.'").value;
								var numsubdim'.$dim.' = document.getElementById("numsubdimensiones'.$dim.'").value;
								var numvalores'.$dim.' = document.getElementById("numvalores'.$dim.'").value;
								cadena += "&dimension'.$dim.'=" + dimension'.$dim.' + "&numsubdim'.$dim.'=" + numsubdim'.$dim.' + "&numvalores'.$dim.'=" + numvalores'.$dim.';
							}
				';
				$subdimensions = $tool->get_subdimension();
				foreach($subdimensions[$dim] as $subdim => $elemsubdim){		
					echo '
							if(document.getElementById("subdimension'.$dim.'_'.$subdim.'") != null){
								var subdimension'.$dim.'_'.$subdim.' = document.getElementById("subdimension'.$dim.'_'.$subdim.'").value;
								var numatributos'.$dim.'_'.$subdim.' = document.getElementById("numatributos'.$dim.'_'.$subdim.'").value;
								cadena += "&subdimension'.$dim.'_'.$subdim.'=" + subdimension'.$dim.'_'.$subdim.' + "&numatr'.$dim.'_'.$subdim.'=" + numatributos'.$dim.'_'.$subdim.';
							}
					';
					$atributos = $tool->get_atributo();
					foreach($atributos[$dim][$subdim] as $atrib => $elematrib){
						echo '
							if(document.getElementById("atributo'.$dim.'_'.$subdim.'_'.$atrib.'") != null){
								var atributo'.$dim.'_'.$subdim.'_'.$atrib.' = document.getElementById("atributo'.$dim.'_'.$subdim.'_'.$atrib.'").value;
								cadena += "&atributo'.$dim.'_'.$subdim.'_'.$atrib.'=" + atributo'.$dim.'_'.$subdim.'_'.$atrib.';
							}
						';
					}
				}
				$valores = $tool->get_valores();
				foreach($valores[$dim] as $grado => $elemvalue){
					echo '
							var valor'.$grado.' = document.getElementById("valor'.$grado.'").value;
							cadena += "&valor'.$grado.'=" + valor'.$grado.';
					';
				}
			}*/
			echo '			doWork(tag, "servidor.php",cadena);
				
						}
			';
			
			
			
			
			?>
						