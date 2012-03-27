<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author		Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// jquery_ui default library

$library = array(
			'js'				=> array('jquery.treeview.js'),
			'css'				=> array('jquery.treeview.css'),
			'class'				=> 'tv',
			'required_helpers'	=> array('form')
);

// this is the custom treeview class that makes useful things :)

class treeview extends CI_Weblibrary {
	
	
	// create a treeview stylish datepicker :)
	function initialize($name, $advanced = '' ){
		$this->create_function($name, $advanced, 'treeview');
	}
	
}