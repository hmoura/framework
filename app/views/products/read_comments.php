<?php
$data = array(
    'product_id' => $params[0]
);
$comentarios = $dao->Retrieve('Comments', $data);
?>

<?php if ($comentarios):?>
<?php foreach ($comentarios as $comentario):?>
<div class="comentario">
    <h4 class="comment-title"><?=$comentario->titulo?></h4>
    <div class="well"><?=$comentario->conteudo?></div>
</div>
<?php endforeach?>
<?php endif?>