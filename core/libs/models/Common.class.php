<?php
/* 
Author: Ot‡vio Barbosa / Cicero Monteiro

Description:
	Defines common methods used by various classes of objects
*/
class Common
{
	function connect()
	{
		return new Connect();
	}
	function constructor($params)
	{
		$this->connect();
		if($params!=NULL)
		{
			if(is_array($params))
			{
                foreach ($params as $k=>$v)
                {
                    if(property_exists($this, $k))
                    {
                        $this->set($k, $v);
                    }
                }
			}
        }
	}
	// generic getter and setter
	function set($attr, $value)
	{
		$this->$attr = $value;
	}
	function get($attr)
	{
		return $this->$attr;
	}
	// deprecated, consider revision
	function get_keys()
	{
		return array_keys(get_object_vars($this));
	}
}
?>