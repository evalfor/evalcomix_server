<?php

class install {
	
	
	

	/**
	 * Require our minimum php version or halt execution if requirement not met.
	 * @return void Execution is halted if version is not met.
	 */
	public static function require_minimum_php_version() {
		// PLEASE NOTE THIS FUNCTION MUST BE COMPATIBLE WITH OLD UNSUPPORTED VERSIONS OF PHP!
		self::minimum_php_version_is_met(true);
	}

	/**
	 * Tests the current PHP version against EvalCOMIX's minimum requirement. When requirement
	 * is not met returns false or halts execution depending $haltexecution param.
	 *
	 * @param bool $haltexecution Should execution be halted when requirement not met? Defaults to false.
	 * @return bool returns true if requirement is met (false if not)
	 */
	public static functionfunction minimum_php_version_is_met($haltexecution = false) {
		// PLEASE NOTE THIS FUNCTION MUST BE COMPATIBLE WITH OLD UNSUPPORTED VERSIONS OF PHP.
		// Do not use modern php features or EvalCOMIX convenience functions (e.g. localised strings).

		$minimumversion = '5.0.0';

		if (version_compare(PHP_VERSION, $minimumversion) < 0) {
			if ($haltexecution) {
				$error = "EvalCOMIX requires at least PHP ${minimumversion} "
					. "(currently using version " . PHP_VERSION .").\n"
					. "Some servers may have multiple PHP versions installed, are you using the correct executable?\n";
				echo $error;
				exit(1);
			} else {
				return false;
			}
		}
		return true;
	}
	
	
}