<?php
/*	PATHANG			- A SLEAK PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 			- pathang.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.pathang.net
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// pathang is the core class of application
// which handles the core switching mechanism
class pathang extends Error
{
		// varaible to store object references	
		private static $instance = array();
		
		// the main function of the class
		public function main(){
			//set the configuration
			$config = json_decode(file_get_contents('config.json'));

			foreach($config as $property => &$value)
				$this->$property = &$value;
			

			$root= $this->SITE->ROOT;
			define('ROOT',$root);

			if(!$this->SITE->INSTALLATION){
				require_once 'app/root.php';
				$rootObj = new ControllerRoot();
				$rootObj->installation();
				exit();
			}
			
			//load the node file and initiate the process of routing
			require_once "lib".DS."node.php";
			$node = pathang::getInstance('node');
			
			$node->router();
		}

				
		//function to load the classes automatically
		private static function _autoload($class){
			$paths = array('lib','app'.DS.'controllers','app'.DS.'models');
			foreach($paths as $path)
			{
				$file = $path.DS.$class.'.php';
				if(file_exists($file))
					require_once $file;
			}
		}
		
		//function to store the values to object variables
		public function set($key,$value){
			$this->$key = $value;
		}
		
		//function to retrieve the data from object varaibles
		public function get($key){
			if(isset($this->$key))
				return $this->$key;
			else
				return null;
		}
		
		// function to contruct and store the reference of the object
		public static function getInstance($class){
			if(isset(self::$instance[$class]))
				return self::$instance[$class];
			else
			{
				//if the class doesnot exists call the autoload function
				if(!class_exists($class))
				self::_autoload($class);
				
				//if the object required is pdo then 
				// extract the config data from kite object
				// and create a pdo object using it
				if($class == 'pdo')
				{
					$pathang = pathang::getInstance('pathang');
					$host = $pathang->DB->HOST;
					$db_name = $pathang->DB->DB_NAME;
					$username = $pathang->DB->USERNAME;
					$password = $pathang->DB->PASSWORD;
					
					self::$instance[$class] = new PDO("mysql:host=$host;dbname=$db_name", "$username", "$password");
				}else	
				self::$instance[$class] = new $class();
				return self::$instance[$class];
			}	
		}
		
		//function to render the view to template or json/html format
		public static function render($view,$tpl=null){
			$pathang = pathang::getInstance('pathang');
			// get the terminal node extension
			$node = pathang::getInstance('node');
			$ext= $node->get('terminal_ext');
			
			// set the view as pathang object variable
			//so as to use in the application call from template
			$pathang->set('VIEW',$view);
			//get the details of template and hash from pathang object
			$theme = $pathang->SITE->THEME;
			$page = $pathang->SITE->PAGE;
			$site_hash = $pathang->SITE->HASH;
			//check if security to display html/json is true or false
			$secure = $pathang->SITE->SECURE;
			
			//setting the view template to default
			if($tpl==null)
				$tpl = 'default';
			if(isset($pathang->THEME))
				$theme=$pathang->THEME;
			if(isset($pathang->PAGE))
				$page=$pathang->PAGE;
					
			//get the url parameters for template and hash if they exists
			$request = pathang::getInstance('request');
			if($request->get('theme')!=null)
			$theme = $request->get('theme');
			if($request->get('page')!=null)
			$page = $request->get('page');
			//if($request->get('hash')!=null)
			$hash =$request->get('hash');
			
			
			//if secure is not true then give access to display json/html format
			if($secure ==0)
				$hash = $site_hash;
				
			$basket = pathang::getInstance('basket');
			
			//if terminal extension is json then display json format
			if($ext==='json')
			{
				if( $site_hash===$hash){
					header("content-type:application/json; charset=UTF-8");
					echo json_encode($basket, JSON_PRETTY_PRINT);
					exit();
					
				}
				else
					Error::message('Access Restricted: Hash code required to access');
			//if the terminal extension is html then render only html without template	
			}else if(	$ext==='html' )
			{
				if( $site_hash===$hash)
					require_once "app".DS."views".DS.$view.DS.$tpl.".php";
				else
					Error::message('Access Restricted: Hash code required to access');
			//else display template +view		
			}else
			{	
				$pathang->set('THEME',$theme);
				$pathang->set('PAGE',$page);
				$pathang->set('TPL',$tpl);
				$template = "themes".DS.$theme.DS.$page.".php";
				if(file_exists($template))
					require_once 	$template;
				else
					Error::message("Template <b>$theme</b> ($page page) not found");
			}	
				
		}
		
		//function called from the template
		//to load the application
		public static function app(){
			//get the values of app and the view to 
			//be rendered from the kite object
			$pathang = pathang::getInstance('pathang');
			$view = $pathang->get('VIEW');
			$tpl = $pathang->get('TPL');
			require_once "app".DS."views".DS.$view.DS.$tpl.".php";
		}
		
		//function to call the other controllers
		public static function getController($controller){
			$file = 'app'.DS.'controllers'.DS.$controller.'.php';
			if(file_exists($file))
			{
				require_once($file);
				$controllerName = 'controller'.$controller;
				$controllerObj = new $controllerName();
				return $controllerObj;
			}else
				Error::message("$controller controller not found");
		}

		//function to call te model of the application
		public static function getModel($model){
			
			$file = "app".DS."models".DS.$model.".php";
			//check if the model exists then load the model file
			if(file_exists($file))
			{					
				require_once $file;
				$modelName = 'model'.$model;
				$modelObj = new $modelName();
				return $modelObj;
			}
			else
				Error::message("model doesnt exists");
		}

		//function to call the helper classes 
		public static function getHelper($helper){
			$file = 'app'.DS.'helpers'.DS.$helper.'.php';
			if(file_exists($file))
			{
				require_once $file;
				$helperName = 'helper'.$helper;
				$helperObj = new $helperName();
				return $helperObj;
			}else
				Error::message("$helper helper not found");
		}
		
		//function to load the desired snippet in template file
		public static function snippet($snippet){
			$file = 'snippets'.DS.$snippet.DS.$snippet.'.php';
			$pathang = pathang::getInstance('pathang');
			$pathang->set('snippet',$snippet);
			if(file_exists($file))
			{
				require_once $file;
				$snippetName = 'snippet'.$snippet;
				$snippetObj = new $snippetName();
				$snippetObj->main();
			}
			else
				Error::message('Snippet not found');
		}

		//function used in snippets to display output
		public static function display($tmpl=null){
			if($tmpl==null)
				$tmpl='default';
			$pathang = pathang::getInstance('pathang');
			$snippet = $pathang->get('snippet');	
			$file = $file = 'snippets'.DS.$snippet.DS.'tmpl'.DS.$tmpl.'.php';
			if(file_exists($file))
				require_once $file;
			else
				Error::message("Snippet $snippet template file $tmpl not found");
		}
		
		// get site Meta information
		public static function Meta($key){
			$pathang = pathang::getInstance('pathang');
			$key = strtoupper($key);
			if(isset($pathang->META->$key))
			echo $pathang->META->$key;
		}

		public static function redirect($key)
		{
			header("Location: $key");
		}

}