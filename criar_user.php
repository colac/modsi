<?php
//ini_set("display_errors", "off");
require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
/*if($tipo_conta != 1){
	header("Location: ./perfil_admin.php");
}*/
$sql = "SELECT idCliente 
		FROM cliente 
		WHERE 1 order by dataInscricao desc limit 1";
$query = mysqli_query($db_connect, $sql);
$row = mysqli_fetch_assoc($query);
$latest_nr_socio = $row['idCliente'];
mysqli_close($db_connect);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gym - Criar User</title>
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
          </form>
		  
        </div>
		
	</div>
</nav>

<div id="resultados_users"></div>

<div class="container">
<form class="form-signin" method="POST" action="./enviar_criar_user.php" enctype="multipart/form-data" onsubmit="return checkpw();"> <!-- submeter executa a funcao checkpw() de JS para verificar pw -->
	<h1>Criar Conta</h1><!-- html5 type=email, required, pattern-->
	<label	for="nr_socio">Nº Sócio</label>
	<input	type="number" name="nr_socio" class="form-control"
			id="nr_socio" placeholder="Nº Sócio" value="<?php echo $latest_nr_socio + 1; ?>" readonly="readonly" required />
	<label	for="nome_socio">Nome do Sócio</label>
    <input	type="text" name="nome_socio" id="nome_socio" placeholder="Nome do Sócio" maxlength="30" class="form-control" required /> 
    <label for="email">Endereço de Email</label>
    <input	type="email" name="email" id="email" placeholder="Email" onkeyup="procurar_user();" maxlength="88"  class="form-control" required /> 
	<!-- mostar disponibilidade do email -->
	<div	id="user_disponib"></div>
    <label	for="pass1">Password</label>
    <input	type="password" name="pass1" class="form-control" 
			id="pass1" placeholder="Password" required />
	<label	for="pass2">Confirmar Password</label>
    <input	type="password" name="pass2" class="form-control"
			id="pass2" placeholder="Confirmar password" required />
	<label	for="contacto">Contacto</label>
	<input 	type="text" name="contacto" class="form-control"
			id="contacto" pattern="(?=.*[0-9]).{9,}" 
			placeholder="Contacto" required />
	<label	for="morada">Morada</label>		
	<textarea rows="2" cols="30" name="morada" id="morada" class="form-control" placeholder="Morada" required ></textarea>
	<label	for="nif">Cartão de Cidadão</label>
	<input 	type="text" name="cc" class="form-control"
			id="cc" placeholder="Cartão de Cidadão" required />
	<label	for="nif">NIF</label>
	<input 	type="text" name="nif" class="form-control"
			id="nif" placeholder="Nº Indentificação Fiscal" required />
	<label	for="nif">NIB</label>
	<input 	type="text" name="nib" class="form-control"
			id="nib" placeholder="Número de Identificação Bancária" required />
<!--	<label	for="fotografia">Fotografia</label>
	<input	name="fotografia" id="fotografia" type="file"/>
	<div> Tipo de ficheiro aceite: JPEG </div><br> -->
	<input class="btn btn-primary" type="submit" name="submit" value="Criar conta"/>
</form>
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
function checkpw() {
//ir buscar pelo id as passwords para confirmar que são iguais
    var pass1j = document.getElementById("pass1").value;
    var pass2j = document.getElementById("pass2").value;
//verificar igualdade
    if (pass1j != pass2j || pass1j ==='' || pass2j ==='') {
		document.getElementById("pass1").value="";
		document.getElementById("pass2").value="";
		alert("Confirme a password.");
		return false;	
    }	
	else {
	return true;
	}
}
</script>

<script>
function checksize() {

var ficheiro_input = document.getElementById("file");
if ('files' in ficheiro_input){
	if (ficheiro_input.files.length==0){
		alert("Selecione uma fotografia.");
		return false;
	}
	else {
		var existe = ficheiro_input.files[0];
		var tamanho = existe.size;
			if (tamanho > 3000000) {
			alert("Fotografia tem de ser menor que 3MB."/*+existe +existe.name*/);
			return false;
			}
			else {
			return true;
				}
		}
	}
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

<script>
function resetSearch() {
    //função que apaga a div que contem o resultado obtido da pesquisa do utilizador
	var elem = document.getElementById("delete_div");
	elem.parentNode.removeChild(elem);
}
</script>

</body>
</html>