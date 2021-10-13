<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class upgrade_controller {
	public static function upgrader_action($currentversion) {
		$request = Request::createFromGlobals();
		require_once(DIRROOT . '/src/install/renderer.php');
		require_once(DIRROOT . '/classes/dblib/evalcomix_table.php');
		require_once(DIRROOT . '/version.php');
		global $version;
		
		$substage = $request->request->get('substage');
		$html = '';
		$title = get_string('upgrade');
		$statusmessage = '';
		
		if (empty($substage)) {
			$versions = new stdclass();
			$versions->currentversion = $currentversion;
			$versions->newversion = $version;
			$html = install_renderer::render_template('src/upgrade/upgrade_confirm_view.php', array('title' => $title,
						'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php',
						'versions' => $versions));
		} else {
			$result = array();
			set_time_limit(300);		
			//CAMBIOS PARA ACTUALIZAR EVALCOMIX 4.1.1 A EVALCOMIX 4.3.0----------------
			if ($currentversion < 2021092400) {
				// Define table user to be created
				$usertable = new evalcomix_table(array('name' => 'users'));

				// Adding fields to table user     
				if (!$usertable->field_exist('id')) {
					$usertable->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10',
						'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_nam')) {
					$usertable->add_field(array('name' => 'usr_nam', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '100',
						'notnull' => EVALCOMIX_NOTNULL, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_pss')) {
					$usertable->add_field(array('name' => 'usr_pss', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '255',
						'notnull' => EVALCOMIX_NOTNULL, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_fnm')) {
					$usertable->add_field(array('name' => 'usr_fnm', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '100',
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_lnm')) {
					$usertable->add_field(array('name' => 'usr_lnm', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '100',
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_eml')) {
					$usertable->add_field(array('name' => 'usr_eml', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '100',
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_phn')) {
					$usertable->add_field(array('name' => 'usr_phn', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '50',
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_enb')) {
					$usertable->add_field(array('name' => 'usr_enb', 'type' => EVALCOMIX_TYPE_BOOL,
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_del')) {
					$usertable->add_field(array('name' => 'usr_del', 'type' => EVALCOMIX_TYPE_BOOL,
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_lgn')) {
					$usertable->add_field(array('name' => 'usr_lgn', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10',
						'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_com')) {
					$usertable->add_field(array('name' => 'usr_com', 'type' => EVALCOMIX_TYPE_TEXT, 'notnull' => null,
						'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_tct')) {
					$usertable->add_field(array('name' => 'usr_tct', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10',
						'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$usertable->field_exist('usr_tmd')) {
					$usertable->add_field(array('name' => 'usr_tmd', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10',
						'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => null, 'sequence' => null, 'default' => null));
				}
				// Adding keys to table config
				if (!$usertable->key_exist(array('keytype' => 'pk'))) {
					$usertable->add_key(array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY));        
				}
				
				$usertable->create_table();
				
				$result['users'] = 'USERS '. get_string('tablecreated');
				
				//-------------------------------------------------------------------------------------
				
				// Define table lms to be created
				$lmstable = new evalcomix_table(array('name' => 'lms'));

				// Adding fields to table lms     
				if (!$lmstable->field_exist('id')) {
					$lmstable->add_field(array('name' => 'id', 'type' => EVALCOMIX_TYPE_INTEGER, 'precision' => '10',
						'unsigned' => EVALCOMIX_UNSIGNED, 'notnull' => EVALCOMIX_NOTNULL, 'sequence' => EVALCOMIX_SEQUENCE, 'default' => null));
				}
				
				if (!$lmstable->field_exist('lms_nam')) {
					$lmstable->add_field(array('name' => 'lms_nam', 'type' => EVALCOMIX_TYPE_CHAR, 'precision' => '100',
						'notnull' => EVALCOMIX_NOTNULL, 'sequence' => null, 'default' => null));
				}
				
				if (!$lmstable->field_exist('lms_des')) {
					$lmstable->add_field(array('name' => 'lms_des', 'type' => EVALCOMIX_TYPE_TEXT, 
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$lmstable->field_exist('lms_url')) {
					$lmstable->add_field(array('name' => 'lms_url', 'type' => EVALCOMIX_TYPE_TEXT, 
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$lmstable->field_exist('lms_tkn')) {
					$lmstable->add_field(array('name' => 'lms_tkn', 'type' => EVALCOMIX_TYPE_TEXT, 
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				if (!$lmstable->field_exist('lms_enb')) {
					$lmstable->add_field(array('name' => 'lms_enb', 'type' => EVALCOMIX_TYPE_BOOL,
						'notnull' => null, 'sequence' => null, 'default' => null));
				}
				
				// Adding keys to table config
				if (!$lmstable->key_exist(array('keytype' => 'pk'))) {
					$lmstable->add_key(array('name' => 'pk_id', 'fields' => array('id'), 'type' => EVALCOMIX_KEY_PRIMARY));        
				}
				
				$lmstable->create_table();

				$result['lms'] = 'LMS ' . get_string('tablecreated');
				
				// evalcomix savepoint reached
				upgrade_evalcomix_savepoint(2021092400);
			}
			
			if (empty($result)) {
				upgrade_evalcomix_savepoint($version);
				return new RedirectResponse(WWWROOT . '/index.php', 302);
			}
			
			$html = install_renderer::render_template('src/upgrade/upgrade_view.php', array('title' => $title,
						'statusmessage' => $statusmessage, 'action' => WWWROOT .'/index.php', 'result' => $result));
		}
		return new Response($html);
	}
}