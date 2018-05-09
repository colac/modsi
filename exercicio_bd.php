<?php
//ini_set("display_errors", "off");

require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
if($tipo_conta != 2){
	header("Location: ./index.html");
}
//mysqli_close($db_connect);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gym</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
            <input type="text" class="form-control" id="email" placeholder="Procurar utilizadores..." >
			<button type="button" class="btn-danger btn-primary btn-xs" onclick="resetSearch()">X</button>
		</form>

        </div>
	</div>
</nav>

<div id="resultados_users"></div>

<div class="container">
	<form method="POST" class="form-signin" action="./enviar_exercicio_bd.php" enctype="multipart/form-data" onsubmit="return checkExercicioLenght();"> <!--  -->
		<h3>Inserir Exercicio no Sistema</h3><!-- html5 type=email, required, pattern-->
		<label	for="nomeExercicio">Exercicio</label>
		<input	type="text" name="nomeExercicio" class="form-control"
			id="nomeExercicio" placeholder="Exercicio" onkeyup="procurarExercicio();" />
		<label	for="tipo">Categoria</label>
		<input	type="text" name="tipo" class="form-control"
			id="tipo" placeholder="Categoria" onkeyup="procurarExercicio();" /> 
		<br>
		<input class="btn btn-primary" type="submit" name="submit" value="Inserir Exercício"/>
	</form>
	<div id="resultados_exercicio"></div>
</div>

<script>
//funcao usada p/ procurar user na base dados 
function procurar_user() {
if (document.getElementById("email").value.length > 4){
//criar objeto xmlhttprequest, p/ IE7+, Firefox, Chrome, Opera, Safari
	var xml = new XMLHttpRequest();
//variaveis relacionadas com o ficheiro php
	var file = "./verificar_email.php";
	var usercheck = document.getElementById("email").value;
	var getuser = "email="+usercheck;
	xml.open("POST",file,true);
//definir tipo de conteudo do header, para enviar as variaveis no request
	xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//Access the onreadystatechange event for the XMLHttpRequest object
//readyState==4, pedido terminado e a resposta esta pronta
//status=200, pagina "Ok"	
if (usercheck != '')	{
	xml.onreadystatechange = function() {
       if (xml.readyState == 4 && xml.status == 200) {
//executa verificar_user cada vez que uma tecla é solta
          document.getElementById("user_disponib").innerHTML = xml.responseText;
            }
        }
//envia dados para verificar_user.php e espera resposta para usar em <div> user_disponib     
    xml.send(getuser);
	document.getElementById("user_disponib").innerHTML="a pesquisar";
	}
//serve para nao ficar com o aviso de user disponivel ou não, este else{} limpa o campo id="user_disponib"
	else {
	document.getElementById("user_disponib").innerHTML="";
		}
	}
//limpa o aviso no caso do utilizador apagar e voltar a ter menos de 3 caracteres
	else {
	document.getElementById("user_disponib").innerHTML="";
	}
}
</script>

<script>
//funcao usada p/ procurar user na base dados 
function procurarExercicio() {
	if (document.getElementById("tipo").value.length > 3 || document.getElementById("nomeExercicio").value.length > 3){
//criar objeto xmlhttprequest, p/ IE7+, Firefox, Chrome, Opera, Safari
	var xml = new XMLHttpRequest();
//variaveis relacionadas com o ficheiro php
	var file = "enviar_consultar_exercicio_bd.php";
	var tipo = document.getElementById("tipo").value;
	var nomeExercicio = document.getElementById("nomeExercicio").value;
	var pesquisaExercicio = "tipo=" + tipo + "&nomeExercicio=" + nomeExercicio;
	xml.open("POST",file,true);
//definir tipo de conteudo do header, para enviar as variaveis no request
	xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//Access the onreadystatechange event for the XMLHttpRequest object
//readyState==4, pedido terminado e a resposta esta pronta
//status=200, pagina "Ok"		
	xml.onreadystatechange = function() {
       if (xml.readyState == 4 && xml.status == 200) {
//executa verificar_user cada vez que uma tecla é solta, mas neste caso com o return isto não acontece
          document.getElementById("resultados_exercicio").innerHTML = xml.responseText;
            }
        }
//envia dados para enviar_procurar_socio.php e espera resposta para usar em <div> resultados_users     
    xml.send(pesquisaExercicio);
	document.getElementById("resultados_exercicio").innerHTML="a pesquisar";
	return false;
	}
}
</script>

<script>
function resetSearch() {
    //função que apaga a div que contem o resultado obtido da pesquisa do utilizador
	var elem = document.getElementById("delete_div");
	elem.parentNode.removeChild(elem);
}
</script>

<script>
function checkExercicioLenght() {
//ir buscar pelo id as passwords para confirmar que são iguais
    var tipo = document.getElementById("tipo").value.length;
    var nomeExercicio = document.getElementById("nomeExercicio").value.length;
//verificar igualdade
    if ((tipo < 4) || (nomeExercicio < 4)) {
		//document.getElementById("tipo").value="";
		//document.getElementById("nomeExercicio").value="";
		alert("Confirme o Exercício e Categoria inseridos.");
		return false;	
    }	
	else {
	return true;
	}
}
</script>

</body>
</html>