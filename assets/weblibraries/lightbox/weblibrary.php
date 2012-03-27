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
			'css'	=> array('jquery.fancybox-1.3.4.css'),
			'js'	=> array('jquery.fancybox-1.3.4.pack.js', 'jquery.easing-1.3.pack.js'),
			'class'	=> 'lightbox'
);

// this is the custom lightbox class that makes useful things :)
class lightbox extends CI_Weblibrary {
	// create a custom datepicker
	function initialize($name, $advanced=""){
		$this->create_function($name, $advanced, 'fancybox');
	}
}