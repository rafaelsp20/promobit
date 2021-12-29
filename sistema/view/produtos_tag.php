<?php 
session_start();
if(isset($_SESSION['usuario'])){

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>produtos tags</title>
		<?php require_once "menu.php"; ?>
		<?php require_once "../classes/conexao.php"; 
		$c= new conectar();
		$conexao=$c->conexao();
		
		$sql="SELECT id,name
		from tag";
		$result=mysqli_query($conexao,$sql);

		$sql="SELECT id,name
		from product";
		$result1=mysqli_query($conexao,$sql);
		
		?>
	</head>
	<body>
		<div class="container">
			<h1>Produtos & Tags</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmProdutos" enctype="multipart/form-data">
						<select class="form-control input-sm" id="categoriaSelect1" name="categoriaSelect1">
							<option value="A">Selecionar Categoria</option>
							<?php while($ver=mysqli_fetch_row($result1)): ?>
								<option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
							<?php endwhile; ?>
						</select>

						<label>Categoria</label> <!--tag 1 -->
						<select class="form-control input-sm" id="categoriaSelect" name="categoriaSelect">
							<option value="A">Selecionar Categoria</option>
							<?php while($mostrar=mysqli_fetch_row($result)): ?>
								<option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1]; ?></option>
							<?php endwhile; ?>
						</select>
						
						
						<p></p>
						<span id="btnAddProduto" class="btn btn-primary">Adicionar</span>
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tabelaProdutosLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->
		
		<!-- Modal -->
		<div class="modal fade" id="abremodalUpdateProduto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Editar Produto</h4>
					</div>
					<div class="modal-body">
						<form id="frmProdutosU" enctype="multipart/form-data">
							<input type="text" id="idProduto" hidden="" name="idProduto">
							<label>Categoria</label>
							<select class="form-control input-sm" id="categoriaSelectU" name="categoriaSelectU">
								<option value="A">Selecionar Categoria</option>
								<?php 
								$sql="SELECT id_categoria,nome_categoria
								from categorias";
								$result=mysqli_query($conexao,$sql);
								?>
								<?php while($mostrar=mysqli_fetch_row($result)): ?>
									<option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1]; ?></option>
								<?php endwhile; ?>
							</select>
							<label>Nome</label>
							<input type="text" class="form-control input-sm" id="nomeU" name="nomeU">
							<label>Descrição</label>
							<input type="text" class="form-control input-sm" id="descricaoU" name="descricaoU">
							<label>Quantidade</label>
							<input type="text" class="form-control input-sm" id="quantidadeU" name="quantidadeU">
							<label>Preço</label>
							<input type="text" class="form-control input-sm" id="precoU" name="precoU">
							
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAtualizarProduto" type="button" class="btn btn-warning" data-dismiss="modal">Editar</button>

					</div>
				</div>
			</div>
		</div>

	</body>
	</html>

	<script type="text/javascript">
		function addDadosProduto(idproduto){
			$.ajax({
				type:"POST",
				data:"idpro=" + idproduto,
				url:"../procedimentos/produtos/obterDados.php",
				success:function(r){
					
					dado=jQuery.parseJSON(r);
					$('#idProduto').val(dado['id_produto']);
					$('#categoriaSelectU').val(dado['id_categoria']);
					$('#nomeU').val(dado['nome']);
					$('#descricaoU').val(dado['descricao']);
					$('#quantidadeU').val(dado['quantidade']);
					$('#precoU').val(dado['preco']);

				}
			});
		}

		function eliminarProduto(idProduto){
			alertify.confirm('Deseja Excluir este Produto?', function(){ 
				$.ajax({
					type:"POST",
					data:"idproduto=" + idProduto,
					url:"../procedimentos/produtos/eliminarProdutos.php",
					success:function(r){
						if(r==1){
							$('#tabelaProdutosLoad').load("produtos/tabelaProdutosTag.php");
							alertify.success("Excluido com sucesso!!");
						}else{
							alertify.error("Não Excluido :(");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado !')
			});
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAtualizarProduto').click(function(){

				dados=$('#frmProdutosU').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/produtos/atualizarProdutos.php",
					success:function(r){
						if(r==1){
							$('#tabelaProdutosLoad').load("produtos/tabelaProdutosTag.php");
							alertify.success("Editado com sucesso!!");
						}else{
							alertify.error("Erro ao editar");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#tabelaProdutosLoad').load("produtos/tabelaProdutosTag.php");

			$('#btnAddProduto').click(function(){

				vazios=validarFormVazio('frmProdutos');

				if(vazios > 0){
					alertify.alert("Preencha todos os campos!!");
					return false;
				}

				var formData = new FormData(document.getElementById("frmProdutos"));

				$.ajax({
					url: "../procedimentos/produtos/inserirProdutosTag.php",
					type: "post",
					dataType: "html",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,

					success:function(r){		
					
						if(r == 1){
							$('#frmProdutos')[0].reset();
							$('#tabelaProdutosLoad').load("produtos/tabelaProdutosTag.php");
							alertify.success("Adicionado com sucesso!!");
						}else{
							alertify.error("Falha ao Adicionar");
						}
					}
				});
				
			});
		});
	</script>

	<?php 
}else{
	header("location:../index.php");
}
?>