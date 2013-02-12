<?php
/* 
Author: Cicero Monteiro 

Description:
	Connects to the database
*/
class Connect
{
	private $host = HOST;
	private $database = DATABASE;
	private $login = USERNAME;
	private $pswd = PASSWORD;
	private $r = FALSE;

	function __construct()
	{
		if ($con = mysql_connect($this->host,$this->login,$this->pswd))
		{
			if ($sel = mysql_select_db($this->database,$con))
			{
				$this->r = $con;
				mysql_query("SET NAMES 'utf8'");
				mysql_query('SET character_set_connection=utf8');
				mysql_query('SET character_set_client=utf8');
				mysql_query('SET character_set_results=utf8');
			}
		}
		return $this->r;
	}
}
?>
