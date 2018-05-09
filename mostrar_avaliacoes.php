<?php
//ini_set("display_errors", "off");
//usar estilo CSS na pág. PHP
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Avaliações Físicas</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
	<link href="custom_style.css" rel="stylesheet">
</head>';

require("./db_connect.php");
//verifica se a sessão está iniciada
require('sessao.php');

$sql = "SELECT idcaracteristicasFisicas, caractFisicas_idCliente, peso, altura, massaGorda, dataCaractFisicas
		FROM rinte.caracteristicasfisicas
		WHERE caractFisicas_idCliente = '$id_session'";
$query = mysqli_query($db_connect, $sql);

if (mysqli_num_rows($query) > 0 ) {
echo "<div class='container'>
<h2 class='sub-header'>Avaliações Físicas de $nome_session</h2>
<div class='table-responsive'>

<table class='table table-striped'>
<thead>
<tr>
<th>Altura</th>
<th>Peso</th>
<th>Percentagem de Massa Gorda</th>
<th>Data da Avaliação</th>
</tr>
</thead>";

while($row = mysqli_fetch_assoc($query)) {

$altura = $row['altura'];
$peso = $row['peso'];
$massaGorda = $row['massaGorda'];
$dataCaractFisicas = $row['dataCaractFisicas'];
$data = date("d-m-Y", strtotime($dataCaractFisicas));
echo "<tr>
<td>$altura m</td>
<td>$peso kg</td>
<td>$massaGorda %</td>
<td>$data</td>
</tr>
</div>
</div>";
	}
echo "</table>";
echo '<a href = "./perfil.php">Perfil</a>';
}
else { 	
    echo 'Não foi realizada nenhuma avaliação física. <a href = "./perfil.php">Perfil</a>';
}
mysqli_close($db_connect);
?>