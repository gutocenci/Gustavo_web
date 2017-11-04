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

$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';

if (isset($_POST['submit'])) {

	$sql = "SELECT COUNT(cpf) AS total FROM passageiro WHERE cpf = '" . $cpf . "'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if($row['total'] > 0){
		$erro = "O CPF informado já existe.";
	} elseif ($cpf == '') {
		$erro = "O CPF não pode ser vazio.";
	} else {
		$sql = "INSERT INTO passageiro (cpf, nome, dt_nasc, sexo)
		VALUES ('" . $cpf . "', '" . $nome . "', '" . $dt_nasc ."', '" . $sexo ."')";

		if ($conn->query($sql) === TRUE) {
		    $sucesso = "Passageiro cadastrado com sucesso!";
		    $nome = '';
		    $sexo = '';
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
	<title>Cadastro de Passageiros</title>
	<?php include 'head.php';?>
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
		
		<form action="passageiros.php" method="post" class="form_validation">
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
			</tr>
	    </thead>
	    <tbody>
	    	<?php
	    	$sql = "SELECT nome, cpf FROM passageiro ORDER BY nome ASC";
	    	$result = mysqli_query($conn, $sql);
	    	while($row = mysqli_fetch_array($result)) {
	    	?>
		    	<tr>
					<td><?php echo $row['nome'];?></td>
					<td><?php echo $row['cpf'];?></td>
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