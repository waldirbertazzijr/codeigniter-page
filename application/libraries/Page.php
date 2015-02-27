<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

define("PAGE_HEAD", 0);
define("PAGE_BODY", 1);

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

	// Private stuff
	
	// Tags
	private $js						= array(PAGE_HEAD=>array(), PAGE_BODY=>array());
	private $css					= array();
	private $php_vars				= array();
	private $metas					= array();
	private $custom_js;
	
	// Views
	private $view_list				= array();
	private $template;
	private $CI;

	// Public
	public $profiler				= false;
	public $js_utils				= true;
	public $head_info				= "<!-- 'A culture disconnected from wild nature becomes insane.'\n\t\t- Toby Hemenway -->\n";


	/**
	* Pages Constructor
	*
	* The constructor loads the needed files to run
	* and creates a benchmark. It also loads the folder 'autoload',
	* that should hold essential files and css, like css reset.
	*/
	function __construct($args = null){
		// Get codeigniter instance
		$this->CI =& get_instance();

		// start the benchmark
		$this->CI->benchmark->mark('page_constructor_start');

		// set the default template
		if(isset($args['template'])){
			$this->template = $args['template'];
		} else{
			$this->template = 'default';
		}
		
		// essential lib
		$this->CI->load->helper('url');

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
	* Imports a javascript file to page.
	*
	* @access	public
	* @param	string - filename located in assets/js
	* @param	int - position to put the file. by default, js is on body
	* @return	bool
	*/
	function js($filename, $position=PAGE_BODY){
		// If its an array we have to load separately.
		if(is_array($filename)){
			foreach($filename as $file){
				// Calls recursively this function for each file
				// on the received array.
				$this->js($file, $position);
			}
		} else {
			if($file = $this->_has_extension($filename)){
				array_pop($file);
				$this->js[$position][] = implode('.', $file);
			} else {
				$this->js[$position][] = $filename;
			}
		}
	}

	/**
	* Imports a css file to page.
	*
	* @access	public
	* @param	string - filename located in assets/css
	* @return	bool
	*/
	function css($filename){
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
				$this->css[] = implode('.', $file);
			} else {
				$this->css[] = $filename;
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
	function meta($name, $content="") {
		$this->metas[] = array('name' => $name, 'content' => $content);
	}

	/**
	* Returns the application assets URL.
	*
	* @access	private
	* @return	string
	*/
	function assets_url($path='') {
		if (substr($path, 0) == '/') {
			return base_url()."assets".$path;
		} else {
			return base_url()."assets/".$path;
		}
	}

	/**
	* Save the load view request to the generate
	* function load it up.
	*
	* @access	public
	* @param	string
	* @param	array
	* @return	void
	*/
	function view($view_name, $data_array = array()){
		if(is_array($view_name)){
			foreach($view_name as $view)
				$this->view($view);	
		} else {		
			if(!is_array($data_array)){
				throw new Exception('The second argument of Page::View page must be an array.');
			} else {
				$this->view_list[] = array('name' => $view_name, 'data' => $data_array);
			}
		}
	}

	/**
	* Show user messages divs
	* to use this you create a session flash_message:
	* 		error_message - for errors
	* 		success_messages - for successes
	*
	* @access	public
	* @return	string
	*/
	function messages(){
		$return = "\n";
		if ($this->CI->session->flashdata('error_message')) {
			$return .= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			$return .= $this->CI->session->flashdata('error_message');
			$return .= '</div>';
		} else if ($this->CI->session->flashdata('success_message')) {
			$return .= '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			$return .= $this->CI->session->flashdata('success_message');
			$return .= '</div>';
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
	* Add custom code to page head script tag
	*
	* @access  public
	* @param  string
	* @return  bool
	*/
	function code($custom_code){
		$this->custom_js[] = $custom_code;
		return true;
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
		if ($this->profiler) {
			$this->CI->output->enable_profiler($this->profiler);
		}
		
		if ($this->js_utils) {
			// Passes site_url, base_url and php_vars to JS. Very useful for javascript frameworks.
			$this->code("// Javascript utils\n\t\tvar site_url = '".site_url()."';\n\t\tvar base_url = '".base_url()."';\n\t\tvar phpvars = ".json_encode($this->php_vars).";");
		}

		// Template header
		$this->CI->load->view(
		"../templates/{$this->template}/header",
		array(
			'head_info'			=> $this->head_info,
			'title'				=> $title,
			'metas'				=> $this->_compile_metas(),
			'css'				=> $this->_compile_css(PAGE_HEAD),
			'js'				=> $this->_compile_js(PAGE_HEAD),
		));
		
		// Foreach saved view in the view_list array load it
		foreach($this->view_list as $view){
			$this->CI->load->view($view['name'], $view['data']);
		}

		// Footer
		$this->CI->load->view(
			"../templates/{$this->template}/footer",
			array(
				'js'			=> $this->_compile_js(PAGE_BODY)
			)
		);

		// Okay dood!
		$this->CI->benchmark->mark('benchmark_end');
	}

	/**
	* Compiles every css that has been passed to the
	* library to one string and returns it.
	*
	* @access	private
	* @param	position int - defines the css to return
	* @return	string
	*/
	private function _compile_css(){
		$compiled_css = "";
		foreach($this->css as $css_file){
			$compiled_css .= "\t<link rel=\"stylesheet\" href=\"".$this->assets_url('css')."/{$css_file}.css\" />\n";
		}
		
		if ($compiled_css == "") return "";

		return "<!-- START Compiled CSS -->\n".$compiled_css."\t<!-- END Compiled CSS -->\n";
	}

	/**
	* Compiles every js that has been passed to the
	* class to one string and returns it.
	*
	* @access	private
	* @return	string
	*/
	private function _compile_js($position){
		$compiled_js = "";
		foreach($this->js[$position] as $js_file){
			$compiled_js .= "\t<script type=\"text/javascript\" src=\"".$this->assets_url('js')."/{$js_file}.js\"></script>\n";
		}
		if (sizeof($this->custom_js) != 0 && $position == PAGE_HEAD) {
			$compiled_js .= "\t<script type=\"text/javascript\">";
			foreach ($this->custom_js as $custom_js) if ($custom_js != '') $compiled_js .= $custom_js;
			$compiled_js .= "\t</script>";
		}
		if ($compiled_js == "") return "";
		
		return "<!-- START Compiled JS -->\n".$compiled_js."\t<!-- END Compiled JS -->\n";
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
		if ($compiled_metas == "") return "";
		
		return "<!-- START Compiled META -->\n".$compiled_metas."\t<!-- END Compiled META -->\n";
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