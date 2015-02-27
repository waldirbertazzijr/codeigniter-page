# Codeigniter Page Library V. 1.0.0
This library is the perfect not-overcomplicated way to manage your app assets like CSS, Javascript, images and more. Designed to be fast and simple.

## Installation and Concepts
### Installation
The installation is pretty simple.

* Paste the Page Library inside your application library folder.
* Paste the _templates_ folder inside your application folder. This folder contains the standard HTML5 header and footer code. You can check it out.
* Paste the _assets_ folder in the same level that resides your application folder.

### Folder Description
#### Template Folders
It contains the basic template for where (ideally) your CSS, Javascript and meta tags should be positioned. You can check it out, it's pretty simple.

#### Assets Folder
Contains all the basic web assets like images, css and javascript code.

##### Vendor
This is a special folder for you to put code from other people or libraries.


## Usage
Here is listed some of the most common actions when developing a web app with assets. Examples of:

### Loading a view
Now that you have Page library, you should not use the main Codeigniter view support, instead, use:

	// Loads the view
	$this->page->view('view_name', $data);
	$this->page->generate('Nice Page Title!');

It works exactly the same the native codeigniter view command. To draw everything you must call the generate method. The first parameter of generate method is the page HTML title.

### Adding a CSS File
By default, the library will load files from the _assets/css_ folder.

	// Let's add a CSS file
	$this->page->css('style');
	
	// Loads the view
	$this->page->view('view_name', $data);
	
	$this->page->generate('A nice title and a nice style!');

You can navigate on the folder tree using two dots. So to load a vendor CSS you may use:

	$this->page->css('../vendor/bootstrap/css/bootstrap.min.css');

codeigniter-page tries to automatically add the .css for you so it's not necessary.
You can also pass an array of files to load:

	$this->page->css(array('style_generics', 'footer_generics', 'pretty_colors'));
	
	// Loads the special CSS if is needed
	if($special_user)
		$this->page->css('special_css');


### Adding a Javascript File
By default, the library will load files from the _assets/js_ folder.

	// Let's add a CSS file
	$this->page->css('style');
	
	// Let's add a JS file in the page HEAD
	$this->page->js('smart_engineering');
	
	// Loads the view
	$this->page->view('view_name', $data);
	
	$this->page->generate('A nice title, a nice style with smart engineering!');

You can navigate on the folder tree using two dots. So to load a vendor JS you may use:

	$this->page->js('../vendor/bootstrap/css/bootstrap.min.css');

codeigniter-page tries to automatically add the .js for you so it's not necessary.
You can choose where page library will put your Javascript inside the page. You can call:

	$this->page->js('smart_engineering', PAGE_HEAD);

So that javascript will be loaded in page head instead page bottom.

You can also pass an array of files to load:

	$this->page->js(array('aphex', 'twin', 'foo'));
	
	// Loads the special JS if is needed
	if($special_user)
		$this->page->js('special_engineering');