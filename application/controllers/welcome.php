<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		// Loading the Orion page's Library
		$this->load->library('page');
				
		// this is how to add a css file to your page header
		$this->page->css('style');
		
		// this will load welcome_message view
		$this->page->view('welcome_message');
		
		// generates the page. The argument is the page title.
		$this->page->generate('Welcome to Orion Project');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */