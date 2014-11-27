<?php
/**
	It checks and cleans $variable. If $default is set, return default value
	@param $variable to check
	@param $default value
	@return $variable checked
	*/
	function getParam($variable, $default = ''){
		if(is_array($variable)){				
			return $variable;
		}
		elseif(isset($variable))
			return htmlentities($variable, ENT_QUOTES, "UTF-8");
		else
			return $default;
	}
/**
It checks if a param exists, in this case return de param value, in other case return a default value
@param string $param the param to check
@param string $default the default value
*/
	function get_param($param, $default = '')
	{
		if($param == '')
		{
			return $default;
		}
		else
		{
			return $param;
		}
	}

/**
Redirect the user to another page
@param string $url the URL to take the user to
*/
	function redirect($url)
	{
		@header($_SERVER['SERVER_PROTOCOL'] . ' 303 See Other'); //302 might not work for POST requests, 303 is ignored by obsolete clients
              	@header('Location: '.$url);
              	echo '<meta http-equiv="refresh" content="'. $delay .'; url='. $encodedurl .'" />';
              	echo '<script type="text/javascript">'. "\n" .'//<![CDATA['. "\n". "location.replace('$url');". "\n". '//]]>'. "\n". '</script>';   // To cope with Mozilla bug
              	die;
	}
	
/**
It Checks if the param is a valid language
@param string $language
**/
	function is_valid_language($language){
		if($language == 'es_utf8' || $language == 'es_es_utf8' || $language == 'en_utf8'){
			return true;
		}
		return false;
	}

/**
$param string $str 
Calculate the hash of $str	
*/
	function encrypt_tool_element($str){
		include_once('../configuration/host.php');
		return md5(sha1(HOST.$str));
	}

	
?>
