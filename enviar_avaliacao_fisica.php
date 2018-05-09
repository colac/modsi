<?php
//ini_set("display_errors", "off");
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

require("./db_connect.php");
//verifica se a sessão está iniciada
require('sessao.php');
require("./PHPMailer-master/PHPMailerAutoload.php");

//verificar se o input=submit foi usado = variavel $_POST['submit'] existe
if (isset($_POST['submit'])){

//efetuando login com conta de admin ou prof é possivel enviar dados
if ($tipo_conta == 1 OR $tipo_conta == 2){

$n_socio = mysqli_real_escape_string($db_connect, $_POST['n_socio']);

if (!isset($n_socio)){
	echo '0-Erro no envio. Insirir n&uacutemero de s&oacutecio.<li><a href="criar_avaliacao_fisica.php">Avaliação Fisica </a></li>';
}
else {
$sql = "SELECT *
		FROM rinte.cliente, rinte.autcliente
		WHERE idCliente = '$nr_socio' AND idCliente = clientes_idClientes AND ativoCliente = '1'";
$query = mysqli_query($db_connect, $sql);
printf("%s\n", mysqli_info($db_connect));
$row = mysqli_fetch_assoc($query);
$email_user = $row['emailCliente'];
$nome_user = $row['nomeCliente'];

/*Funcao usada p/ criar string valida em SQL usada por um "statment" de SQL. 
The string is encoded to an escaped SQL string, taking in account the current character set of the connection*/

$altura = mysqli_real_escape_string($db_connect, $_POST['altura']);
$peso = mysqli_real_escape_string($db_connect, $_POST['peso']);
$massaGorda = mysqli_real_escape_string($db_connect, $_POST['massaGorda']);

//enviar dados para base de dados

$sql = "INSERT INTO rinte.caracteristicasfisicas (caractFisicas_idCliente, peso, altura, massaGorda) VALUES('$n_socio', '$peso', '$altura','$massaGorda')";
$query = mysqli_query($db_connect, $sql);
//caso de sucesso no envio  if(mysqli_query($db_connect, $sql)){
if ($query) { 
	echo 'Dados inseridos com sucesso.';
	echo '<br><a href = "./perfil_admin.php">Perfil Admin</a>';
//caso de insucesso no envio	
	} else {
	echo '1-Erro no envio. <br><a href="criar_avaliacao_fisica.php">Avaliação Fisica </a><br>';
	echo $n_socio; echo $peso; echo $altura; echo $massaGorda; 
		}
mysqli_close($db_connect);
		}
} else { 
	echo '2-Erro no envio. <br><a href="criar_avaliacao_fisica.php">Avaliação Fisica </a>';
	}
}
//se a variavel submit nao estiver definida algo correu mal, então o user é redirecionado para pagina de criação de conta outra vez
else {
	header("location:./logout.php");
	exit();
}
?>