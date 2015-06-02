<?php 

 require_once('extend_mysqli.php');
 
/**
 * This class handles multiple Database connections and allows you to utilise lazy connections
 */ 
class connect 
{
	private static $_instance = null;
	private $_connections = array();

	public function __construct() {

	}

	
	// added "static" to fix non-static method warning)
	public static function getInstance()
	{ 
		if(!self::$_instance instanceof self) 
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	

	public function createConnection($handle,$host,$database,$userName = null,$password = null) 
	{
		$this->_connections[$handle] = array('host' 	=> $host,
		 	                                 'database' => $database,
		 	                                 'userName' => $userName,
		 	                                 'password' => $password);
		return $this;
	}
	

	public function getDatabaseConnection($handle)
	{
		if(isset($this->_connections[$handle]))
		{
			if(isset($this->_connections[$handle]['object']))
			{
				return $this->_connections[$handle]['object'];
			}
			else
			{
				$connectionData = $this->_connections[$handle];
				$object = new extend_mysqli($connectionData['host'],$connectionData['userName'],$connectionData['password'],$connectionData['database']);
										  
				// $object->options(MYSQLI_OPT_CONNECT_TIMEOUT,5);
				//This is a non OO method - only used for pre 5.2.9 compat.
				if(!mysqli_connect_error()) {
				    $this->_connections[$handle]['object'] = $object;
					return $object;
				}
				else
				{
					throw new Exception('Connect: Mysqli Connect Error: '.mysqli_connect_error());
				}
			}
		}
		
		throw new Exception('Connect: Could not find a connection with the handle ' . $handle);
	  }


	public function __get($handle) 
	{
		return $this->getDatabaseConnection($handle);
	}
}
 