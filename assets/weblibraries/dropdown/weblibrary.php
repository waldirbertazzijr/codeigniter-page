<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author		Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// dropdown default library

$library = array(
			'js'				=> array('superfish.js', 'hoverIntent.js', 'supersubs.js'),
			'css'				=> array('superfish.css', 'superfish-navbar.css', 'superfish-vertical.css'),
			'class'				=> 'dd'
);

// this is the custom dropdown class that makes useful things :)
class dropdown extends CI_Weblibrary {
	function initialize($name, $advanced=""){
		$this->create_function($name, $advanced, 'superfish');
	}
}