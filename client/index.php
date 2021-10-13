<?php
	require_once('selectlanguage.php');	
	$curso = getParam($_GET['cur']);
	$plataforma = getParam($_GET['plt']);
	if(!isset($curso) || !isset($plataforma)){
		echo '
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<title>EvalCOMIX 3.2</title>
					<link href="style/copia.css" type="text/css" rel="stylesheet">
				</head>
				<body>
					<div style="margin-left:40%;border:1px solid #fff; width: 10em; padding:1em; background-color:#e2e2e2">
						Faltan Parámetros
					</div>
				</body>
			</html>
		';exit;
	}
	$_SESSION['curso'] = $curso;
	$_SESSION['plataforma'] = $plataforma;
	require('cabecera_select_tool.php');
?>

				<div id="titulomenu">Elija el tipo de instrumento a crear</div>
				<form action="generator.php" method="post">
				<?php
					echo '
					<input type="radio" name="type" id="escala" checked value="escala"/><label for="escala">'.$string['ratescale'].'</label><br>
					<input type="radio" name="type" id="listaescala" value="listaescala"/><label for="listaescala">'.$string['listrate'].'</label><br>
					<input type="radio" name="type" id="lista" value="lista"/><label for="lista">'.$string['checklist'].'</label><br>
					<input type="radio" name="type" id="rubrica" value="rubrica"/><label for="rubrica">'.$string['rubric'].'</label><br>
					<input type="radio" name="type" id="diferencial" value="diferencial"/><label for="diferencial">'.$string['differentail'].'</label><br>
					<input type="radio" name="type" id="mixta" value="mixta"/><label for="mixta">'.$string['mix'].'</label><br>
					<input type="radio" name="type" id="importar" value="importar"/><label for="importar">'.$string['import'].'</label><br>
					<input type="submit" name="submit" id="submit" value=""/>
					';
				?>
				</form>
			</div>
<?php
	require('pie_select_tool.php');
?>