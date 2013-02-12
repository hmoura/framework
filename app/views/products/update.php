<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
    <head>
    	<title>PHP Orientado - UNP</title>
        <?php include(DOCROOT.'/app/views/public/_inc_head.php');?>

        <style type="text/css">
        .comment-title{
            text-transform: capitalize;
            background: #f0f0f0;
            padding: 10px;
            margin: 0;
            border: 1px solid #ddd;
        }
        </style>

        <?php
        // $params = variável de sistema que traz parâmetros da URL
        $produto = $dao->Retrieve('Product', $params[0]);

        $controller = new Products_Controller();
        $controller->update($produto);

        if ($_POST && @$_POST['comentario'])
        {
            unset($_POST['comentario']);

            $comentario = new Comment($_POST);
            $dao->Create($comentario);
        }
        ?>
    </head>
      
    <body>
        <?php include(DOCROOT.'/app/views/public/_inc_menu.php');?>
        <div class="container">
        	<h1>Editar Produto</h1>

            <form action="" method="post">
                <input type="hidden" name="produto" value="1" />

                <label>Nome: </label>
                <input type="text" name="nome" class="span4" value="<?php echo $produto->nome?>" /><br />

                <label>Preço: </label>
                <input type="text" name="preco" class="span4" value="<?php echo $produto->preco?>" /><br />

                <label>Quantidade: </label>
                <input type="text" name="qtd" class="span4" value="<?php echo $produto->qtd?>" /><br />

                <button type="submit" class="btn btn-primary">Cadastrar</button>

                <a href="#" id="show_comments_btn" class="btn">Mostrar Comentários</a>
                <a href="#" id="add_comment_btn" class="btn">Adicionar Comentário</a>
            </form>

            <div id="show_comments">
                <hr />

                <h3>Comentários:</h3>
                <div id="output_comments"></div>
            </div>

            <div id="add_comment">
                <hr />

                <h3>Novo Comentário</h3>

                <form action="" method="post">

                    <input type="hidden" name="comentario" value="1" />
                    <input type="hidden" name="product_id" id="product_id" value="<?=$params[0]?>" />

                    <label>Título: </label>
                    <input type="text" name="titulo" id="titulo" class="span4" value="" /><br />

                    <label>Comentário: </label>
                    <textarea name="conteudo" id="comentario" class="span4" rows="12"></textarea><br />

                    <button type="button" class="btn btn-primary" id="submit_ajax">Cadastrar Comentário</button>

                    <div id="output"></div>
                </form>

            </div>
    	</div>
        <?php include(DOCROOT.'/app/views/public/_inc_scripts.php');?>
        <script type="text/javascript">
        $(document).ready(function(){

            function read_comments()
            {
                $("#output_comments").html('Carregando...');
                $.ajax({
                    url : 'http://localhost/unp/products/read_comments/'+$("#product_id").val(),
                    success : function(data){
                        $("#output_comments").html(data);
                    }
                });
            }

            $("#show_comments").hide();
            //$("#add_comment").hide();

            $("#show_comments_btn").click(function(e){
                $("#show_comments").slideToggle();
                e.preventDefault();
            });

            $("#add_comment_btn").click(function(e){
                $("#add_comment").slideToggle();
                e.preventDefault();
            });

            $("#submit_ajax").click(function(){

                var titulo = $("#titulo").val();
                var comentario = $("#comentario").val();
                var product_id = $("#product_id").val();
                $.ajax({
                    url : 'http://localhost/unp/products/add_ajax/'+product_id+'/'+titulo+'/'+comentario,
                    success : function(data){
                        $("#output").html(data);
                        read_comments();
                    }
                });
                $("#titulo").val('');
                $("#comentario").val('');
                $("#show_comments").slideToggle();

            });

            read_comments();


        });
        </script>
    </body>
</html>

















