
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <?php
    head('Sistema bloqueado');
    ?>
    <style type="text/css">
    #pswd{text-align: center; text-transform: uppercase;}
    .error{color: #ef034d;}
    </style>
    </head>
      
    <body class="errorPage">
    <form action="<?=WWWROOT?>/admin/system_password" method="post">
    <div class="container-fluid">

        <div class="errorContainer">
            <div class="page-header">
                <h1 class="center"><small>Sistema Bloqueado</small></h1>
            </div>

            <h2 class="center">Falta de Pagamento</h2>
            <?php if (@$_SESSION['invalid_token']):?>
            <h2 class="center error">ERRO: Chave Inválida</h2>
            <?php 
                unset($_SESSION['invalid_token']);
            endif;?>

            <div class="center">
                <h2>Informe abaixo a chave de desbloqueio</h2><br>
                <input type="text" class="span4 pswd" id="pswd" name="pswd" />
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Desbloquear</button>
                <!-- <a href="<?=WWWROOT?>" class="btn" style="margin-right:10px;">Voltar</a> -->
            </div>

        </div>
    </form>
    </div><!-- End .container-fluid -->

    <?php include(DOCROOT.'/app/views/public/scripts.php');?>
    <script type="text/javascript">
    // document ready function
    $(document).ready(function() {
        //------------- Some fancy stuff in error pages -------------//
        $('.errorContainer').hide();
        $('.errorContainer').fadeIn(1000).animate({
        'top': "50%", 'margin-top': +($('.errorContainer').height()/-2-30)
        }, {duration: 750, queue: false}, function() {
        // Animation complete.
        });

        $("#pswd").focus();
    });
    </script>
    </body>
</html>
<?php die()?>
