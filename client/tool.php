<?php
ini_set('display_errors', 'On');
include_once('toolscale.php');
include_once('toollistscale.php');
include_once('tooldifferential.php');
include_once('toollist.php');
include_once('toolrubric.php');
include_once('toolmix.php');
include_once('toolargument.php');

class tool{
	private $object;
	var $language;
	var $type;
	
	function __construct($language, $type, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim){
		switch($type){
			case 'lista':{
				$this->object = new toollist($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr);
			}break;
			case 'escala':{
				$this->object = new toolscale($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim);
			}break;
			case 'listaescala':{
				$this->object = new toollistscale($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim);
			}break;
			case 'diferencial':{
				$this->object = new tooldifferential($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr);
			}break;
			case 'rubrica':{
				$this->object = new toolrubric($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim);
			}break;
			case 'mixta':{
				$this->object = new toolmix($language, $titulo);
			}break;
			case 'argumentario':{
				$this->object = new toolargument($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $dimpor, $subdimpor, $atribpor, $commentAtr);
			}break;
		}
		$this->language = $language;
		$this->type = $type;
	}
	
	function display_header($data = ''){
		include('lang/'. $this->language . '/evalcomix.php');
		include_once('../configuration/host.php');
		echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<title>EvalCOMIX 4.2</title>
					<link href="'.HOST.'client/style/copia.css" type="text/css" rel="stylesheet">
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
					<script type="text/javascript" src="javascript/size.js"></script>
					<script type="text/javascript" src="javascript/rollover.js"></script>					
					<script type="text/javascript" src="javascript/ajax.js"></script>
					<script type="text/javascript" src="javascript/check.js"></script>
					<script type="text/javascript" src="javascript/valida.js"></script>
					<script language="JavaScript" type="text/javascript">

						function abrir() {
							abrirVentana("ventana-modal-frame.html", 500, 300, "ventana-modal");
						}

						function ventanaSecundaria (URL){
							window.open(URL,"ventana1","width=700,height=500,left=300,top=100, scrollbars=NO")
						}	

						function mostrar(capa){
							var obj = document.getElementById(capa)
							if(obj.style.visibility== "hidden")  obj.style.visibility= "visible";
							else if(obj.style.visibility == "visible") obj.style.visibility= "hidden";
							else obj.style.visibility = "visible";
						}

						document.onkeydown = function(){
							if(window.event && window.event.keyCode == 116){
								window.event.keyCode = 505;
							}
							if(window.event && window.event.keyCode == 505){
								return false;
								// window.frame(main).location.reload(True);
							}
						}
						document.onkeydown = function(e){
							var key;
							var evento;
							if(window.event){
								if(window.event && window.event.keyCode == 116){
									window.event.keyCode = 505;
								}
								if(window.event && window.event.keyCode == 505){
									return false;
									// window.frame(main).location.reload(True);
								}								
							}
							else{
								evento = e;
								key = e.which; // Firefox
								if(evento && key == 116){
									key = 505;
								}
								if(evento && key == 505){
									return false;
									// window.frame(main).location.reload(True);
								}
							}
							
							
						}

						function unificarValores(tagname, element)
						{
							var valores = document.getElementsByName(tagname);
							for(var i=0; i<valores.length; i++){
								valores[i].value=element.value;
							}
						}
						function confirmar(mensaje){
							var r=confirm(mensaje);
							if (r==true){
								return true;
							}
							return false;
						}
						function imprimir(que) {
							var ifrm = document.createElement("IFRAME"); 
							ifrm.setAttribute("src", "generator.php?op=view");
							ifrm.setAttribute("id", "frameprint");
							ifrm.style.width = 640+"px";
							ifrm.style.height = 480+"px";
							document.body.appendChild(ifrm);
							var id = "frameprint";
							var iframe = document.frames ? document.frames[id] : document.getElementById(id); 
							var ifWin = iframe.contentWindow || iframe;     
							ifWin.focus();     
							ifWin.print();      
							
						}
						
						function checkwindow(){
							window.opener.location.reload(); 
							/*window.opener.close();*/
						}

						document.oncontextmenu=function(){return false;} 
					 
					</script>
				</head>

				<!--<body id="body" onunload="checkwindow();" > -->
				<body id="body" >
					<noscript>
                                               <div style="color:#f00"> Para el correcto funcionamiento de EvalCOMIX debe habilitar Javascript en su navegador</div>
                                        </noscript>
					<div id="cabecera">
						<div id="menu">				
							<a href="#" onclick=\'javascript:
						/*	var id_dim=document.getElementsByName("dimensiontagname");
							for(var i=0; i<id_dim.length; i++){
								var valores=document.getElementsByName("select"+id_dim[i].value);
								var repeated = 0;
								for(var j=0; j<valores.length; j++){
									for(var k=0; k<valores.length; k++){
										if(j != k && valores[j].value == valores[k].value){
											repeated = 1;
											break;		
										}
									}
								}
								if(repeated == 1){
									alert("Error: Existen valores repetidos en alguna de las escalas definidas.\nUna vez arreglado vuelva a hacer clic en Guardar");
									return false;
								}
							}
						*/
							var cadena; if(document.getElementById("cuerpomix")){cadena="addtool=1&titulo="+document.getElementById("titulo").value+""}else{cadena="id=0&addDim=1&titulo0="+document.getElementById("titulo0").value+"";}sendPost("html","save=1&amp;"+cadena+"","mainform0");\'><img id="guardar" src="'.HOST.'client/images/guardar.png" onmouseover="javascript:cAmbiaOver(this.id, \''.HOST.'client/images/guardarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \''.HOST.'client/images/guardar.png\');" alt="' . $string['TSave'] . '" title="' . $string['TSave'] . '"/></a>
							<!--<a href="generator.php?op=import"><img id="importar" src="images/importar.png" alt="' . $string['TImport'] . '" title="' . $string['TImport'] . '" onmouseover="javascript:cAmbiaOver(this.id, \'images/importarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/importar.png\');"/></a>-->
							<a href="generator.php?op=export" onclick=\'javascript:var r=confirm("         Estás a punto de exportar el instrumento.\n\nAsegúrate de haber GUARDADO todos los cambios realizados\n");if (r==true){return true;}return false;\'><img id="exportar" src="'.HOST.'client/images/exportar.png" alt="' . $string['TExport'] . '" title="' . $string['TExport'] . '" onmouseover="javascript:cAmbiaOver(this.id, \''.HOST.'client/images/exportarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \''.HOST.'client/images/exportar.png\');"/></a>
							<a onClick="MasTxt(\'mainform0\');" href=#><img id="aumentar" src="'.HOST.'client/images/aumentar.png" alt="Aumentar" title="' . $string['TAumentar'] . '" onmouseover="javascript:cAmbiaOver(this.id, \''.HOST.'client/images/aumentarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \''.HOST.'client/images/aumentar.png\');"/></a>
							<a onClick="MenosTxt(\'mainform0\');" href=#><img id="disminuir" src="'.HOST.'client/images/disminuir.png" alt="Disminuir" title="' . $string['TDisminuir'] . '" onmouseover="javascript:cAmbiaOver(this.id, \''.HOST.'client/images/disminuirhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \''.HOST.'client/images/disminuir.png\');"/></a>
							<a href="generator.php?op=view"><img id="visualizar" src="'.HOST.'client/images/visualizar.png" alt="Ver" title="' . $string['TView'] . '" onmouseover="javascript:cAmbiaOver(this.id, \''.HOST.'client/images/visualizarhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \''.HOST.'client/images/visualizar.png\');"/></a>
							<a href="servidor.php?op=imprimir"><img id="imprimir" src="'.HOST.'client/images/imprimir.png" alt="' . $string['TPrint'] . '" title="' . $string['TPrint'] . '" onmouseover="javascript:cAmbiaOver(this.id, \''.HOST.'client/images/imprimirhover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \''.HOST.'client/images/imprimir.png\');"/></a>
							';
							
		$lang = 'es_ES';
		if($this->language == 'en_utf8'){
			$lang = 'en_US';
		}
		include('lang/'.$this->language.'/evalcomix.php');
		//<a onclick=\'javascript:ventanaSecundaria("http://avanza.uca.es/assessmentservice/help/'.$lang.'/");\'><img id="ayuda" src="images/ayuda.png" alt="' . $string['THelp'] . '" title="' . $string['THelp'] . '" onmouseover="javascript:cAmbiaOver(this.id, \'images/ayudahover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/ayuda.png\');"/></a>
		if(!isset($id)){
			$id = null;
		}
		echo '
							<a  href="http://avanza.uca.es/assessmentservice/help/'.$lang.'/" target="_blank"><img id="ayuda" src="images/ayuda.png" alt="' . $string['THelp'] . '" title="' . $string['THelp'] . '" onmouseover="javascript:cAmbiaOver(this.id, \'images/ayudahover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/ayuda.png\');"/></a>
							<a  href=\'javascript:mostrar("about")\'><img id="acerca" src="images/acerca.png" alt="' . $string['TAbout'] . '" title="' . $string['TAbout'] . '" onmouseover="javascript:cAmbiaOver(this.id, \'images/acercahover.png\');" onmouseout="javascript:cAmbiaOut(this.id, \'images/acerca.png\');"/></a>
						</div>
					</div>
					<div id="about">
						<div style="margin:10px">Acerca de</div>
						<div id="about_white">
							'.$string['idea'].'<BR>
							<div class="about_linea">María Soledad Ibarra Sáiz</div>
							<div class="about_linea">Gregorio Rodríguez Gómez</div>
							'.$string['design'].'<BR>
							<div class="about_linea">Álvaro Martínez Del Val</div>
							<div class="about_linea">Daniel Cabeza Sánchez</div>
							'.$string['develop'].'<BR>
							<div class="about_linea">Daniel Cabeza Sánchez</div>
							'.$string['translation'].'<BR>
							<div class="about_linea">Daniel Cabeza Sánchez</div>
							'.$string['colaboration'].'<BR>
							<div class="about_linea">Juan A. Caballero Hernández</div>
							<div class="about_linea">Claudia Ortega Gómez</div>
							<div class="about_linea">Álvaro Martínez Del Val</div>
							<div class="about_linea">Juan Manuel Dodero Beardo</div>
							<div class="about_linea">Miguel A. Gómez Ruiz</div>
							<div class="about_linea">Álvaro R. León Rodríguez</div>
							<div class="about_linea">Antonio Gámez Mellado</div>
							'.$string['license'].'<BR>
							<div class="about_linea">GNU GPL v2</div><br>
							<input type="button" style="margin-left:4em;width:5em;" onclick=\'javascript:mostrar("about");\' value="Cerrar"/>	
						</div>					
					</div>
					<div id="loader" style="text-align:center"></div>
					<form id="mainform0" name="mainform'.$id.'" method="POST" action="generator.php">
					';	
					
			flush();	
		}
	
	function save($id = ''){ return $this->object->save($id);}
	
	function export(){return $this->object->export();}
	
	function display_tool($data, $id){
		return $this->object->display_tool($data, $id);
	}
	
	function display_body($data){
		include('lang/'.$this->language.'/evalcomix.php');
		$html = $this->object->display_body($data);
		
		return $html;		
	}
	
	function display_dimension($dim, $data, $id){
		return $this->object->display_dimension($dim, $data, $id);
	}
	
	function display_subdimension($dim, $subdim, $data, $id){
		return $this->object->display_subdimension($dim, $subdim, $data, $id);
	}
	
	function display_footer(){
		echo '		</form>
				</body>
			</html>';
			flush();
	}
	
	function display_dialog(){
		include('lang/'. $this->language . '/evalcomix.php');
		include('cabecera_select_tool.php');
		echo '
				<div id="titulomenu">Importar Fichero</div>
					<form name="formimport" enctype="multipart/form-data" action="servidor.php" method=post>
						<label for="Filetype">' . $string['selectfile'] . ':</label><br>
						<input type="file" name="Filetype" id="Filetype"><br><br><br>
						<input type="submit" value="' . $string['upfile'] . '" onclick=\'javascript:if(document.formimport.Filetype.value.lastIndexOf(".evx") == -1){alert("' . $string['ErrorExtension'] . '");return false;}\'>
						<input type="button" value="Cancelar" onclick=\'history.back(-1)\';">
					</form>
				</div>
			';
		include('pie_select_tool.php');
	}
	
	function addDimension($dim, $key, $id = 0){
		$this->object->addDimension($dim, $key, $id);
	}
	function addSubdimension($dim, $subdim, $key, $id=0){
		return $this->object->addSubdimension($dim, $subdim, $key, $id);
	}
	/*function upAtributo($dim, $subdim, $atrib, $id=0){
	 	return $this->object->upAtributo($dim, $subdim, $atrib, $id);
	}
	function downAtributo($dim, $subdim, $atrib, $id=0){
		return $this->object->downAtributo($dim, $subdim, $atrib, $id);
	}
	
	function upSubdimension($dim, $subdim, $id=0){
		return $this->object->upSubdimension($dim, $subdim, $id);
	}
	function downSubdimension($dim, $subdim, $key, $id=0){
		return $this->object->downSubdimension($dim, $subdim, $id);
	}*/
	
	function upBlock($params){
		return $this->object->upBlock($params);
	}
	function downBlock($params){
		return $this->object->downBlock($params);
	}
	
	function addAtributo($dim, $subdim, $atrib, $key, $id=0){
		return $this->object->addAtributo($dim, $subdim, $atrib, $key, $id);
	}
	
	function addValores($dim, $key, $id=0){
		return $this->object->addValores($dim, $key, $id);
	}
		
	function addValoresTotal($key, $id=0){
		return $this->object->addValoresTotal($key, $id);
	}
	
	function eliminaValoresTotal($grado, $id=0){
		return $this->object->eliminaValoresTotal($grado, $id);
	}
	
	function eliminaDimension($dim, $id=0){			
		return $this->object->eliminaDimension($dim, $id);
	}
	
	function eliminaSubdimension($dim, $subdim, $id=0){
		return $this->object->eliminaSubdimension($dim, $subdim, $id);
	}
	
	function eliminaAtributo($dim, $subdim, $atrib, $id=0){
		return $this->object->eliminaAtributo($dim, $subdim, $atrib, $id);
	}
	
		
	function eliminaValores($dim, $grado, $id=0){
		return $this->object->eliminaValores($dim, $grado, $id);
	}
	
	function addRango($dim, $grado, $key, $id=0){
		return $this->object->addRango($dim, $grado, $key, $id);
	}
		
	function eliminaRango($dim, $grado, $key, $id=0){
		return $this->object->eliminaRango($dim, $grado, $key, $id);
	}
	
	function add($type, $index = null){
		return $this->object->add($type, $index);
	}
	
	function remove($index){
		return $this->object->remove($index);
	}
	
	function get_numtool(){return $this->object->get_numtool();}
	function get_toolpor(){return $this->object->get_toolpor();}
	function get_tools(){return $this->object->get_tools();}
	function get_tool($id){return $this->object->get_tool($id);}
	function get_titulo($id){return $this->object->get_titulo($id);}
	function get_dimension($id){return $this->object->get_dimension($id);}
	function get_numdim($id){return $this->object->get_numdim($id);}
	function get_subdimension($id){return $this->object->get_subdimension($id);}
	function get_numsubdim($id){return $this->object->get_numsubdim($id);}
	function get_atributo($id){return $this->object->get_atributo($id);}
	function get_numatr($id){return $this->object->get_numatr($id);}
	function get_valores($id){return $this->object->get_valores($id);}
	function get_numvalores($id){return $this->object->get_numvalores($id);}
	function get_valtotal($id){return $this->object->get_valtotal($id);}
	function get_numtotal($id = null){return $this->object->get_numtotal($id);}
	function get_valtotalpor($id){return $this->object->get_valtotalpor($id);}
	function get_valorestotal($id){return $this->object->get_valorestotal($id);}
	function get_valglobal($id){return $this->object->get_valglobal($id);}
	function get_valglobalpor($id){return $this->object->get_valglobalpor($id);}
	function get_dimpor($id){return $this->object->get_dimpor($id);}
	function get_subdimpor($id){return $this->object->get_subdimpor($id);}
	function get_atribpor($id){return $this->object->get_atribpor($id);}
	function get_numrango($id){return $this->object->get_numrango($id);}
	function get_rango($id){return $this->object->get_rango($id);}
	function get_description($id){return $this->object->get_description($id);}
	function get_commentAtr($id){return $this->object->get_commentAtr($id);}
	function get_porcentage(){return $this->object->get_porcentage();}
	function get_dimensionsId(){return $this->object->get_dimensionsId();}
	function get_subdimensionsId(){return $this->object->get_subdimensionsId();}
	function get_atributosId(){return $this->object->get_atributosId();}
	function get_valoresId(){return $this->object->get_valoresId();}
	function get_valorestotalesId(){return $this->object->get_valorestotalesId();}
	function get_valoreslistaId(){return $this->object->get_valoreslistaId();}
	function get_rangoId(){return $this->object->get_rangoId();}
	function get_descriptionsId(){return $this->object->get_descriptionsId();}
	function get_atributopos(){return $this->object->get_atributopos();}
	function get_atributosposId(){return $this->object->get_atributosposId();}
	function get_plantillasId(){return $this->object->get_plantillasId();}
	function get_valoreslista(){return $this->object->get_valoreslista();}
	
	function set_titulo($titulo, $id){$this->object->set_titulo($titulo, $id);}
	function set_dimension($dimension, $id){$this->object->set_dimension($dimension, $id);}
	function set_numdim($numdim, $id){$this->object->set_numdim($numdim, $id);}
	function set_subdimension($subdimension, $id){$this->object->set_subdimension($subdimension, $id);}
	function set_numsubdim($numsubdim, $id){$this->object->set_numsubdim($numsubdim, $id);}
	function set_atributo($atributo, $id){$this->object->set_atributo($atributo, $id);}
	function set_numatr($numatr, $id){$this->object->set_numatr($numatr, $id);}
	function set_valores($valores, $id){$this->object->set_valores($valores, $id);}
	function set_numvalores($numvalores, $id){$this->object->set_numvalores($numvalores, $id);}
	function set_valtotal($valtotal, $id){$this->object->set_valtotal($valtotal, $id);}
	function set_numtotal($numtotal, $id){$this->object->set_numtotal($numtotal, $id);}
	function set_valtotalpor($valtotalpor, $id){$this->object->set_valtotalpor($valtotalpor, $id);}
	function set_valorestotal($valorestotal, $id){$this->object->set_valorestotal($valorestotal, $id);}
	function set_valglobal($valglobal, $id){$this->object->set_valglobal($valglobal, $id);}
	function set_valglobalpor($valglobalpor, $id){$this->object->set_valglobalpor($valglobalpor, $id);}
	function set_dimpor($dimpor, $id){$this->object->set_dimpor($dimpor, $id);}
	function set_subdimpor($subdimpor, $id){$this->object->set_subdimpor($subdimpor, $id);}
	function set_atribpor($atribpor, $id){$this->object->set_atribpor($atribpor, $id);}
	function set_rango($rango, $id){$this->object->set_rango($rango, $id);}
	function set_toolpor($porcentage){$this->object->set_toolpor($porcentage);}
	function set_view($view, $id){$this->object->set_view($view, $id);}
	function set_commentAtr($comment){$this->object->set_commentAtr($comment);}
	function set_dimensionsId($dimensionsId, $id){$this->object->set_dimensionsId($dimensionsId, $id);}
	function set_subdimensionsId($subdimensionsId, $id){$this->object->set_subdimensionsId($subdimensionsId, $id);}
	function set_atributosId($atributosId, $id){$this->object->set_atributosId($atributosId, $id);}
	function set_valoresId($valoresId, $id){$this->object->set_valoresId($valoresId, $id);}
	function set_valorestotalesId($valoresId, $id){$this->object->set_valorestotalesId($valoresId, $id);}
	function set_valoreslistaId($valoresId, $id){$this->object->set_valoreslistaId($valoresId, $id);}
	function set_rangoId($valoresId, $id){$this->object->set_rangoId($valoresId, $id);}
	function set_descriptionsId($valoresId, $id){$this->object->set_descriptionsId($valoresId, $id);}
	function set_atributopos($atributo, $id){$this->object->set_atributopos($atributo, $id);}
	function set_atributosposId($atributo, $id){$this->object->set_atributosposId($atributo, $id);}
	function set_plantillasId($plantillas, $id){$this->object->set_plantillasId($plantillas, $id);}

	function import($xml){
		unset($this->object);
		$type_evx3 = dom_import_simplexml($xml)->tagName;
		$type = '';
		if($type_evx3 == 'mt:MixTool' || $type_evx3 == 'MixTool'){
			$this->type = 'mixta';
			$this->object = new toolmix($this->language, (string)$xml['name'], (string)$xml->Description);
			$tools = array();
			
			$index = 1;
			if(isset($xml->Description))
				$index = 0;
				
			$plantillasId = array();
			$i = 0;
			foreach($xml as $valor){
				if($index == 0){
					$index = 1;
					continue;
				}
				$tool = $this->importSimpleTool($valor, $i);
				$tools[$i] = $tool; 
				$plantillasId[$i] = (string)$valor['id'];
				++$i;
			}
			$this->object->set_tools($tools);
			$this->object->set_plantillasId($plantillasId);
		}
		else{
			$this->object = $this->importSimpleTool($xml);
			
			$tagName = dom_import_simplexml($xml)->tagName;
			$type_tool = ''; 
			if($tagName[2] == ':'){
				$type_evx3 = explode(':', $tagName);
				$type_tool = $type_evx3[1];
			}
			else{
				$type_tool = $tagName;
			}

			$type = '';
			switch($type_tool){
				case 'ControlList':
					$type = 'lista';
					break;
				case 'EvaluationSet':
					$type = 'escala';
					break;
				case 'Rubric':
					$type = 'rubrica';
					break;
				case 'ControlListEvaluationSet':
					$type = 'listaescala';
					break;
				case 'SemanticDifferential':
					$type = 'diferencial';
					break;
				case 'ArgumentSet':
					$type = 'argumentario';
					break;
			}
			$this->type = $type;
		}
	}
	
	function importSimpleTool($xml, $id = 0){
		$language = $this->language;
		$dimension; 
		$numdim;
		$subdimension;
		$numsubdim;
		$atributo;
		$numatr;
		$valores;
		$numvalores;
		$numtotal = null;
		$valores;
		$valtotal = null;
		$valtotalpor;
		$valorestotal = null;
		$valglobal;
		$valglobalpor;
		$subdimpor;
		$atribpor;
		$numrango;
		$rango;
		$observation = null;
		$description;
		
		$tagName = dom_import_simplexml($xml)->tagName;
		$type_tool = ''; 
		if($tagName[2] == ':'){
			$type_evx3 = explode(':', $tagName);
			$type_tool = $type_evx3[1];
		}
		else{
			$type_tool = $tagName;
		}

		$type = '';
		switch($type_tool){
			case 'ControlList':
				$type = 'lista';
				break;
			case 'EvaluationSet':
				$type = 'escala';
				break;
			case 'Rubric':
				$type = 'rubrica';
				break;
			case 'ControlListEvaluationSet':
				$type = 'lista+escala';
				break;
			case 'SemanticDifferential':
				$type = 'diferencial';
				break;
			case 'ArgumentSet':
				$type = 'argumentario';
				break;
		}

		if($type == 'diferencial'){
			if($this->type != 'mixta'){
				$this->type = $type;
			}

			$titulo = (string)$xml['name'];
			$dim = 0;
			$numvalores[$id][$dim] = (string)$xml['values'];
			$numdim[$id] = 1;
			$dimension[$id][$dim]['nombre'] = "Dimension1";
			$valglobal[$id][$dim] = false;
			$valglobalpor[$id][$dim] = null;
			$dimpor[$id][$dim] = 100;
			$subdim = 0;
			$subdimension[$id][$dim][$subdim]['nombre'] = 'subdimension1';
			$numsubdim[$id][$dim] = 1;
			$subdimpor[$id][$dim][$subdim] = 100;
			$numatr[$id][$dim][$subdim] = (string)$xml['attributes'];
			$percentage = (string)$xml['percentage'];
			$valuecommentAtr = array();
			$observation[$id] = (string)$xml->Description;

			$atributosId = array();
			$atributosposId = array();
			$valoresId = array();
			
			$j = 0;
			foreach($xml->Values[0] as $values){ 
				$valores[$id][$dim][$j]['nombre'] = (string)$values;
				$valoresId[$id][$dim][$j] = (string)$values['id'];
				++$j;
			}

			//DATOS DE LOS ATRIBUTOS
			$atrib = 0;
			foreach($xml->Attribute as $attribute){
				$atributo[$id][$dim][$subdim][$atrib]['nombre'] = (string)$attribute['nameN'];
				$atributopos[$id][$dim][$subdim][$atrib]['nombre'] = (string)$attribute['nameP'];
				$atribpor[$id][$dim][$subdim][$atrib] = (string)$attribute['percentage'];		
				$commentAtr[$id][$dim][$subdim][$atrib] = 'hidden';
				$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute;
				$atributosId[$id][$dim][$subdim][$atrib] = (string)$attribute['idNeg'];
				$atributosposId[$id][$dim][$subdim][$atrib] = (string)$attribute['idPos'];
				
				if((string)$attribute['comment'] == 1)
					$commentAtr[$id][$dim][$subdim][$atrib] = 'visible';
				
				if((string)$attribute['comment'] != 1 && (string)$attribute['comment'] != ''){
					$commentAtr[$id][$dim][$subdim][$atrib] = 'visible';
					$valuecommentAtr[$id][$dim][$subdim][$atrib] = (string)$attribute['comment'];
				}
				
				++$atrib;
			}//foreach($subdimension->Attribute as $attribute)
			
			$params['atributosId'] = $atributosId;
			$params['atributosposId'] = $atributosposId;
			$params['valoresId'] = $valoresId;
		}
		else{
			$valtotal = null;
			if(isset($xml->GlobalAssessment->Values->Value[0])){
				$valtotal[$id] = 'true';
				$valuetotalvalue[$id] = (string)$xml->GlobalAssessment->Attribute;
			}
			else{
				$valuetotalvalue[$id] = '';
			}
			$titulo = (string)$xml['name'];
			$observation[$id] = (string)$xml->Description;
			$percentage = (string)$xml['percentage'];
			$numdim[$id] = (string)$xml['dimensions']; 
			$valglobal = $valglobalpor = $commentDim = array();
			
			//Para los formularios cumplimentados
			$valueattribute = array();
			$valueglobaldim = array();
			$valuecommentAtr = array();
			$valuecommentDim = array();
			$dimensionsId = array();
			$subdimensionsId = array();
			$atributosId = array();
			$valoresId = array();
			$valoreslistaId = array();
			$rangoId = array();
			$descriptionsId = array();
			
		   //DATOS DE LA DIMENSIÃ“N
			$dim = 0;
			foreach ($xml->Dimension as $dimen){
				if(isset($dimen->DimensionAssessment[0]->Attribute)){
					$valglobal[$id][$dim] = 'true';
					$valglobalpor[$id][$dim] = (string)$dimen->DimensionAssessment['percentage'];
					$valueglobaldim[$id][$dim] = (string)$dimen->DimensionAssessment[0]->Attribute;
					if($type == 'rubrica'){
						$valueglobaldim[$id][$dim] = (string)$dimen->DimensionAssessment[0]->Attribute->selection->instance;
					}
					$commentDim[$id][$dim] = 'hidden';
					if((string)$dimen->DimensionAssessment[0]->Attribute['comment'] == '1'){
							$commentDim[$id][$dim] = 'visible';
					}
					if((string)$dimen->DimensionAssessment[0]->Attribute['comment'] != '1' && (string)$dimen->DimensionAssessment[0]->Attribute['comment'] != ''){
							$commentDim[$id][$dim] = 'visible';
							$valuecommentDim[$id][$dim] = (string)$dimen->DimensionAssessment[0]->Attribute['comment'];
						}
				}
				$dimension[$id][$dim]['nombre'] = (string)$dimen['name'];
				$dimpor[$id][$dim] = (string)$dimen['percentage'];
				$numsubdim[$id][$dim] = (string)$dimen['subdimensions'];
				$numvalores[$id][$dim] = (string)$dimen['values'];
				$dimensionsId[$id][$dim] = (string)$dimen['id'];
				
				//VALORES DE LA DIMENSIÓN
				$grado = 0;
				if(isset($dimen->Values[0])){
					foreach($dimen->Values[0] as $values){
						if($type != 'rubrica'){
							$valores[$id][$dim][$grado]['nombre'] = (string)$values;
							$valoresId[$id][$dim][$grado] = (string)$values['id'];
						}
						else{
							$valores[$id][$dim][$grado]['nombre'] = (string)$values['name'];
							$numrango[$id][$dim][$grado] = (string)$values['instances'];
							$i = 0;
							foreach($values->instance as $range){
								$rango[$id][$dim][$grado][$i] = (string)$range;
								$rangoId[$id][$dim][$grado][$i] = (string)$range['id'];
								$i++;
							}
							$valoresId[$id][$dim][$grado] = (string)$values['id'];
						}
						$grado++;
					}
				}
				
				//VALUES OF CHECKLIST OF CHECKLIST+RATESCALES
				if($type == 'lista+escala'){
					$grado = 0;
					foreach($dimen->ControlListValues[0] as $values){
						$this->valoreslista[$id][$dim][$grado]['nombre'] = (string)$values;
						$valoreslistaId[$id][$dim][$grado] = (string)$values['id'];
						$grado++;
					}
				}
				
				//DATOS DE LA SUBDIMENSION
				$subdim = 0;
				foreach($dimen->Subdimension as $subdimen){
					$subdimension[$id][$dim][$subdim]['nombre'] = (string)$subdimen['name'];
					$subdimpor[$id][$dim][$subdim] = (string)$subdimen['percentage'];
					$numatr[$id][$dim][$subdim] = (string)$subdimen['attributes'];
					$subdimensionsId[$id][$dim][$subdim] = (string)$subdimen['id'];
					
					//DATOS DE LOS ATRIBUTOS				
					$atrib = 0;
					foreach($subdimen->Attribute as $attribute){
						$atributo[$id][$dim][$subdim][$atrib]['nombre'] = (string)$attribute['name'];
						$atribpor[$id][$dim][$subdim][$atrib] = (string)$attribute['percentage'];
						$atributosId[$id][$dim][$subdim][$atrib] = (string)$attribute['id'];
						$commentAtr[$id][$dim][$subdim][$atrib] = 'hidden';
	
						if((string)$attribute['comment'] == '1')
							$commentAtr[$id][$dim][$subdim][$atrib] = 'visible';
						
						if((string)$attribute['comment'] != '1' && (string)$attribute['comment'] != ''){
							$commentAtr[$id][$dim][$subdim][$atrib] = 'visible';
							$valuecommentAtr[$id][$dim][$subdim][$atrib] = (string)$attribute['comment'];
						}
						
						$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute;
						if($type == 'lista+escala'){
							$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute->selection;
						}
						
						//$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute;
						if($type == 'rubrica'){
							$valueattribute[$id][$dim][$subdim][$atrib] = (string)$attribute->selection->instance;
						}
						
						//DESCRIPCIONES DE LAS RÚBRICAS
						if($type == 'rubrica')
						{
							foreach($attribute->descriptions[0] as  $descrip)
							{
								$grado = (string)$descrip['value'];
								$description[$id][$dim][$subdim][$atrib][$grado] = (string)$descrip;
								$descriptionsId[$id][$dim][$subdim][$atrib][$grado] = (string)$descrip['id'];
							}
						}//if($type == 'rubrica')
						$atrib++;
					}//foreach($subdimension->Attribute as $attribute)
					$subdim++;
				}//foreach($dimension->Subdimension as $subdimension)     
				$dim++;
			}//foreach ($xml->Dimension as $dimension)

			$params['dimensionsId'] = $dimensionsId;
			$params['subdimensionsId'] = $subdimensionsId;
			$params['atributosId'] = $atributosId;
			$params['valoresId'] = $valoresId;
			$params['valoreslistaId'] = $valoreslistaId;
			$params['rangoId'] = $rangoId;
			$params['descriptionsId'] = $descriptionsId;
			
		   //DATOS DE VALORES TOTALES
			$numtotal = $valtotalpor = $valorestotal = null;
			if(isset($xml->GlobalAssessment[0]->Values[0]->Value)){
				$valorestotalesId = array();
				$numtotal[$id] = (string)$xml->GlobalAssessment['values'];
				$valtotalpor[$id] = (string)$xml->GlobalAssessment['percentage'];
				$grado = 0;
				foreach ($xml->GlobalAssessment[0]->Values[0] as $value){
					$valorestotal[$id][$grado]['nombre'] = (string)$value;
					$valorestotalesId[$id][$grado] = (string)$value['id'];
					$grado++;
				}
				$params['valorestotalesId'] = $valorestotalesId;
			}
		}
		$instrument;
		switch($type){
			case 'lista':{
				$instrument = new toollist($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $id, $observation, $percentage, $valueattribute, $valuecommentAtr, $params);
			}break;
			case 'escala':{
				$instrument = new toolscale($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim, $id, $observation, $percentage, $valtotalpor, $valueattribute, $valueglobaldim, $valuetotalvalue, $valuecommentAtr, $valuecommentDim, $params);
			}break;
			case 'lista+escala':{
				$instrument = new toollistscale($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim, $id, $observation, $percentage, $valtotalpor, $valueattribute, $valueglobaldim, $valuetotalvalue, $valuecommentAtr, $valuecommentDim, $params);
			}break;
			case 'rubrica':{
				$instrument = new toolrubric($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $commentDim, $id, $observation, $percentage, $valtotalpor, $rango, $numrango, $description, $valueattribute, $valueglobaldim, $valuetotalvalue, $valuecommentAtr, $valuecommentDim, $params);
			}break;
			case 'diferencial':{
				$instrument = new tooldifferential($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $valores, $numvalores, $valtotal, $numtotal, $valorestotal, $valglobal, $valglobalpor, $dimpor, $subdimpor, $atribpor, $commentAtr, $id, $observation, $percentage, $atributopos, $valueattribute, $valuecommentAtr, $params);
			}break;
			case 'argumentario':{
				$instrument = new toolargument($language, $titulo, $dimension, $numdim, $subdimension, $numsubdim, $atributo, $numatr, $dimpor, $subdimpor, $atribpor, $commentAtr, $id, $observation, $percentage, $valuecommentAtr, $params);
			}break;
		}
		return $instrument;
		//echo "<br><br>" .print_r($this->object);
	}
	
	function display_view(){
			$id = '';
			echo '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<title>EvalCOMIX 4.2</title>
					<link href="style/copia.css" type="text/css" rel="stylesheet">
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<script type="text/javascript" src="javascript/size.js"></script>
					<script type="text/javascript" src="javascript/rollover.js"></script>					
					<script type="text/javascript" src="javascript/ajax.js"></script>
					<script type="text/javascript" src="javascript/check.js"></script>
					<script type="text/javascript" src="javascript/valida.js"></script>
					<script type="text/javascript" src="javascript/ventana-modal.js"></script>
					<script language="JavaScript" type="text/javascript">
					
						document.onkeydown = function(){
							if(window.event && window.event.keyCode == 116){
								window.event.keyCode = 505;
							}
							if(window.event && window.event.keyCode == 505){
								return false;
								// window.frame(main).location.reload(True);
							}
						}
						document.onkeydown = function(e){
							var key;
							var evento;
							if(window.event){
								if(window.event && window.event.keyCode == 116){
									window.event.keyCode = 505;
								}
								if(window.event && window.event.keyCode == 505){
									return false;
									// window.frame(main).location.reload(True);
								}								
							}
							else{
								evento = e;
								key = e.which; // Firefox
								if(evento && key == 116){
									key = 505;
								}
								if(evento && key == 505){
									return false;
									// window.frame(main).location.reload(True);
								}
							}											
						}
						function imprimir(que){
							var ventana = window.open("", "", "");
							var contenido = "<html><head><link href=\'style/copia.css\' type=\'text/css\' rel=\'stylesheet\'></head><body onload=\'window.print();window.close();\'>";
							contenido = contenido + document.getElementById(que).innerHTML + "</body></html>";
							ventana.document.open();
							ventana.document.write(contenido);
							ventana.document.close();
						}
						
						document.oncontextmenu=function(){return false;} 
					 
					</script>
					<style type="text/css">
						#mainform0{
							border: 1px solid #00f;
						}
						.dimension, .valoracionglobal, .valoraciontotal, #comentario{
							border: 2px solid #6B8F6B
;
						}
						.subdimension{
							background-color: #F1F2F1;
							margin: 0.7em 2em 0em 2em;
							overflow:visible
						}
					</style>
				</head>

				<body id="body" onload=\'javascript:window.print();location.href="generator.php"\'>
					
					<form id="mainform0" name="mainform'.$id.'" method="POST" action="generator.php">
		';	
	}
	function display_body_view($data, $mix='', $porcentage=''){
		return $this->object->display_body_view($data, $mix, $porcentage);
	}
	function display_dimension_view($dim, $data, $id=0, $mix=''){
		return $this->object->display_dimension_view($dim, $data, $id, $mix);
	}
	function display_subdimension_view($dim, $subdim, $data, $id=0, $mix=''){
		return $this->object->display_subdimension_view($dim, $data, $id, $mix);
	}
	function print_tool(){
		return $this->object->print_tool();
	}
	
	function view_assessment_header(){
		//<!-- <link href="'.$root.'client/style/platform.css" type="text/css" rel="stylesheet"> -->
		echo '
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
				<html>

					<head>
						<title>EVALCOMIX</title>
						<style>
body {background-color: #fff;font-family: "arial";font-size: 0.72em; 	margin:0; }  p{margin:0; }  form{margin:0; }  h1,h2,h3,h4,h5,h6{color: #146C84; } #linea{height: 5px;background-color: #f5751a; }  #titulo{font-size: 1em;color:#146C84;font-weight: bold;font-style:italic;margin-top: -2em;margin-left:5em;margin-bottom: 1em; }#cabecera{border-bottom: 1px solid #000; }  /*campos1------------------------------------*/ #ca1_env{float: right;margin-bottom: 1em; } /*-------------------------------------------*/  #crear{padding-left: 0.5em; }#dim{background-color: #146C84;color: #fff; }  .planmenu{text-decoration:none;border-right: 1px solid #fff;padding: 0.8em 1em 0.7em 0;color:#fff; }  /*.planmenu:hover{text-decoration:none;color: #fff;background-color: #00aaff;border-right: 1px solid #000000;padding-right: 1em; }*/  .tam{width: 85%; }  .fields{margin-bottom: 1em; }  .fields legend{color: #146C84;font-weight: bold; }  .tabla{width: 100%;background-color: #E5F0FD;font-family: "arial"; 	margin:0; 	padding:0; /*   font-size: 1em;*/ }  .tabla th{background-color: #146C84;color: #fff; }  .td{ 	font-size: 0.8em;font-weight: bold;text-align:center; }  .rub{width: 12em; }  .eval{margin:0; 	padding:0; }  .global{text-align:right;font-style: italic;font-weight: bold; }  .boton_est{text-decoration:none;color: #0000ff;font-weight:bold;padding: 0.3em 0.8em 0.3 0.8em;background-color: #a3a3a3;border-right: 1px solid #000;border-bottom: 1px solid #000;border-top: 1px solid #fff;border-left: 1px solid #fff; }  .botones{padding-bottom: 2em; }  .boton{float:right; }  .table_rubrica{width: 90%; }  .table_rubrica textarea{width:100%; }  .arubric{padding: 5% 40% 5% 40%;background-color:#fff;text-decoration:none; }  .float{margin-left: 1em;float:left; }  .obligatorio{font-size: 0.7em;font-weight: bold; }  .bold{font-weight: bold; }  .subdim{font-style:italic;font-weight:bold; }  .rango{text-align:center; }  .search_menu{text-decoration:none;color:#146f8f;padding:0.1em 0.2em 0.1em 0.2em;background-color:#e3e3e3;border: 1px solid #a3a3a3;font-weight: bold; }  .clear{clear:both; }  .pordim{ 	font-weight: bold; 	witdh: 3em;	 }  .subdimpor{ 	font-style:italic;	font-weight:bold; 	text-align:center; 	font-size: 0.9em; }  .atribpor{ 	text-align:right; 	font-size:0.8em }  .showcomment, .showcomment:hover{ 	background-image: url("../images/editar.gif"); 	width: 19px; 	height: 16px; 	border:0; 	background-color:#fff; 	background-repeat: no-repeat; }  .showcomment{ 	border: 1px solid #434343;	 }  .showcomment:hover{ 	border: 2px solid #0076C1; }  
						</style>
		';
		
	}
	
	function view_tool($root = '', $grade = '', $print='view', $title = ''){
			include('lang/'. $this->language . '/evalcomix.php');
			$wprint = '';
			if($print == 'print'){
				$wprint = 'onload="window.print()"';
			}
			$this->view_assessment_header();
			echo '
						<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
						<script language="JavaScript" type="text/javascript">
							function muestra_oculta(id){
								if (document.getElementById){ //se obtiene el id
									var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
									if(el.style.display == "none"){
										el.style.display = "block";
										el.disabled = false;
									}
									else{
										el.style.display = "none";
										el.disabled = true;
									}
									//el.style.display = (el.style.display == "none") ? "block" : "none"; //damos un atributo display:none que oculta el div
								}
							}
							window.onload = function(){
								var valores=document.getElementsByName("comAtrib");
								for(var i=0; i<valores.length; i++){
									valores[i].style.display = "none";
									
								}
							}
						</script>
					</head>

					<body '. $wprint .'>
						<div class="clear"></div>
						<div class="eval" id="evalid">						
						<h2>'.$title.'</h2>
							<form name="mainform" method="post" action="">
			';
			echo '

				<div class="boton" style="margin-right: 1em;">
					<input type="button" name="imprimir" value="'.$string['TPrint'].'" onclick="javascript:
					var ficha = document.getElementById(\'evalid\');
					var ventimp=window.open(\'\',\'popimpr\');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();">
				</div>
				<div class="clear"></div>';
		
			$this->object->print_tool();
			
			echo '
						</form>
							
					</div>
				</div>
			';
			
			$tool = '';
			if(isset($_GET['pla'])){
				$tool = $_GET['pla'];
			}
			
			echo '
				<div class="clear"></div>
					<hr><br>
			';
			
			if($grade != ''){
				echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": " . $grade . "</span></div>";
			}
			
			echo '		
					<br><hr>
					<div class="botones">
						<div class="boton" style="margin-right: 1em;">
<!--							<input type="button" name="imprimir" value="Imprimir" onclick="window.focus();window.print().window.close();"> -->
								
								<input type="button" name="imprimir" value="'.$string['TPrint'].'" onclick="javascript:
								var ficha = document.getElementById(\'evalid\');
								var ventimp=window.open(\'\',\'popimpr\');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();">
								
					</div>
					<div class="clear"></div>
							 
					<div class="clear"></div>
					<br>
					</body>
					
				</html>
			';
		}
		
		function assessment_tool($root = '', $assessmentid = 0, $idTool = 0, $grade = '', $saved = '', $title = ''){
			include('lang/'. $this->language . '/evalcomix.php');
			$action = $root . 'assessment/saveassess.php?ass=' . $assessmentid . '&tool='.$idTool;
			$this->view_assessment_header();
			echo '	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
						<script type="text/javascript" src="'.$root.'client/javascript/ajax.js"></script>
						<script>
							function limpiar_mainform(){
								if(confirm(\'¿Confirma que desea borrar todas las calificaciones asignadas al instrumentos?\'))
									for (i=0;i<document.mainform.elements.length;i++){
										if(document.mainform.elements[i].type == "radio" && document.mainform.elements[i].checked == true)
										  document.mainform.elements[i].checked=false;
										else if(document.mainform.elements[i].type == "textarea") document.mainform.elements[i].value = "";
								}
							}
							
							function muestra_oculta(id){
								if (document.getElementById){ //se obtiene el id
									var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
									if(el.style.display == "none"){
										el.style.display = "block";
										el.disabled = false;
									}
									else{
										el.style.display = "none";
										el.disabled = true;
									}
									//el.style.display = (el.style.display == "none") ? "block" : "none"; //damos un atributo display:none que oculta el div
								}
							}
							window.onload = function(){
								var valores=document.getElementsByName("comAtrib");
								for(var i=0; i<valores.length; i++){
									valores[i].style.display = "none";
									
								}
							}
						
						</script>
					</head>

					<body>
						<div class="clear"></div>
			';
			
			echo '
						<div class="eval" id="evalid">
							<h2>'.$title.'</h2>
			
							<form id="mainform" name="mainform" method="post" action="'.$action.'">
								<div class="boton" style="margin-right: 1em;">
								<input type="button" name="imprimir" value="'.$string['TPrint'].'" onclick="javascript:
								var ficha = document.getElementById(\'evalid\');
								var ventimp=window.open(\'\',\'popimpr\');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();">
								</div>
			';
			//echo '<input type="submit" name="submit" value="'.$string['TSave'].'" $disabledbutton>';
			echo "<input type='button' name='".$string['TSave']."' value='".$string['TSave']."' onclick='sendPostAssess(\"totalgrade\",\"uno=1\",\"mainform\",\"".$action."\");alert(\"".$string['alertsave']."\");'>";
			$type =	get_class($this->object);	
			if($type == 'toolargument' && $grade != ''){
				$grade_exploded = explode('/',$grade);
				$score = $grade_exploded[0];
				echo "
						<div class='eval' id='evalid'>
							<div style='text-align:right; font-size:1.5em;'>
								<label for='grade'>".$string['grade'] .": </label>
								<select id='grade' name='grade'>
									<option value='-1'>".$string['nograde']."</option><br>
				";
		
				for($i = 100; $i >= 0; --$i){
					$selected = '';
					if(is_numeric($score) && $score == $i){
						$selected = 'selected';
					}
					echo "<option value='$i' $selected>$i</option><br>";
				}
				echo "
								</select>
							</div>";
			}
			
			$this->object->print_tool();
			
			//echo "</div>";
			
			//echo "<input type='submit' name='".$string['TSave']."' value='".$string['TSave']."'>";
			echo "<input type='button' name='".$string['TSave']."' value='".$string['TSave']."' onclick='sendPostAssess(\"totalgrade\",\"uno=1\",\"mainform\",\"".$action."\");alert(\"".$string['alertsave']."\");'>";
			
			echo "<input type='button' onclick=\"javascript:limpiar_mainform()\" value='Reset'>";
								   
			echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": </span><span id='totalgrade'>" . $grade . "</span></div>";
			//echo '<script type="text/javascript" language="javascript">if(document.getElementById("saved").value == "saved")alert("'.$string['alertsave'].'");</script>';
			
			//echo "</div>";
			echo '			
						</form>
				</div>
			';
			
			if($saved == 'saved'){
				echo '<script type="text/javascript" language="javascript">alert("'.$string['alertsave'].'");</script>';
			}
			
			echo '
			<hr>
			<div class="botones">
				<div class="boton" style="margin-right: 1em;">
					<input type="button" name="imprimir" value="'.$string['TPrint'].'" onclick="javascript:
					var ficha = document.getElementById(\'evalid\');
					var ventimp=window.open(\'\',\'popimpr\');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();">
			</div>
			</div>';
			echo '
				<div class="clear"></div>
											 
					<div class="clear"></div>
					
					</body>
					
				</html>
			';
		}
		
		function assessment_tool_mixed($root = '', $assessmentid = 0, $idTool = '', $grade = '', $saved = '', $tools = array(), $title = ''){
			include('lang/'. $this->language . '/evalcomix.php');
			$action = $root . 'assessment/saveassess.php?ass=' . $assessmentid . '&tool='.$idTool;
			$this->view_assessment_header();
			echo '
						<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
						<script type="text/javascript" src="'.$root.'client/javascript/ajax.js"></script>
						<script>
							function limpiar_mainform(form){
								if(confirm(\'¿Confirma que desea borrar todas las calificaciones asignadas al instrumentos?\'))
									for (i=0;i<form.elements.length;i++){
										if(form.elements[i].type == "radio" && form.elements[i].checked == true)
										  form.elements[i].checked=false;
										else if(form.elements[i].type == "textarea") form.elements[i].value = "";
								}
							}
						</script>
					</head>

					<body>
						<div class="clear"></div>
						<div class="eval" id="evalid">
						<h2>'.$title.'</h2>
			';
			
							
			//print_r($this->object);
			$listTool = $this->object->get_tools();
			$countListTool = count($listTool) - 1;
			$i = 0;
			foreach($listTool as $tool){
				$type =	get_class($tool);	
				$idsingle = '';
				foreach($tools as $key => $item){
					$object = $item->object;
					if(get_class($object) == $type  && $object->get_titulo() == $tool->get_titulo() 
							&& $object->get_dimension() == $tool->get_dimension() && $object->get_subdimension() == $tool->get_subdimension()
							&& $object->get_valores() == $tool->get_valores() && $object->get_atributo() == $tool->get_atributo()
							&& $object->get_commentAtr() == $tool->get_commentAtr()){
						if($type != 'toollist'){
							if($object->get_valglobal() == $tool->get_valglobal() && $object->get_valtotal() == $tool->get_valtotal()){
								if($type == 'toolrubric'){
									$getrango1 = $object->get_rango();
									$getrango2 = $tool->get_rango();
									list(, $objectrango) = each($getrango1);
									list(, $toolrango) = each($getrango2);
									if($objectrango == $toolrango){
										$idsingle = $key;
										break;
									}
								}
								else{
									$idsingle = $key;
									break;
								}
							}
						}
						else{
							$idsingle = $key;
							break;
						}
					}
				}
				if($idsingle == ''){
					break;
				}
				unset($tools[$idsingle]);
				echo '
							<form name="form'. $i .'" id="form'. $i .'" method="post" action="'.$action.'">
								<!-- <input type="hidden" id="cod" name="cod" value="'.$idsingle.'"> -->
								<input type="hidden" id="cod_form'. $i .'" name="cod_form'. $i .'" value="'.$idsingle.'">
								<div class="boton" style="margin-right: 1em;">
								<input type="button" name="imprimir" value="'.$string['TPrint'].'" onclick="javascript:
								var ficha = document.getElementById(\'evalid\');
								var ventimp=window.open(\'\',\'popimpr\');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();">
								</div>
								<!-- <input type="submit" name="submit" value="'.$string['TSave'].'"> -->
				';
				
				echo "<input type='button' name='".$string['TSave']."' value='".$string['TSave']."' onclick='sendPostAssess(\"totalgrade\",\"uno=1\",\"form".$i."\",\"".$action."\");alert(\"".$string['alertsave']."\");'>";
				$global_comment = 'none';
				if($i == $countListTool){
					$global_comment = 'global_comment';
				}
				$tool->print_tool($global_comment);
				
				echo "
								</div>
								<!-- <input type='submit' name='".$string['TSave']."' value='".$string['TSave']."'> -->
								<input type='button' name='".$string['TSave']."' value='".$string['TSave']."' onclick='sendPostAssess(\"totalgrade\",\"uno=1\",\"form".$i."\",\"".$action."\");alert(\"".$string['alertsave']."\");'>
								<input type='button' onclick=\"javascript:limpiar_mainform(form".$i.")\" value='Reset'>
								<div class='boton' style='margin-right: 1em;'>
								<input type='button' name='imprimir' value='".$string['TPrint']."' onclick=\"javascript:
								var ficha = document.getElementById('evalid');
								var ventimp=window.open('','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();\">
								</div>
								   		 		
							</form>
							
							</div><br><br><hr>
				";
				++$i;
			}
//			$this->object->print_assessment_tool();
			echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": </span><span id='totalgrade'>" . $grade . "</span></div>";
			//echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": " . $grade . "</span></div>";
			
			if($saved == 'saved'){
				echo '<script type="text/javascript" language="javascript">alert("'.$string['alertsave'].'");</script>';
			}
			
			echo '
				<div class="clear"></div>
											 
					<div class="clear"></div>
					
					</body>
					
				</html>
			';
		}
		
		function view_tool_mixed($root = '', $grade = '', $title = ''){
			include('lang/'. $this->language . '/evalcomix.php');
			//$action = $root . '/assessment/webservice/services/saveassess.php?ass=' . $assessmentid . '&tool='.$idTool;
			$action = '';
			$this->view_assessment_header();
			echo '
						<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
						<script>
							function limpiar_mainform(form){
								if(confirm(\'¿Confirma que desea borrar todas las calificaciones asignadas al instrumentos?\'))
									for (i=0;i<form.elements.length;i++){
										if(form.elements[i].type == "radio" && form.elements[i].checked == true)
										  form.elements[i].checked=false;
										else if(form.elements[i].type == "textarea") form.elements[i].value = "";
								}
							}
						</script>
					</head>

					<body>
						<div class="clear"></div>
						<div class="boton" style="margin-right: 1em;">
							<!-- <input type="button" name="imprimir" value="'.$string['TPrint'].'" onclick="window.print();"> -->
							<input type="button" name="imprimir" value="Imprimir" onclick="javascript:
								var ficha = document.getElementById(\'evalid\');
								var ventimp=window.open(\'\',\'popimpr\');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();">
						</div>
						<div class="eval" id="evalid">
						<h2>'.$title.'</h2>
			';
			
			//print_r($this->object);
			$listTool = $this->object->get_tools();
			$countListTool = count($listTool) - 1;
			$i = 0;
			foreach($listTool as $tool){
				echo '
							<form name="form'. $i .'" method="post" action="'.$action.'">
				';
				
				$global_comment = 'none';
				if($i == $countListTool){
					$global_comment = 'global_comment';
				}
				$tool->print_tool($global_comment);
				
				echo "					   		 		
							</form>
							
							</div><br><br><br><hr>
				";
				++$i;
			}
//			$this->object->print_assessment_tool();
			
			echo "<div style='text-align:right;font-size:1.7em'><span>".$string['grade'].": " . $grade . "</span></div>";
			
			echo '<div class="botones">
						<div class="boton" style="margin-right: 1em;">
							<!-- <input type="button" name="imprimir" value="'.$string['TPrint'].'" onclick="window.print();"> -->
							<input type="button" name="imprimir" value="Imprimir" onclick="javascript:
								var ficha = document.getElementById(\'evalid\');
								var ventimp=window.open(\'\',\'popimpr\');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();">
						</div>
					</div>';
			
			echo '
				<div class="clear"></div>
											 
					<div class="clear"></div>
					
					</body>
					
				</html>
			';
		}
}
?>
