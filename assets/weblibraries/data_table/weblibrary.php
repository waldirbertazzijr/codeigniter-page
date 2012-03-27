<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// data_tables default library

$library = array(
			'css'	=> array('table_style.css'),
			'js'	=> array('jquery.dataTables.min.js'),
			'class'	=> 'dt'
);

// this is the custom data_table class that makes useful things :)
class data_table extends CI_Weblibrary {
	// create a custom datepicker
	function initialize($name, $advanced = "{'bJQueryUI': true}"){		
		$this->create_function($name, $advanced, 'dataTable');
	}
}