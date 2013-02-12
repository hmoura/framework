<?php
if ($_POST)
{
    global $MSG;
    $dados = array(
        'email' => $_POST['email'],
        'senha' => md5($_POST['senha'])
    );
    $usuario = $dao->Retrieve('Users', $dados, true, true);

    if ($usuario)
    {
        $_SESSION['id'] = $usuario->id;
        $_SESSION['nome'] = $usuario->nome;
        $_SESSION['email'] = $usuario->email;
        
        redirect_to();
    }
    else
    {
        $MSG->error[] = 'Erro ao logar. Verifique os dados e tente novamente.';
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php auth('no')?>
    	<title>PHP Orientado - UNP</title>
        <?php include(DOCROOT.'/app/views/public/_inc_head.php');?>
    </head>
      
    <body>
        <?php include(DOCROOT.'/app/views/public/_inc_menu.php');?>
        <div class="container">
        	<h1>Login</h1>

            <?php default_messages()?>

            <form action="" method="post">

                <label>E-mail:</label>
                <input type="text" class="span4" name="email" id="email" /><br>

                <label>Senha:</label>
                <input type="password" class="span4" name="senha" /><br>

                <button type="submit" class="btn btn-primary">Efetuar Login</button>

            </form>
        	
        </div>
        <?php include(DOCROOT.'/app/views/public/_inc_scripts.php');?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#email").focus();
        });
        </script>
    </body>
</html>
