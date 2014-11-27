<?php

abstract class export_object{
	public $tool;
	
	/**
	* Provide export strategy
	**/
	abstract public function export();
}
?>