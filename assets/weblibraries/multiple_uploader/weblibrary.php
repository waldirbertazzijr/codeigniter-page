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
			'css'				=> array('fileuploader.css'),
			'js'				=> array('fileuploader.js'),
			'class'				=> 'mu'
);

class multiple_uploader extends CI_Weblibrary {
	// create a custom visual_editor
	function start($uploader_id, $list_id, $action){
		// remove javascript selectors
		$function = "
		function createUploader(){            
		    var uploader = new qq.FileUploader({
		        element: document.getElementById('$uploader_id'),
		        listElement: document.getElementById('$list_id'),
		        action: '$action'
		    });
		}
		window.onload = createUploader;
		";
		$this->add_code($function);
	}
}