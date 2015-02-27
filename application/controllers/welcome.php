<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		// Loading the lib
		$this->load->library('page');
		
		// this is how to add a css file to your page
		$this->page->css('bootstrap.min.css');
		
		// this is how to add js files after the page body
		$this->page->js(array('jquery-1.9.1.min.js', 'bootstrap.min.js'), PAGE_HEAD);
		
		// this will load welcome_message view
		$this->page->view('welcome_message');
		
		// generates the page. The argument is the page title.
		$this->page->generate('Welcome to Codeigniter-page');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */