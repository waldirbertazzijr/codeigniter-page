<?php
/**
 * Orion Project
 *
 * And advanced, feature-rich PHP framework.
 *
 * @author		Waldir Bertazzi Junior
 */

// ------------------------------------------------------------------------

// jquery default library

$library = array(
			'class'				=> 'ga'
);

// this is the custom jqueryu

class google_analytics extends CI_Weblibrary {
	function __construct(){
		parent::__construct();
	}
	function initialize($analytics_code){
		$this->add_code("
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '".$analytics_code."']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		");
	}
}