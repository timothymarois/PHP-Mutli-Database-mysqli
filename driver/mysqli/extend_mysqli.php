<?php 
 /**
  * Extends mysqli and adds the ability to easily apc cache queries
  */
class extend_mysqli extends mysqli 
{
	/**
     * This Function overwrites the mysql query function but should return the same objects
     */
	public function query($query,$resultmode=null)
	{
		if($return = parent::query($query))
		{
			if ($resultmode==='row') 
			{
				$r = $return->fetch_object();
				$return->free();
			}
			elseif ($resultmode==='result') 
			{
				$r = $this->_buildArray($return);
				$return->free();
			}
			else {
				$r = true;
			}

			return $r;
		}
		else
		{
			return false;
		} 
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
 