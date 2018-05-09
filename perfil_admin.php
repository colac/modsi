<?php
//ini_set("display_errors", "off");
require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
if($tipo_conta != 1 AND $tipo_conta != 2){
	header("Location: ./perfil.php");
}
$sql = "SELECT *
		FROM rinte.cliente, rinte.presencacliente, rinte.autcliente
		WHERE DATE(dataPresencaCliente) = CURDATE() AND clientes_idClientes = idCliente AND presenca_idCliente = idCliente ";
$query = mysqli_query($db_connect, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Gym - <?php echo $nome_session ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
	<!-- Folha de estilo CSS -->
	<link href="custom_style.css" rel="stylesheet">
    
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
<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#"><?php echo $login_session ?><span class="sr-only">(current)</span></a></li>
          </ul>	  
          <ul class="nav nav-sidebar">
			<li><a href = "perfil.php">Perfil Sócios</a></li>
            <li><a href="criar_user.php">Criar Sócio</a></li>
			<li><a href="criar_plano_treino.php">Criar Plano de Treino</a></li>
			<li><a href="criar_avaliacao_fisica.php">Avaliação Fisica</a></li>
			<li><a href="exercicio_bd.php">Inserir Exercício no Sistema</a></li>
			<li><a href="consultar_exercicio_bd.php">Consultar Exercícios</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Painel de Administração</h1>
		  
		<div id="resultados_users"></div>
          
		  <h2 class="sub-header">Entradas do dia: <?php echo date("d-m-Y");?></h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th>Hora da entrada</th>
				<th>Nome</th>
				<th>Nº de Sócio</th>
				<th>Email</th>
				<th>Contacto</th>
                </tr>
              </thead>
              <tbody>               
<?php 
while($row = mysqli_fetch_assoc($query)) {
$login_time = date("h:i", strtotime($row['dataLogin'])); 
		echo	'<tr>
				<td>'.$login_time.'</td>
				<td>'.$row['nomeCliente'].'</td>
				<td>'.$row['idCliente'].'</td>
				<td>'.$row['emailCliente'].'</td>
				<td>'.$row['telefoneCliente'].'</td>
				</tr>';
}
mysqli_close($db_connect);	
?>            
              </tbody>
            </table>
          </div>
        </div>
	</div>
</div>

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

    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>