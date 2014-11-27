<?php

require_once 'simpletest/autorun.php';
require_once 'evalcomix_dbobject_test.php';
require_once 'evalcomix_field_test.php';
require_once 'evalcomix_table_test.php';

class AllTests extends TestSuite {
    function __construct() {
        parent::__construct();
        $this->add(new EvalcomixDBobjectCase());
		$this->add(new EvalcomixFieldCase());
		$this->add(new EvalcomixTableCase());
    }
}

?>