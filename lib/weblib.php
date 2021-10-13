<?php

/**
 * PARAM_SAFEDIR - safe directory name, suitable for include() and require()
 */
define('PARAM_SAFEDIR',  'safedir');

/**
 * PARAM_EMAIL - an email address following the RFC
 */
define('PARAM_EMAIL',   'email');

/**
 * PARAM_FILE - safe file name, all dangerous chars are stripped, protects against XSS, SQL injections and directory traversals
 */
define('PARAM_FILE',   'file');

/**
 * PARAM_FLOAT - a real/floating point number.
 *
 * Note that you should not use PARAM_FLOAT for numbers typed in by the user.
 * It does not work for languages that use , as a decimal separator.
 * Use PARAM_LOCALISEDFLOAT instead.
 */
define('PARAM_FLOAT',  'float');

/**
 * PARAM_HOST - expected fully qualified domain name (FQDN) or an IPv4 dotted quad (IP address)
 */
define('PARAM_HOST',     'host');

/**
 * PARAM_INT - integers only, use when expecting only numbers.
 */
define('PARAM_INT',      'int');

/**
 * PARAM_LANG - checks to see if the string is a valid installed language in the current site.
 */
define('PARAM_LANG',  'lang');

/**
 * PARAM_PATH - safe relative path name, all dangerous chars are stripped, protects against XSS, SQL injections and directory
 * traversals note: the leading slash is not removed, window drive letter is not allowed
 */
define('PARAM_PATH',     'path');

/**
 * PARAM_RAW specifies a parameter that is not cleaned/processed in any way except the discarding of the invalid utf-8 characters
 */
define('PARAM_RAW', 'raw');

/**
 * PARAM_TEXT - general plain text compatible with multilang filter, no other html tags. Please note '<', or '>' are allowed here.
 */
define('PARAM_TEXT',  'text');

/**
 * PARAM_URL - expected properly formatted URL. Please note that domain part is required, http://localhost/ is not accepted but
 * http://localhost.localdomain/ is ok.
 */
define('PARAM_URL',      'url');

/**
 * PARAM_INTEGER - deprecated alias for PARAM_INT
 * @deprecated since 2.0
 */
define('PARAM_INTEGER',  'int');

/**
 * PARAM_NUMBER - deprecated alias of PARAM_FLOAT
 * @deprecated since 2.0
 */
define('PARAM_NUMBER',  'float');

/**
 * PARAM_ALPHA - contains only English ascii letters [a-zA-Z].
 */
define('PARAM_ALPHA',    'alpha');

/**
 * PARAM_ALPHANUM - expected numbers 0-9 and English ascii letters [a-zA-Z] only.
 */
define('PARAM_ALPHANUM', 'alphanum');


/**
 * PARAM_BOOL - converts input into 0 or 1, use for switches in forms and urls.
 */
define('PARAM_BOOL',     'bool');

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
function get_param($name, $type, $optional = 'required', $default = null) {
	// POST has precedence.
	if (isset($_POST[$name])) {
		$param = $_POST[$name];
	} else if (isset($_GET[$name])) {
		$param = $_GET[$name];
	} else {
		if ($optional == 'required') {
			throw new Exception('Missing parameter');
		} else {
			return $default;
		}
	}
	
	return clean_param($param, $type);
}

/**
 * @param mixed $param the variable we are cleaning
 * @param string $type expected format of param after cleaning.
 * @return mixed
 * @throws coding_exception
 */
function clean_param($param, $type) {
    global $CFG;

    if (is_array($param)) {
        throw new Exception('clean_param() can not process arrays.');
    } else if (is_object($param)) {
        if (method_exists($param, '__toString')) {
            $param = $param->__toString();
        } else {
            throw new Exception('clean_param() can not process objects');
        }
    }

    switch ($type) {
        case PARAM_RAW:
            // No cleaning at all.
            $param = fix_utf8($param);
            return $param;

        case PARAM_INT:
            // Convert to integer.
            return (int)$param;

        case PARAM_FLOAT:
            // Convert to float.
            return (float)$param;
			
		case PARAM_ALPHANUM:
            // Remove everything not `a-zA-Z0-9`.
            return preg_replace('/[^A-Za-z0-9]/i', '', $param);
			
        case PARAM_ALPHA:
            // Remove everything not `a-z`.
            return preg_replace('/[^a-zA-Z]/i', '', $param);

        case PARAM_ALPHANUM:
            // Remove everything not `a-zA-Z0-9`.
            return preg_replace('/[^A-Za-z0-9]/i', '', $param);

        case PARAM_BOOL:
            // Convert to 1 or 0.
            $tempstr = strtolower($param);
            if ($tempstr === 'on' or $tempstr === 'yes' or $tempstr === 'true') {
                $param = 1;
            } else if ($tempstr === 'off' or $tempstr === 'no'  or $tempstr === 'false') {
                $param = 0;
            } else {
                $param = empty($param) ? 0 : 1;
            }
            return $param;

        case PARAM_TEXT:
            // Leave only tags needed for multilang.
            $param = fix_utf8($param);
            // If the multilang syntax is not correct we strip all tags because it would break xhtml strict which is required
            // for accessibility standards please note this cleaning does not strip unbalanced '>' for BC compatibility reasons.
            do {
                if (strpos($param, '</lang>') !== false) {
                    // Old and future mutilang syntax.
                    $param = strip_tags($param, '<lang>');
                    if (!preg_match_all('/<.*>/suU', $param, $matches)) {
                        break;
                    }
                    $open = false;
                    foreach ($matches[0] as $match) {
                        if ($match === '</lang>') {
                            if ($open) {
                                $open = false;
                                continue;
                            } else {
                                break 2;
                            }
                        }
                        if (!preg_match('/^<lang lang="[a-zA-Z0-9_-]+"\s*>$/u', $match)) {
                            break 2;
                        } else {
                            $open = true;
                        }
                    }
                    if ($open) {
                        break;
                    }
                    return $param;

                } else if (strpos($param, '</span>') !== false) {
                    // Current problematic multilang syntax.
                    $param = strip_tags($param, '<span>');
                    if (!preg_match_all('/<.*>/suU', $param, $matches)) {
                        break;
                    }
                    $open = false;
                    foreach ($matches[0] as $match) {
                        if ($match === '</span>') {
                            if ($open) {
                                $open = false;
                                continue;
                            } else {
                                break 2;
                            }
                        }
                        if (!preg_match('/^<span(\s+lang="[a-zA-Z0-9_-]+"|\s+class="multilang"){2}\s*>$/u', $match)) {
                            break 2;
                        } else {
                            $open = true;
                        }
                    }
                    if ($open) {
                        break;
                    }
                    return $param;
                }
            } while (false);
            // Easy, just strip all tags, if we ever want to fix orphaned '&' we have to do that in format_string().
            return strip_tags($param);

        case PARAM_FILE:
            // Strip all suspicious characters from filename.
            $param = fix_utf8($param);
            $param = preg_replace('~[[:cntrl:]]|[&<>"`\|\':\\\\/]~u', '', $param);
            if ($param === '.' || $param === '..') {
                $param = '';
            }
            return $param;

        case PARAM_PATH:
            // Strip all suspicious characters from file path.
            $param = fix_utf8($param);
            $param = str_replace('\\', '/', $param);

            // Explode the path and clean each element using the PARAM_FILE rules.
            $breadcrumb = explode('/', $param);
            foreach ($breadcrumb as $key => $crumb) {
                if ($crumb === '.' && $key === 0) {
                    // Special condition to allow for relative current path such as ./currentdirfile.txt.
                } else {
                    $crumb = clean_param($crumb, PARAM_FILE);
                }
                $breadcrumb[$key] = $crumb;
            }
            $param = implode('/', $breadcrumb);

            // Remove multiple current path (./././) and multiple slashes (///).
            $param = preg_replace('~//+~', '/', $param);
            $param = preg_replace('~/(\./)+~', '/', $param);
            return $param;

        case PARAM_HOST:
            // Allow FQDN or IPv4 dotted quad.
            $param = preg_replace('/[^\.\d\w-]/', '', $param );
            // Match ipv4 dotted quad.
            if (preg_match('/(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})/', $param, $match)) {
                // Confirm values are ok.
                if ( $match[0] > 255
                     || $match[1] > 255
                     || $match[3] > 255
                     || $match[4] > 255 ) {
                    // Hmmm, what kind of dotted quad is this?
                    $param = '';
                }
            } else if ( preg_match('/^[\w\d\.-]+$/', $param) // Dots, hyphens, numbers.
                       && !preg_match('/^[\.-]/',  $param) // No leading dots/hyphens.
                       && !preg_match('/[\.-]$/',  $param) // No trailing dots/hyphens.
                       ) {
                // All is ok - $param is respected.
            } else {
                // All is not ok...
                $param='';
            }
            return $param;

        case PARAM_URL:
            // Allow safe urls.
            $param = fix_utf8($param);
            include_once($CFG->dirroot . '/lib/validateurlsyntax.php');
            if (!empty($param) && validateUrlSyntax($param, 's?H?S?F?E-u-P-a?I?p?f?q?r?')) {
                // All is ok, param is respected.
            } else {
                // Not really ok.
                $param ='';
            }
            return $param;

        case PARAM_LANG:
            $param = clean_param($param, PARAM_SAFEDIR);
            if (get_string_manager()->translation_exists($param)) {
                return $param;
            } else {
                // Specified language is not installed or param malformed.
                return '';
            }

        default:
            // Doh! throw error, switched parameters in optional_param or another serious problem.
            throw new Exception('clean_param() unknown param type.');
    }
}

/**
 * Makes sure the data is using valid utf8, invalid characters are discarded.
 *
 * Note: this function is not intended for full objects with methods and private properties.
 *
 * @param mixed $value
 * @return mixed with proper utf-8 encoding
 */
function fix_utf8($value) {
    if (is_null($value) or $value === '') {
        return $value;

    } else if (is_string($value)) {
        if ((string)(int)$value === $value) {
            // Shortcut.
            return $value;
        }
        // No null bytes expected in our data, so let's remove it.
        $value = str_replace("\0", '', $value);

        // Note: this duplicates min_fix_utf8() intentionally.
        static $buggyiconv = null;
        if ($buggyiconv === null) {
            $buggyiconv = (!function_exists('iconv') or @iconv('UTF-8', 'UTF-8//IGNORE', '100'.chr(130).'€') !== '100€');
        }

        if ($buggyiconv) {
            if (function_exists('mb_convert_encoding')) {
                $subst = mb_substitute_character();
                mb_substitute_character('');
                $result = mb_convert_encoding($value, 'utf-8', 'utf-8');
                mb_substitute_character($subst);

            } else {
                // Warn admins on admin/index.php page.
                $result = $value;
            }

        } else {
            $result = @iconv('UTF-8', 'UTF-8//IGNORE', $value);
        }

        return $result;

    } else if (is_array($value)) {
        foreach ($value as $k => $v) {
            $value[$k] = fix_utf8($v);
        }
        return $value;

    } else if (is_object($value)) {
        // Do not modify original.
        $value = clone($value);
        foreach ($value as $k => $v) {
            $value->$k = fix_utf8($v);
        }
        return $value;

    } else {
        // This is some other type, no utf-8 here.
        return $value;
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
		if (file_exists('../configuration/conf.php')) {
			require_once('../configuration/conf.php');
		} else {
			require_once(__DIR__.'/../configuration/conf.php');
		}
		return md5(sha1(WWWROOT.$str));
	}