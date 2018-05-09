<?php
//ini_set("display_errors", "off");
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');

//verificar se o input=submit foi usado = variavel $_POST['submit'] existe
if (isset($_POST['submit'])){

//apenas efetuando o login com conta de admin é possivel enviar dados
if ($tipo_conta == 2){

//converter email para minusculas
$emailowercase = strtolower($_POST['email']);


/*Funcao usada p/ criar string valida em SQL usada por um "statment" de SQL. 
The string is encoded to an escaped SQL string, taking in account the current character set of the connection*/
$nome = mysqli_real_escape_string($db_connect, $_POST['nome_socio']);
$email = mysqli_real_escape_string($db_connect, $emailowercase);
$pass = mysqli_real_escape_string($db_connect, $_POST['pass1']);
$contacto = mysqli_real_escape_string($db_connect, $_POST['contacto']);
$morada = mysqli_real_escape_string($db_connect, $_POST['morada']);
$cc = mysqli_real_escape_string($db_connect, $_POST['cc']);
$nif = mysqli_real_escape_string($db_connect, $_POST['nif']);
$nib = mysqli_real_escape_string($db_connect, $_POST['nib']);
$nr_socio = mysqli_real_escape_string($db_connect, $_POST['nr_socio']);


if($pass == NULL){
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, "	UPDATE rinte.cliente 
							SET nomeCliente = '$nome', cc = '$cc', nif = '$nif', nib = '$nib', moradaCliente = '$morada', telefoneCliente = '$contacto' 
							WHERE idCliente = '$nr_socio'");
mysqli_query($db_connect, "UPDATE rinte.autcliente 
SET emailCliente = '$email'
WHERE clientes_idClientes = '$nr_socio'");
$exeTransc = mysqli_commit($db_connect);
	if ($exeTransc) {
		echo 'Dados de ' . $email.', editados com sucesso.<br><a href = "perfil_admin.php">Regressar ao Perfil</a>';
	}
	else {
		echo '1-Erro na alteração dos dados de ' . $email.', <br><a href="editar_user.php">Voltar atrás</a>';
		}
}

else{
//segurança: password hashing 
$options = ['cost' => 10, ];
$passhash = $pass;
$hash = password_hash($passhash, PASSWORD_BCRYPT, $options);
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, "UPDATE rinte.cliente 
SET nomeCliente = '$nome', cc = '$cc', nif = '$nif', nib = '$nib', moradaCliente = '$morada', telefoneCliente = '$contacto' 
WHERE idCliente = '$nr_socio'");
printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, "UPDATE rinte.autcliente 
SET emailCliente = '$email', passwordCliente = '$hash'
WHERE clientes_idClientes = '$nr_socio'");
printf("%s\n", mysqli_info($db_connect));
$exeTransc = mysqli_commit($db_connect);
printf("%s\n", mysqli_info($db_connect));
	if ($exeTransc) {
		echo 'Dados de ' . $email.', editados com sucesso.<br><a href = "perfil_admin.php">Regressar ao Perfil</a>';
		echo $email;
		echo $hash;
	}
	else {
		echo '2-Erro na alteração dos dados de ' . $email.', <br><a href="editar_user.php">Voltar atrás</a>';
		}
		}
	}
}
mysqli_close($db_connect);
?>