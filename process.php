<?php
session_start(); //início do código
ini_set("display_errors", 1); // mostra possíveis erros
error_reporting(E_ERROR);



$mysqli = new mysqli('localhost', 'root', '','crud') or die(mysqli_error($mysqli)); //login no banco de dados

$id = '';        //seta valores padrão de variáveis usadas ao longo do código
$update = false;
$nome = '';
$valor = '';
$estoque = '';

if (isset($_POST['save'])){ //salva novos registros
	$nome = $_POST['nome'];
	$valor = $_POST['valor'];
	$estoque = $_POST ['estoque'];
	$mysqli->query("INSERT INTO produtos (nome, valor, estoque) VALUES('$nome', '$valor', '$estoque')") or die (mysqli_error($mysqli));

	$_SESSION["message"] = "O Registro foi adicionado!"; //define a mensagem
	$_SESSION["msg_type"] = "success";

	header ("location: index.php");
	exit();
}elseif(isset($_GET['delete'])){ //deleta os registros

	$id = $_GET['delete'];
	$query="DELETE FROM produtos WHERE id=(?)";

	$tratada=$mysqli->prepare($query); //trata a requisição de deleção, evitando SQL injection


	$tratada->bind_param('i',$id);

	$tratada->execute() or die (mysqli_error($mysqli));
	$_SESSION["message"] = "O Registro foi deletado!"; // define a mensagem
	$_SESSION["msg_type"] = "danger";

	header ("location: index.php");
	exit();
}else if (isset($_POST['update'])){ //atualiza os registros
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$valor = $_POST['valor'];
	$estoque = $_POST['estoque'];
	$query="UPDATE produtos SET nome='$nome', valor='$valor', estoque='$estoque' WHERE id='$id'";

	$mysqli->query($query) or die (mysqli_error($mysqli));

	$_SESSION['message'] = "Registro atualizado com sucesso!"; //define a mensagem
	$_SESSION['msg_type'] = "success";


	header ("location: index.php");
	exit();
}elseif (isset($_GET['edit'])){ // seleciona e mostra os dados escolhidos ao clicar no botao editar
	$id =$_GET['edit'];
	$update = true;
	$query="SELECT * FROM produtos WHERE id=$id";
	$result = $mysqli->query($query) or die (mysqli_error($mysqli));

	if (count($result) == 1){
		$row = $result->fetch_array();
		$nome = $row['nome'];
		$valor = $row['valor'];
		$estoque = $row['estoque'];
	}

}


?>