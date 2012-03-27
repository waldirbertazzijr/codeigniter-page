# Codeigniter Page Library V. 0.1a
This library is a extremely robust and flexible library for you to build websites more easily and focus on the code and forget about the structure.
Page weblibraries adds the power of javascript to your PHP files. The default HTML scructure follows the most advanced HTML5 page layout and it's based on HTML5 Boilerplate. There is also a CSS reseter and much more! Please keep reading.

## What are weblibraries?
Weblibraries are small pieces of javascript that can talk to your page automagically. They integrates with Page library and allow you to use Javascript code within Codeigniter, so you don't have to worry about importing them. For example, if you want to add a Visual editor (WYSIWYG editor), just load the visual_editor weblibrary to the page library in any controller like this:

	$this->page->load('visual_editor');

After this, the visual editor weblibrary will be ready to user. Now you can put this in your view:
	
	$this->page->ve->open('.product_description', true);

And ta-da! You have a visual editor ready to use. You don't have to worry about the javascript. The page library will handle it for you and put the .js files and .css files in the page header. After loading the weblibrary, it will be available in:

	$this->page->X->method();

Where X is the weblibrary name's initial characters. For instance, Visual Editor will be vd.

## Quick Start
The page library comes with a predefined structure. If you follow this structure, you don't have to change anything. This is a quick guide to help you run your page library.
Copy the "assets" folder to your app root. Inside assets you will find the css, js, images and weblibraries folders. Now:

* Copy the Page and Weblibrary libraries to your application.
* Copy the application/templates to your application folder.
* Copy the assets folder to you app root.
* You are ready to go!

## How to use it
Here is listed some of the most common functions that you will need:
### Loading views and generating the final HTML
You have to change the way you load your views. Normally, you would start by loading views using the codeigniter's default way (using $this->load->view()). If you want to have all the Page library's power, you must load this way:

	$this->page->view('view/name', array('data'=>$to_the_view));

It's really the same as the default way. First the view name, second the parameters. When all your views are ready, you must use

	$this->page->generate('Hello, this is the page title!');

This will generate and output all the HTML for you with the title you want.

### Inserting a CSS into your page
**All your css must be inside the /assets/css/ folder!** The page library will add it automatically for you but you have to put it there.
For instance, I have created a css file called **login.css** inside the **/assets/css/** folder. After that, just use:

	$this->page->css('login');

And bang! Your css will be imported into the next generate(); function.

### Importing a JS file into your page
**All your javascript must be inside the /assets/js/ folder!** The page library will add it automatically for you but you have to put it there.
For instance, I have created a css file called **ajax_login.js** inside the **/assets/js/** folder. After that, just use:

	$this->page->js('ajax_login');

And bang! Your js will be imported into the next generate(); function.

### Loading weblibraries
You can check the list of all available weblibraries if you go to the folder **/assets/weblibraries/**. As you already know, they are pieces of javascript that integrates with the Page library.
Some weblibraries have they own methods, some do not. For example, jQuery don't have any methods. When you load it, all it does is inserting a javascript into the page header (in this case, jquery.min.js will be loaded).
To load a weblibrary you can use:

	$this->page->load('lightbox');

The lightbox, in the other hand, have they own methods. For now, you can check its methods if you open **/assets/weblibraries/lightbox/weblibrary.php**.


### Inserting a custom code into your page
It's really easy to add a custom javascript code to your page. Just use:

	$this->user->code('
		$(function){
			alert("Hello World!");
		}
	');

This will put the code into the right scripts tags into the page header.

### Inserting a custom css into your page
It's really easy to add a custom css code to your page. Just use:

	$this->user->style('
		#my_div{ color: #444; text-shadow: 0 1px 0 #fff; }
	');

This will put the code into the right style tags into the page header.

### Inserting custom meta tags into your page
It's really easy to add custom meta tags to your page. Just use:

	$this->user->meta('author', 'Jimi Hendrix');
	$this->user->meta('company', 'Feel Good Inc.');

This will create the meta tags.

---
# Changelog
* Version 0.1a
	* First commit to github.
	* Added a simple documentation.