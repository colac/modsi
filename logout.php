<?php
ini_set("display_errors", "on");
if($tipo_conta == NULL){
	header("Location: ./index.html");
}
//ficheiros necessarios para apagar entrada na tabela de utilizadores logged in
require("./db_connect.php");
require("./sessao.php");
/*$_SESSION = array() limpa apenas as variáveis locais de $_SESSION.
session_destroy "destroi" os dados da sessão guardados no ficheiro do sistema.*/
//é preciso inicializar a sessão para a funcao destroy "saber" que sessao "destruir"
session_start();
$_SESSION = array();
session_destroy();
header("Location: ./index.html");// ../ directorio acima, parent directory
?>