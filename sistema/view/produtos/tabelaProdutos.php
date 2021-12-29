
<?php 

require_once "../../classes/conexao.php";
	$c = new conectar();
		$conexao=$c->conexao();

	$sql = "SELECT id, name FROM product";
	$result = mysqli_query($conexao, $sql);

	 ?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	<caption><label>Produtos teste</label></caption>
	<tr>
		<td>Nome</td>
		<td>Editar</td>
		<td>Excluir</td>
	</tr>

	<?php while($mostrar=mysqli_fetch_row($result)): ?>

	<tr>
		<?php //var_dump($result);?>
		<td><?php echo $mostrar[1]; ?></td>
	
			
		<td>
		<span  data-toggle="modal" data-target="#abremodalUpdateProduto" class="btn btn-warning btn-xs" onclick="addDadosProduto('<?php echo $mostrar[0];?>')">



				<span class="glyphicon glyphicon-pencil"></span>
			</span>
		</td>
		<td>
			<span class="btn btn-danger btn-xs" onclick="eliminarProduto('<?php echo $mostrar[0] ?>')">
				<span class="glyphicon glyphicon-remove"></span>
			</span>
		</td>
	</tr>
<?php endwhile; ?>
</table>