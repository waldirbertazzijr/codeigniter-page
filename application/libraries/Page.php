<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

define("FROM_LIBRARY", true);
define("FROM_USER", false);

/**
* Page Class
*
* @package		Orion Project
* @subpackage	Libraries
* @category		Pages
* @author		Waldir Bertazzi Junior
* @link			http://waldir.org/
*/
class Page {

	// Private
	private $js						= array();
	private $css					= array();
	private $custom_js				= array();
	private $custom_css				= array();
	private $lib_js					= array();
	private $lib_css				= array();
	private $metas					= array();
	private $view_list				= array();
	private $php_vars				= array();
	private $custom_tags			= "";
	private $template;
	private $CI;

	// Public
	public $ret						= false;
	public $profiler				= false;
	public $loaded_weblibraries		= array();
	public $head_info				= "<!--\n  ▽ Orion Framework\n\n'All you need is love, love,\nLove is all you need'\n\t\t- John Lennon -->\n\n";


	/**
	* Pages Constructor
	*
	* The constructor loads the needed files to run
	* and creates a benchmark. It also loads the folder 'autoload',
	* that should hold essential files and css, like css reset.
	*
	*/
	function __construct($args = null){		
		$this->CI =& get_instance();

		// start the benchmark
		$this->CI->benchmark->mark('page_constructor_start');

		// set the default template
		if(isset($args['template'])){
			$this->template = $args['template'];
		} else{
			$this->template = 'default';
		}
		
		// essential helpers
		$this->CI->load->helper('url');

		// essential libraries
		$this->CI->load->library('weblibrary');

		// set the profiler
		$this->profiler = $args['profiler'];

		// end the benchmark	
		$this->CI->benchmark->mark('page_constructor_end');
	}

	/**
	* Changes the default template name.
	*
	* @return void
	* @param template name - the name of the template to change
	* @author Waldir Bertazzi Junior
	**/
	function set_template($template_name) {
		$this->template = $template_name;
	}

	/**
	* Add custom code to page head script tag
	*
	* @access	public
	* @param	string
	* @return	bool
	*/
	function code($custom_code){
		$this->custom_js[] = $custom_code;
		return true;
	}

	/**
	* Add custom style to page head style tag
	*
	* @access	public
	* @param	string
	* @return	bool
	*/
	function style($custom_css){
		$this->custom_css[] = $custom_css;
		return true;
	}

	/**
	* Imports a javascript file to the Page.
	* It can receives weblibraries javascripts too.
	*
	* @access	public
	* @param	string
	* @param	bool
	* @return	bool
	*/
	function js($filename, $from_lib=FROM_USER){
		// If its an array we have to load separately.
		if(is_array($filename)){
			foreach($filename as $file){
				// Calls recursively this function for each file
				// on the received array.
				$this->js($file);
			}
		} else {
			if($file = $this->_has_extension($filename)){
				array_pop($file);
				if(!$from_lib)
					$this->js[] = implode('.', $file);
				else
					$this->lib_js[] =implode('.', $file);
			} else {
				if(!$from_lib)
					$this->js[] = $filename;
				else
					$this->lib_js[] = $filename;

			}
		}
	}

	/**
	* Imports a css file to the Page.
	* It can receives weblibraries css too.
	*
	* @access	public
	* @param	string
	* @param	bool
	* @return	bool
	*/
	function css($filename, $from_lib=FROM_USER){
		// If its an array we have to load separately.
		if(is_array($filename)){
			foreach($filename as $file){
				// Calls recursively this function for each file
				// on the received array.
				$this->css($file);
			}
		} else {
			if($file = $this->_has_extension($filename)){
				array_pop($file);
				if(!$from_lib)
					$this->css[] = implode('.', $file);
				else
					$this->lib_css[] = implode('.', $file);
			} else {
				if(!$from_lib)
					$this->css[] = $filename;
				else
					$this->lib_css[] = $filename;

			}
		}
	}

	/**
	* Add a meta tag to the page head.
	*
	* @access	public
	* @param	string
	* @param	string
	* @return	bool
	*/
	function meta($name, $content=""){
		$this->metas[] = array('name' => $name, 'content' => $content);
	}

	/**
	* Add a custom tag to page head.
	*
	* @access	public
	* @param	string
	* @param	string
	* @return	bool
	*/
	function custom($string){
		$this->custom_tags .= $string;
	}
	
	/**
	* Returns the APP assets URL.
	*
	* @access	private
	* @return	string
	*/
	function assets_url($path='')
	{
		$path = explode("/", $path);
		return base_url()."assets/".implode("/", $path)."/";
	}

	/**
	* This function will load a weblibrary to the system.
	* Weblibraries are small pieces of php that integrates with the page.
	* The weblibrary class provides routines to make it easy to handle
	* your javascript libraries within the system.
	*
	* @access	public
	* @param	string
	* @param	string
	* @return	bool
	**/
	function load($name, $custom_name = ""){

		$this->CI->benchmark->mark($name.'_load_start');

		// if first parameter is array, weve a list of libraries to load.
		if(is_array($name)){

			// foreach library received we call it recursively to load each
			// array index separately
			foreach($name as $lib_name){
				$this->load($lib_name);
			}

			// otherwise is just one
		} else {
			if ( ! is_dir('./assets/weblibraries/'.$name.'/'))
			show_error('Weblibrary <strong>'.$name.'</strong> could not be found.');
			// ok, weve got one library to load
			require_once('./assets/weblibraries/'.$name.'/weblibrary.php');

			// parse the weblibrary preferences
			if(isset($library)){
				if(isset($library['js']))
					foreach($library['js'] as $js_library)
					$this->js($name."/js/".$js_library, FROM_LIBRARY);
				if(isset($library) && isset($library['css']))
					foreach($library['css'] as $css_library)
					$this->css($name."/css/".$css_library, FROM_LIBRARY);
				if(isset($library['required_helpers']))
					foreach($library['required_helpers'] as $required_helper)
					$this->CI->load->helper($required_helper);
			}
			// ok, lets turn on the engines!
			if(isset($library['class'])){
				// no custom name
				if($custom_name == ""){
					// default loading
					$this->$library['class'] = new $name();
					$this->loaded_weblibraries[] = $library['class'];
					// yes, custom name detectd
				} else {
					// turn on with custom name
					$this->$custom_name = new $name();
					$this->loaded_weblibraries[] = $custom_name;
				}
			}
		}
		$this->CI->benchmark->mark($name.'_load_end');
	}

	/**
	* Save the load view request to the generate
	* function load it up.
	*
	* @access	public
	* @param string
	* @param array
	* @return	void
	*/
	function view($view_name, $data_array = array()){
		if(is_array($view_name)){
			foreach($view_name as $view)
				$this->view($view);	
		} else {		
			if(!is_array($data_array)){
				throw new Exception('The second argument of Page->View page must be an array!');
			} else {
				// page
				$this->view_list[] = array('name' => $view_name, 'data' => $data_array);
			}
		}
	}

	/**
	* Show user messages divs
	* to use this you create a session flash_message:
	*  error_message - for errors
	*  success_messages - for successes
	*
	* @access	public
	* @return	string
	*/
	function messages(){
		$return = "\n";
		if ($this->CI->session->flashdata('error_message')) {
			$return .= '<div class="alert alert-error"><span>';
			$return .= $this->CI->session->flashdata('error_message');
			$return .= '</span></div>';
		} else if ($this->CI->session->flashdata('success_message')) {
			$return .= '<div class="alert alert-success"><span>';
			$return .= $this->CI->session->flashdata('success_message');
			$return .= '</span></div>';
		}

		return $return;

	}

	/**
	* Append a new index to the php_vars
	* to be passed to javascript.
	*
	* @access	public
	* @param	string
	* @param	structure
	*/
	function add_php_var($key, $value){
		$this->php_vars[$key] = $value;
	}

	/**
	* Generate the page using helper functions
	* and show the page with the page title.
	*
	* @access	public
	* @param	string
	* @return	string
	*/
	function generate($title=""){
		// Page generate benchmark
		$this->CI->benchmark->mark('benchmark_start');

		// Turn on profiler if necessary
		if($this->profiler) {
			$this->CI->output->enable_profiler(TRUE);
		}

		$return = "";

		// Passes site_url, base_url and php_vars to JS. Very useful for javascript frameworks.
		$this->code("// Util variables\n\t\tvar site_url = '".site_url()."';\n\t\tvar base_url = '".base_url()."';\n\t\tvar phpvars = ".json_encode($this->php_vars).";");

			// Template header
		$return .= $this->CI->load->view(
		"../templates/{$this->template}/header",
		array(
			'head_info'		=> $this->head_info,
			'title'			=> $title,
			'metas'			=> $this->_compile_metas(),
			'css'			=> $this->_compile_css(),
			'js'			=> $this->_compile_js(),
			'custom'		=> $this->custom_tags
			),
			$this->ret);

			// Foreach saved view in the view_list array draw it
			foreach($this->view_list as $view){
				$return .= $this->CI->load->view($view['name'], $view['data'], $this->ret);
			}

			// Footer
			$return .= $this->CI->load->view(
			"../templates/{$this->template}/footer",
			array(
				'footer_js'=>$this->_compile_weblibraries_js()
				),
				$this->ret);

				// Okay dood!
				$this->CI->benchmark->mark('benchmark_end');

				// Return?
				if($this->ret){
					return $return;
				}
			}

	/**
	* Compiles every css that has been passed to the
	* library to one string and returns it.
	*
	* @access	private
	* @return	string
	*/
	private function _compile_css(){
		$compiled_css = "";
		foreach($this->lib_css as $css_file){
			$compiled_css .= "\t<link rel=\"stylesheet\" href=\"".$this->assets_url('weblibraries')."{$css_file}.css\" />\n";
		}
		foreach($this->css as $css_file){
			$compiled_css .= "\t<link rel=\"stylesheet\" href=\"".$this->assets_url('css')."{$css_file}.css\" />\n";
		}
		foreach($this->custom_css as $css_code){
			$compiled_css .= "\t<style type=\"text/css\" media=\"all\">\n\t\t{$css_code}\n\t</style>\n";
		}

		return "<!-- Compiled CSS -->\n".$compiled_css."\t<!-- END Compiled CSS -->\n";
	}

	/**
	* Compiles every css that has been passed to the
	* class to one string and returns it.
	*
	* @access	private
	* @return	string
	*/
	private function _compile_js(){
		$compiled_js = "";
		foreach($this->lib_js as $js_file){
			$compiled_js .= "\t<script type=\"text/javascript\" src=\"".$this->assets_url('weblibraries')."{$js_file}.js\"></script>\n";
		}
		foreach($this->js as $js_file){
			$compiled_js .= "\t<script type=\"text/javascript\" src=\"".$this->assets_url('javascript')."{$js_file}.js\"></script>\n";
		}
		foreach($this->custom_js as $js_code){
			$compiled_js .= "\t<script type=\"text/javascript\">\n\t\t{$js_code}\n\t</script>\n";
		}
		return "<!-- Compiled JS -->\n".$compiled_js."\t<!-- END Compiled JS -->\n";
	}

	/**
	* Compile every css that weblibraries passed to the
	* class and returns it.
	*
	* @access	private
	* @return	string
	*/
	private function _compile_weblibraries_js(){
		if(sizeof($this->loaded_weblibraries) > 0){
			$compiled_js = "<script type=\"text/javascript\">\n\t\t$(document).ready( function () {";
				foreach($this->loaded_weblibraries as $library){
					$compiled_js .= "\n\t\t\t// $library javascript\n\t\t\t".$this->$library->bootstrap()."\n";
					}
					return $compiled_js."\t\t} );\n\t</script>";
				}
				return false;
			}

	/**
	* Compile every meta that has been passed to
	* the Class and returns it.
	*
	* @access	private
	* @return	string
	*/
	private function _compile_metas(){
		$compiled_metas = "";
		foreach($this->metas as $meta){
			$compiled_metas .= "\t".'<meta name="'.$meta['name'].'" content="'.$meta['content'].'">'."\n";
		}
		return "<!-- Compiled META -->\n".$compiled_metas."\t<!-- END Compiled META -->\n";
	}
	
	/**
	* Checks if the filename has a extension.
	*
	* @access	private
	* @return	string the extension
	*/	
	private function _has_extension($filename) {
		$exploded = explode(".", $filename);

		if(sizeof($exploded) > 1)
			return $exploded;
		else
			return false;
	}
}