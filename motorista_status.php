<?php

include 'config.php';
include 'classes.php';

$cpf = $_POST['cpf'];
$estado = $_POST['estado'];

if ($estado == "false") {
	$status = '0';
} else {
	$status = '1';
}

$sql = "UPDATE motorista SET estado = '" . $status . "' WHERE cpf = '" . $cpf . "'";
mysqli_query($conn, $sql);
if (mysqli_affected_rows($conn) == 1) {
	$json = '{"status":"sucesso", "mensagem":"Alterado com sucesso!"}';
} else {
	$json = '{"status":"erro", "mensagem":"Não foi possível alterar o status do motorista."}';
}

header('Content-Type: application/json');
echo $json;
?>