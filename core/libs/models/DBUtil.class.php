<?php
/* 
Author: Otavio Barbosa / Cicero Monteiro

Description:
	Defines the SQL strings that accesses the database
	This is CORE!!!
*/
include "Inflector.class.php";

class DBUtil extends Inflector
{
	/* Returns SQL string to create an object */
	function SQL_Create($obj)
	{
		$sql = "INSERT INTO ".$this->get_db_name(get_class($obj));
		$str_keys   = "";
		$str_values = "";
		$arr_keys   = $obj->get_keys();
		$obj_size   = sizeof($arr_keys);
		for($i=0; $i<$obj_size; $i++)
		{
			if(($obj->get($arr_keys[$i]) != NULL) && ($arr_keys[$i] != 'rel'))
			{
				$str_keys .= $str_keys == "" ? $arr_keys[$i] : ",".$arr_keys[$i];
				$str_values .= $str_values == "" ? "'".injection($obj->get($arr_keys[$i]))."'" : ",'".injection($obj->get($arr_keys[$i]))."'";
			}
		}
		$str_keys .= $str_keys == "" ? "created_at" : ",created_at";
		$str_values .= $str_values == "" ? "'".now()."'" : ",'".now()."'";

		return $sql." (".$str_keys.") VALUES (".$str_values.")";
	}
	/* Returns SQL string to retrieve an object */
	function SQL_Retrieve($obj, $params=NULL, $active=NULL, $pk='id')
	{
		$sql = "SELECT * FROM ".$this->get_db_name($obj);
		$where = "";
		$deleted = $active ? "deleted_at IS NULL" : "deleted_at IS NOT NULL";
		if($params)
		{
			if(is_numeric($params))// id
			{
				$where = "WHERE $pk = '".$params."'";
			}
			else if(is_array($params))// array
			{
				$where .= "WHERE ";
				$keys = array_keys($params);
				$sizeof = sizeof($params);
				for ($i=0;$i<$sizeof;$i++)
				{
					if ($i>0)
					{
						$where .= " AND";
					}
					$where .= " ".$keys[$i]." = '".$params[$keys[$i]]."'";
				}
			}
			else if ($params != "all")// string sql
			{
				$where = $params."";
			}
			else// all
			{
				$where = "WHERE ".$deleted;
			}
		}
		else
		{
			$where = "WHERE ".$deleted;
		}
		return $sql." ".$where;
	}
	/* Returns SQL string to update an object */
	function SQL_Update($obj, $act_obj, $pk="id")
	{
		$sql = "UPDATE ".$this->get_db_name(get_class($obj))." SET ";
		$str_params = "";
		$arr_keys = $obj->get_keys();
		$obj_size = sizeof($arr_keys);
		for($i=0; $i<$obj_size; $i++)
		{
			if($arr_keys[$i]!="$pk")
			{
				if (($act_obj->get($arr_keys[$i]) != $obj->get($arr_keys[$i])) && !is_array($obj->get($arr_keys[$i])))
				{
					$str_params .= $str_params == "" ? " ".$arr_keys[$i]."='".injection($obj->get($arr_keys[$i]))."'" : ", ".$arr_keys[$i]."='".injection($obj->get($arr_keys[$i]))."'";
				}
			}
		}
		$sql .= $str_params == "" ? "" : $str_params.", ";
		$sql .= " updated_at='".now()."'";
		return $sql." WHERE $pk='".$obj->get($pk)."'";
	}
	/* Returns SQL string to virtual delete an object */
	function SQL_Delete($obj, $pk="id")
	{
		$sql = "UPDATE ".$this->get_db_name(get_class($obj))." SET deleted_at='".now()."' WHERE $pk='".$obj->get($pk)."'";
		return $sql;
	}
	/* Returns SQL string to remove an object from the database */
	function SQL_Remove($obj, $pk="id")
	{
		$sql = "DELETE FROM ".$this->get_db_name(get_class($obj))." WHERE $pk = '".$obj->get($pk)."'";
		return $sql;
	}
	/* Internal: gets the name of the table, based on the class name */
	function get_db_name($class)
	{
		return $this->pluralize($this->singularize(strtolower($class)));
	}
}
?>
