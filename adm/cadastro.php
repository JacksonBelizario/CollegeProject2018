<?php
//Opção de cadastro
$menu = array(4,"Empresa","Cliente","Fornecedor","Usuário"); ?>
<div class="row">
	<div class="col-sm-3 col-md-2">
		<ul class="nav flex-column nav-pills">
			<?php
            for ($i=1; $i <= $menu[0]; $i++) {
                echo("<li class=\"nav-item\"><a class=\"nav-link ". (isset($_GET['subid']) && $_GET['subid'] == $i ? 'active' : '') ."\" href=\"?id=1&subid=$i\" >".$menu[$i]."</a></li>");
            }
            ?>
		</ul>
	</div>
	<div class="col-sm-9 col-md-10">
		<?php
        if (isset($_GET['subid'])) {
            switch ($_GET['subid']) {
                case 1:
                {
                    //Tratar a requisição POST
                    if (isset($_POST['subid']) && $_POST['subid'] == 1) {

                        $query_params = array(
                            ':razao_social'			=> $_POST['nome'],
                            ':denominacao_social'	=> $_POST['denominacao'],
                            ':endereco'				=> $_POST['end'],
                            ':cpf_cnpj'				=> $_POST['doc'],
                            ':id'					=> $_POST['codigo']
                        );

                        $query = "UPDATE cadastro.cadastro_empresa SET
						razao_social		= :razao_social,
						denominacao_social	= :denominacao_social,
						endereco			= :endereco,
						cpf_cnpj			= :cpf_cnpj
						WHERE id = :id";
                        //executando SQL de update no banco de dados
                        try {
                            $dados = $db->prepare($query);
                            $dados->execute($query_params);
							echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
								  	<strong>Sucesso!</strong> Cadastro efetuado.
								</div>';
                        }
						catch (PDOException $ex) {
							echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Erro</strong> ' . $ex->getMessage() .'
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  		</div>' ;
                        }
                    }
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
							<button type="button" name="bt_edit" id="bt_edit" class="btn btn-default" onclick="javascript:editar();" />Editar</button>
							<button type="submit" id="bt_save" class="btn btn-primary">Salvar</button>
						</div>
					</form>

					<script language="javascript" type="text/javascript">
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
					</script>
					<?php
                    break;
                }
                case 2:
                {
                    //Tratar a requisição POST
                    if (isset($_POST['subid']) && $_POST['subid'] == 2) {
                        //montagem do SQL de atualização
                        if (empty($_POST['codigo'])) {
                            $query_params = array(
                                ':nome'			=> $_POST['nome'],
                                ':endereco'		=> $_POST['endereco'],
                                ':cpf_cnpj'		=> $_POST['cpf_cnpj'],
                                ':tipo'			=> $_POST['tipo']
                            );
                            $query = "INSERT INTO cadastro.cadastro_cliforn (nome, endereco, cpf_cnpj, tipo) VALUES (:nome, :endereco, :cpf_cnpj, :tipo)";
                        } else {
                            $query_params = array(
                                ':nome'			=> $_POST['nome'],
                                ':endereco'		=> $_POST['endereco'],
                                ':cpf_cnpj'		=> $_POST['cpf_cnpj'],
                                ':tipo'			=> $_POST['tipo'],
                                ':id'			=> $_POST['codigo']
                            );
                            $query = "UPDATE cadastro.cadastro_cliforn SET
							nome	= :nome,
							endereco= :endereco,
							cpf_cnpj= :cpf_cnpj,
							tipo	= :tipo
							WHERE id= :id";
                        }
                        //executando SQL de update no banco de dados
                        try {
                            $dados = $db->prepare($query);
                            $dados->execute($query_params);
							echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
								  	<strong>Sucesso!</strong> Cadastro efetuado.
								</div>';
                        }
						catch (PDOException $ex) {
							echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Erro</strong> ' . $ex->getMessage() .'
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  		</div>' ;
                        }
                    }
                    ?>
					<form class="row p-3 mt-4" id="cadastro" action="" method="POST">
						<div class="col-12">
							<h4>Ficha de Cadastro: Clientes <span id="id_cliente"></span></h4>

							</div>
							<div class="col-6">
								<fieldset class="form-group">
									<label for="nome">Nome</label>
									<input type="text" class="form-control" id="nome" name="nome" value="" maxlength="200">
								</fieldset>
							</div>
							<div class="col-6">
								<fieldset class="form-group">
									<label for="cpf_cnpj">CPF</label>
									<input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="" maxlength="15">
								</fieldset>
							</div>
							<div class="col-12">
								<fieldset class="form-group">
									<label for="endereco">Endereço</label>
									<input type="text" class="form-control" id="endereco" name="endereco" value="" maxlength="200">
								</fieldset>
							</div>
							<div class="col-12 text-right">
								<input type="hidden" class="form-control" id="codigo" name="codigo" value="">
								<input type="hidden" name="subid" id="subid" value="<?= $_GET["subid"] ?>" />
								<input type="hidden" name="tipo" id="tipo" value="0" />
								<button type="submit" id="bt_save" class="btn btn-primary">Salvar</button>
							</div>
						</form>
						<h4>Clientes Cadastrados</h4>
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nome</th>
									<th scope="col">CPF</th>
									<th scope="col">Endereço</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<?php
                                $sql = "SELECT * FROM cadastro.cadastro_cliforn WHERE tipo = 0 ORDER BY id ASC";
                                $query = $db->prepare($sql);
                                $query->execute();
                                foreach ($query->fetchAll() as $res) {
                                    ?>
									<tr id="cliente-<?= $res['id'] ?>">
										<th scope="row"><?= $res['id'] ?></th>
										<td class="nome"><?= $res['nome'] ?></td>
										<td class="cpf_cnpj"><?= $res['cpf_cnpj'] ?></td>
										<td class="endereco"><?= $res['endereco'] ?></td>
										<td><a href="javascript:editarClientes(<?= $res['id'] ?>)">Editar</a></td>
									</tr>
								<?php
                                } ?>
							</tbody>
						</table>
						<script language="javascript" type="text/javascript">
						function editarClientes(id)
						{
							let cliente = document.getElementById("cliente-"+id)
							let nome = cliente.getElementsByClassName("nome")[0].innerHTML;
							let cpf_cnpj = cliente.getElementsByClassName("cpf_cnpj")[0].innerHTML;
							let endereco = cliente.getElementsByClassName("endereco")[0].innerHTML;
							document.getElementById('nome').value = nome;
							document.getElementById('cpf_cnpj').value = cpf_cnpj;
							document.getElementById('endereco').value = endereco;
							document.getElementById('codigo').value = id;
							document.getElementById('id_cliente').innerHTML = "/ editando "+ id;
						}
						</script>
						<?php
                    break;
                }
                case 3:
                {
                    //Tratar a requisição POST
                    if (isset($_POST['subid']) && $_POST['subid'] == 3) {
                        //montagem do SQL de atualização
                        if (empty($_POST['codigo'])) {
                            $query_params = array(
                                ':nome'			=> $_POST['nome'],
                                ':endereco'		=> $_POST['endereco'],
                                ':cpf_cnpj'		=> $_POST['cpf_cnpj'],
                                ':tipo'			=> $_POST['tipo']
                            );
                            $query = "INSERT INTO cadastro.cadastro_cliforn (nome, endereco, cpf_cnpj, tipo) VALUES (:nome, :endereco, :cpf_cnpj, :tipo)";
                        } else {
                            $query_params = array(
                                ':nome'			=> $_POST['nome'],
                                ':endereco'		=> $_POST['endereco'],
                                ':cpf_cnpj'		=> $_POST['cpf_cnpj'],
                                ':tipo'			=> $_POST['tipo'],
                                ':id'			=> $_POST['codigo']
                            );
                            $query = "UPDATE cadastro.cadastro_cliforn SET
							nome	= :nome,
							endereco= :endereco,
							cpf_cnpj= :cpf_cnpj,
							tipo	= :tipo
							WHERE id= :id";
                        }
                        //executando SQL de update no banco de dados
                        try {
                            $dados = $db->prepare($query);
                            $dados->execute($query_params);
							echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
								  	<strong>Sucesso!</strong> Cadastro efetuado.
								</div>';
                        }
						catch (PDOException $ex) {
							echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Erro</strong> ' . $ex->getMessage() .'
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  		</div>' ;
                        }
                    }
                    ?>
					<form class="row p-3 mt-4" id="cadastro" action="" method="POST">
						<div class="col-12">
							<h4>Ficha de Cadastro: Fornecedores <span id="id_cliente"></span></h4>

							</div>
							<div class="col-6">
								<fieldset class="form-group">
									<label for="nome">Nome</label>
									<input type="text" class="form-control" id="nome" name="nome" value="" maxlength="200">
								</fieldset>
							</div>
							<div class="col-6">
								<fieldset class="form-group">
									<label for="cpf_cnpj">CNPJ</label>
									<input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="" maxlength="15">
								</fieldset>
							</div>
							<div class="col-12">
								<fieldset class="form-group">
									<label for="endereco">Endereço</label>
									<input type="text" class="form-control" id="endereco" name="endereco" value="" maxlength="200">
								</fieldset>
							</div>
							<div class="col-12 text-right">
								<input type="hidden" class="form-control" id="codigo" name="codigo" value="">
								<input type="hidden" name="subid" id="subid" value="<?= $_GET["subid"] ?>" />
								<input type="hidden" name="tipo" id="tipo" value="1" />
								<button type="submit" class="btn btn-primary">Salvar</button>
							</div>
						</form>
						<h4>Fornecedores Cadastrados</h4>
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nome</th>
									<th scope="col">CNPJ</th>
									<th scope="col">Endereço</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<?php
                                $sql = "SELECT * FROM cadastro.cadastro_cliforn WHERE tipo = 1 ORDER BY id ASC";
                                $query = $db->prepare($sql);
                                $query->execute();
                                foreach ($query->fetchAll() as $res) {
                                    ?>
									<tr id="cliente-<?= $res['id'] ?>">
										<th scope="row"><?= $res['id'] ?></th>
										<td class="nome"><?= $res['nome'] ?></td>
										<td class="cpf_cnpj"><?= $res['cpf_cnpj'] ?></td>
										<td class="endereco"><?= $res['endereco'] ?></td>
										<td><a href="javascript:editarFornecedores(<?= $res['id'] ?>)">Editar</a></td>
									</tr>
								<?php
                                } ?>
							</tbody>
						</table>
						<script language="javascript" type="text/javascript">
						function editarFornecedores(id)
						{
							let cliente = document.getElementById("cliente-"+id)
							let nome = cliente.getElementsByClassName("nome")[0].innerHTML;
							let cpf_cnpj = cliente.getElementsByClassName("cpf_cnpj")[0].innerHTML;
							let endereco = cliente.getElementsByClassName("endereco")[0].innerHTML;
							document.getElementById('nome').value = nome;
							document.getElementById('cpf_cnpj').value = cpf_cnpj;
							document.getElementById('endereco').value = endereco;
							document.getElementById('codigo').value = id;
							document.getElementById('id_cliente').innerHTML = "/ editando "+ id;
						}
						</script>
						<?php
                    break;
                }
            }
        }
		else
		{
		?>
			<div class="alert alert-info" role="alert">
			  	<h4 class="alert-heading">Painel de Cadastro</h4>
			  	<hr>
			  	<p class="mb-0">Selecione ao lado o tipo de cadastro desejado.</p>
			</div>
		<?php
		}
        ?>
		</div>
	</div>
