<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author		Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// jquery default library

$library = array(
			'js'				=> array('jquery.min.js'),
			'class'				=> 'jq'
);

// this is the custom jquery

class jquery extends CI_Weblibrary {
	function __construct(){
	}
}