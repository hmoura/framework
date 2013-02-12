<?php

//var_dump($params);

$dao = new DAO();

$data = array(
	'product_id' => $params[0],
	'titulo' => $params[1],
	'conteudo' => $params[2]
);

$comentario = new Comment($data);

if ($dao->Create($comentario))
{
	echo 'Comentário cadastrato';
}

?>