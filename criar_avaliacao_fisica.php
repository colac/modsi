<?php
//ini_set("display_errors", "off");
require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
if($tipo_conta != 1 AND $tipo_conta != 2){
	header("Location: ./perfil.php");
}
mysqli_close($db_connect);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gym - Criar User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="custom_style.css" />
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          </button>
          <a class="navbar-brand" href="#">Gym</a>
        </div>
		
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="perfil_admin.php">Painel de Administração</a></li>
            <li><a href = "logout.php">Terminar sessão</a></li>
          </ul>
		  
          <form method="POST" action="" class="navbar-form navbar-right" onsubmit="return find_users();">
            <input type="text" class="form-control" id="nome_socio" placeholder="Procurar utilizadores..." >
          </form>
        </div>
		
	</div>
</nav>

<div id="resultados_users"></div>

<form class="form-signin" method="POST" action="./enviar_avaliacao_fisica.php" enctype="multipart/form-data" onsubmit="return checkpw();"> <!-- submeter executa a funcao checkpw() de JS para verificar pw-->
<h1>Avaliação Física</h1>
	<div class="form-group">
	<label	for="n_socio">Nº Sócio</label>
	<input	type="text" name="n_socio" class="form-control" id="n_socio" placeholder="Nº Sócio" />
	</div>
	<div class="form-group">
	<label	for="altura">Altura</label>
	<input	type="text" name="altura" class="form-control" id="altura" placeholder="Ex: 1.55m" />
	</div>
	<div class="form-group">
	<label	for="peso">Peso</label>
	<input	type="text" name="peso" class="form-control" id="peso" placeholder="Ex: 70kg" />
	</div>
	<div class="form-group">
	<label	for="massaGorda">Percentagem de Massa Gorda</label>
	<input	type="text" name="massaGorda" class="form-control" id="massaGorda" placeholder="Ex: 18%" />
	</div>
	
	<input class="btn btn-primary" type="submit" name="submit" value="Inserir dados"/>
</form>

<script>
//funcao usada p/ procurar user na base dados 
function find_users() {
//criar objeto xmlhttprequest, p/ IE7+, Firefox, Chrome, Opera, Safari
	var xml = new XMLHttpRequest();
//variaveis relacionadas com o ficheiro php
	var file = "enviar_procurar_socio.php";
	var nome = document.getElementById("nome_socio").value;
	var nome_inserido = "nome_socio=" + nome;
	xml.open("POST",file,true);
//definir tipo de conteudo do header, para enviar as variaveis no request
	xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//Access the onreadystatechange event for the XMLHttpRequest object
//readyState==4, pedido terminado e a resposta esta pronta
//status=200, pagina "Ok"		
	xml.onreadystatechange = function() {
       if (xml.readyState == 4 && xml.status == 200) {
//executa verificar_user cada vez que uma tecla é solta, mas neste caso com o return isto não acontece
          document.getElementById("resultados_users").innerHTML = xml.responseText;
            }
        }
//envia dados para verificar_user.php e espera resposta para usar em <div> resultados_users     
    xml.send(nome_inserido);
	document.getElementById("resultados_users").innerHTML="a pesquisar";
	return false;
}
</script>

</body>
</html>