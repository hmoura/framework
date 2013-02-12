<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
    <head>
        <?php auth('yes')?>
        
    	<title>PHP Orientado - UNP</title>
        <?php include(DOCROOT.'/app/views/public/_inc_head.php');?>

        <?php
        $controller = new Products_Controller();
        $controller->add();
        ?>
    </head>
      
    <body>
        <?php include(DOCROOT.'/app/views/public/_inc_menu.php');?>
        <div class="container">
        	<h1>Novo Produto</h1>

            <form action="" method="post">

                <label>Nome: </label>
                <input type="text" name="nome" /><br />

                <label>Preço: </label>
                <input type="text" name="preco" /><br />

                <label>Quantidade: </label>
                <input type="text" name="qtd" /><br />

                <button type="submit" class="btn btn-primary">Cadastrar</button>

            </form>
        </div>
        <?php include(DOCROOT.'/app/views/public/_inc_scripts.php');?>
    	
    </body>
</html>
