<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php auth('yes')?>
    	<title>PHP Orientado - UNP</title>
        <?php include(DOCROOT.'/app/views/public/_inc_head.php');?>
    </head>
      
    <body>
        <?php include(DOCROOT.'/app/views/public/_inc_menu.php');?>
        <div class="container">
        	<h1>Bem vindo ao projeto PHP Orientado</h1>

            <p>Escolha uma opção no menu acima</p>
        </div>
        <?php include(DOCROOT.'/app/views/public/_inc_scripts.php');?>
    </body>
</html>
