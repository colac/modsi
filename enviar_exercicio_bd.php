<?php
ini_set("display_errors", "on");
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');

//verificar se o input=submit foi usado = variavel $_POST['submit'] existe
if (isset($_POST['submit'])){

//apenas efetuando o login com conta de admin é possivel enviar dados
if ($tipo_conta == 2){

/*Funcao usada p/ criar string valida em SQL usada por um "statment" de SQL. 
The string is encoded to an escaped SQL string, taking in account the current character set of the connection*/
$nomeExercicio = mysqli_real_escape_string($db_connect, $_POST['nomeExercicio']);
$tipo = mysqli_real_escape_string($db_connect, $_POST['tipo']);


$sql = "INSERT INTO rinte.exercico (nomeExercicio, tipo)
		VALUES ('$nomeExercicio', '$tipo')";
$query = mysqli_query($db_connect, $sql);

	if ($query) {
		echo 'Exercício ' . $nomeExercicio.', inserido com sucesso.<br><a href = "perfil_admin.php">Regressar ao Perfil</a>';
	}
	else {
		echo 'Exercício ' . $nomeExercicio.', não inserido. <br><a href = "perfil_admin.php">Regressar ao Perfil</a>';
		}
	}
}
	else {
		echo 'Erro na submissão do formulário. <br><a href = "perfil_admin.php">Regressar ao Perfil</a>';
	}
mysqli_close($db_connect);
?>