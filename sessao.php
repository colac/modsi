<?php
ini_set("display_errors", "off");
/*sessao.php criado para ser mais facil verificar se existe sessão iniciada*/
//require("./db_connect.php");
session_start();
if(isset($_SESSION['id_autFunc'])){
$login_session = $_SESSION['user_email'];
$id_session = $_SESSION['id_autFunc'];
$nome_session = $_SESSION['nome'];

	if ($_SESSION['admin'] != NULL)	{
$tipo_conta = $_SESSION['admin'];
	}
}
elseif($_SESSION['id'] != NULL){
	$login_session = $_SESSION['user_email'];
	$id_session = $_SESSION['id'];
	$_SESSION['tipo'];
	$nome_session = $_SESSION['nome'];
	$id_session = $_SESSION['id'];
	$n_socio = $id_session;
}

/*se $_SESSION['user_name'] nao tiver definida e for NULL o utilizador é direcionado para o formulario de login*/
if(!isset($login_session)){
      header("location:./index.html");
	  exit; //para a execução do codigo obrigatoriamente
	  mysqli_close($db_connect);
}
else{}
?>