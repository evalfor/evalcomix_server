<?php
class install_renderer{
	// Auxiliar function to render templates
	public static function render_template($path, array $args) {
		extract($args);
		ob_start();
		require $path;
		$html = ob_get_clean();
		
		return $html;
	}
	
	public static function show_head($params) {
		$output = '';
		
		$title = '';
		if(isset($params['title'])){
			$title = $params['title'];
		}
		$keywords = '';
		if(isset($params['keywords'])){
			$keywords = $params['keywords'];
		}
		$description = '';
		if(isset($params['description'])){
			$description = $params['description'];
		}
		$url = '';
		if(isset($params['url'])){
			$url = $params['url'];
		}
		$links = '';
		if(isset($params['links'])){
			$links = $params['links'];
		}
		$path = '';
		if(isset($params['path'])){
			$path = $params['path'];
		}
		$scripts = '';
		if(isset($params['scripts'])){
			$scripts = $params['scripts'];
		}
		$style = '';
		if(isset($params['style'])){
			$style = $params['style'];
		}	
	
		$output =  '<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>'.$title.'</title>
		<meta name="title" content="'.$title.'">
		<meta name="keywords" content="'.$keywords.'" />
		<meta name="description" content="'.$description.'" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="'.$path.'/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		
		<script src="'.$path.'/js/jquery.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
		<!-- (Optional) Latest compiled and minified JavaScript translation files -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
		<link rel="stylesheet" href="'.$path.'/styles/general.css">
		<link rel="stylesheet" href="'.$path.'/styles/gototop.css">
		<link href="//db.onlinewebfonts.com/c/0801c08e5412f54e4b4e9ad146d83a12?family=Ink+Free" rel="stylesheet" type="text/css"/>
		'.$links.'
		<script src="'.$path.'/js/ajax.js"></script>
		'.$scripts.'
		<style type="text/css">
		'.$style.'
		</style>
		
	</head>
	';
		
		return $output;
	}	
	
	public static function show_body_open($params = array()){
		extract($params);
		
		$lang = $_SESSION['lang'];
		$eslang = ($lang == 'es_utf8') ? 'selected' : '';
		$enlang = ($lang == 'en_utf8') ? 'selected' : '';
		
		$loginhtml = '<div class="text-right" style="text-align:right">';
		$loginhtml .= '<select class="selectpicker show-tick" data-size="2" onchange="location.href=location.pathname + \'?lang=\' + this.value">
			<option class="sellang" style="color:#333" value="es_utf8" '.$eslang.'>Castellano</option>
			<option class="sellang" style="color:#333" value="en_utf8" '.$enlang.'>English</option>
		</select>
		';
		$showlogin = (isset($showlogin)) ? $showlogin : false;
		
		if ($showlogin === true) {
			$loginhtml .= '
			<b>'.$username.'</b> ('.$loginaction.')';
		}
		$loginhtml .= '</div>';
		
		$output = '
	<body>
		<div id="page">
			<div id="header">
				<div id="header-main" class="margin">
					'.$loginhtml.'
					<div style="clear:both"></div>
					<a href="'.WWWROOT.'/app.php"><img src="'.WWWROOT.'/images/logoevalcomix.png" width="200"></a>
				</div>
		';

		
		//$output .= render::show_path($path);
		

		$output .= '
			</div>
			
			<div id="container" class="row margin">
		';
		
		return $output;
	}
	
	public static function show_body_close(){
		$path = WWWROOT;
		$output = '
		 <a id="scrolltotop" class="gototop" href="#header""> 
		</a> 
		<script src="'.$path.'/js/scrolltotop.js"></script>
		<script src="'.$path.'/js/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
		<script src="'.$path.'/js/jquery.accordion.js" type="text/javascript" charset="utf-8"></script>
		<script>
			(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');

			ga(\'create\', \'UA-78566346-2\', \'auto\');
			ga(\'send\', \'pageview\');

			</script>
		<script type="text/javascript" charset="utf-8">
		$(function(){
			$(\'.subblock\').accordion({keepOpen:false, startingOpen: \'#open\'})
		});
		</script>
		
				
			</div>';
			
		return $output;
	}
	
	public static function show_form_open($params = array()){
		$action = '';
		if (isset($params['action'])) {
			$action = $params['action'];
		}
		
		$method = 'post';
		if (isset($params['method'])) {
			$method = $params['method'];
		}
		
		$id = '';
		if (isset($params['id'])) {
			$id = $params['id'];
		}
		
		$name = '';
		if (isset($params['name'])) {
			$name = $params['name'];
		}
		
		$file = '';
		if (isset($params['file'])) {
			$file = 'enctype="multipart/form-data"';
		}
		
		$extra = '';
		if (isset($params['extra'])) {
			$extra = $params['extra'];
		}
		
		require_once(DIRROOT . '/classes/csrf.class.php');
		$csrf = new csrf();
		// Genera un identificador y lo valida
		$token_id = $csrf->get_token_id();
		$token_value = $csrf->get_token($token_id);
		$output = '';
		
		$output .= '<form action="'.$action.'" method="'.$method.'" name="'.$name.'" id="'.$id.'" '.$extra.' '.$file.'>
			<input type="hidden" name="'. $token_id .'" value="'.$token_value.'" />';
			
		return $output;
	}
	
	public static function show_form_close(){
		$output = '</form>';
		
		return $output;
	}
	
	public static function show_footer() {
		$output = '
			<hr style=" border: 1px solid #AC0600; margin-top:1em">
				
			<div class="footer">'.get_string('developedby').'</div>
		</body>
	</html>';
		
		return $output;
	}
	
	/*
	 * This function shows status message
	 * @param array $param['message']
	 *              $param['type'] can be 'info', 'success', 'warning', 'danger'
	 * @return string $html
	 */
	public static function show_status_message($params) {
		$output = '';
		$types = array('info', 'success', 'warning', 'danger');
		if (!empty($params['message'])) {
			$type = 'info';
			if (!empty($params['type']) && in_array($params['type'], $types)) {
				$type = $params['type'];
			}
			$output .= '<div class="alert alert-'.$type.'" role="alert">'.$params['message'].'</div>';
		}
		return $output;
	}
	
	public static function show_page_header($params){
		$output = '<div class="page-header">';
		if(isset($params['content']) && isset($params['type'])){
			$content = $params['content'];
			switch ($params['type']) {
				case 'h1': $output .= '<h1>'.$content.'</h1>';break;
				case 'h2': $output .= '<h2>'.$content.'</h2>';break;
				case 'h4': $output .= '<h4>'.$content.'</h4>';break;
				case 'h5': $output .= '<h5>'.$content.'</h5>';break;
				case 'h6': $output .= '<h6>'.$content.'</h6>';break;
				default: $output .= '<h3>'.$content.'</h3>';
			}
		}
		$output .= '</div>';
		return $output;
	}
	
}