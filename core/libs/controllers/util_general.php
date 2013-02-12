<?php
/****************************
**    GENERAL FUNCTIONS    **
*****************************/

// sanitize data
function injection($vlw)
{
	global $MYSQLI;
	if (is_type($vlw, 'float'))
	{
		$vlw = c_float($vlw);
	}
	else if (is_type($vlw, 'date'))
	{
		$vlw = format_date($vlw, '-');
	}
	else// regular string
	{
		$vlw = htmlspecialchars(stripslashes($vlw));
        $vlw = str_ireplace("script", "blocked", $vlw);
        $vlw = mysqli_real_escape_string($MYSQLI, $vlw);
        $vlw = trim($vlw);
	}
	return $vlw;
}

// verify different types of data via regex
function is_type($vlw, $type)
{
	$r = FALSE;
	if (is_string($vlw))
	{
		switch ($type)
		{
			case "int":
				$regex = "/^[0-9]{1,}$/";
				break;
			case "float":
				$regex = "/^([0-9]{1,3}\.?){1,}((\,[0-9]{2}){1})?$/";
				break;
			case "date":
				//$regex = "/^([0-9]{2,4}\/?\-?){2}([0-9]{2,4}\/?\-?)((\s?[0-9]{2}\:?){3})?$/";
				$regex = "/^([0-9]{2})\/?\-?([0-9]{2})\/?\-?([0-9]{4})$/";
				break;
			default:
				break;
		}
		if (preg_match($regex, $vlw))
		{
			$r = TRUE;
		}
	}
	return $r;
}

// format numbers as float values to insert into or retreive from the db
function c_float($vlw, $op=FALSE)
{
	if ($op)
	{
		return number_format($vlw, 2, ',', '.');
	}
	else if (strstr($vlw, ","))
	{
		$vlw = str_replace('.', '', $vlw);
		return str_replace(',','.', $vlw);
	}
	else if ($op && strstr($vlw, "."))
	{
		return str_replace('.',',', $vlw);
	}
	return $vlw;
}

// formats like currency value
function f_currency($vlw, $symbol=true)
{
	if ($vlw)
	{
    	return $symbol ? "R$ ".number_format($vlw, 2, ',', '') : number_format($vlw, 2, ',', '');
	}
	else
	{
		return false;
	}
}

// generates urls by given models/views/params
function url($model=false, $view=false, $params=false)
{
	global $CFG;
	$page = $CFG->wwwroot;
	if ($model)
	{
		$inf = new Inflector();
		$page .= $model ? "/".$inf->pluralize($model) : "";
		$page .= $view ? "/".$view : "";
		if (!is_array($params) && $params)
		{
			$page .= "/$params";
		}
		else if ($params)
		{
			if (count($params))
			{
				foreach ($params as $k=>$v)
				{
					$page .= "/$k/$v";
				}
			}
		}
	}
	return $page;
}

// generates an uniq numeric only ID
function UID()
{
	$r = false;
	$num = array(0,1,2,3,4,5,6,7,8,9);
	for($i=0;$i<6;$i++)
	{
		$r .= array_rand($num);
	}
	return $r;
}

// generates a numeric id
function nuid($length=6)
{
    $id = uniqid(time());
    $numid = "";
    $arr = str_split($id);
    foreach ($arr as $v)
    {
        $numid .= is_type($v, 'int') ? $v : "";
    }
    $numid = str_shuffle($numid);
    if (strlen($numid) > $length)
    {
        $numid = substr($numid, 0, $length);
    }
    $numid = str_shuffle($numid);
    return $numid;
}

// generates a really good and unique token
function uuid() {   

     // Generate 128 bit random sequence
     $randmax_bits = strlen(base_convert(mt_getrandmax(), 10, 2));  // how many bits is mt_getrandmax()
     $x = '';
     while (strlen($x) < 128) {
         $maxbits = (128 - strlen($x) < $randmax_bits) ? 128 - strlen($x) :  $randmax_bits;
         $x .= str_pad(base_convert(mt_rand(0, pow(2,$maxbits)), 10, 2), $maxbits, "0", STR_PAD_LEFT);
     }

     // break into fields
     $a = array();
     $a['time_low_part'] = substr($x, 0, 32);
     $a['time_mid'] = substr($x, 32, 16);
     $a['time_hi_and_version'] = substr($x, 48, 16);
     $a['clock_seq'] = substr($x, 64, 16);
     $a['node_part'] =  substr($x, 80, 48);
    
     // Apply bit masks for "random or pseudo-random" version per RFC
     $a['time_hi_and_version'] = substr_replace($a['time_hi_and_version'], '0100', 0, 4);
     $a['clock_seq'] = substr_replace($a['clock_seq'], '10', 0, 2);

    // Format output
    return sprintf('%s%s%s%s%s',
        str_pad(base_convert($a['time_low_part'], 2, 16), 8, "0", STR_PAD_LEFT),
        str_pad(base_convert($a['time_mid'], 2, 16), 4, "0", STR_PAD_LEFT),
        str_pad(base_convert($a['time_hi_and_version'], 2, 16), 4, "0", STR_PAD_LEFT),
        str_pad(base_convert($a['clock_seq'], 2, 16), 4, "0", STR_PAD_LEFT),
        str_pad(base_convert($a['node_part'], 2, 16), 12, "0", STR_PAD_LEFT));
}

// updates a batch of data for one object
function batch_update($obj, $arr)
{
	foreach ($arr as $k=>$v)
	{
		if (is_array($v))
		{
			echo $k." - ".$v."<br />";
		}
		$obj->set($k, $v);
	}
	return $obj;
}

// validates the uniqueness of one field
function validates_uniqueness_of($attr, $array, $class, $field_name=FALSE)
{
	global $FIELDS;
	global $MSG;
	$dao = new DAO();
	if ($dao->Retrieve($class, array($attr=>$array[$attr]), TRUE, TRUE))
	{
		$field_name = $field_name ? $field_name : $attr;
		$FIELDS[] = $attr;
		$MSG->error[] = "<strong>$field_name</strong> Já existe.";
	}
	return false;
}

// validates the presence of one field
function validates_presence_of($model, $view, $field_name=FALSE)
{
    global $FIELDS;
    global $MSG;
    $field_name = $field_name ? $field_name : $view;
    if (!@$_POST['data'][ucwords($model)][$view])
    {
        $FIELDS[] = ucwords($model)."_".ucwords($view);
        $MSG->error[] = "O campo <strong>$field_name</strong> não pode ser nulo.";
    }
    return false;
}

// validates format of one field
function validates_format_of($model, $view, $format, $field_name=FALSE, $required=FALSE)
{
    global $FIELDS;
    global $MSG;
    $field_name = $field_name ? $field_name : $view;
    switch ($format)
    {
        case "email":
            if (!filter_var($_POST['data'][$model][$view], FILTER_VALIDATE_EMAIL) && @$_POST['data'][$model][$view])
            {
                $FIELDS[] = ucwords($model)."_".ucwords($view);
                $MSG->error[] = "The field <strong>$field_name</strong> is not a valid e-mail address.";
            }
            if ($required && !@$_POST['data'][$model][$view])
            {
				$FIELDS[] = ucwords($model)."_".ucwords($view);
                $MSG->error[] = "The field <strong>$field_name</strong> can't be null.";
            }
            break;
        default:
            break;
    }
}

// check for errors before procedure
function check_errors()
{
	global $FIELDS;
	global $ONLOAD;
	if ($sizeof = sizeof($FIELDS))
	{
		$ONLOAD = " onload=\"";
		for ($i=0;$i<$sizeof;$i++)
		{
			$ONLOAD .= "validates_presence_of('".$FIELDS[$i]."');";
		}
		$ONLOAD .= "\"";
		return true;
	}
	else
	{
		$ONLOAD = "";
	}
	return false;
}

// redirects to any page
function redirect_to($addr="")
{
    $wwwroot = WWWROOT;
    header("location:$wwwroot/$addr");
}

// authenticates user depending on the case
function auth($op=FALSE, $redirect_to="")
{
	global $MSG;
	
	$r = TRUE;
	switch ($op)
	{
		case "yes":// logged in
			if (!$_SESSION)
			{
                redirect_to("session/login");
			}
			break;
		case "no":// logged out
			if ($_SESSION)
			{
				redirect_to($redirect_to);
			}
			break;
		default:// both
			break;
	}
	
	return $r;
}

// verifica a permissão para cada página
function permission()
{
    // páginas que não são verificadas
    $exclude = array('/', '/login', '/login', '/session/login', '/session/logout');
    $active = '/'.str_replace('/index', '', @$_SESSION['URL']);
    //echo $active;
    if (in_array($active, $exclude)) 
    {
    	return false;
    }
    $dao = new DAO();
    if (!$page = $dao->Retrieve('Navigation_page', "WHERE url = '$active'", true, true)) 
    {
    	return false;// uso like para permitir passagem de parâmetros
    }
    //echo $active;
    if (!$page = $dao->Retrieve('Permissions', array('user_group_id'=>$_SESSION['user_group_id'], 'navigation_page_id'=>$page->id), true, true))
    {
    	include(DOCROOT.'/core/libs/views/403.php');
    }
    return false;
}

function block_use()
{
	global $SYSTEM_PSWD;
	$dao = new DAO();
	$period = date('Y').'-'.str_pad(date('m'), 2, '0', STR_PAD_LEFT);
	$due_date = $period.'-'.str_pad($_SESSION['due_day'], 2, '0', STR_PAD_LEFT);
	$today = date('Y-m-d');
	// verifica se passaram 5 dias do vencimento
	if (calc_days($due_date, $today) > 5)
	{
		// verifica se a chave do mês corrente existe
		if ($pswd = $dao->Retrieve('System_password', "WHERE periodo = '$period'", true, true))
		{
			// verifica se a chave é válida
			if (md5($pswd->senha) == $SYSTEM_PSWD[$period])
			{
				return true;
			}
		}
		block_app();
	}
	return true;
}

function random_pass($length=10) 
{
	$alphabets = range('A','Z');
	$numbers = range('0','9');
	$additional_characters = array('_','.');
	$final_array = array_merge($alphabets,$numbers);
	 
	$password = '';

	while($length--) 
	{
		$key = array_rand($final_array);
		$password .= $final_array[$key];
	}

	return $password;
}

function debug($var)
{
	echo "<pre><strong>Debugging Mode On</strong><br />";
	if (is_array($var))
	{
		foreach ($var as $k=>$v)
		{
			var_dump($var);
			echo "<hr />";
		}
	}
	else if (is_string($var))
	{
		var_dump($var);
	}
	echo "</pre>";
}

// transforms an object into an array
function object_2_array($obj)
{
	$obj2array = array();

	$arr_keys = $obj->get_keys();
	$obj_size = sizeof($arr_keys);

	for($i=0; $i<$obj_size; $i++){
		$obj2array[$arr_keys[$i]] = $obj->get($arr_keys[$i]);
	}

    return $obj2array;
}

function get_files_dir($dir, $tipos = null)
{
	if(file_exists($dir))
    {
    	$dh =  opendir($dir);									        	
    	$arquivos = array();
		
    	while (false !== ($filename = readdir($dh))) 
        {
    		if($filename != "." && $filename != "..")
            {
	        	if(is_array($tipos))
                {
                	$extensao = get_extensao_file($filename);
					$nomeSemExtensao = explode('.', $filename);
					//&& preg_match("(^[0-9])", $nomeSemExtensao[0])
                	if(in_array($extensao, $tipos)){
                    	array_push($arquivos, $filename);
                	}
            	}
        	}
    	}
		if(is_array($arquivos)){
	    	sort($arquivos);
    	}
		
    	return $arquivos;
	}
	else{
		return false;
	}
}

function get_extensao_file($nome)
{
    $verifica = explode('.', $nome);
    return end($verifica);
}

function run_sql_file($location){
    //load file
    $commands = file_get_contents($location);

    //delete comments
    $lines = explode("\n",$commands);
    $commands = '';
    foreach($lines as $line){
        $line = trim($line);
        if( $line && !strstr($line,'--') ){
            $commands .= $line . "\n";
        }
    }

    //convert to array
    $commands = explode(";", $commands);

    //run commands
    $total = $success = 0;
    foreach($commands as $command){
        if(trim($command)){
            $success += (@mysql_query($command)==false ? 0 : 1);
            $total += 1;
        }
    }

    //return number of successful queries and total number of queries found
    return array(
        "success" => $success,
        "total" => $total
    );
}

?>