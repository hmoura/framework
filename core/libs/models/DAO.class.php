<?php
/* 
Author: Ot?vio Barbosa / Cicero Monteiro 

Description:
	Generic Data Access Object Class
	Defines the generic methods to manage objects
*/
include "DBUtil.class.php";

class DAO extends DBUtil
{
	var $sql;
	var $Return = FALSE;
	var $Debbug = FALSE;// change to debbug

	function connect()
	{
		return new Connect();
	}
	/* Gets an object */
	function get($class, $params=NULL)
	{
		$this->Return = FALSE;
		$this->connect();
		if($params==NULL || is_array($params))
		{
			$this->Return = $this->get_new($class, $params);
		}
		else if(is_numeric($params) || is_string($params))
		{
			$this->Return = $this->Retrieve($class, $params);
		}
		//mysql_close();

		return $this->Return;
	}
	/* Create a new object */
	function Create($obj, $debbug=false)
	{
		global $MSG;
		$error = false;
		$this->Return = false;
		$this->connect();
		$this->sql = $this->SQL_Create($obj);
		if(mysql_query($this->sql))
		{
			$this->Return = mysql_insert_id();
		}
		else
			$error = mysql_error();
		if ($debbug)
		{
			$MSG->notice[] = $this->sql;
			if ($error)
				$MSG->error[] = $error;
		}

		return $this->Return;
	}
	/* Retrieves an existing object */
	function Retrieve($class, $param=FALSE, $active=TRUE, $unique=FALSE, $debbug=false, $pk='id')
	{
		global $MSG;
		$this->Return = FALSE;
		$con = $this->connect();
		$this->sql = $this->SQL_Retrieve($class, $param, $active, $pk);
		if($q = mysql_query($this->sql))
		{
			if(mysql_num_rows($q))
			{
				if(is_numeric($param) || $unique)
				{
					$rs = mysql_fetch_array($q);
					$this->Return = $this->get_new($class, $rs);
				}
				else
				{
					$arr = array();
					while($rs = mysql_fetch_array($q))
					{
						array_push($arr, $this->get_new($class, $rs));
					}
					$this->Return = $arr;
				}
			}
		}
		if ($debbug)
		{
			$MSG->notice[] = $this->sql;
			if (mysql_error())
			{
				$MSG->error[] = mysql_error();
			}
		}
		//mysql_close();
		return $this->Return;
	}
	/* Updates an object */
	// salva o log dentro de DBUtil
	function Update($obj, $debbug=false, $pk='id')
	{
		global $MSG;
		if (!is_object($obj)) return false;
		$act_obj = $this->Retrieve(get_class($obj), $obj->get($pk), TRUE, TRUE);
		$this->Return = FALSE;
		$this->connect();
		$this->sql = $this->SQL_Update($obj, $act_obj, $pk);

		if(mysql_query($this->sql))
		{
			$this->Return = TRUE;
		}
		if ($debbug)
		{
			$MSG->notice[] = $this->sql;
			if (mysql_error())
			{
				$MSG->error[] = mysql_error();
			}
		}
		//mysql_close();
		return $this->Return;
	}
	/* Virtual delete of an object. It sets the field deleted_at in the database */
	function Delete($obj, $debbug=false, $pk='id')
	{
		global $MSG;
		$this->Return = FALSE;
		$this->connect();
		$this->sql = $this->SQL_Delete($obj, $pk);
		//echo $this->sql;
		if(mysql_query($this->sql))
		{
			$this->Return = TRUE;
		}
		if ($debbug)
		{
			$MSG->notice[] = $this->sql;
			$MSG->error[] = mysql_error();
		}
		//mysql_close();
		return $this->Return;
	}
	/* Removes an object, deleting it from the database */
	function Remove($obj, $debbug=false, $pk='id')
	{
		global $MSG;
		if (is_array($obj))// array de objetos
		{
			foreach ($obj as $k=>$v)
			{
				$this->Remove($v, $debbug, $pk);
			}
		}
		else if (is_object($obj))
		{
			$this->Return = FALSE;
			$this->connect();
			$this->sql = $this->SQL_Remove($obj, $pk);
			if(mysql_query($this->sql))
			{
				$this->Return = TRUE;
			}
		}
		if ($debbug)
		{
			$MSG->notice[] = $this->sql;
			$MSG->error[] = mysql_error();
		}
		//mysql_close();
		return $this->Return;
	}
	/* Retrieves related objects using foreign keys */
	function get_related($obj, $exception=array())// retreive related objects
	{
		$arr = object_2_array($obj);
		$objs = array();
		foreach ($arr as $k=>$v)
		{
			if (strstr($k, '_id') && !in_array($k, $exception))// if it's foreign key
			{
				$field = explode('_', $k);
				array_pop($field);
				$f = count($field) ? implode('_', $field) : $field[0];
				$objs[$f] = $this->Retrieve(ucwords($this->get_db_name($f)), $v, true, true);
			}
		}
		return count($objs) ? $objs : false;
	}
	/* Internal: gets a generic object */
	function get_new($class, $params=NULL)
	{
		$obj = $this->singularize(ucwords($class));
		return new $obj($params);
	}
}

?>