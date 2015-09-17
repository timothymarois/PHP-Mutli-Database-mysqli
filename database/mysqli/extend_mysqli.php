<?php 

/**
 * Extends mysqli and adds the ability to easily apc cache queries
 */
class extend_mysqli extends mysqli 
{
	private $return;

	/**
   * This Function overwrites the mysql query function but should return the same objects
   */
	public function query($query='')
	{
		if($query!='' && $this->return = parent::query($query)) 
		{
			return $this;
		}
		
		return false;
	}  

	public function row() {
		if ($this->return) {
			return $this->return->fetch_object();
		}

		return false;
	}

	public function result() {
		if ($this->return) {
		  return $this->_buildArray($this->return);
		}

		return false;
	}

	public function affected_rows() {
		if ($this->affected_rows) {
			return $this->affected_rows;
		}

		return false;
	}

	public function insert_id() {
		if ($this->insert_id) {
			return $this->insert_id;
		}

		return false;
	}

	
	/**
   * This function loops through the results and returns them as an array of objects
   */
	private function _fetch_assoc_obj_array(mysqli_result $result)
	{
		$array = array();
    	
		while($obj = $result->fetch_object() && $assoc = $result->fetch_assoc())
		{
			$array[$assoc] = $obj;
		}
    	
		return $array;
	}
    
	
	/**
   * This function loops through the results and returns them as an array of objects
   */
	private function _buildArray(mysqli_result $result)
	{
		$array = array();
    	
		while($obj = $result->fetch_object())
		{
			$array[] = $obj;
		}
    	
		return $array;
	}

 }
