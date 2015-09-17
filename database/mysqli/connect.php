<?php 

class DatabaseException extends Exception { }

require_once('extend_mysqli.php');
 
/**
 * This class handles multiple Database connections and allows you to utilise lazy connections
 */ 
class connect 
{
	private static $instance;
	private $_connections = array();

 /**
  * gets the instance via lazy initialization (created on first usage)
  *
  * @return self
  */
	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

 /**
  * is not allowed to call from outside: private!
  *
  */
  private function __construct()
  {
  }

 /**
  * prevent the instance from being cloned
  *
  * @return void
  */
  private function __clone()
  {
  }

 /**
  * prevent from being unserialized
  *
  * @return void
  */
  private function __wakeup()
  {
  }
	

	public function createConnection($handle,$host,$database,$userName = null,$password = null) 
	{
		$this->_connections[$handle] = array('host' 	  => $host,
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
					throw new DatabaseException('Database Connect: Mysqli Connect Error: '.mysqli_connect_error());
				}
			}
		}
		
		throw new DatabaseException('Database Connect: Could not find a connection with the handle ' . $handle);
	}


	public function __get($handle) {
		try {
		  return $this->getDatabaseConnection($handle);
		}
		catch (DatabaseException $e) {
			die($e->getMessage());
		}
	}
}
 