<?php
	session_start();
	if (!isset($_SESSION['count']))
		{
  	$_SESSION['count'] = 0;
  	}
  else
  	{
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
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
    {
    $path = $pwd."\adm;".$path;
    }
  else
    {
    $path = $pwd."/adm:".$path;
    }
  //echo ("Path: $path <br/>");
  ini_set("include_path", $path);
  //print_r($_POST);
  //Listar dados da empresa
	try
		{
	  //Instancia objeto PDO para conexão com banco de dados
	  $db = new PDO('pgsql:dbname=caixa;
	  							 host=aula-alcione.serv.comp.uems.br;
                   user=pw2018;
                   password=PW2018&');
    }
  catch (PDOException $e)
  	{
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
    <link href="adm/css.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="adm/javascript.js">
      <!--
      // -->
    </script>
  </head>
  <body>
  	<?php
  		if (isset($_SESSION['logado']))
  			{
  			if ($_SESSION['logado'])
  				{
  				//Tratar a requisição POST
	if (isset($_POST['id']))
		{
		switch($_POST['id'])
			{
			case 1:
				{
				//montagem do SQL de atualização
				$sql = "update cadastro.cadastro_empresa set ";
				$sql .= "razao_social='".$_POST['nome']."',";
				$sql .= "denominacao_social='".$_POST['denominacao']."',";
				$sql .= "endereco='".$_POST['end']."',";
				$sql .= "cpf_cnpj='".$_POST['doc']."' where id=".$_POST['codigo'];
				//executando SQL de update no banco de dados
				$n = $db->exec($sql);
				if ($n == 0)
				  {
				  echo ("Erro: ".$db->errorInfo());
				  }
				break;
				}
			}
		}
		?>
		Contador de Sessão: <?php echo($_SESSION['count']); ?><br/>
 		<a href="logout.php" >Terminar Sessão</a><br/>
    <h1>Controle de Fluxo de caixa</h1>
    <hr></hr>
    <a href="<?php echo($n_arq); ?>?id=1" >Cadastro</a> | <a href="<?php echo($n_arq); ?>?id=2" >Lançamentos</a> | <a href="<?php echo($n_arq); ?>?id=3" >Relatórios</a>
    <hr></hr>
    <?php
      //print_r ($_GET);
      if (isset($_GET['id']))
        {
        switch ($_GET['id'])
          {
          default:
            {
            echo ("Bem Vindo ao Sistema de Controle de Fluxo de Caixa!");
            break;
            }
          case 1:
            {
            include ("cadastro.php");
            break;
            }
          }
        }
    ?>
		<?php

  				}
  			else
  				{
  				include("login.php");
  				}
  			}
  		else
  			{
  			include("login.php");
  			}
  	?>
  </body>
</html>
