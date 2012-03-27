<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author		Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// lightbox default library

$library = array(
			'css'	=> array('apprise.min.css'),
			'js'	=> array('apprise-1.5.min.js'),
			'class'	=> 'apprise'
);

// this is the custom alert class that makes useful things :)
class apprise extends CI_Weblibrary {
	
	function __construct() {

	}
}