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
<form action="" method="POST" >
	<table summary="" >
		<tr>
			<td>Usuário:</td><td><input type="text" name="usuario" id="usuario" maxlength="20" size="10" /></td>
		</tr>
		<tr>
			<td>Senha:</td><td><input type="password" name="senha" id="senha" size="10" /></td>
		</tr>
	</table>
	<input type="submit" value="Logar" />
</form>
