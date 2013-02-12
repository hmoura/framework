<?php
/*****************************
** DEFAULT LAYOUT FUNCTIONS **
*****************************/

function default_messages()
{
	global $MSG;
	global $CFG;

	if (count($MSG->success))
	{
		foreach ($MSG->success as $msg)
		{
            $id = uniqid();
            echo "<div class=\"alert alert-success\">
                <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>  
                <strong>Sucesso!</strong> $msg
            </div>";
			//echo "<p class=\"success\"><span>Success</span>$msg</p>";
        }
	}
	if(count($MSG->error))
	{
		foreach ($MSG->error as $msg)
		{
            echo "<div class=\"alert alert-error\">
                <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>  
                $msg
            </div>";
		}
	}
	if(count($MSG->alert))
	{
		foreach ($MSG->alert as $msg)
		{
            echo "<div class=\"alert alert-warning\">
                <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>  
                <strong>Atenção!</strong> $msg
            </div>";
		}
			//echo "<p class=\"alert\"><span>Alert</span>$msg</p>";
	}
	if(count($MSG->notice))
	{
		foreach ($MSG->notice as $msg)
		{
            echo "<div class=\"alert alert-info\">
                <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>  
                 $msg
            </div>";
		}
			//echo "<p class=\"notice\"><span>Notice</span>$msg</p>";
	}
}

function title($str=false)
{
	$title = $str ? "<title>$str - Hotel</title>" : "<title>Ligue Consulta</title>";
	echo $title;
	return false;
}

function head($title=NULL)
{
	global $CFG;
	title($title);
	include DOCROOT."/app/views/public/_inc_head.php";
	return FALSE;
}

function menu()
{
	global $CFG;
	include DOCROOT."/app/views/public/_inc_menu.php";
	return FALSE;
}

function footer()
{
    global $CFG;
    include DOCROOT."/app/views/public/_inc_footer.php";
    return FALSE;
}

function error_404()
{
	include DOCROOT."/core/libs/views/404.php";
	die();
}
function block_app()
{
	include DOCROOT."/core/libs/views/block.php";
	die();
}
?>
