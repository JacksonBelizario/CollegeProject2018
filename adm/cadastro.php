<?php
//Opção de cadastro
ini_set('display_errors','On');
echo ("Cadastros<br/>");
$menu = array (4,"Empresa","Cliente","Fornecedor","Usuário");
for ($i=1; $i <= $menu[0]; $i++)
{
	echo ("<a href=\"?id=1&subid=$i\" >".$menu[$i]."</a>\n | ");
}
echo ("<hr></hr>\n");
if (isset($_GET['subid']))
{
	switch($_GET['subid'])
	{
		case 1:
		{

			//Consulta SQL
			$sql = "select * from cadastro.cadastro_empresa where id=1";
			//Prepara a execução da consulta SQL
			$query = $db->prepare($sql);
			//Executa
			$query->execute();
			//Quantidade de dados recebidos
			//echo ($query->rowCount());
			//Laço de repetição para percorrer todas as posições do resultado da consulta SQL
			for ($i=0; $row = $query->fetch(); $i++)
			{
				//Atribuição dos dados para uma variável de manipulação
				$dados[$i] = $row;
			}
			echo ("<form id=\"cadastro\" action=\"\" method=\"POST\" />\n");
			echo ("<input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$_GET['id']."\" />");
			echo ("<input type=\"hidden\" name=\"subid\" id=\"subid\" value=\"".$_GET['subid']."\" />");
			echo ("Código: <input type=\"hidden\" name=\"codigo\" id=\"codigo\" value=\"".$dados[0][0]."\" />".$dados[0][0]."<br/>\n");
			echo ("Razão: <input type=\"text\" name=\"nome\" id=\"nome\" value=\"".$dados[0][1]."\" maxlength=\"200\" /></br>\n");
			echo ("Denominação: <input type=\"text\" name=\"denominacao\" id=\"denominacao\" value=\"".$dados[0][2]."\" maxlength=\"200\" /></br>\n");
			echo ("Endereço: <input type=\"text\" name=\"end\" id=\"end\" value=\"".$dados[0][3]."\" maxlength=\"200\" /></br>\n");
			echo ("CPF ou CNPJ: <input type=\"text\" name=\"doc\" id=\"doc\" value=\"".$dados[0][4]."\" maxlength=\"15\" /> </br>\n");
			echo ("<input type=\"button\" value=\"Editar\" name=\"bt_edit\" id=\"bt_edit\" onclick=\"javascript:editar();\" />\n");
			echo ("<input type=\"submit\" value=\"Salvar\" name=\"bt_save\" id=\"bt_save\"/>\n");
			echo ("</form>\n");
			?>
			<script language="javascript" type="text/javascript">
			<!--
			document.getElementById('nome').disabled = true;
			document.getElementById('denominacao').disabled = true;
			document.getElementById('end').disabled = true;
			document.getElementById('doc').disabled = true;
			document.getElementById('bt_save').disabled = true;
			function editar()
			{
				document.getElementById('nome').disabled = false;
				document.getElementById('denominacao').disabled = false;
				document.getElementById('end').disabled = false;
				document.getElementById('doc').disabled = false;
				document.getElementById('bt_edit').disabled = true;
				document.getElementById('bt_save').disabled = false;
			}
			//-->
		</script>
		<?php
		break;
	}
}
}
?>
