<h4>Fluxo de Caixa</h4>
<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Descrição</th>
			<th scope="col">Cliente/Fornecedor</th>
			<th scope="col">Valor</th>
			<th scope="col">Saldo</th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql = "SELECT fl.*, cl.nome FROM cadastro.fluxo_caixa fl LEFT JOIN cadastro.cadastro_cliforn cl ON fl.cliforn_id = cl.id ORDER BY id ASC";
		$query = $db->prepare($sql);
		$query->execute();
		$saldo = 0;
		foreach ($query->fetchAll() as $res) {
			$saldo = $res['tipo'] == '1' ? ($saldo + $res['valor']) : ($saldo - $res['valor']);
			?>
			<tr id="fluxo-<?= $res['id'] ?>">
				<th scope="row"><?= $res['id'] ?></th>
				<td class="descricao"><?= $res['descricao'] ?></td>
				<td class="cliente"><?= $res['nome'] ?></td>
				<td class="valor <?= $res['tipo'] == '1' ? 'text-success' : 'text-danger' ?>"><?= number_format($res['valor'], 2, ',', ' ') ?></td>
				<td class="saldo <?= $saldo >= 0 ? 'text-info' : 'text-warning' ?>"><?= number_format($saldo, 2, ',', ' ') ?></td>
				<td class="text-right"><a href="javascript:removerFLuxo(<?= $res['id'] ?>)">Apagar</a></td>
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
