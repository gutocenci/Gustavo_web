<?php
include 'config.php';
include 'classes.php';

$motorista_cpf = isset($_POST['motorista']) ? str_replace('.', '', str_replace('-', '', $_POST['motorista'])) : '';
$passageiro_cpf = isset($_POST['passageiro']) ? str_replace('.', '', str_replace('-', '', $_POST['passageiro'])) : '';
$valor = isset($_POST['valor']) ? $_POST['valor'] : '';
$valor_form = $valor;
$valor = str_replace(',', '', $valor);

if (isset($_POST['submit'])) {
		
	$sql = "INSERT INTO corrida (motorista_cpf, passageiro_cpf, valor) VALUES ('" . $motorista_cpf . "', '" . $passageiro_cpf . "', '" . $valor ."')";

	if ($conn->query($sql) === TRUE) {
	    $sucesso = "Corrida cadastrada com sucesso!";
	    $motorista_cpf = '';
	    $passageiro_cpf = '';
	    $valor_form = '';
	} else {
		printf("Error: %s\n", $conn->error);
	    $erro = "Não foi possível cadastrar!";
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Cadastro de Corridas</title>
	<?php include 'head.php';?>
	<script>
		$(function($){
			
			$("#valor").maskMoney();

			$('.toggle-two').bootstrapToggle({
			     on: 'Ativo',
			     off: 'Inativo'
			});

			$('.toggle-two').change(function() {
				var cpf = $(this).val();
				var estado = $(this).prop('checked');
				$.post("motorista_status.php", { cpf: cpf, estado: estado }).done(function( data ) {
				  	if (data.status == "sucesso") {
				  		//alert(data.mensagem);
				  	}
				}, "json");
		    });

			$("#form_corrida").submit(function( event ) {
			 	if ($('#motorista').val() == '') {
			 		alert("Por favor selecione o motorista.");
			 		var error = true;
			 	} else if ($('#passageiro').val() == '') {
			 		alert("Por favor selecione o passageiro.");
			 		var error = true;
			 	} else if ($('#valor').val() == '') {
			 		alert("Por favor digite o valor da corrida.");
			 		var error = true;
			 	}
			 	if (error) {
			 		event.preventDefault();
			 	}
			});
		});
	</script>
</head>

<body>
	<?php include 'navbar.php';?>
	<div class="container">
		<?php if(isset($sucesso)) { ?>
			<div class="row">
				<div class="alert alert-success col-sm-4">
					<?php echo $sucesso; ?>
				</div>
			</div>
		<?php
		}
		?>
		<?php if(isset($erro)) { ?>
			<div class="row">
				<div class="alert alert-danger col-sm-4">
					<?php echo $erro; ?>
				</div>
			</div>
		<?php
		}
		?>
		
		<form action="corridas.php" method="post" id="form_corrida">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="motorista">Motorista:</label>
						<select class="form-control" id="motorista" name="motorista">
							<option value=""></option>
							<?php
					    	$sql = "SELECT cpf, nome FROM motorista WHERE estado = '1' ORDER BY nome ASC";
					    	$result = mysqli_query($conn, $sql);
					    	while($row = mysqli_fetch_array($result)) {
					    	?>
						    	<option value="<?php echo $row['cpf'];?>"><?php echo $row['nome'];?></option>
							<?php
							}
					    	?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="passageiro">Passageiro:</label>
						<select class="form-control" id="passageiro" name="passageiro">
							<option value=""></option>
							<?php
					    	$sql = "SELECT cpf, nome FROM passageiro ORDER BY nome ASC";
					    	$result = mysqli_query($conn, $sql);
					    	while($row = mysqli_fetch_array($result)) {
					    	?>
						    	<option value="<?php echo $row['cpf'];?>"><?php echo $row['nome'];?></option>
							<?php
							}
					    	?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="valor">Valor:</label>
						<input type="text" class="form-control" id="valor" name="valor" value="<?php echo $valor_form;?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<input type="submit" class="btn btn-info" id="submit" name="submit" value="Cadastrar">
					</div>
				</div>
			</div>
		</form>
		<table class="table table-striped table-bordered">
	    <thead>
	    	<tr>
	    		<th>ID</th>
	    		<th>Motorista</th>
				<th>Passageiro</th>
				<th>Valor</th>
			</tr>
	    </thead>
	    <tbody>
	    	<?php
	    	$sql = "SELECT id, passageiro.nome AS passageiro_nome, motorista.nome AS motorista_nome, valor FROM corrida INNER JOIN motorista ON motorista.cpf = corrida.motorista_cpf INNER JOIN passageiro ON passageiro.cpf = corrida.passageiro_cpf ORDER BY valor ASC";
	    	$result = mysqli_query($conn, $sql);
	    	while($row = mysqli_fetch_array($result)) {
	    	?>
		    	<tr>
		    		<td><?php echo $row['id'];?></td>
					<td><?php echo $row['motorista_nome'];?></td>
					<td><?php echo $row['passageiro_nome'];?></td>
					<td>R$ <?php echo number_format($row['valor'], 2, ',', '.');?></td>
				</tr>
			<?php
			}
	    	?>
	    </tbody>
	  </table>
	</div>
</body>
</html>
<?php
$conn->close();
?>