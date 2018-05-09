<?php
ini_set("display_errors", "on");
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

require("./db_connect.php");
//verifica se a sessão está iniciada
require('sessao.php');
require("./PHPMailer-master/PHPMailerAutoload.php");

//verificar se o input=submit foi usado = variavel $_POST['submit'] existe
if (isset($_POST['submit'])){

//apenas efetuando o login com conta de admin é possivel enviar dados
if ($tipo_conta == 2){

//converter email para minusculas
$emailowercase = strtolower($_POST['email']);

if (mb_strlen($emailowercase, "UTF-8") < 5){
	die('Erro na criação da conta' . $emailowercase . '<a href = "./perfil_admin.php">Voltar atrás</a>');
}
else {
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

//$tipo = mysqli_real_escape_string($db_connect, $_POST['tipo']);
//$ficheiro = mysqli_real_escape_string($db_connect, $_FILES['fotografia']['tmp_name']);

//fotografia para ser inserida na BD
/*$fp = fopen($ficheiro, "rb"); 
$ficheiro_conteudo = fread($fp, filesize($_FILES['fotografia']['tmp_name']));
$foto_conteudo = mysqli_real_escape_string($db_connect, $ficheiro_conteudo);
fclose($fp);*/


//segurança: password hashing 
$options = ['cost' => 10, ];
$passhash = password_hash($pass, PASSWORD_BCRYPT, $options);


$mail = new PHPMailer;
// Modo de debug, 1-erros e mensagens; 2-mensagens
$mail->SMTPDebug = 0;		

$mail->isSMTP(); 
//desativa verificação ssl(secure socket layers), visto que nao tenho nenhum certificado
$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
	)
);
$mail->Host = 'smtp.gmail.com';	// Specify main and backup SMTP servers
$mail->SMTPAuth = true;		// Enable SMTP authentication
$mail->Username = 'pie.pesta@gmail.com';		// SMTP username
$mail->Password = 'pesta1100363';		// SMTP password
$mail->SMTPSecure = 'tls';		// Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('pie.pesta@gmail.com', 'Gym');
$mail->addAddress($email, $nome);	// Add a recipient

$mail->isHTML(true);		// Set email format to HTML

$mail->Subject = 'Bem vindo(a) ao Gym';
$mail->Body = 'Bem vindo(a) ao Gym ' . $nome . ', qualquer d&uacutevida ou esclarecimento necess&aacuterio pode ser feita atrav&eacutes deste email.';
$mail->AltBody = 'Bem vindo(a) ao Gym ' . $nome . ', qualquer d&uacutevida ou esclarecimento necess&aacuterio pode ser feita atrav&eacutes deste email.';

//enviar dados para base de dados

/*$sql = "START TRANSACTION;
INSERT INTO rinte.cliente (idCliente, nomeCliente, cc, nif, nib, moradaCliente, telefoneCliente)
  VALUES('$nr_socio', '$nome', '$cc', '$nif', '$nib', '$morada', '$contacto');
SELECT LAST_INSERT_ID() INTO @userIDinsert;
INSERT INTO rinte.autcliente (clientes_idClientes, emailCliente, passwordCliente) 
  VALUES(@userIDinsert,'$email', '$passhash');
COMMIT;";*/
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, "INSERT INTO rinte.cliente (nomeCliente, cc, nif, nib, moradaCliente, telefoneCliente)
  VALUES('$nome', '$cc', '$nif', '$nib', '$morada', '$contacto');");
mysqli_query($db_connect, "INSERT INTO rinte.autcliente (clientes_idClientes, emailCliente, passwordCliente) 
  VALUES('$nr_socio','$email', '$passhash');");
$exeTransc = mysqli_commit($db_connect);
//caso de sucesso no envio  if(mysqli_query($db_connect, $sql)){
if ($exeTransc) { 
		if ($mail->send()){
	echo 'Conta criada com sucesso. Email enviado para: ' . $email .'.';
	echo '<br><a href = "./perfil_admin.php">Perfil Admin</a>';
	}
		else {
			echo 'Conta criada com sucesso. Mas ocorreu um erro no envio do email para: ' . $email . '<br><a href = "./perfil_admin.php">Perfil Admin</a>';
		}	
//caso de insucesso no envio	
	} 
	else {
	echo 'Erro na criação da conta ' . $tipo_conta . ' <br> <a href = "./perfil_admin.php">Voltar atrás</a>';
		}
mysqli_close($db_connect);
	}
} else { 
	echo 'Erro na criação da conta . ' . $tipo_conta . ' <br> <a href = "./perfil_admin.php">Voltar atrás</a>';
	}
}
//se a variavel submit nao estiver definida algo correu mal, então o user é redirecionado para pagina de criação de conta outra vez
else {
	header("location:./logout.php");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>GymLife</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="custom_style.css" />
</head>
<body>
</body>
</html>