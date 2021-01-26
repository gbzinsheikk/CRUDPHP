<?php
session_start();
ini_set("display_errors", 1);
error_reporting(E_ERROR);



$mysqli = new mysqli('localhost', 'gabriel', '','crud') or die(mysqli_error($mysqli));

$id = '';
$update = false;
$nome = '';
$valor = '';
$estoque = '';

if (isset($_POST['save'])){
	$nome = $_POST['nome'];
	$valor = $_POST['valor'];
	$estoque = $_POST ['estoque'];
	$mysqli->query("INSERT INTO produtos (nome, valor, estoque) VALUES('$nome', '$valor', '$estoque')") or die (mysqli_error($mysqli));

	$_SESSION["message"] = "O Registro foi adicionado!";
	$_SESSION["msg_type"] = "success";

	header ("location: index.php");
	exit();
}elseif(isset($_GET['delete'])){

	$id = $_GET['delete'];
	$query="DELETE FROM produtos WHERE id=(?)";

	$tratada=$mysqli->prepare($query);


	$tratada->bind_param('i',$id);

	$tratada->execute() or die (mysqli_error($mysqli));
	$_SESSION["message"] = "O Registro foi deletado!";
	$_SESSION["msg_type"] = "danger";

	header ("location: index.php");
	exit();
}else if (isset($_POST['update'])){
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$valor = $_POST['valor'];
	$estoque = $_POST['estoque'];
	$query="UPDATE produtos SET nome='$nome', valor='$valor', estoque='$estoque' WHERE id='$id'";

	$mysqli->query($query) or die (mysqli_error($mysqli));

	$_SESSION['message'] = "Registro atualizado com sucesso!";
	$_SESSION['msg_type'] = "success";


	header ("location: index.php");
	exit();
}elseif (isset($_GET['edit'])){
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