<?php require_once 'process.php'; ?>
<!DOCTYPE html>
<html>
<head> 
	<!--css para centralizar elementos-->
	<style> 
.center {
  margin: auto;
  width: 40%;
  padding: 15px;
}
</style>
	<meta charset="UTF-8">
	<title> CRUD </title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>

		<?php
		if (isset($_SESSION['message'])): //checa e mostra variavel message
		?>

		<div class="alert alert-<?=$_SESSION['msg_type']?>" >
			
			<?php 
				echo $_SESSION['message']; //mostra a mensagem
				unset ($_SESSION['message']); //esvazia a variavel message	
			?>
		</div>
	<?php endif; ?>
		<?php 
				$result = $mysqli->query("SELECT * FROM produtos") or die ($mysqli->error); //seleciona no banco de dados as informações
				
		?>			
					<!--container para mostrar os conteudos do banco em uma tabela-->
					<div class="container">
					<div class= "row align-items-center">
					<table class="table">
						<thead>
						<tr>
							<th>Nome</th>
							<th>Valor</th>
							<th>Estoque</th>
							<th>Opções</th>
						</tr>
						</thead>
						<?php while ($row = $result->fetch_assoc()): ?> <!-- loop para mostrar todos os arquivos do banco-->
							<tr>
								<td><?php echo $row['nome']; ?></td>
								<td><?php echo $row['valor']; ?></td>
								<td><?php echo $row['estoque']; ?></td>
								<td> 
								<a href=index.php?edit=<?php echo $row['id'];?> class="btn btn-info">Editar</a>
								<a href=process.php?delete=<?php echo $row['id'];?> onclick="return confirmaDeletar()" class="btn btn-danger">Deletar</a>
								</td>
							</tr>
								<?php endwhile; ?> <!--fim  do loop-->
						</table>

			<!--função javascript para perguntar ao usuario se realmente deseja deletar o registro -->

			<script type="text/javascript">
				function confirmaDeletar(){
				return confirm('Tem certeza que deseja excluir o registro?');
				}
			</script>



				<?php
				pre_r($result->fetch_assoc());  //exibe o array de dados do banco

				function pre_r ( $array ) {
					echo '<pre>';
					print_r($array);
					echo'</pre>';

				}

				?>

		<!--formulário-->

		<div class="center">
		<form action="" method="POST">
			<input type="hidden" name= "id" value = "<?php echo $id ?>">
			<div class="form-group">
			<input type="text" name="nome" value="<?php echo $nome ?>"placeholder="insira o nome do produto ">
			</div>
			<div class="form-group">
			<input type="text" name="valor" value="<?php echo $valor ?>" placeholder="insira o valor do produto">
			</div>
			<div class="form-group">
			<input type="text" name="estoque" value="<?php echo $estoque ?>" placeholder="insira a quantidade">
			</div>
			<div class="form-group">
				<?php if ($update == true): ?>
					<button type="submit" class="btn btn-primary" name="update">Atualizar</button>
				<?php else: ?>
					<button type="submit" class="btn btn-primary" name="save">Salvar</button>
				<?php endif; ?>
			</div>
		</div>
		</div>
		</form>

</body>
</html>