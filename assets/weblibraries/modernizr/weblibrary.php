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
			'js'				=> array('modernizr.min.js'),
			'class'				=> 'md'
);

// this is the custom jquery

class modernizr extends CI_Weblibrary {
	function __construct(){
	}
}