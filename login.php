<?php
//print_r($_POST);
if (isset($_POST['usuario'])) {
	$sql = "select * from cadastro.usuario where ";
	$sql .= "login='".$_POST['usuario']."' ";
	$sql .= "and senha=md5('".$_POST['senha']."')";
	//executando SQL de update no banco de dados
	$query = $db->prepare($sql);
	//Executa
	$query->execute();
	//Quantidade de dados recebidos
	if ($query->rowCount() == 1) {
		for ($i=0; $row = $query->fetch(); $i++) {
			//Atribuição dos dados para uma variável de manipulação
			$dados[$i] = $row;
		}
		$_SESSION['logado'] = true;
		$_SESSION['usuario'] = $dados[0][2];
		header('Location: index.php');
	}
}
?>
<div class="text-center">
	<form action="" method="POST" class="form-signin">
		<img class="mb-4" src="./img/login.png" alt="" width="100" height="100">
		<h1 class="h3 mb-3 font-weight-normal">Login</h1>
		<label for="inputEmail" class="sr-only">Usuário</label>
		<input type="text" id="usuario"name="usuario" class="form-control" placeholder="Usuário" maxlength="20" required autofocus>
		<label for="inputPassword" class="sr-only">Senha</label>
		<input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" value="remember-me"> Lembre-me
			</label>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Logar</button>
	</form>
</div>
