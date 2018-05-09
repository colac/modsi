<?php
ini_set("display_errors", "off");
//liga a base de dados
require("./db_connect.php");
require('sessao.php');

if (isset($_POST['email_user'])){
$email_user = mysqli_real_escape_string($db_connect, $_POST['email_user']);
//verifica se o utilizador usou um username com menos de 6 caracteres, se for verdade pára a execução do script PHP com a mensagem. Usei mb_strlen pois certos caracteres sao contados como mais do que um byte com mb_strlen sao contados como 1.
if (mb_strlen($email_user, "UTF-8") < 9){
	echo 'Erro no envio dos dados ' . $email_user . ' tem menos de 6 caracteres.';
	}
else {
//ir buscar dados a bd 
$sql = "SELECT n_socio, nome
		FROM utilizadores
		WHERE email = '$email_user'";
$query = mysqli_query($db_connect, $sql);

//retorna o nr de linhas num query
if (mysqli_num_rows($query) > 0) {
//função vai buscar a linha do query como um vector associativo
$row = mysqli_fetch_assoc($query);
//imprime dados de ID e username 
		echo $row["nome"] . " possui o nº de sócio: " . $row["n_socio"];
    
	}	else	{
//como php pode conter codigo html criei seletores para User disponivel e não disponivel, em verde e vermelho respetivamente 	
		echo "<user_nao_disp>Email não encontrado.</user_nao_disp><br>";
	}
mysqli_close($db_connect);
	}
}
else {
	header("location:./includes_login_form/logout.php");
	exit();
}
?>