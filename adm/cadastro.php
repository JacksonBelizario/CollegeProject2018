<?php
//Opção de cadastro
$menu = array (4,"Empresa","Cliente","Fornecedor","Usuário"); ?>
<div class="row">
	<div class="col-sm-3 col-md-2">
		<ul class="nav flex-column nav-pills">
			<?php
			for ($i=1; $i <= $menu[0]; $i++)
			{
				echo ("<li class=\"nav-item\"><a class=\"nav-link ". (isset($_GET['subid']) && $_GET['subid'] == $i ? 'active' : '') ."\" href=\"?id=1&subid=$i\" >".$menu[$i]."</a></li>");
			}
			?>
		</ul>
	</div>
	<div class="col-sm-9 col-md-10">
		<?php
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
					$empresa = $query->fetch(PDO::FETCH_ASSOC);
					?>
					<form class="row p-3 mt-4" id="cadastro" action="" method="POST">
						<div class="col-12">
							<h4>Ficha de Cadastro</h4>
							<label for="codigo">Código: <?= $empresa["id"] ?></label>
							<input type="hidden" class="form-control" id="codigo" name="codigo" value="<?= $empresa["id"] ?>">
						</div>
						<div class="col-6">
							<fieldset class="form-group">
								<label for="nome">Razão</label>
								<input type="text" class="form-control" id="nome" name="nome" value="<?= $empresa["razao_social"] ?>" maxlength="200">
							</fieldset>
						</div>
						<div class="col-6">
							<fieldset class="form-Denominação">
								<label for="denominacao">Denominação</label>
								<input type="text" class="form-control" id="denominacao" name="denominacao" value="<?= $empresa["denominacao_social"] ?>" maxlength="200">
							</fieldset>
						</div>
						<div class="col-6">
							<fieldset class="form-group">
								<label for="end">Endereço</label>
								<input type="text" class="form-control" id="end" name="end" value="<?= $empresa["endereco"] ?>" maxlength="200">
							</fieldset>
						</div>
						<div class="col-6">
							<fieldset class="form-group">
								<label for="doc">CPF ou CNPJ</label>
								<input type="text" class="form-control" id="doc" name="doc" value="<?= $empresa["cpf_cnpj"] ?>" maxlength="15">
							</fieldset>
						</div>
						<div class="col-12 text-right">
							<input type="hidden" name="id" id="id" value="<?= $_GET["id"] ?>" />
							<input type="hidden" name="subid" id="subid" value="<?= $_GET["subid"] ?>" />
							<button type="button" class="btn btn-default" onclick="javascript:editar();" />Editar</button>
							<button type="submit" class="btn btn-primary">Salvar</button>
						</div>
					</form>


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
	</div>
</div>
