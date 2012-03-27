<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author		Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// visual editor default library

$library = array(
			'css'				=> array('jquery.cleditor.css'),
			'js'				=> array('jquery.cleditor.min.js'),
			'class'				=> 've'
);

// this is the custom visual editor class that makes useful things :)

class visual_editor extends CI_Weblibrary {
	// create a custom visual_editor
	function open($name, $return = TRUE, $default="", $advanced=""){
		// remove javascript selectors
		$this->create_function($name, $advanced, 'cleditor');
		if($return){
			$info = $this->get_info($name);
			// but it fails if we cant determine what is it :(
			if($info == false){
				show_error('To return a html tag, library visual_editor::<b>editor</b> must receive a string with a <b>#</b> (id) or a <b>.</b> (class).');
				return;
			}
			return '<textarea '.$info['type'].'="'.$info['string'].'" name="'.$info['string'].'">'.$default.'</textarea>';
		}
		
	}
}