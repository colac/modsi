<?php
//ini_set("display_errors", "off");
require('./db_connect.php');
//verifica se a sessão está iniciada
require('sessao.php');

$sql = "SELECT foto_perfil 
		FROM utilizadores 
		WHERE email = '$login_session'";
$query = mysqli_query($db_connect, $sql);
$row = mysqli_fetch_assoc($query);

$foto_perfil = $row['foto_perfil'];

//Limpar headers que estejam armazenados no buffer de output

//definir headers que especificam o tipo/nome/tamanho e outras definicoes do ficheiro, https://evertpot.com/http-11-updated/
header('Content-Type: image/jpg');

echo $foto_perfil;
?>