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
			'js'				=> array('bootstrap.min.js'),
			'css'				=> array('bootstrap.min.css'),
			'class'				=> 'bs'
);

// this is the custom jquery

class bootstrap extends Weblibrary {
	function __construct(){
	}
}