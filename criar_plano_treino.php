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
  <title>GymLife - Criar Plano de Treino</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="custom_style.css" />
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Gym <?php echo $tipo_conta ?></a>
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


<div class="col-md-2 col-md-offset-1 sidebar">
	<br><br><br>
	<ul class="nav nav-sidebar">
	<li>	<input type="text" name="exercicioPlano" class="form-control"  id="exercicioPlano" placeholder="Ex.: Supino Alto" onkeyup="procurarExercicio();" /></li>
	<li><div id="resultados_exercicio"></div></li>
	</ul>
</div>

		
<div id="resultados_users"></div>

<div class="text-center"><h1>Criar Plano de Treino</h1></div>

<div class="row">
<div class="container">
<form class="form-horizontal" method="POST" action="./enviar_criar_plano_treino.php" enctype="multipart/form-data"> <!-- submeter executa a funcao checkpw() de JS para verificar pw-->
	<div class="form-signin">
		<!-- mostar disponibilidade do email -->
	<div id="num_socio"></div><br>
	<label for="nr_socio">Nº de Sócio</label>
    <input type="text" name="nr_socio" id="nr_socio" placeholder="Nº de Sócio" maxlength="10" class="form-control" title="Nº de Sócio" required /> 
	</div>
	

<div class="col-md-9 col-md-offset-3 container">
	<h3>Treino 
		<select id="planoDia" name="planoDia" >
		<option value="A">A</option>
		<option value="B">B</option>
		<option value="C">C</option>
		<option value="D">D</option>
		<option value="E">E</option>
		</select>
	</h3>

	<div class="input-group">
	<span class="input-group-addon">Exercício 1</span>
	<input	list="datalist_ex_1" type="text" name="ex_1" class="form-control"  id="ex_1" placeholder="Ex.: Supino Alto" onkeyup="procurarExercicio();" required />
	
	
	
	<input	type="text" name="notas_ex_1" class="form-control" id="notas_ex_1" placeholder="Notas" required />
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 2</span>
	<input	type="text" name="ex_2" class="form-control" id="ex_2" placeholder="Ex.: Cuban Press" required />
	
	<div id="datalist_ex_2"></div>
	
	<input	type="text" name="notas_ex_2" class="form-control" id="notas_ex_2" placeholder="Notas" required />
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 3</span>
	<input	type="text" name="ex_3" class="form-control" id="ex_3" placeholder="Exercício 3" required />
	
	<div id="datalist_ex_3"></div>
	
	<input	type="text" name="notas_ex_3" class="form-control" id="notas_ex_3" placeholder="Notas" required />
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 4</span>
	<input	type="text" name="ex_4" class="form-control" id="ex_4" placeholder="Exercício 4" required />
	
	<div id="datalist_ex_4"></div>
	
	<input	type="text" name="notas_ex_4" class="form-control" id="notas_ex_4" placeholder="Notas" required />
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 5</span>
	<input	type="text" name="ex_5" class="form-control" id="ex_5" placeholder="Exercício 5" required />
	
	<div id="datalist_ex_5"></div>
	
	<input	type="text" name="notas_ex_5" class="form-control" id="notas_ex_5" placeholder="Notas" required />
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 6</span>
	<input	type="text" name="ex_6" class="form-control" id="ex_6" placeholder="Exercício 6" required />
	
	<div id="datalist_ex_6"></div>
	
	<input	type="text" name="notas_ex_6" class="form-control" id="notas_ex_6" placeholder="Notas" required />
	</div>
	<div class="input-group">
	<span class="input-group-addon">Notas</span>
	<textarea type="text" name="notas_exercicio" class="form-control" id="notas_exercicio" placeholder="Notas relativas ao plano de treino" ></textarea>
	</div>
	<br>
	<input class="btn btn-primary" type="submit" name="submit" value="Inserir dados"/>
</form>
</div>
</div>

<script>
//funcao usada p/ procurar user na base dados 
function procurarExercicio() {
//criar objeto xmlhttprequest, p/ IE7+, Firefox, Chrome, Opera, Safari
	var xml = new XMLHttpRequest();
//variaveis relacionadas com o ficheiro php
	var file = "enviar_consultar_exercicio_bd.php";
	var exercicioPlano = document.getElementById("exercicioPlano").value;
	
	var pesquisaExercicio = "exercicioPlano=" + exercicioPlano;
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
</script>

<script>
//funcao usada p/ procurar user na base dados 
function find_users() {
//criar objeto xmlhttprequest, p/ IE7+, Firefox, Chrome, Opera, Safari
	var xml = new XMLHttpRequest();
//variaveis relacionadas com o ficheiro php
	var file = "enviar_procurar_socio.php";
	var nome = document.getElementById("email").value;
	var nome_inserido = "email=" + nome;
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
//envia dados para enviar_procurar_socio.php e espera resposta para usar em <div> resultados_users     
    xml.send(nome_inserido);
	document.getElementById("resultados_users").innerHTML="a pesquisar";
	return false;
}
</script>

<script>
function resetSearch() {
    //função que apaga a div que contem o resultado obtido da pesquisa do utilizador
	var elem = document.getElementById("delete_div");
	elem.parentNode.removeChild(elem);
}
</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>