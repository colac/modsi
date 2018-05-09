<?php
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

if (isset($_POST['submit'])){

require("./db_connect.php");
session_start();

$staff_login = mysqli_real_escape_string($db_connect, $_POST['staff_email']);
$pass_form = mysqli_real_escape_string($db_connect, $_POST['staff_password']);

$sql = "SELECT autFuncionario.idautFuncionario, autFuncionario.autFuncionarios_idFuncionario, autFuncionario.emailFuncionario, autFuncionario.passwordFuncionario, funcionario.nomeFuncionario, funcionario.admin, funcionario.ativoFuncionario
		FROM rinte.autFuncionario, rinte.funcionario
		WHERE emailFuncionario = '$staff_login' AND idFuncionario = autFuncionarios_idFuncionario"; 
$query = mysqli_query($db_connect, $sql);
//função vai buscar a linha do query como um vector associativo
if($row = mysqli_fetch_assoc($query) AND $row['ativoFuncionario'] == 1){

//password armazenada na base de dados
$hashpassword = $row["passwordFuncionario"];
if(password_verify($pass_form, $hashpassword)){

//coloca o user_login na variavel $_SESSION["user_email"] para se poder usar noutros ficheiros
	$_SESSION['user_email'] = $row['emailFuncionario'];
	$_SESSION['id_autFunc'] = $row['autFuncionarios_idFuncionario'];
	$_SESSION['nome'] = $row['nomeFuncionario'];
	$_SESSION['admin'] = $row['admin'];
	$id_session = $_SESSION['idFuncionario'];
	
//adiciona uma entrada na tabela users_on, apenas para os socios
/*	if($_SESSION['tipo'] == 3){
	$sql_login = "INSERT INTO users_on (fk_id_on)
		VALUES ('$id_session')";	
	$query = mysqli_query($db_connect, $sql_login);
//permite guardar o id do ultimo INSERT ou UPDATE efetuado
	$_SESSION['login_time'] = mysqli_insert_id($db_connect);
	} */
header("location:./perfil_admin.php");
} 
else {//No caso da password estar errada mostra esta mensagem
		echo "Password errada.<br>";
		echo "<br><a href='./index.html'>Voltar atrás</a><br/>";
		}
	}//No caso de email nao existir mostra esta mensagem
	else{
		echo "Email errado.<br>";
		echo "<br><a href='./index.html'>Voltar atrás</a><br/>";
	}
mysqli_close($db_connect);
	}
else {
//se o user tentar por exemplo ir diretamente para a pagina de perfil sem usar o formulario de login é redirecionado para a pagina index.html
	header("location:./index.html");
}
?>