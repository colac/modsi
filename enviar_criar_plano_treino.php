<?php
//ini_set("display_errors", "off");
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
require("./PHPMailer-master/PHPMailerAutoload.php");

//verificar se o input=submit foi usado = variavel $_POST['submit'] existe
if (isset($_POST['submit'])){

$nr_socio = mysqli_real_escape_string($db_connect, $_POST['nr_socio']);
$planoDia = mysqli_real_escape_string($db_connect, $_POST['planoDia']);

$ex_1 = mysqli_real_escape_string($db_connect, $_POST['ex_1']);
$notas_ex_1 = mysqli_real_escape_string($db_connect, $_POST['notas_ex_1']);
$ex_2 = mysqli_real_escape_string($db_connect, $_POST['ex_2']);
$notas_ex_2 = mysqli_real_escape_string($db_connect, $_POST['notas_ex_2']);
$ex_3 = mysqli_real_escape_string($db_connect, $_POST['ex_3']);
$notas_ex_3 = mysqli_real_escape_string($db_connect, $_POST['notas_ex_3']);
$ex_4 = mysqli_real_escape_string($db_connect, $_POST['ex_4']);
$notas_ex_4 = mysqli_real_escape_string($db_connect, $_POST['notas_ex_4']);
$ex_5 = mysqli_real_escape_string($db_connect, $_POST['ex_5']);
$notas_ex_5 = mysqli_real_escape_string($db_connect, $_POST['notas_ex_5']);
$ex_6 = mysqli_real_escape_string($db_connect, $_POST['ex_6']);
$notas_ex_6 = mysqli_real_escape_string($db_connect, $_POST['notas_ex_6']);
$notas_exercicio = mysqli_real_escape_string($db_connect, $_POST['notas_exercicio']);

	/*if (!isset($nr_socio) OR !isset($planoDia)){
	echo 'Erro no envio. Insirir n&uacutemero de s&oacutecio e o dia de Treino (ex: A, B, C ...).<li><a href="criar_plano_treino.php">Avaliação Fisica </a></li>';
			}
	else { */
//desativar plano que o utilizador tenha para o mesmo dia, A, B, etc, se este existir
$sql = "SELECT idplanoTreino
		FROM rinte.planotreino 
		WHERE planoDia = '$planoDia' AND planoTreino_idCliente = '$nr_socio' AND ativoPlanoTreino = 1";
$query = mysqli_query($db_connect, $sql);
$row = mysqli_fetch_assoc($query);
$idplanoTreino = $row['idplanoTreino'];

	$idplanoTreino = $row['idplanoTreino'];
	$sql = "UPDATE rinte.planotreino
			SET ativoPlanoTreino = 0
			WHERE idplanoTreino = '$idplanoTreino'";
$query = mysqli_query($db_connect, $sql);
$row = mysqli_fetch_assoc($query);



/* Enviar plano de treino por email
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
$mail->addAddress($email_user, $nome_user);	// Add a recipient

$mail->isHTML(true);		// Set email format to HTML

$mail->Subject = 'Plano de Treino do GymLife';
$mail->Body = 'No seguimento da avalia&ccedil&atildeo e de acordo com os objetivos definidos por si, ' . $nome_user . ', enviamos o plano de treino desenvolvido &agrave sua medida. Este pode tamb&eacutem ser consultado no nosso site. Qualquer d&uacutevida ou esclarecimento necess&aacuterio pode ser feita atrav&eacutes deste email.';
$mail->AltBody = 'No seguimento da avalia&ccedil&atildeo e de acordo com os objetivos definidos por si, ' . $nome_user . ', enviamos o plano de treino desenvolvido &agrave sua medida. Este pode tamb&eacutem ser consultado no nosso site. Qualquer d&uacutevida ou esclarecimento necess&aacuterio pode ser feita atrav&eacutes deste email.';
*/


/* set autocommit to off */
mysqli_autocommit($db_connect, FALSE);
//enviar dados para base de dados
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, "INSERT INTO rinte.planotreino (planoTreino_idCliente, planoTreino_idFuncionario, observacaoPlanoTreino, planoDia, ativoPlanoTreino) VALUES ('$nr_socio','$id_session','$notas_exercicio','$planoDia', '1');");
//$row = mysqli_fetch_assoc($query);
$exercicioUser_idplanoTreino = mysqli_insert_id($db_connect);
/*$query = */mysqli_query($db_connect, "INSERT INTO rinte.exerciciouser (exercicioUser_idplanoTreino, exercicoUser_idexercico, observacaoExercicioUser)
							VALUES ('$exercicioUser_idplanoTreino', '$ex_1', '$notas_ex_1'), ('$exercicioUser_idplanoTreino', '$ex_2', '$notas_ex_2'), ('$exercicioUser_idplanoTreino', '$ex_3', '$notas_ex_3'), ('$exercicioUser_idplanoTreino', '$ex_4', '$notas_ex_4'), ('$exercicioUser_idplanoTreino', '$ex_5', '$notas_ex_5'), ('$exercicioUser_idplanoTreino', '$ex_6', '$notas_ex_6');");
//echo $exercicioUser_idplanoTreino;
$exeTransc = mysqli_commit($db_connect);


if ($exeTransc) { 
//caso de sucesso no envio  if(mysqli_query($db_connect, $sql)){
//if ($exeTransc) { 
	//	if ($mail->send()){
	echo 'Conta criada com sucesso. Email enviado para utilizador com o nrº de socio ' . $nr_socio .'.';
	echo '<br><a href = "./perfil_admin.php">Perfil Admin</a>';
	//echo $exercicioUser_idplanoTreino . '<br>';
	//echo $ex_1 . '<br>';
	//echo $notas_exercicio . '<br>';
	}
		else {
			echo 'Conta criada com sucesso. Mas ocorreu um erro no envio do email para: ' . $nr_socio . '<br><a href = "./perfil_admin.php">Perfil Admin</a>';
		}	
//caso de insucesso no envio	
	//} 
	/*else {
	echo 'Erro na criação da conta ' . $tipo_conta . ' <br> <a href = "./perfil_admin.php">Voltar atrás</a>';
		}*/
mysqli_close($db_connect);
		
		} 
//}
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