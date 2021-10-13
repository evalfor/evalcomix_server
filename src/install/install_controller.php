<?php
require_once('renderer.php');

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

define('DIRROOT_IS_NOT_CONFIGURED_PROPERLY', 0);
define('WWWROOT_IS_NOT_CONFIGURED_PROPERLY', 1);

class install_controller {
	public static function display_landpage_action($statusmessage = '', $format = true){
		$title = get_string('install');
		if (empty($statusmessage)) {
			$statusmessage = get_string('successfullyinstalled');
		}
		
		$html = $statusmessage;
		$dashboard = false;
		$username = user_controller::get_username();
		$loginaction = user_controller::get_loginaction();
		if (user_controller::check_session()) {
			$dashboard = true;
		}
		
		if ($format) {
			$html = install_renderer::render_template('src/install/install_success_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'dashboard' => $dashboard, 'username' => $username, 'loginaction' => $loginaction));
		}		
		return new Response($html);
	}
	
	public static function check_action(){
		if (self::configfile_exists_action()) {
			$checkconfigfile = self::check_configfile_action();
			if (self::check_configfile_action() === true) {
				require_once(__DIR__ . '/../../configuration/conf.php');
				if (self::db_validate_action(TYPEDB, HOSTDB, USERDB, PASSDB, NAMEDB)) {
					if (!self::check_upgrade_required()) {
						if (self::db_validate_tables_action(TYPEDB, HOSTDB, USERDB, PASSDB, NAMEDB)) {
							if (self::environment_meets_requirements_action()) {
								if (self::test_install_action() === true) {
									if (!self::admin_user_exist()) {
										return false;
									}
								} else {
									throw new Exception(get_string('exceptioninstall'));
								}
							} else {
								return false;
							}
						} else {
							return false;
						}
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
		
		return true;
	}
	
	public static function check_configfile_action() {
		require_once(__DIR__ . '/../../configuration/conf.php');
		
		if (defined('DIRROOT')) {
			$dirroot = trim(DIRROOT);
			if (empty($dirroot)) {
				return DIRROOT_IS_NOT_CONFIGURED_PROPERLY;
			}
			
			if (!is_dir(DIRROOT)) {
				return DIRROOT_IS_NOT_CONFIGURED_PROPERLY;
			}
		} else {
			return DIRROOT_IS_NOT_CONFIGURED_PROPERLY;
		}
		
		if (defined('WWWROOT')) {
			$wwwroot = trim(WWWROOT);
			if (empty($wwwroot)) {
				return WWWROOT_IS_NOT_CONFIGURED_PROPERLY;
			}
		} else {
			return WWWROOT_IS_NOT_CONFIGURED_PROPERLY;
		}
		
		return true;
	}
	
	public static function check_upgrade_required() {
		require_once(DIRROOT . '/classes/db.php');
		require_once(DIRROOT . '/version.php');
		global $version;
		$oldversion = 0;

		$sql = 'SELECT * FROM config WHERE name = "version"';
		try{
			if($result = DB::query($sql)){
				$row = $result->fetch();
				$oldversion = (int)$row['value'];
			}
		}
		catch(Exception $e){
			$oldversion = 0;
		}
		
		if ((int)$oldversion >= (int)$version) {
			return 0;
		}
		
		return $oldversion;
	}
	
	public static function install_action(){
		$request = Request::createFromGlobals();
		
		if (!$lang = $request->query->get('lang')) {
			$lang = $_SESSION['lang'];
		}
		
		if (self::configfile_exists_action()) {
			require_once(__DIR__ . '/../../configuration/conf.php');
			$checkconfigfile = self::check_configfile_action();
			if ($checkconfigfile === true) {
				if (self::db_validate_action(TYPEDB, HOSTDB, USERDB, PASSDB, NAMEDB)) {
					if (self::db_validate_tables_action(TYPEDB, HOSTDB, USERDB, PASSDB, NAMEDB)) {
						if (self::environment_meets_requirements_action()) {
							if (!self::admin_user_exist()) {
								return self::install_stage03_action();
							}
						} else {
							return self::install_check_environment_action();
						}
					} else {
						return self::install_stage02_action();
					}
				} else {
					$statusmessage = get_string('dbconnectionfailure');
					return self::display_landpage_action($statusmessage);
				}
			} else {
				if ($checkconfigfile === DIRROOT_IS_NOT_CONFIGURED_PROPERLY) {
					$statusmessage = 'DIRROOT is not configured properly, directory does not exist or is not accessible! Exiting.';
					return self::display_landpage_action($statusmessage, false);
				} else if ($checkconfigfile === WWWROOT_IS_NOT_CONFIGURED_PROPERLY) {
					$statusmessage = 'WWWROOT is not configured properly! Exiting.';
					return self::display_landpage_action($statusmessage, false);
				}
			}
		} else {
			return self::install_stage01_action($lang);
		}
	}
	
	private static function install_stage01_action($lang) {
		$request = Request::createFromGlobals();
		
		$title = get_string('install');
		$statusmessage = '';
		
		$substage = $request->request->get('substage');

		if (!$substage) {
			$html = install_renderer::render_template('src/install/install_stage-1-0_view.php', array('title' => $title,
			'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'lang' => $lang));
		} else if ($substage == '1') {
			$html = install_renderer::render_template('src/install/install_stage-1-1_view.php', array('title' => $title,
			'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'lang' => $lang));
		} else if ($substage == '2') {
			$driver = trim($request->request->get('driver'));
			$dbhost = trim($request->request->get('databasehost'));
			$dbname = trim($request->request->get('databasename'));
			$dbuser = trim($request->request->get('databaseuser'));
			$dbpass = trim($request->request->get('databasepass'));
			
			if (!empty($driver) && !empty($dbhost) && !empty($dbname) && !empty($dbuser) && !empty($dbpass)) {
				if (self::db_validate_action($driver, $dbhost, $dbuser, $dbpass, $dbname)) {
					$_SESSION['driver'] = $driver;
					$_SESSION['dbhost'] = $dbhost;
					$_SESSION['dbname'] = $dbname;
					$_SESSION['dbuser'] = $dbuser;
					$_SESSION['dbpass'] = $dbpass;
					
					$checks = self::check_environment();
					
					$html = install_renderer::render_template('src/install/install_stage-1-2_view.php', array('title' => $title,
					'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'lang' => $lang,
					'checks' => $checks));
				} else {
					$statusmessage = get_string('dbconnectionerror');
					$html = install_renderer::render_template('src/install/install_stage-1-1_view.php', array('title' => $title,
					'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'driver' => $driver,
					'dbhost' => $dbhost, 'dbname' => $dbname, 'dbuser' => $dbuser, 'dbpass' => $dbpass));
				}
			} else {
				$statusmessage = get_string('emptyfieldsdb');
				$html = install_renderer::render_template('src/install/install_stage-1-1_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'lang' => $lang, 'driver' => $driver,
					'dbhost' => $dbhost, 'dbname' => $dbname, 'dbuser' => $dbuser, 'dbpass' => $dbpass));
			}	
		} else if ($substage == '3') {
			if (!isset($_SESSION['dbhost']) || !isset($_SESSION['dbuser']) || !isset($_SESSION['dbpass'])
				|| !isset($_SESSION['dbname']) || !isset($_SESSION['driver'])) {
				$statusmessage = get_string('missingsession');
				$html = install_renderer::render_template('src/install/install_stage-1-0_view.php', array('title' => $title,
				'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'lang' => $lang));
			} else {
				$params = array(
					'HOSTDB' => $_SESSION['dbhost'],
					'USERDB' => $_SESSION['dbuser'],
					'PASSDB' => $_SESSION['dbpass'],
					'NAMEDB' => $_SESSION['dbname'],
					'DIRROOT' => realpath(DIRROOT),
					'TYPEDB' => $_SESSION['driver'],
					'WWWROOT' => WWWROOT,
					'WWWCPANEL' => WWWROOT . '/app.php/dashboard',
					'SITENAME' => 'EvalCOMIX Server',
				);
				$configphp = self::generate_configphp($params);
				$filename = DIRROOT . '/configuration/conf.php';
				$dirname = DIRROOT . '/configuration';
				$error = false;
				if (is_writable($dirname)) {
					 if (!$handle = fopen($filename, 'w')) {
						 $error = true;
					 }
					if (fwrite($handle, $configphp) === FALSE) {
						$error = true;
					}
					
					fclose($handle);
				} else {
					$error = true;
				}
				
				if ($error) {
					$statusmessage = get_string('configisnotwritable');
					$html = install_renderer::render_template('src/install/install_stage-1-3_view.php', array('title' => $title,
					'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'configphp' => $configphp));
				} else {
					return new RedirectResponse(WWWROOT . '/index.php', 302);
				}
			}
		}
		
		return new Response($html);
	}
	
	private static function install_stage02_action() {
		$request = Request::createFromGlobals();
		
		$title = get_string('install');
		$statusmessage = '';
		
		$result = self::install_database();
		require_once(DIRROOT . '/lib/upgradelib.php');
		require_once(DIRROOT . '/version.php');
		global $version;
		upgrade_evalcomix_savepoint($version);
		
		$html = install_renderer::render_template('src/install/install_stage-2-0_view.php', array('title' => $title,
					'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'result' => $result));
					
		return new Response($html);
	}
	
	private static function install_stage03_action() {
		$request = Request::createFromGlobals();
		
		$title = get_string('install');
		$statusmessage = '';
		
		$substage = $request->request->get('usersubstage');
		$html = '';
		if (!$substage) {
			$html = install_renderer::render_template('src/install/install_stage-3-0_view.php', array('title' => $title,
						'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'changepassword' => false));
		} else {
			require_once(DIRROOT . '/src/user/user_controller.php');

			$username = htmlentities(trim($request->request->get('username')));
			$firstname = htmlentities(trim($request->request->get('firstname')));
			$lastname = htmlentities(trim($request->request->get('lastname')));
			$password = trim($request->request->get('password'));
			
			if (!empty($username) && !empty($password) && !empty($firstname) && !empty($lastname)) {
				$userparams = array('username' => $username, 'password' => $password,'firstname' => $firstname,
					'lastname' => $lastname);
				$userid = user_controller::insert_user_action($userparams);
				$statusmessage = get_string('usercreatedsuccessfully');
				return self::display_landpage_action($statusmessage);
			} else {
				$statusmessage = get_string('errorrequiredfields');
				$html = install_renderer::render_template('src/install/install_stage-3-0_view.php', array('title' => $title,
						'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php'));
			}
		}			
		return new Response($html);
	}
	
	private static function install_check_environment_action() {
		$title = get_string('install');
		$statusmessage = '';
		$checks = self::check_environment();
			
		$html = install_renderer::render_template('src/install/install_stage-1-2_view.php', array('title' => $title,
		'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'checks' => $checks));
		return new Response($html);
	}
	
	public static function environment_meets_requirements_action() {
		$checks = self::check_environment();
		
		foreach ($checks['extra'] as $name => $status) {
			if (!$status) {
				return false;
			}
		}
		foreach ($checks['phpextensions'] as $name => $status) {
			if (!$status) {
				return false;
			}
		}
		
		return true;
	}
	
	private static function check_environment() {
		$result = array(
			'tempdir' => false,
			'phpextensions' => array()
		);
		
		if (self::tempdir_is_writable()) {
			$result['extra']['tempdir'] = true;
		} else {
			$result['extra']['tempdir'] = false;
		}
		
		if (version_compare(PHP_VERSION, '7.2.5') < 0) {
			$result['extra']['phpversion'] = false;
		} else {
			$result['extra']['phpversion'] = true;
		}

		// Check PHP extensions
		$phpextensions = array('curl', 'simplexml', 'libxml', 'tokenizer', 'session', 'ctype', 'iconv');
		foreach ($phpextensions as $extension) {
			if (!extension_loaded($extension)) {
				$result['phpextensions'][$extension] = false;
			} else {
				$result['phpextensions'][$extension] = true;
			}				
		}
		return $result;
	}
	
	/**
	 * Check if /configuration/conf.php exists
	 * @return bool
	 */
	public static function configfile_exists_action() {
		$configfile = __DIR__ .'/../../configuration/conf.php';
		if (!file_exists($configfile)) {
			return false;
		}
		return true;
	}
	
	/**
	 * Returns content of conf.php file.
	 *
	 * Uses PHP_EOL for generating proper end of lines for the given platform.
	 *
	 * @param array $params
	 * @return string
	 */
	public static function generate_configphp($params) {
		$configphp = '<?php  // EvalCOMIX configuration file' . PHP_EOL . PHP_EOL;

		foreach ($params as $key=>$value) {
			if ($key === 'TYPEDB') {
				$configphp .= '// Possible values: \'postgresql\' or \'mysql\'' . PHP_EOL;
			}
			if ($key === 'WWWROOT') {
				$configphp .= '// Full web address to where EvalCOMIX has been installed. Do not include a trailing slash.' . PHP_EOL;
			}
			if ($key === 'WWWCPANEL') {
				$configphp .= '// Control panel URI.' . PHP_EOL;
			}
			$configphp .= 'if(!defined("'.$key.'")){' . PHP_EOL;
			$configphp .= '    define("'.$key.'", "'.$value.'");' . PHP_EOL;
			$configphp .= '}' . PHP_EOL . PHP_EOL;
		}

		$configphp .= '// There is no php closing tag in this file,' . PHP_EOL;
		$configphp .= '// it is intentional because it prevents trailing whitespace problems!' . PHP_EOL;

		return $configphp;
	}
	
	/**
	 * Check if /client/temp is writable
	 * @return bool
	 */
	public static function tempdir_is_writable() {
		$tempdir = '';
		if (defined('DIRROOT')) {
			$tempdir = DIRROOT .'/client/temp';
		} else {
			$tempdir = __DIR__ .'/../../client/temp';
		}
		if (!is_writable($tempdir)) {
			return false;
		}
		return true;
	}
	
	/**
	 * @param string $driver
	 * @param string $dbhost
	 * @param string $dbuser
	 * @param string $dbpass
	 * @param string $dbname
	 * @return bool
	 */
	public static function db_validate_action($driver, $dbhost, $dbuser, $dbpass, $dbname) {
		$dirroot = '';
		if (defined(DIRROOT)) {
			$dirroot = DIRROOT;
		} else {
			$dirroot = __DIR__ . '/../..';
		}
		require_once($dirroot . '/classes/pdo_database.php');
		
		try {
			$dbparams = array('dbtype' => $driver, 'dbhost' => $dbhost, 'dbuser' => $dbuser, 'dbpass' => $dbpass,
				'dbname' => $dbname, 'throw' => true);
			$connection = new pdo_database($dbparams);
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	public static function db_validate_tables_action($driver, $dbhost, $dbuser, $dbpass, $dbname) {
		$dirroot = '';
		if (defined(DIRROOT)) {
			$dirroot = DIRROOT;
		} else {
			$dirroot = __DIR__ . '/../..';
		}
		require_once($dirroot . '/classes/pdo_database.php');
		
		try {
			$dbparams = array('dbtype' => $driver, 'dbhost' => $dbhost, 'dbuser' => $dbuser, 'dbpass' => $dbpass,
				'dbname' => $dbname, 'throw' => true);
			$connection = new pdo_database($dbparams);
			
			$error = false;
			$xmlstring = file_get_contents($dirroot . '/db/install.xml');
			if ($xml = simplexml_load_string($xmlstring)){
				foreach ($xml->TABLES->TABLE as $table) {
					if ($tablename = (string)$table['NAME']) {
						if (!$connection->table_exists(array('tablename' => $tablename))) {
							return false;
						}
					}
				}
			}
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	private static function install_database() {
		require_once(DIRROOT . '/classes/dblib/evalcomix_table.php');
		require_once(DIRROOT . '/classes/dblib/evalcomix_constant.php');
		require_once(DIRROOT . '/lib/upgradelib.php');
		require_once(DIRROOT . '/classes/db.php');
		
		$result = array();
		
		$xmlstring = file_get_contents(DIRROOT . '/db/install.xml');
		if ($xml = simplexml_load_string($xmlstring)){
			foreach ($xml->TABLES->TABLE as $table) {
				if ($tablename = (string)$table['NAME']) {
					$tableobj = new evalcomix_table(array('name' => $tablename));
					if (DB::table_exists(array('tablename' => $tablename))) {
						$result[$tablename] = 0;
						continue;
					}
					foreach ($table->FIELDS->FIELD as $field) {
						$fieldname = (string)$field['NAME'];
						$type = (string)$field['TYPE'];
						if(!$tableobj->field_exist($fieldname)){
							$fieldparams = array(
											'name' => $fieldname,
											'type' => evalcomix_table::get_type($type),
											'precision' => (string)$field['LENGTH'],
											);
							if (isset($field['DEFAULT'])) {
								$fieldparams['default'] = (string)$field['DEFAULT'];
							}
							if (isset($field['NOTNULL']) && (string)$field['NOTNULL'] === 'true') {
								$fieldparams['notnull'] = (string)$field['NOTNULL'];
							}
							if (isset($field['PRIMARY']) && (string)$field['PRIMARY'] === 'true') {
								$fieldparams['pk'] = EVALCOMIX_KEY_PRIMARY;
							}
							if (isset($field['SEQUENCE']) && (string)$field['SEQUENCE'] === 'true') {
								$fieldparams['sequence'] = EVALCOMIX_SEQUENCE;
							}
							if (isset($field['UNSIGNED']) && (string)$field['UNSIGNED'] === 'true') {
								$fieldparams['unsigned'] = EVALCOMIX_UNSIGNED;
							}
							if (isset($field['UNIQUE']) && (string)$field['UNIQUE'] === 'true') {
								$fieldparams['unique'] = EVALCOMIX_INDEX_UNIQUE;
							}
							
							$tableobj->add_field($fieldparams);
						}
					}
					
					// Adding keys to table config
					foreach ($table->KEYS->KEY as $key) {
						$type = evalcomix_table::get_type((string)$key['TYPE']);
						$keyname = (string)$key['NAME'];
						if (!$tableobj->key_exist(array('keyname' => $keyname, 'keytype' => $type))) {
							$keyparams = array(
											'name' => $keyname,
											'fields' => array((string)$key['FIELDS']),
											'type' => $type
										 );
							if (isset($key['REFTABLE'])) {
								$keyparams['reftable'] = (string)$key['REFTABLE'];
							}
							if (isset($key['REFFIELDS'])) {
								$keyparams['reffield'] = (string)$key['REFFIELDS'];
							}
							$tableobj->add_key($keyparams);        
						}
					}
					
					if ($tableobj->create_table()) {
						$result[$tablename] = true;
					} else {
						$result[$tablename] = false;
					}
				}
			}
		}
		return $result;
	}	
	
	public static function test_install_action() {
		$xml = '<mt:MixTool xmlns:mt="http://avanza.uca.es/assessmentservice/mixtool"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://avanza.uca.es/assessmentservice/mixtool http://avanza.uca.es/assessmentservice/MixTool.xsd"
name="Pruebas_Mixto" instruments="5">
<Description></Description>
<EvaluationSet  name="Pruebas_Mixto_Escala" dimensions="2"  percentage="20">
<Dimension name="Dimension" subdimensions="2" values="2" percentage="50">
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
</Values>
<Subdimension name="Subdimension" attributes="1" percentage="50">
<Attribute name="Atributo" comment="" percentage="100">0</Attribute>
</Subdimension>
<Subdimension name="Subdimension2" attributes="1" percentage="50">
<Attribute name="Atributo1" comment="" percentage="100">0</Attribute>
</Subdimension>
</Dimension>
<Dimension name="Dimension2" subdimensions="1" values="5" percentage="50">
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
<Value>Valor5</Value>
</Values>
<Subdimension name="Subdimension1" attributes="3" percentage="50">
<Attribute name="Atributo1" comment="1" percentage="33">0</Attribute>
<Attribute name="Atributo3" comment="1" percentage="33">0</Attribute>
<Attribute name="Atributo2" comment="1" percentage="33">0</Attribute>
</Subdimension>
<DimensionAssessment percentage="50">
			<Attribute name="Global assessment" comment="1" percentage="0">0</Attribute>
		</DimensionAssessment></Dimension>
</EvaluationSet><ControlListEvaluationSet  name="Pruebas_Mixto_Lista+Escala" dimensions="2"  percentage="20">
<Dimension name="Dimension" subdimensions="2" values="4" percentage="33">
<ControlListValues>
<Value>No</Value>
<Value>Sí</Value>
</ControlListValues>
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
</Values>
<Subdimension name="Subdimension" attributes="3" percentage="33">
<Attribute name="Atributo" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo2" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo3" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<Subdimension name="Subdimension2" attributes="3" percentage="33">
<Attribute name="Atributo1" comment="1" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo2" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo3" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<DimensionAssessment percentage="33">
					<Attribute name="Global assessment" comment="1" percentage="100">0</Attribute>
				</DimensionAssessment></Dimension>
<Dimension name="Dimension2" subdimensions="1" values="2" percentage="33">
<ControlListValues>
<Value>No</Value>
<Value>Yes</Value>
</ControlListValues>
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
</Values>
<Subdimension name="Subdimension1" attributes="1" percentage="50">
<Attribute name="Atributo1" comment="" percentage="100">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<DimensionAssessment percentage="50">
					<Attribute name="Global assessment" comment="" percentage="100">0</Attribute>
				</DimensionAssessment></Dimension>
<GlobalAssessment values="4" percentage="33">
				<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
</Values>

				<Attribute name="Global assessment" percentage="100">0</Attribute>
			</GlobalAssessment>
</ControlListEvaluationSet><ControlList  name="Pruebas_Mixto_Lista" dimensions="2"  percentage="20">
			<Dimension name="Dimension" subdimensions="2" values="2" percentage="50">
	<Values>
<Value>No</Value>
<Value>Sí</Value>
</Values>
<Subdimension name="Subdimension" attributes="3" percentage="50">
	<Attribute name="Atributo" comment="" percentage="33">0</Attribute>
	<Attribute name="Atributo3" comment="" percentage="33">0</Attribute>
	<Attribute name="Atributo2" comment="" percentage="33">0</Attribute>
	</Subdimension>
<Subdimension name="Subdimension2" attributes="1" percentage="50">
	<Attribute name="Atributo1" comment="" percentage="100">0</Attribute>
	</Subdimension>
</Dimension>
<Dimension name="Dimension2" subdimensions="1" values="2" percentage="50">
	<Values>
<Value>No</Value>
<Value>Yes</Value>
</Values>
<Subdimension name="Subdimension1" attributes="1" percentage="100">
	<Attribute name="Atributo1" comment="" percentage="100">0</Attribute>
	</Subdimension>
</Dimension>
</ControlList><Rubric  name="Pruebas_Mixto_Rúbrica" dimensions="2"  percentage="20">
		<Dimension name="Dimension" subdimensions="2" values="3" percentage="33">
		<Values>
<Value name="Valor1" instances="2">
<instance>1</instance>
<instance>2</instance>
</Value>
<Value name="Valor2" instances="2">
<instance>3</instance>
<instance>4</instance>
</Value>
<Value name="Valor3" instances="2">
<instance>5</instance>
<instance>6</instance>
</Value>
</Values>
<Subdimension name="Subdimension" attributes="3" percentage="33">
		<Attribute name="Atributo" comment="1" percentage="33">
						<descriptions>
<description value="0">Descripción 1</description>
<description value="1">Descripción 2</description>
<description value="2">Descripción 3</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo3" comment="" percentage="33">
						<descriptions>
<description value="0">Descripción 4</description>
<description value="1">Descripción 5</description>
<description value="2">Descripción 6</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="1" percentage="33">
						<descriptions>
<description value="0">Descripción 7</description>
<description value="1">Descripción 8</description>
<description value="2">Descripción 9</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
<Subdimension name="Subdimension2" attributes="2" percentage="33">
		<Attribute name="Atributo3" comment="" percentage="50">
						<descriptions>
<description value="0">Descripción 10</description>
<description value="1">Descripción 11</description>
<description value="2">Descripción 12</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="1" percentage="50">
						<descriptions>
<description value="0">Descripción 13</description>
<description value="1">Descripción 14</description>
<description value="2">Descripción 15</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
<DimensionAssessment percentage="33">
					<Attribute name="Global assessment" comment="1" percentage="0">
					<descriptions>
<description value="0"></description>
<description value="1"></description>
<description value="2"></description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
</Attribute>
				</DimensionAssessment></Dimension>
<Dimension name="Dimension2" subdimensions="1" values="2" percentage="33">
		<Values>
<Value name="Valor1" instances="2">
<instance>1</instance>
<instance>2</instance>
</Value>
<Value name="Valor2" instances="2">
<instance>3</instance>
<instance>4</instance>
</Value>
</Values>
<Subdimension name="Subdimension1" attributes="2" percentage="100">
		<Attribute name="Atributo1" comment="" percentage="50">
						<descriptions>
<description value="0">Descripción 16</description>
<description value="1">Descripción 17</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="" percentage="50">
						<descriptions>
<description value="0">Descripción 18</description>
<description value="1">Descripción 19</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
</Dimension>
<GlobalAssessment values="5" percentage="33">
				<Values>
		<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
<Value>Valor5</Value>
</Values>

				<Attribute name="Global assessment" percentage="0">0</Attribute>
			</GlobalAssessment>
		</Rubric><SemanticDifferential  name="Pruebas_Mixto_Diferencial" attributes="5" values="5"  percentage="20">
<Values>
<Value>-2</Value>
<Value>-1</Value>
<Value>0</Value>
<Value>1</Value>
<Value>2</Value>
</Values>
<Attribute nameN="Atributo Negativo1" nameP="Atributo Positivo1" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo2" nameP="Atributo Positivo2" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo3" nameP="Atributo Positivo3" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo4" nameP="Atributo Positivo4" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo5" nameP="Atributo Positivo5" comment="" percentage="20">0</Attribute>
</SemanticDifferential></mt:MixTool>';

		include_once(DIRROOT . '/client/tool.php');
		include_once(DIRROOT . '/classes/mixtopla.php');
		include_once(DIRROOT . '/classes/plantilla.php');
		include_once(DIRROOT . '/classes/pdo_database.php');
		
		$id = uniqid('test_');
		$xml = simplexml_load_string($xml);

		$tool = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
		$tool->import($xml);
		
		try{
			$result = $tool->save($id);
			if($plantilla = plantilla::fetch(array('pla_cod' => $id))){
				$mixtopla = mixtopla::fetch_all(array('mip_mix' => $plantilla->id));
				foreach($mixtopla as $tool){
					$pla = plantilla::fetch(array('id' => $tool->mip_pla));
					$pla->delete();
					$tool->delete();
				}
				$plantilla->delete();
			}
			return true;
		}
		catch(Exception $e){
			return $e->getMessage();
		}
	}
	
	public static function admin_user_exist() {
		require_once(DIRROOT . '/classes/users.php');

		if ($user = users::fetch(array('usr_nam' => 'admin'))) {
			return true;
		}
		
		return false;
	}
}