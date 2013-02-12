<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
    <head>
        <?php auth('yes')?>
        <?php
        if ($_POST)
        {
            global $MSG;
            $dados = array(
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => md5($_POST['senha']),
            );

            $usuario = new User($dados);

            if ($dao->Create($usuario))
            {
                $MSG->success[] = 'Cadastro efetuado';
            }
        }
        ?>
    	<title>PHP Orientado - UNP</title>
        <?php include(DOCROOT.'/app/views/public/_inc_head.php');?>

    </head>
      
    <body>
        <?php include(DOCROOT.'/app/views/public/_inc_menu.php');?>
        <div class="container">
        	<h1>Novo Usuário</h1>

            <?php default_messages()?>

            <form action="" method="post">

                <label>Nome: </label>
                <input type="text" name="nome" class="span4" /><br />

                <label>E-mail: </label>
                <input type="text" name="email" class="span4" /><br />

                <label>Senha: </label>
                <input type="password" name="senha" class="span4" /><br />

                <button type="submit" class="btn btn-primary">Cadastrar</button>

            </form>
        </div>
        <?php include(DOCROOT.'/app/views/public/_inc_scripts.php');?>
    	
    </body>
</html>
