<?php
ini_set("display_errors", "on");
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

require("./db_connect.php");

$login_session = mysqli_real_escape_string($db_connect, $_POST['user_email']);
$pass = mysqli_real_escape_string($db_connect, $_POST['user_password']);
$options = ['cost' => 10, ];
$passhash = password_hash($pass, PASSWORD_BCRYPT, $options);


$sql = "SELECT idautFuncionario
		FROM rinte.autfuncionario
		WHERE emailFuncionario='$login_session'";
		
$query = mysqli_query($db_connect, $sql);
$row = mysqli_fetch_assoc($query);
$id = $row['idautFuncionario'];

if ($query) {
	
	$sql = "UPDATE rinte.autfuncionario
		SET passwordFuncionario='$passhash'
		WHERE idautFuncionario='$id'";
		$query = mysqli_query($db_connect, $sql);
		
		echo 'Dados editados com sucesso, ' . $login_session . $passhash ;
	}
	else {
		echo 'Erro na alteração dos dados, ' . $login_session . '<br><a href="criar_admin.html">Voltar atrás</a>';
		}

mysqli_close($db_connect);
?>