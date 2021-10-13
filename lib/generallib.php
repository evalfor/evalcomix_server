<?php
/**
 * Library with general porpouse functions and constants
 * @author Daniel Cabeza Sánchez <info@ansaner.net>
 */


/**
 * Converts an array of strings to their localized value.
 *
 * @param string $identifier The identifier of the string to search for
 * @param string|object|array $a An object, string or number that can be used
 *      within translation strings
 * @return string The String !
 */
function get_string($identifier, $a = null) {
	$dictionary = array();
	$strings = array();
	if (isset($_SESSION['lang'])){
		$lang = (string)$_SESSION['lang'];
		if (!file_exists(DIRROOT .'/lang/'.$lang.'/dictionary.php')){
			$dictionary = array();
		} else {
			require_once(DIRROOT .'/lang/'.$lang.'/dictionary.php');
			global $strings;
			$dictionary = $strings;
		}
	} else {
		if (!file_exists(DIRROOT .'/lang/'.$lang.'/dictionary.php')){
			$dictionary = array();
		} else {
			require_once(DIRROOT .'/lang/'.$lang.'/dictionary.php');
			$dictionary = $strings;
		}
	}
	
	if (!isset($dictionary[$identifier])) {
		return '';
	}
	$string = $dictionary[$identifier];
	
	if ($a !== null) {
		// Process array's and objects (except lang_strings).
        if (is_array($a) or (is_object($a))) {
            $a = (array)$a;
            $search = array();
            $replace = array();
            foreach ($a as $key => $value) {
                if (is_int($key)) {
                    // We do not support numeric keys - sorry!
                    continue;
                }
                if (is_array($value) or (is_object($value))) {
                    // We support just string or lang_string as value.
                    continue;
                }
                $search[]  = '{$a->'.$key.'}';
                $replace[] = (string)$value;
            }
            if ($search) {
                $string = str_replace($search, $replace, $string);
            }
        } else {
            $string = str_replace('{$a}', (string)$a, $string);
        }
    }
    return $string;
}

function download($params = array()) {
	if (!empty($params['fileName'])) {
		$fileName = $params['fileName'];
		if (file_exists($fileName)) {
			$mime = get_mime_type($fileName);
			if (isset($params['mime'])) {
				$mime = $params['mime'];
			}
			$filenameDownload = $fileName;
			if (isset($params['filenameDownload'])) {
				$filenameDownload = $params['filenameDownload'];
			}
			header("Content-Disposition: attachment; filename=$filenameDownload");
			header("Content-type:".$mime);
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
			header("Pragma: public");
			readfile($fileName);
			exit;
		}
	}
}

function get_mime_type($filename){
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mimetype = finfo_file($finfo, $filename);
	finfo_close($finfo);
	return $mimetype;
}

// Function to get the client ip address
function get_client_ip_env() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

function uploadfile($file, $path = "../uploads/", $index = null){
    $uploadedfileload="true";
    $file_size = $file_error = $file_name = $file_tmp= '';
    if($index == null){
        $file_name=$_FILES[$file]['name'];
        $file_error = $_FILES[$file]['error'];
        $file_size = $_FILES[$file]['size'];
        $file_tmp = $_FILES[$file]['tmp_name'];
    }
    elseif(is_numeric($index)){
        $file_name=$_FILES[$file]['name'][$index];
        $file_error = $_FILES[$file]['error'][$index];
        $file_size = $_FILES[$file]['size'][$index];
        $file_tmp = $_FILES[$file]['tmp_name'][$index];
    }
    
    $uploadedfile_size = $file_size;
    $error = '';
    $msg = '';
     switch( $file_error ) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error .= ' - file too large.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $error .= ' - file upload was not completed.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $error .= ' - zero-length file uploaded.';
                break;
            default:
                $error .= ' - internal error #'.$_FILES['newfile']['error'];
                break;
    }
    if(!empty($error)){
        echo "<div style='color:#f00'>".$error."</div>";
        return 0;
    }
    
    if ($file_size > 5000000){
        $msg=$msg."<div style='color:#f00'>El archivo es mayor que 200KB, debes reduzcirlo antes de subirlo</div><BR>";
        $uploadedfileload="false";
    }
    
    $add = $path.$file_name;
    if($uploadedfileload=="true"){
        if(move_uploaded_file ($file_tmp, $add)){
            return 1;
        }
        else{
            echo "<div style='color:#f00;margin:0.7em 0 0 2em'>Error al subir el archivo</div><hr>";
        }
    }
    else{
        echo "<div style='color:#f00;margin:0.7em 0 0 2em'>".$msg."</div><hr>";
    }
    return 0;
}

function modal($content, $id){
    echo '<div class="modal fade" id="'.$id.'" role="dialog">
		<div class="modal-dialog modal-lg">
			
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					'.$content.'
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>				  
		</div>
	</div>
  ';
}
