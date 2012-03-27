<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author		Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// masked_input default library

$library = array(
			'js'				=> array('jquery.maskedinput.js'),
			'class'				=> 'mi',
			'required_helpers'	=> array('form')
);

// this is the custom masked input class that makes useful things :)

class masked_input extends CI_Weblibrary {
	var $_tabs = array();
	
	function __construct(){

	}
	
	// create a generic input
	function input($name, $return = TRUE, $value = "", $mask = ""){
		if(is_array($name)){
			foreach($name as $item)
				$this->telephone($item);
		} else {
			
			$this->create_function($name, "'".$mask."'", 'mask');
			// Returns the input tag if requested
			if($return){
				$info = $this->get_info($name);
				// but it fails if we cant determine what is it :(
				if($info == false){
					show_error('To return a html tag, library masked_input::<b>input</b> must receive a string with a <b>#</b> (id) or a <b>.</b> (class).'.debug(debug_backtrace(), false, true));
					return;
				}
				$data = array(
					$info['type']		=> $info['string'],
					'name'				=> $info['string'],
					'value'				=> $value,
					'readonly'			=> "readonly"
				);
				
				return form_input($data);
			}
		}
	}
}