<?php
include 'config.php';
include 'classes.php';

$cpf = isset($_POST['cpf']) ? str_replace('.', '', str_replace('-', '', $_POST['cpf'])) : '';
$nome = isset($_POST['name']) ? $_POST['name'] : '';
$dt_nasc = isset($_POST['dt_nasc']) ? $_POST['dt_nasc'] : '';
$dt_nasc_form = $dt_nasc;

if ($dt_nasc != ''){
	$dt_nasc = explode('/', $dt_nasc);
	$dt_nasc = $dt_nasc[2] . '-' . $dt_nasc[1] . '-' . $dt_nasc[0];
}

$modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';

if (isset($_POST['submit'])) {

	$sql = "SELECT COUNT(cpf) AS total FROM motorista WHERE cpf = '" . $cpf . "'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if($row['total'] > 0){
		$erro = "O CPF informado já existe.";
	} elseif ($cpf == '') {
		$erro = "O CPF não pode ser vazio.";
	} else {
		$sql = "INSERT INTO motorista (cpf, nome, dt_nasc, modelo, estado, sexo)
		VALUES ('" . $cpf . "', '" . $nome . "', '" . $dt_nasc ."', '" . $modelo ."', '" . $estado ."', '" . $sexo ."')";

		if ($conn->query($sql) === TRUE) {
		    $sucesso = "Motorista cadastrado com sucesso!";
		    $nome = '';
		    $modelo = '';
		    $sexo = '';
		    $estado = '';
		    $dt_nasc_form = '';
		    $cpf = '';

		} else {
			printf("Error: %s\n", $conn->error);
		    $erro = "Não foi possível cadastrar!";
		}
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Cadastro de Motoristas</title>
	<?php include 'head.php';?>
	<script>
		$(function($){

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
		<form action="motoristas.php" method="post" class="form_validation">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="cpf">CPF:</label>
						<input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $cpf;?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="name">Nome:</label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo $nome;?>">
					</div>
				</div>
			</div>
		    <div class="row">
		        <div class='col-sm-4'>
		            <div class="form-group">
		            	<label for="dt_nasc">Data de nascimento:</label>
		            	<input type="text" class="form-control" value="<?php echo $dt_nasc_form;?>" id="dt_nasc" name="dt_nasc">
		            </div>
		        </div>
		        <script type="text/javascript">
		        	$.datetimepicker.setLocale('pt-BR');
		            $(function () {
		                $('#dt_nasc').datetimepicker({
		                    timepicker:false,
		                    format:'d/m/Y'
		                });
		            });
		        </script>
		    </div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="modelo">Modelo:</label>
						<select class="form-control" id="modelo" name="modelo">
							<option>Gol</option>
							<option>Uno</option>
							<option>Palio</option>
							<option>Celta</option>
							<option>Corsa</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="usr">Status:</label>
						 <div class="radio">
							<label><input type="radio" name="estado" value="1"<?php echo $estado == '1' || $estado == '' ? ' checked' : '';?>> Ativo</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="estado" value="0"<?php echo $estado == '0' ? ' checked' : '';?>> Inativo</label>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="usr">Sexo:</label>
						<div class="radio">
							<label><input type="radio" cheked name="sexo" value="M"<?php echo $sexo == 'M' || $sexo == '' ? ' checked' : '';?>> Masculino</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="sexo" value="F"<?php echo $sexo == 'F' ? ' checked' : '';?>> Feminino</label>
						</div>
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
	    		<th>Nome</th>
				<th>CPF</th>
				<th>Status</th>
			</tr>
	    </thead>
	    <tbody>
	    	<?php
	    	$sql = "SELECT nome, cpf, estado FROM motorista ORDER BY nome ASC";
	    	$result = mysqli_query($conn, $sql);
	    	while($row = mysqli_fetch_array($result)) {
	    	?>
		    	<tr>
					<td><?php echo $row['nome'];?></td>
					<td><?php echo $row['cpf'];?></td>
					<td><input type="checkbox" value="<?php echo $row['cpf'];?>" class="toggle-two"<?php echo $row['estado'] == '1' ? ' checked' : '';?>></td>
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