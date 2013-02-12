<?php

class Products_Controller extends App_Controller{

	function add()
	{
		if ($_POST)
		{
			var_dump($_POST);

			// 1. criar array com dados
			// $dados = array(
			// 	'nome' => $_POST['nome'],
			// 	'preco' => $_POST['preco'],
			// 	'qtd' => $_POST['qtd']
			// );

			// var_dump($dados);

			// 2. instanciar o objeto
			$produto = new Product($_POST);

			// 3. salvar com objeto DAO
			$dao = new DAO();

			$dao->Create($produto);
		}
	}

	function search()
	{
		$dao = new DAO();

		// método Retrieve() - Nome da classe e parâmetros de busca
        $lista = $dao->Retrieve('Products', 'all');

        return $lista;
	}

	function update($produto)
	{
        if ($_POST && @$_POST['produto'])
        {
        	$dao = new DAO();
            $produto->set('nome', $_POST['nome']);
            $produto->set('preco', $_POST['preco']);
            $produto->set('qtd', $_POST['qtd']);

            $dao->Update($produto);
        }
	}

}

?>