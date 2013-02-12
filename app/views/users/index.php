<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
    <head>
        <?php auth('yes')?>
    	<title>PHP Orientado - UNP</title>
        <?php include(DOCROOT.'/app/views/public/_inc_head.php');?>
        <?php
        $usuarios = $dao->Retrieve('Users', 'all');
        ?>
    </head>
      
    <body>
        <?php include(DOCROOT.'/app/views/public/_inc_menu.php');?>

        <div class="container">
        	<h1>Listar Usuários</h1>

            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data de Cadastro</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($usuarios as $usuario):?>
                    <tr>
                        <td><?php echo $usuario->nome?></td>
                        <td><?php echo $usuario->email?></td>
                        <td><?php echo $usuario->created_at?></td>
                        <td>
                            <a href="<?php echo WWWROOT?>/products/update/<?=$usuario->id?>">Editar</a> |
                            <a href="<?PHP echo WWWROOT?>/products/delete/<?=$usuario->id?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach?>
                </tbody>
            </table>

    	</div>
        <?php include(DOCROOT.'/app/views/public/_inc_scripts.php');?>
    </body>
</html>
