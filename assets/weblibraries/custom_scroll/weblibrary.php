<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// custom_scroll default library

$library = array(
			'js'	=> array('jquery.mousewheel.js', 'jquery.jscrollpane.min.js', 'mwheelIntent.js'),
			'css'	=> array('jquery.jscrollpane.css'),
			'class'	=> 'custom_scroll'
);

// this is the custom custom_scroll class that makes useful things :)
class custom_scroll extends CI_Weblibrary {
	// create a custom datepicker
	function initialize($name, $advanced=""){
		$this->create_function($name, $advanced, 'jScrollPane');
	}
}