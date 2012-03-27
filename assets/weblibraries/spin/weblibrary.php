<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author		Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// spin default library

$library = array(
	'js'	=> array('spin.min.js'),
	'class'	=> 'spin'
);

// this is the custom spin
class spin extends CI_Weblibrary {
	function __construct(){
	}
}