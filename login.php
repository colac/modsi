<?php
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

if (isset($_POST['submit'])){

require("./db_connect.php");
session_start();

$user_login = mysqli_real_escape_string($db_connect, $_POST['user_email']);
$pass_form = mysqli_real_escape_string($db_connect, $_POST['user_password']);

$sql = "SELECT *
		FROM rinte.cliente, rinte.autcliente
		WHERE emailCliente = '$user_login' AND idCliente = clientes_idClientes  AND ativoCliente = 1"; 
$query = mysqli_query($db_connect, $sql);
//função vai buscar a linha do query como um vector associativo
if($row = mysqli_fetch_assoc($query)){

//password armazenada na base de dados
$hashpassword = $row["passwordCliente"];
if(password_verify($pass_form, $hashpassword)){

//coloca o user_login na variavel $_SESSION["user_email"] para se poder usar noutros ficheiros
	$_SESSION['user_email'] = $row['emailCliente'];
	$_SESSION['id'] = $row['idCliente'];
	$_SESSION['tipo'] = $row['tipo'];
	$_SESSION['nome'] = $row['nomeCliente'];
	$id_session = $_SESSION['id'];
//adiciona uma entrada na tabela users_on, apenas para os socios
	$_SESSION['tipo'];
$sql_login = "INSERT INTO rinte.logincliente (loginCliente_idCliente) 
			VALUES ('$id_session')";	
	$query = mysqli_query($db_connect, $sql_login);
//permite guardar o id do ultimo INSERT ou UPDATE efetuado
	$_SESSION['login_time'] = mysqli_insert_id($db_connect);
	}
	header("location: perfil.php");
} 
else {//No caso da password estar errada mostra esta mensagem
		echo "Password errada.<br>";
		echo "<br><a href='./index.html'>Voltar atrás</a><br/>";
	}
mysqli_close($db_connect);
}

else {
//se o user tentar por exemplo ir diretamente para a pagina de perfil sem usar o formulario de login é redirecionado para a pagina index.html
	header("location:./staff.html");
}
?>