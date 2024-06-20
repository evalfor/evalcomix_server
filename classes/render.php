<?php
class render {
	/*
	 * This function load notifications, events or alarms
	 */
	public static function globals($params = array()) {		
		return array();
	}
	
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
		<link href="'.$path.'/styles/bootstrap/css/bootstrap502.min.css" rel="stylesheet">
		<script src="'.$path.'/js/popper.min.js"></script>
		<script src="'.$path.'/js/bootstrap.min.js"></script>
		<script src="'.$path.'/js/bootstrap.bundle.min.js"></script>
		<link rel="stylesheet" href="'.$path.'/styles/bootstrap-select-1.13.14.min.css">
		<script src="'.$path.'/js/bootstrap-select.min.js"></script>
		<link rel="stylesheet" href="'.$path.'/styles/general.css">
		<link rel="stylesheet" href="'.$path.'/styles/gototop.css">
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
		$loginhtml .= '<select class="selectpicker show-tick" onchange="location.href=location.pathname + \'?lang=\' + this.value">
			<option class="sellang" style="color:#333" value="es_utf8" '.$eslang.'>Castellano</option>
			<option class="sellang" style="color:#333" value="en_utf8" '.$enlang.'>English</option>
		</select>
		';
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
					<a href="'.WWWROOT.'/app.php/dashboard"><img src="'.WWWROOT.'/images/logoevalcomix.png" width="200"></a>
				</div>
		';

		
		$output .= render::show_path($path);
		

		$output .= '
			</div>
			
			<div id="container" class="row margin">
				<div id="column-left" class="col-sm-3">
		';
		$menutype = '';
		if (isset($params['menutype'])) {
			$menutype = $params['menutype'];
		}
		
		$output .= render::show_menu(array('menutype' => $menutype, 'root' => $root));
		$output .= '
				</div>
				
				<div id="column-right" class="col-sm-9">';
		
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
		
		require_once('csrf.class.php');
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
	
	public static function show_body_close(){
		$path = WWWROOT;
		$output = '
		 <a id="scrolltotop" class="gototop" href="#header""> 
		</a> 
		<script src="'.$path.'/js/scrolltotop.js"></script>
		<script src="'.$path.'/js/jquery.min.js"></script>
		<script src="'.$path.'/js/jquery.accordion.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
		$(function(){
			$(\'.subblock\').accordion({keepOpen:false, startingOpen: \'#open\'})
		});
		</script>
		
				</div>
			</div>';
			
		return $output;
	}
	
	public static function show_menu($params = array()) {
		$params_global = render::globals($params);
		$root = '';
		if(isset($params['root'])){
			$root = $params['root'];
		}
		$menutype = '';
		if (isset($params['menutype'])) {
			$menutype = $params['menutype'];
		}
		
		$output = '';
		
		$output .= '			
				<div class="block">
					<span>'.get_string('administration').'</span>
					<ul class="subblock" id="menu-subblock">
						<li><a href="'.WWWROOT . '/app.php/dashboard/lms">'.get_string('lmsmanager').'</a></li>
						<li><a href="'.WWWROOT.'/app.php/dashboard/password/edit">'.get_string('changepassword').'</a></li>
						<li><a href="'.WWWROOT.'/app.php/dashboard/about">'.get_string('about').'</a></li>
		';
				
		$output .= '
					</ul>
				</div>
		';
	
	/*	$role_capabilities = roleController::getCapabilities(array('roleid' => $_SESSION['roleid']));

		if($menutype == 'course'){
			$course = $params['course'];
			
			if ($role_capabilities['coursestudent:view']) {
				
				$output .= '			
				<div class="block">
					<span>'.strtoupper($course->shortname).' ADMINISTRATION</span>
					<ul class="subblock" id="menu-subblock">
				';
				
				if ($role_capabilities['coursestudent:view']) {
					$output .= '<li><a href="'.WWWCPANEL.'coursestudent/list?course='.$course->id.'">Course students</a></li>';
				}

				if ($role_capabilities['absence:view']) {
					$output .= '<li><a href="'.WWWCPANEL.'coursestudent/absence?course='.$course->id.'">Attendance list</a></li>';
				}
				
				if ($role_capabilities['enrollment:view']) {
					$output .= '<li><a href="'.WWWCPANEL.'enrollment/list?course='.$course->id.'">Enrollment</a></li>';
				}
				
				if ($role_capabilities['group:view']) {
					$output .= '<li><a href="">Groups<span class="caret"></span></a>
							<ul>';
					
					$output .= '<li><a href="'.WWWCPANEL.'coursegroup/list?course='.$course->id.'">Browse list of groups</a></li>';
					if ($role_capabilities['group:assignstudent:view']) {
						$output .= '<li><a href="'.WWWCPANEL.'coursegroup/assign?course='.$course->id.'">Assign students</a></li>';
					}
					if ($role_capabilities['group:delete']) {
						$output .= '<li><a href="'.WWWCPANEL.'coursegroup/delete?course='.$course->id.'">Delete</a></li>';
					}
					
					$output .= '
							</ul>
						</li>';
				}
						
							
				
				if ($role_capabilities['timetable:view']) {
					$output .= '
						<li><a href="">Timetable<span class="caret"></span></a>
							<ul>
								<li><a href="'.WWWCPANEL.'timetable/list?course='.$course->id.'">Design timetable</a></li>
					';
					
					if ($role_capabilities['timetable:consult']) {
						$output .= '<li><a href="'.WWWCPANEL.'timetable/consult?course='.$course->id.'">Consult timetable</a></li>';
					}
					
					$output .= '
							</ul>
						</li>
					';
					
					if ($role_capabilities['course_program:view']) {
						$output .= '<li><a href="'.WWWCPANEL.'course_program/list?course='.$course->id.'">Course Program</a></li>';
					}
				}
				
				if ($role_capabilities['report_card:view']) {
					$output .= '<li><a href="'.WWWCPANEL.'report_card/list?course='.$course->id.'">Report Cards</a></li>';
				}
				
				if ($role_capabilities['official_exam:view'] || $role_capabilities['practice_exam:view'] || $role_capabilities['internal_exam:view']) {
					$output .= '
							<li><a href="">Exams<span class="caret"></span></a>
								<ul>
					';
					
					if ($role_capabilities['internal_exam:view']) {
						$output .= '
									<li><a href="">Internal exams<span class="caret"></span></a>
										<ul>
											<li><a href="'.WWWCPANEL.'exam/internal/list?course='.$course->id.'">Browse list of internal exams</a></li>
						';
						
						if ($role_capabilities['internal_exam:delete']) {
							$output .= '
											<li><a href="'.WWWCPANEL.'exam/internal/delete?course='.$course->id.'">Delete exam</a></li>
							';
						}
						
						if ($role_capabilities['internal_exam:gradebook:view']) {
							$output .= '
											<li><a href="'.WWWCPANEL.'exam/internal/gradebook/consult?course='.$course->id.'">Gradebook</a></li>
							';
						}
						$output .= '		</ul>
									</li>';
					}
					
					if ($role_capabilities['official_exam:view'] || $role_capabilities['practice_exam:view']) {
						$output .= '<li><a href="">Official exams<span class="caret"></span></a>
										<ul>
						';
						if ($role_capabilities['practice_exam:view']) {
							$output .= '
											<li><a href="">Practice exams<span class="caret"></span></a>
												<ul>
													<li><a href="'.WWWCPANEL.'exam/practice/list?course='.$course->id.'">Browse list of practice exams</a></li>
							';
							if ($role_capabilities['practice_exam:delete']) {
								$output .= '<li><a href="'.WWWCPANEL.'exam/practice/delete?course='.$course->id.'">Delete exam</a></li>';
							}
							
							$output .= '
												</ul>
											</li>
							';
						}
						
						if ($role_capabilities['official_exam:view']) {
							$output .= '
											<li><a href="">Official exams<span class="caret"></span></a>
												<ul>
													<li><a href="'.WWWCPANEL.'exam/official/list?course='.$course->id.'">Browse list of official exams</a></li>
							';
							
							if ($role_capabilities['official_exam:delete']) {
								$output .= '
													<li><a href="'.WWWCPANEL.'exam/official/delete?course='.$course->id.'">Delete exam</a></li> ';
							}
							$output .= '
												</ul>
											</li>
							';
							if ($role_capabilities['official_exam:gradebook:view']) {
								$output .= '<li><a href="'.WWWCPANEL.'exam/official/gradebook/consult?course='.$course->id.'">Gradebook</a></li>';
							}
						}
						
						$output .= '
										</ul>
									</li>
						';
					}
					$output .= '
							</ul>
						</li>';
				}
				
				if ($role_capabilities['exportcourse:view']) {
					$output .= '<li><a href="'.WWWCPANEL.'exportcourse?course='.$course->id.'">Export course</a></li>';
				}
				
				$output .= '
					</ul>
				</div>
			';
			}
		
		}
		
		if ($role_capabilities['configuration:view'] || $role_capabilities['change_password:view']
				|| $role_capabilities['user:view'] || $role_capabilities['role:view']
			    || $role_capabilities['course:view']) {
				
			$output .= '
			<div class="block">
				<span>'.get_string('siteadministration').'</span>
				<ul class="subblock">
			';
		
			
			
			if ($role_capabilities['change_password:view']) {
				$output .= '<li><a href="'.WWWCPANEL.'/user/password/change?id='.$_SESSION['userid'].'">'.get_string('changepassword').'</a></li>';
			}
			
			if ($role_capabilities['user:view']) {
				$output .= '<li><a href="">'.get_string('users').'<span class="caret"></span></a>
							<ul>
								<li><a href="'.WWWCPANEL.'/user/list">'.get_string('userlist').'</a></li>
				';
				
				$output .= '
							</ul>
						</li>
				';
			}
			
			$output .= '
					</ul>
				</div>
			';
		}*/
		return $output;
	}
	
	
	public static function show_path($params = array()) {
		$output = '<div id="header-path" class="margin">
					<span class="margin">';
		
		$count = count($params);
		if (!empty($params) && $count > 0) {
			$i = 1;
			foreach ($params as $key => $url) {
				if ($i == $count) {
					$output .= $key;
				}
				else if (empty($url) || $url == '#') {
					$output .= $key .' > ';
				}
				else {
					$output .= '<a href="'.$url.'" class="path">'.$key.'</a> > ';
				}
				$i++;
			}
		}
		
		$output .= '	</span>
				</div>';
		
		return $output;
	}
	
	/*public static function show_button($params = array()) {
		$value = '';
		if (isset($params['value'])) {
			$value = $params['value'];
		}
		$action = '';
		if (isset($params['action'])) {
			$action = $params['action'];
		}
		$classes = '';
		if (isset($params['classes'])) {
			$classes = $params['classes'];
		}
		
		$output = '
		<div class="'.$classes.'">
			<button class="button" onclick="location.href=\''.$action.'\'">
				<span class="course-name">'. $value .'</span>
			</button>
		</div>';
		
		return $output;
	}*/

	public static function show_footer() {
		$output = '
			<hr style=" border: 1px solid #AC0600">
				
			<div class="footer">'.get_string('developedby').'</div>
		</body>
	</html>';
		
		return $output;
	}
	
	public static function input($params = array()){
		$output = '';
		
		$name = '';
		if (isset($params['name'])) {
			$name = $params['name'];
		}
		$id = '';
		if (isset($params['id'])) {
			$id = $params['id'];
		}
		
		$event = '';
		if (isset($params['event'])) {
			$event = $params['event'];
		}
		
		$class = '';
		if (isset($params['class'])) {
			$class = $params['class'];
		}
		
		$style = '';
		if (isset($params['style'])) {
			$style = $params['style'];
		}
		
		$value = '';
		if (isset($params['value'])) {
			$value = $params['value'];
		}
		
		$type = 'text';
		if (isset($params['type'])) {
			$type = $params['type'];
		}
		
		$extra = '';
		if (isset($params['extra'])) {
			$extra = $params['extra'];
		}
		
		//$output = '<input type="'.$type.'" class="text-uppercase '.$class.'" id="'.$id.'" name="'.$name.'" onblur="javascript:this.value=normalize_aux(this.value);" '.$event.' '.$style.' value="'.$value.'" '.$extra.'>';
		$output = '<input type="'.$type.'" class=" '.$class.'" id="'.$id.'" name="'.$name.'" '.$event.' '.$style.' value="'.$value.'" '.$extra.'>';
		
		return $output;	
	}
	
	/*public static function textarea($params = array()){
		$output = '';
		
		$name = '';
		if (isset($params['name'])) {
			$name = $params['name'];
		}
		$id = '';
		if (isset($params['id'])) {
			$id = $params['id'];
		}
		
		$event = '';
		if (isset($params['event'])) {
			$event = $params['event'];
		}
		
		$class = '';
		if (isset($params['class'])) {
			$class = $params['class'];
		}
		
		$style = '';
		if (isset($params['style'])) {
			$style = $params['style'];
		}
		
		$value = '';
		if (isset($params['value'])) {
			$value = $params['value'];
		}
		
		$extra = '';
		if (isset($params['extra'])) {
			$extra = $params['extra'];
		}
		
		//$output = '<textarea class="text-uppercase '.$class.'" id="'.$id.'" name="'.$name.'" onkeyup="javascript:this.value=normalize_aux(this.value);" '.$event.' '.$style.' '.$extra.'>'.$value.'</textarea>';
		$output = '<textarea class="text-uppercase '.$class.'" id="'.$id.'" name="'.$name.'" '.$event.' '.$style.' '.$extra.'>'.$value.'</textarea>';
		return $output;	
	}
	
	public static function editor_nicedit($params = array()) {
		extract($params);
		$classAux = '';
		if (isset($class)) {
			$classAux = ' class="input" ';
		}
		
		$extraAux = '';
		if (isset($extra)) {
			$extraAux = $extra;
		}
		
		$output = '
	<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
	<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() {
	
	new nicEditor({buttonList : ["left","center","right","justify","ol","ul","fontSize","fontFormat", "bold", "italic","underline"]}).panelInstance("'.$name.'");
});
  //]]>
	</script>
	<textarea '.$classAux.' id="'.$name.'" name="'.$name.'" '.$extra.'>'.$value.'</textarea>
';
		
		return $output;
	}
	
	public static function editor_tinymce($params = array()) {
		extract($params);
		$output = '';
		
		$output .= "
	<script src='//cloud.tinymce.com/stable/tinymce.min.js'></script>
	<script>
		tinymce.init({
		selector: '#".$name."'
	});
	</script>
	
	<textarea id='".$name."' name='".$name."' rows='20'>".$value."</textarea>
		";
		
		return $output;
	}*/
	
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
	
	/*public static function show_form_buttons($params = array()){
		$cancel_url = WWWROOT. 'cpanel/index.php';
		$output = '';
		$output .= '
		<div class="form-group row">
		<div class="col-sm-3 text-right"></div>
		<div class="col-sm-9">
			<button type="submit" class="btn btn-default">Save</button>
			<a href="'.$cancel_url.'" class="btn btn-default">Cancel</a>
			<p><br>There are required fields in this form marked <span class="text-danger">*</span></p>
		</div>
	</div>
		';
		
		return $output;
	}*/
	
	public static function show_script($params) {
		$output = '';
		if (isset($params['url'])) {
			$output .= '<script src="'.$params['url'].'"></script>';
		}
		return $output;
	}
	
	public static function icon($name, $title = '') {
		$result = '';
		switch ($name) {
			case 'edit': {
				$result  = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
						<title>'.$title.'</title>
						<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
						<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
					</svg>';
			}break;
			case 'search': {
				$result  = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <title>'.$title.'</title>
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
</svg>';
			}break;
			case 'delete': {
				$result  = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
  <title>'.$title.'</title>
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
</svg>';
			}break;
		}
		return $result;
	}
}
