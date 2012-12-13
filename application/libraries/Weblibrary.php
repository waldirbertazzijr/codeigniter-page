<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * Orion Application Library Class
 *
 * This class object is the super class that every
 * asset library will be assigned to.
 *
 */
class Weblibrary {
	
	var $_data;
	var $_code;
	
	/**
	 * Constructor
	 *
	 * Calls the initialize() function
	 */
	function Weblibrary()
	{	
		log_message('debug', "Weblibrary Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Bootstrap
	 *
	 * This routine prepares all the javascript that will
	 * returned by the library while printing javascript
	 *
	 * @access	private
	 * @return	void
	 */
	function bootstrap(){
		$building = "";
		$concat = "";
		
		if(is_array($this->_data)){
			foreach($this->_data as $build){
				if($build['advanced']==""){
					$building.='$("'.$build['name'].'").'.$build['function'].'();';
				} else {
					$building.='$("'.$build['name'].'").'.$build['function'].'('.$build['advanced'].');';
				}
			}
		}
		
		if (is_array($this->_code)) {
			foreach ($this->_code as $code) {
				$building .= $code;
			}
		}
		
		return $building;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Add Function
	 *
	 * This function will add a new jquery function to the page
	 * head.
	 *
	 * @access	public
	 * @return	void
	 */
	function create_function($selector, $advanced, $function){
		$this->_data[] = array('name'=>$selector, 'advanced'=>$advanced, 'function'=>$function);
	}

	
	// --------------------------------------------------------------------
	
	/**
	 * Add Code
	 *
	 * This function will add a new arbitrary code to the page
	 * head.
	 *
	 * @access	public
	 * @return	void
	 */
	function add_code($code){
		$this->_code[] = $code;
	}
	
	// --------------------------------------------------------------------

	/**
	 * This function will detect if the received string
	 * is a id or a class and return an array
	 *
	 * @access	private
	 * @return	array
	 */
	function get_info($name){
		$return = array();
		// maybe id
		if(strpos($name, '#') === 0){
			$return['type'] = 'id';
			$return['symbol'] = '#';
			$return['string'] = str_replace("#", "", $name);
		}
		// nah, maybe its a class
		elseif(strpos($name, '.') === 0){
			$return['type'] = 'class';
			$return['symbol'] = '.';
			$return['string'] = str_replace(".", "", $name);
		}
		// houston, we have a problem.
		else {
			$return = false;
		}
		return $return;
	}
}