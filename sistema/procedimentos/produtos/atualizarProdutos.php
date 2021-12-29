<?php 

	require_once "../../classes/conexao.php";
	require_once "../../classes/produtos.php";

	$obj= new produtos();

$dados=array(
		$_POST['idProduto'],
	    $_POST['nomeU'],
			);

    echo $obj->atualizar($dados);

 ?>