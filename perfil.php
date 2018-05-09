<?php
//ini_set("display_errors", "off");
require('./db_connect.php');
//verifica se a sessão está iniciada
require('./sessao.php');

$sql = "SELECT *
		FROM rinte.cliente, rinte.autcliente
		WHERE emailCliente = '$login_session'";
$query = mysqli_query($db_connect, $sql);
$row = mysqli_fetch_assoc($query);
mysqli_close($db_connect);

$morada = $row['moradaCliente'];
$data_sql = $row['dataInscricao'];
$contacto = $row['telefoneCliente'];
$nif = $row['nif'];
$cc = $row['cc'];
$nib = $row['nib'];

$data_registo = date("d/m/Y", strtotime($data_sql));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Gym</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
	<!-- Folha de estilo CSS criada -->
	<link href="custom_style.css" rel="stylesheet">
</head>
<body>
<?php 
if($tipo_conta == 1 OR $tipo_conta == 2){
echo '<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          </button>
          <a class="navbar-brand" href="#">GymLife</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">

			<li><a href="perfil_admin.php">Painel de Administração</a></li>
            <li><a href = "logout.php">Terminar sessão</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
	</div>
</nav>';
}

?>
<div class="container">
<div class="col-sm-2 sidebar"> <h2>Perfil</h2>     
	<ul class="nav nav-sidebar">
		<li class="active"><a href="#"><?php echo $login_session ?><span class="sr-only"></span></a></li>
		<li><a href = "mostrar_avaliacoes.php">Ver Avaliações Físicas</a></li>
		<li><a href="plano_treino.php">Ver Planos de Treino</a></li>
		<li><a href = "logout.php">Terminar sessão</a></li>
	</ul>
</div><!-- Dados do utilizador -->
	<div class="panel-heading resume-heading">
		<div class="row">
			<div class="col-sm-12">
				<div class="col-sm-2 col-sm-offset-1"> 
					<img class="" src="imagem_perfil.php" style="width:200px;height:250px;">
                    </div>
					<div class="col-sm-8 col-sm-offset-1">
						<ul class="list-group">
						<li class="list-group-item"><b>Nome</b> <?php echo $nome_session ?></li>
						<li class="list-group-item"><b>Nº Sócio</b> <?php echo $n_socio ?></li>
						<li class="list-group-item"><b>Email</b> <?php echo $login_session ?></li>
						<li class="list-group-item"><b>Morada</b> <?php echo $morada ?></li>
						<li class="list-group-item"><b>Contacto</b> <?php echo $contacto ?></li>
						<li class="list-group-item"><b>CC</b> <?php echo $cc ?></li>
						<li class="list-group-item"><b>NIF</b> <?php echo $nif ?></li>
						<li class="list-group-item"><b>NIB</b> <?php echo $nib ?></li>
						<li class="list-group-item"><b>Data de inscrição</b> <?php echo $data_registo ?></li>
						</ul>
					</div>
			</div>
		</div>
	</div>
</div>
    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>
</html>