
<?php 


require_once "../../classes/conexao.php";
	$c = new conectar();
		$conexao=$c->conexao();

 $sql ="SELECT p.product_id , p.tag_id, g.name, t.name
		FROM product_tag p
		INNER JOIN product g ON p.product_id = g.id
		INNER JOIN tag t ON p.tag_id = t.id";

$result = mysqli_query($conexao, $sql);

?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	<caption><label>Relatório Produtos e Respectiva Tags Cadastrada</label></caption>
	<tr>
		<td>Produto</td>
		<td>Tags</td>
		
	</tr>

	<?php while($mostrar=mysqli_fetch_row($result))://&& //$mostrar=mysqli_fetch_row($result)):   ?>
	
	<tr>		
		<td><?php echo $mostrar[2]; ?></td>		
		<td><?php echo $mostrar[3]; ?></td>	
	
	</tr>
<?php endwhile; ?>
</table>