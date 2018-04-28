<div class="row">
	<div class="col-sm-3 col-md-2">
		<ul class="nav flex-column nav-pills">
			<li class="nav-item"><a class="nav-link <?= isset($_GET['subid']) && $_GET['subid'] == '1' ? 'active' : '' ?>" href="?id=2&subid=1" >Receita</a></li>
			<li class="nav-item"><a class="nav-link <?= isset($_GET['subid']) && $_GET['subid'] == '2' ? 'active' : '' ?>" href="?id=2&subid=2" >Despesa</a></li>
		</ul>
	</div>
	<div class="col-sm-9 col-md-10">
		<?php
        if (isset($_GET['subid'])) {
            switch ($_GET['subid']) {
                case 1:
                {
                ?>
					<form class="row p-3 mt-4" id="lancamentos" action="" method="POST">
						<div class="col-12">
							<h4>Lançamentos: Receita</h4>

							</div>
							<div class="col-4">
								<fieldset class="form-group">
									<label for="nome">Descrição</label>
									<input type="text" class="form-control" id="descricao" name="descricao" maxlength="200">
								</fieldset>
							</div>
							<div class="col-4">
								<fieldset class="form-group">
									<label for="cpf_cnpj">Cliente</label>
									<select class="form-control"  id="cliforn_id" name="cliforn_id">
										<?php
		                                $sql = "SELECT * FROM cadastro.cadastro_cliforn WHERE tipo = 0 ORDER BY id ASC";
		                                $query = $db->prepare($sql);
		                                $query->execute();
		                                foreach ($query->fetchAll() as $res) {
		                                    ?>
											<option value="<?= $res['id'] ?>"><?= $res['nome'] ?></option>
										<?php
		                                } ?>
								    </select>
								</fieldset>
							</div>
							<div class="col-4">
								<fieldset class="form-group">
									<label for="endereco">Valor</label>
									<input type="text" class="form-control" id="valor" name="valor" value="" maxlength="200">
								</fieldset>
							</div>
							<div class="col-12 text-right">
								<input type="hidden" name="subid" id="subid" value="<?= $_GET["subid"] ?>" />
								<input type="hidden" name="tipo" id="tipo" value="1" />
								<button type="submit" class="btn btn-primary">Salvar</button>
							</div>
						</form>
						<?php
		                    //Tratar a requisição POST
		                    if (isset($_POST['subid']) && $_POST['subid'] == 1) {
								$query_params = array(
									':descricao'	=> $_POST['descricao'],
									':tipo'			=> $_POST['tipo'],
									':valor'		=> $_POST['valor'],
									':cliforn_id'	=> $_POST['cliforn_id']
								);
								$query = "INSERT INTO cadastro.fluxo_caixa (descricao, tipo, valor, cliforn_id) VALUES (:descricao, :tipo, :valor, :cliforn_id)";
		                        //executando SQL de update no banco de dados
		                        try {
		                            $dados = $db->prepare($query);
		                            $dados->execute($query_params);
									echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
										  	<strong>Sucesso!</strong> Lançamento realizado.
										</div>';
		                        } catch (PDOException $ex) {
		                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Erro</strong> ' . $ex->getMessage() .'
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									  	</div>' ;
		                        }
		                    }
						 ?>
						<h4>Últimos Lançamentos</h4>
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Descrição</th>
									<th scope="col">Cliente</th>
									<th scope="col">Valor</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<?php
                                $sql = "SELECT fl.*, cl.nome FROM cadastro.fluxo_caixa fl LEFT JOIN cadastro.cadastro_cliforn cl ON fl.cliforn_id = cl.id WHERE fl.tipo = '1' ORDER BY id ASC";
                                $query = $db->prepare($sql);
                                $query->execute();
                                foreach ($query->fetchAll() as $res) {
                                    ?>
									<tr id="fluxo-<?= $res['id'] ?>">
										<th scope="row"><?= $res['id'] ?></th>
										<td class="descricao"><?= $res['descricao'] ?></td>
										<td class="cliente"><?= $res['nome'] ?></td>
										<td class="valor text-success"><?= number_format($res['valor'], 2, ',', ' ') ?></td>
										<td><a href="javascript:removerFLuxo(<?= $res['id'] ?>)">Apagar</a></td>
									</tr>
								<?php
                                } ?>
							</tbody>
						</table>
						<script language="javascript" type="text/javascript">
						function removerFLuxo(id)
						{
							//TODO implementar função removerFLuxo
							alert("Função não implementada. Por favor, implemente! XD");
						}
						</script>
						<?php
                    break;
                }
                case 2:
                {
                ?>
					<form class="row p-3 mt-4" id="lancamentos" action="" method="POST">
						<div class="col-12">
							<h4>Lançamentos: Despesa</h4>

							</div>
							<div class="col-4">
								<fieldset class="form-group">
									<label for="nome">Descrição</label>
									<input type="text" class="form-control" id="descricao" name="descricao" maxlength="200">
								</fieldset>
							</div>
							<div class="col-4">
								<fieldset class="form-group">
									<label for="cpf_cnpj">Fornecedor</label>
									<select class="form-control"  id="cliforn_id" name="cliforn_id">
										<?php
		                                $sql = "SELECT * FROM cadastro.cadastro_cliforn WHERE tipo = 1 ORDER BY id ASC";
		                                $query = $db->prepare($sql);
		                                $query->execute();
		                                foreach ($query->fetchAll() as $res) {
		                                    ?>
											<option value="<?= $res['id'] ?>"><?= $res['nome'] ?></option>
										<?php
		                                } ?>
								    </select>
								</fieldset>
							</div>
							<div class="col-4">
								<fieldset class="form-group">
									<label for="endereco">Valor</label>
									<input type="text" class="form-control" id="valor" name="valor" value="" maxlength="200">
								</fieldset>
							</div>
							<div class="col-12 text-right">
								<input type="hidden" name="subid" id="subid" value="<?= $_GET["subid"] ?>" />
								<input type="hidden" name="tipo" id="tipo" value="2" />
								<button type="submit" class="btn btn-primary">Salvar</button>
							</div>
						</form>
						<?php
		                    //Tratar a requisição POST
		                    if (isset($_POST['subid']) && $_POST['subid'] == 2) {
								$query_params = array(
									':descricao'	=> $_POST['descricao'],
									':tipo'			=> $_POST['tipo'],
									':valor'		=> $_POST['valor'],
									':cliforn_id'	=> $_POST['cliforn_id']
								);
								$query = "INSERT INTO cadastro.fluxo_caixa (descricao, tipo, valor, cliforn_id) VALUES (:descricao, :tipo, :valor, :cliforn_id)";
		                        //executando SQL de update no banco de dados
		                        try {
		                            $dados = $db->prepare($query);
		                            $dados->execute($query_params);
									echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
										  	<strong>Sucesso!</strong> Lançamento realizado.
										</div>';
		                        } catch (PDOException $ex) {
		                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Erro</strong> ' . $ex->getMessage() .'
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									  	</div>' ;
		                        }
		                    }
						 ?>
						<h4>Últimos Lançamentos</h4>
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Descrição</th>
									<th scope="col">Fornecedor</th>
									<th scope="col">Valor</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<?php
                                $sql = "SELECT fl.*, cl.nome FROM cadastro.fluxo_caixa fl LEFT JOIN cadastro.cadastro_cliforn cl ON fl.cliforn_id = cl.id WHERE fl.tipo = '2' ORDER BY id ASC";
                                $query = $db->prepare($sql);
                                $query->execute();
                                foreach ($query->fetchAll() as $res) {
                                    ?>
									<tr id="fluxo-<?= $res['id'] ?>">
										<th scope="row"><?= $res['id'] ?></th>
										<td class="descricao"><?= $res['descricao'] ?></td>
										<td class="cliente"><?= $res['nome'] ?></td>
										<td class="valor text-danger"><?= number_format($res['valor'], 2, ',', ' ') ?></td>
										<td><a href="javascript:removerFLuxo(<?= $res['id'] ?>)">Apagar</a></td>
									</tr>
								<?php
                                } ?>
							</tbody>
						</table>
						<script language="javascript" type="text/javascript">
						function removerFLuxo(id)
						{
							//TODO implementar função removerFLuxo
							alert("Função não implementada. Por favor, implemente! XD");
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
			  	<h4 class="alert-heading">Painel de Lançamentos</h4>
			  	<hr>
			  	<p class="mb-0">Selecione ao lado o tipo de lançamento desejado.</p>
			</div>
		<?php
		}
        ?>
		</div>
	</div>
