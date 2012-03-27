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
			'js'				=> array('jquery_ui.js', 'jquery.uniform.min.js'),
			'css'				=> array('Aristo/jquery-ui-1.8.7.custom.css', 'uniform.aristo.css'),
			'class'				=> 'jqui',
			'required_helpers'	=> array('form')
);

// this is the custom jquery_ui class that makes useful things :)

class jquery_ui extends CI_Weblibrary {
	var $_tabs = array();

	function __construct(){

	}
	
	// create a jquery_ui stylish datepicker :)
	function datepicker($name, $return = TRUE, $value = "", $advanced = "{dateFormat: 'dd/mm/yy'}"){
		if(is_array($name)){
			foreach($name as $item)
				$this->datepicker($item);
		} else {
			$this->create_function($name, $advanced, 'datepicker');
			// Returns the input tag if requested
			if($return){
				$info = $this->get_info($name);
				// but it fails if we cant determine what is it :(
				if($info == false){
					show_error('To return a html tag, library jquery_ui::<b>datapicker</b> must receive a string with a <b>#</b> (id) or a <b>.</b> (class).'.debug(debug_backtrace(), false, true));
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
	
	// create a jquery_ui stilish button :)
	function button($name, $return = FALSE, $href = "", $text = "", $advanced = ""){
		if(is_array($name)){
			foreach($name as $item)
				$this->button($item);
		} else {
			$this->create_function($name, $advanced, 'button');
			// Returns the a tag if requested
			if($return){
				$info = $this->get_info($name);
				// but it fails if we cant determine what is it :(
				if($info == false){
					show_error('To return a html tag, library jquery_ui::<b>button</b> must receive a string with a <b>#</b> (id) or a <b>.</b> (class).');
					return;
				}
				if($href=="submit"){
					return "<button ".$info['type']."=\"".$info['string']."\" value=\"".$info['string']."\">{$text}</button>";
				}
				return "<a ".$info['type']."=\"".$info['string']."\" href=\"{$href}\">{$text}</a>";
			}
		}
	}
	
	// make objects draggable
	function draggable($name, $advanced=""){
		$this->create_function($name, $advanced, 'draggable');
	}
	
	// this function add a tab for the next function to generate it
	function add_tab($title, $content = ""){
		if( ! is_array($title))
			$this->tabs[] = array('title'=>$title, 'content'=>$content);
		if(is_array($title))
			foreach($title as $content)
				$this->tabs[] = array('title'=>$content['title'], 'content'=>$content['content']);
	}
	
	// this function will generate the whole thing about the tabs
	function generate_tabs($name){
		$info = $this->get_info($name);
		if($info == false){
			show_error('To return a html tag, library jquery_ui::<b>generate_tabs</b> must receive a string with a <b>#</b> (id) or a <b>.</b> (class).');
			return;
		}
		$return = '
		<div '.$info['type'].'="'.$info['string'].'">
			<ul>
		';
		// Generation of jquery ui tabs
		$i = 1;
		$tabs = "";
		$contents = "";
		foreach($this->tabs as $tab){
			$tabs.="\t\t".'<li><a href="#tabs-'.$i.'">'.$tab['title'].'</a></li>'."\n";
			$contents.="\t\t".'<div id="tabs-'.$i.'">
			'.$tab['content'].'</div>';
			$i++;
		}
		// put the tabs together
		$return .= $tabs;
		// Close the ul list that makes the tabs
		$return .= "\t\t\t</ul>\n\n";
		// put the contents together
		$return .= $contents ;
		// Close the mother div
		$return .= "</div>\n";
		// send data to bootstrap
		$this->create_function($info['symbol'].$info['string'], '', 'tabs');
		
		// cuz every litle thing is gonna be alright :)
		return $return;
	}
}