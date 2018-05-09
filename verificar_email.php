<?php
ini_set("display_errors", "on");
require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');

if (isset($_POST['email'])){
$user_email = mysqli_real_escape_string($db_connect, $_POST['email']);
//verifica se o email tem mais de 5 caracteres, se for verdade comeca a verificar disponibilidade. Usei mb_strlen pois certos caracteres sao contados como mais do que um byte com mb_strlen sao contados como 1.
if (mb_strlen($user_email, "UTF-8") >= 5){
	
//ir buscar dados a bd 
$sql = "SELECT 	emailCliente 
		FROM rinte.autcliente 
		WHERE emailCliente = '$user_email'";
$query = mysqli_query($db_connect, $sql);

//retorna o nr de linhas num query
if (mysqli_num_rows($query) > 0) {
//função vai buscar a linha do query como um vector associativo
$row = mysqli_fetch_assoc($query);
//imprime dados de ID e username <user_nao_disp> " não disponivel.</user_nao_disp><br>"
		echo " Email: " . $row["emailCliente"] . " não disponível" ;
    
	}	else	{
//como php pode conter codigo html criei seletores para User disponivel e não disponivel, em verde e vermelho respetivamente 	<user_disp> </user_disp><br>
		echo "Email disponivel.";
	}
mysqli_close($db_connect);
	}
}
else {
	header("location:./logout.php");
	exit();
}
?>