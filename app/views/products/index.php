<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
    <head>
        <?php auth('yes')?>
    	<title>PHP Orientado - UNP</title>
    	<?php include(DOCROOT.'/app/views/public/_inc_head.php');?>

        <?php
        $controller = new Products_Controller();
        $lista = $controller->search();
        ?>
    </head>
      
    <body>
        <?php include(DOCROOT.'/app/views/public/_inc_menu.php');?>
        <div class="container">
        	<h1>Listar Produtos</h1>

            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista as $produto):?>
                    <tr>
                        <td><?php echo $produto->nome?></td>
                        <td><?php echo $produto->preco?></td>
                        <td><?php echo $produto->qtd?></td>
                        <td>
                            <a href="<?php echo WWWROOT?>/products/update/<?=$produto->id?>" class="btn btn-primary btn-mini">Editar</a>
                            <a href="<?PHP echo WWWROOT?>/products/delete/<?=$produto->id?>" class="btn btn-danger btn-mini">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach?>
                </tbody>
            </table>
    	</div>
        <?php include(DOCROOT.'/app/views/public/_inc_scripts.php');?>
    </body>
</html>
