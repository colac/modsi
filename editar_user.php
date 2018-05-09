<?php
//ini_set("display_errors", "off");
require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
if($tipo_conta != 2){
	header("Location: ./perfil_admin.php");
}

$n_socio=$_GET['n_socio'];

$sql = "SELECT idCliente, nomeCliente, cc, nif, nib, dataInscricao, ativoCliente, moradaCliente, telefoneCliente, emailCliente
		FROM rinte.cliente, rinte.autcliente
		WHERE idCliente = '$n_socio' AND clientes_idClientes = idCliente;";
$query = mysqli_query($db_connect, $sql);
$row = mysqli_fetch_assoc($query);
$n_socio = $row['idCliente'];
$nomeUser = $row['nomeCliente'];
$cc = $row['cc'];
$nif = $row['nif'];
$nib = $row['nib'];
$dataInscricao = $row['dataInscricao'];
$ativoCliente = $row['ativoCliente'];
$moradaCliente = $row['moradaCliente'];
$telefoneCliente = $row['telefoneCliente'];
$emailCliente = $row['emailCliente'];

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
        </div>
	</div>
</nav>

<div id="resultados_users"></div>

<div class="container">
<form method="POST" class="form-signin" action="./enviar_editar_user.php" enctype="multipart/form-data" onsubmit="return checkpw();"> <!-- submeter executa a funcao checkpw() de JS para verificar pw-->
	<h3>Editar perfil do sócio <?php echo $nomeUser; ?></h3><!-- html5 type=email, required, pattern-->
	<label	for="nr_socio">Nº Sócio</label>
	<input	type="number" name="nr_socio" class="form-control"
			id="nr_socio" placeholder="Nº Sócio" value="<?php echo $n_socio; ?>" readonly="readonly"  />
	<label	for="nome_socio">Nome do Sócio</label>
    <input	type="text" name="nome_socio" id="nome_socio" value="<?php echo $nomeUser; ?>" placeholder="Nome do Sócio" maxlength="30" class="form-control" /> 
    <label for="email">Endereço de Email</label>
    <input	type="email" name="email" id="email" value="<?php echo $emailCliente;?>" placeholder="Email" onkeyup="procurar_user();" maxlength="88"  class="form-control"  /> 
	<!-- mostar disponibilidade do email -->
	<div	id="user_disponib"></div>
    <label	for="pass1">Password</label>
    <input	type="password" name="pass1" class="form-control" 
			id="pass1" placeholder="Password" />
	<label	for="pass2">Confirmar Password</label>
    <input	type="password" name="pass2" class="form-control"
			id="pass2" placeholder="Confirmar password"/>
	<label	for="contacto">Contacto</label>
	<input 	type="text" name="contacto" class="form-control"
			id="contacto" value="<?php echo $telefoneCliente;?>" pattern="(?=.*[0-9]).{9,}" 
			placeholder="Contacto" />
	<label	for="morada">Morada</label>		
	<textarea rows="2" cols="30" name="morada" id="morada" class="form-control" placeholder="Morada" ><?php echo $moradaCliente;?></textarea>
	<label	for="cc">Cartão de Cidadão</label>
	<input 	type="text" name="cc" class="form-control"
			id="cc" value="<?php echo $cc;?>" placeholder="Cartão de Cidadão" required />
	<label	for="nif">NIF</label>
	<input 	type="text" name="nif" class="form-control"
			id="nif" value="<?php echo $nif;?>" placeholder="Nº Indentificação Fiscal" required />
	<label	for="nib">NIB</label>
	<input 	type="text" name="nib" class="form-control"
			id="nib" value="<?php echo $nib;?>" placeholder="Número de Identificação Bancária" required />
	<label	for="ativoCliente">Estado de Ativação da Conta (1-Ativada | 2-Desativada)</label>
	<input 	type="text" name="ativoCliente" class="form-control"
			id="ativoCliente" value="<?php echo $ativoCliente;?>" placeholder="Estado de Ativação da Conta" required /> 
	<br>
	<input class="btn btn-primary" type="submit" name="submit" value="Editar conta"/>
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
    if (pass1j != pass2j) {
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
</body>
</html>