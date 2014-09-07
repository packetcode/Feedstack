<?php
/*	PATHANG			- A SLEAK PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 			- node.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.pathang.net
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// A class which deals with url and its fragments(nodes)
// the nodes are named as n1,n2,n3... respectively
// the first few nodes are used for understand the application
// and the rest are used in application for processing

class node extends pathang{
		
		// node class router function	
		public function router(){
			//get the nodes to node object
			$this->nodes();
			
			require_once 'app'.DS.'root.php';
			$controller = new ControllerRoot();
			if(!isset($this->n1))
			{
				$controller->main();
			}	
			elseif(method_exists('controllerRoot',$this->n1))
			{
				$method = $this->n1;
				$controller->$method();
			}else
				$controller->main();
		}
		
		// if the controller exists then call the controller
		//also store the values in  Pathang object
		public function nodes(){
			// check if the url parameter is set
			if(isset($_GET['url']))
			{
				// load the url into url variable
				$url = $_GET['url'];
				
				//trim the url to remove slashes on right
				$url = rtrim($url,'/');
				define('URL',$url);
				//break the url to fragments
				$url = explode('/',$url);
				//load the url to the object variable 
				// as n1,n2,n3....
				foreach($url as $key => $value)
				{
					$key++;
					$this->set('n'.$key,$value);	
				}
				// store the terminal position of the node
				$terminal_node = 'n'.sizeof($url);
				$terminal_position = sizeof($url);
				$this->set('terminal_position',$terminal_position);			
				$this->set('terminal_node',$terminal_node);			
				$this->node_terminal();	
			}else
			{
				$this->set('terminal_position',0);			
				$this->set('terminal_node',null);			
			}	
		}
		
		//function which analyses the last node 
		//and picks up the extension and stores in node object
		public function node_terminal(){
			$terminal_node = $this->get('terminal_node');
			$terminal = $this->$terminal_node;
			$terminal_items = explode('.',$terminal);	
			
			if(isset($terminal_items[0]))
				$this->set('terminal_item',$terminal_items[0]);
			if(	isset($terminal_items[1]))
				$this->set('terminal_ext',$terminal_items[1]);
			
			//update the terminal node
			$this->set($terminal_node,$terminal_items[0]);
		}

}
