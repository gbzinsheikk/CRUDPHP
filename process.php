<?php
ini_set("display_errors", 1);
error_reporting(E_ERROR);

	session_start();


		$mysqli = new mysqli('localhost', 'gabriel', '','crud') or die(mysqli_error($mysqli_error($mysqli)));

			$nome = '';
			$valor = '';
			$estoque = '';

			if (isset($_POST['save'])){
				$nome = $_POST['nome'];
				$valor = $_POST['valor'];
				$estoque = $_POST ['estoque'];
				$mysqli->query("INSERT INTO produtos (nome, valor, estoque) VALUES('$nome', '$valor', '$estoque')") or die ($mysqli->error);

				$_SESSION["message"] = "O Registro foi adicionado!";
				$_SESSION["msg_type"] = "success";
			}

		if(isset($_GET['delete'])){

			$id = $_GET['delete'];
			$mysqli->query("DELETE FROM produtos WHERE id=$id") or die ($mysqli->error());
			$_SESSION["message"] = "O Registro foi deletado!";
			$_SESSION["msg_type"] = "danger";

			header ("location: index.php");
		}

		if (isset($_GET['edit'])){
			$id =$_GET['edit'];
			$result = $mysqli->query("SELECT * FROM produtos WHERE id=$id") or die ($mysqli->error());
			
			if (count($result) == 1){
				$row = $result->fetch_array();
				$nome = $row['nome'];
				$valor = $row['valor'];
				$estoque = $row['estoque'];
			}

		}


?>