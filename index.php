<?php
/** teste de documentação **/
session_start();
if (!isset($_SESSION['count'])) {
	$_SESSION['count'] = 0;
} else {
	$_SESSION['count']++;
}
//print_r($_SESSION);
ini_set('error_reporting', E_ALL);
$file = $_SERVER["SCRIPT_FILENAME"];
//echo ("Arquivo: $file <br/>");
$diretorio = pathinfo($file);
//echo ("diretorio: ");
//print_r($diretorio);
//echo ("<br/>");
$pwd = $diretorio['dirname'];
$n_arq = $diretorio['basename'];
//echo ("Caminho: $pwd <br/>");
$path = ini_get("include_path");
//echo ("Path: $path <br/>");
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	$path = $pwd."\adm;".$path;
} else {
	$path = $pwd."/adm:".$path;
}
//echo ("Path: $path <br/>");
ini_set("include_path", $path);
//print_r($_POST);
//Listar dados da empresa
try {
	//Instancia objeto PDO para conexão com banco de dados
	$db = new PDO('pgsql:dbname=zjmyszer;
	host=elmer.db.elephantsql.com;
	user=zjmyszer;
	password=rlYVx3LvH2ahGOXnBN6nEnXfrIAq3ful');
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Controle de Fluxo de Caixa</title>
	<meta name="generator" content="Bluefish 2.2.10" />
	<meta name="author" content="Alcione Ferreira" />
	<meta name="date" content="2018-04-12T22:10:04-0400" />
	<meta name="copyright" content=""/>
	<meta name="keywords" content=""/>
	<meta name="description" content=""/>
	<meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="adm/css.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="adm/javascript.js"></script>
</head>
<body>
	<div class="container">
		<?php
		if (isset($_SESSION['logado'])) {
			if ($_SESSION['logado']) {
				?>
				<nav class="navbar navbar-light bg-light">
					<a class="navbar-brand" href="#">Controle de Fluxo de Caixa</a>
					<div class="form-inline my-2 my-lg-0">
						<a href="logout.php" >Terminar Sessão</a><br/>
					</form>
				</nav>
				<hr></hr>
				<ul class="nav nav-pills">
					<li class="nav-item"><a class="nav-link <?= ((isset($_GET['id']) && $_GET['id'] == 1) ? 'active' : '') ?>" href="<?= $n_arq ?>?id=1">Cadastro</a></li>
					<li class="nav-item"><a class="nav-link <?= ((isset($_GET['id']) && $_GET['id'] == 2) ? 'active' : '') ?>" href="<?= $n_arq ?>?id=2">Lançamentos</a></li>
					<li class="nav-item"><a class="nav-link <?= ((isset($_GET['id']) && $_GET['id'] == 3) ? 'active' : '') ?>" href="<?= $n_arq ?>?id=3">Relatórios</a></li>
				</ul>
				<hr></hr>
				<?php
				//print_r ($_GET);
				if (isset($_GET['id'])) {
					switch ($_GET['id']) {
						default:
						{
							echo("Bem Vindo ao Sistema de Controle de Fluxo de Caixa!");
							break;
						}
						case 1:
						{
							include("cadastro.php");
							break;
						}
					}
				} ?>
				<?php
			} else {
				include("login.php");
			}
		} else {
			include("login.php");
		}
		?>
	</div>
</body>
</html>
