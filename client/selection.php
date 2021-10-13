<?php
	require_once('../session/check_session.php');
	require_once('selectlanguage.php');	
	$id = getParam($_GET['identifier']);
	$new = getParam($_GET['type']);
	if(!isset($id) || !isset($new)){
		echo '
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<title>EvalCOMIX 4.3</title>
					<link href="style/copia.css" type="text/css" rel="stylesheet">
					<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
				</head>
				<body>
					<div style="margin-left:40%;border:1px solid #fff; width: 10em; padding:1em; background-color:#e2e2e2">
						Faltan Parámetros
					</div>
				</body>
			</html>
		';exit;
	}

	if($new == 'new'){
		$_SESSION['id'] = $id;	
		unset($_SESSION['open']);
		require('cabecera_select_tool.php');
?>

				<div style="margin-left: 3em"><img src="images/evalcomix.jpg" alt="EvalCOMIX 4.0"></div>
				<?php echo '<div id="titulomenu">'.$string['selecttool'].'</div>'; ?>
				<form action="generator.php" method="post">
				<?php
				echo '
					<input type="radio" name="type" id="escala" checked value="escala"/><label for="escala">'.$string['ratescale'].'</label><br>
					<input type="radio" name="type" id="listaescala" value="listaescala"/><label for="listaescala">'.$string['listrate'].'</label><br>
					<input type="radio" name="type" id="lista" value="lista"/><label for="lista">'.$string['checklist'].'</label><br>
					<input type="radio" name="type" id="rubrica" value="rubrica"/><label for="rubrica">'.$string['rubric'].'</label><br>
					<input type="radio" name="type" id="diferencial" value="diferencial"/><label for="diferencial">'.$string['differentail'].'</label><br>
					<input type="radio" name="type" id="mixta" value="mixta"/><label for="mixta">'.$string['mix'].'</label><br>
					<input type="radio" name="type" id="argumentario" value="argumentario"/><label for="argumentario">'.$string['argument'].'</label><br>
					<input type="radio" name="type" id="importar" value="importar"/><label for="importar">'.$string['import'].'</label><br>
					<input type="button" name="submit" id="submit" value="'.$string['accept'].'" onclick=\'javascript:var valores=document.getElementsByName("type");for(var i=0; i<valores.length; i++){if(valores[i].checked){tipo=valores[i].id;location.replace("generator.php?type="+tipo)/*lanzarSubmenu("generator.php?type="+tipo);*/}}\'/>
					';
				?>
				</form>
			</div>
<?php
		require('pie_select_tool.php');
	}
	elseif($new == 'open'){
		$_SESSION['id'] = $id;
		$_SESSION['open'] = 1;
		require_once('../configuration/conf.php');
		require_once('post_xml.php');
		require_once("../classes/plantilla.php");
		require_once("../classes/exporter.php");
		
		if ($plantilla = plantilla::fetch(array('pla_cod' => $id))) {
			$params['tool_id'] = $plantilla->id;
			$format = 'xml';
			$result = new exporter($params, $format);
			$xmlstring = $result->export(null);
			$xml = simplexml_load_string($xmlstring);
			require('inicio.php');
			$tool->import($xml);
			$tool->display_header();
			$tool->display_body('');
			$tool->display_footer();
			$toolObj = serialize($tool);
			$_SESSION['tool'] = $toolObj;
		} else{
			die('This Tool is not enabled');
		}
	}
?>
