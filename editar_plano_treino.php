<?php
//ini_set("display_errors", "off");
require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');

$n_socio=$_GET['n_socio'];

$sql = "SELECT     
	idexercico,
    nomeExercicio,
    idplanoTreino,
    planoTreino_idCliente,
    observacaoPlanoTreino,
    planoDia,
    ativoPlanoTreino,
    idexercicioUser,
    exercicioUser_idplanoTreino,
    exercicoUser_idexercico,
    observacaoExercicioUser
FROM
    rinte.exercico,
    rinte.planotreino,
    rinte.exerciciouser
WHERE exercicoUser_idexercico = idexercico AND exercicioUser_idplanoTreino = idplanoTreino AND ativoPlanoTreino = 1 AND planoTreino_idCliente = '$n_socio'
ORDER BY planoDia ASC, idexercicioUser ASC";
$query = mysqli_query($db_connect, $sql);
$row_cnt = mysqli_num_rows($query);
//for ($row_cnt; $row_cnt > 0; $row_cnt--){
	while ($row = mysqli_fetch_assoc($query)){
		$exerciciosNome[] = $row['nomeExercicio'];
		$observacaoPlanoTreino[] = $row['observacaoPlanoTreino'];
		$observacaoExercicioUser[] = $row['observacaoExercicioUser'];
		$idplanoTreino[] = $row['idplanoTreino'];
		$idexercicioUser[] = $row['idexercicioUser']; //usar para editar exercicios
		$ativoPlanoTreino[] = $row['ativoPlanoTreino'];
		$idexercicio[] = $row['idexercico'];
	}
//}

?>
<!DOCTYPE html>
<html>
<head>
	<title>GymLife - Plano de Treino</title>
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
          <a class="navbar-brand" href="#">Gym <?php echo $row_cnt; ?></a>
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

<div class="col-md-2 sidebar">
	<br><br><br>
	<ul class="nav nav-sidebar">
	<input type="text" name="exercicioPlano" class="form-control"  id="exercicioPlano" placeholder="Ex.: Supino Alto" onkeyup="procurarExercicio();" />
	<div id="resultados_exercicio"></div>
	</ul>
</div>

<div id="resultados_users"></div>

<div class="col-md-9 col-md-offset-2 container">
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">Home</a>
  </li>
  <li role="presentation"><a href="#treino_a" data-toggle="tab" role="tab">Plano de Treino A</a></li>
  <li role="presentation"><a href="#treino_b" data-toggle="tab" role="tab">Plano de Treino B</a></li>
  <li role="presentation"><a href="#treino_c" data-toggle="tab" role="tab">Plano de Treino C</a></li>
  <li role="presentation"><a href="#treino_d" data-toggle="tab" role="tab">Plano de Treino D</a></li>
  <li role="presentation"><a href="#treino_e" data-toggle="tab" role="tab">Plano de Treino E</a></li>
</ul>

<div class="container-fluid">
  <div class="tab-content">
	<div id="home" role="tabpanel" class="tab-pane fade in active">
      <div class="alert alert-info"><?php echo $nome_session; ?>, nos separadores desta página pode editar os planos de treino desenvolvidos para o sócio nº <?php echo $n_socio; ?> .</div>
    </div>

<div id="treino_a" role="tabpanel" class="tab-pane fade">
<form class="form-horizontal" method="POST" action="./enviar_editar_plano_treino.php"  enctype="multipart/form-data">
	<br>
	<div id="ativoPlanoTreinoA">Estado de ativação</div>
	<input type="number" name="ativoPlanoTreinoA" value="<?php echo $ativoPlanoTreino[0];?>" min="0" max="1"/><br>
	<input name="n_socio" value="<?php echo $n_socio;?>" hidden/>
	<input name="idPlanoTreinoA" value="<?php echo $idplanoTreino[0];?>" hidden/><br>
	<ul class="list-group">
	<div class="input-group">
	<span class="input-group-addon">Exercício 1</span>
	<li class="form-control"><?php echo $exerciciosNome[0]; ?></li>
	<input type="number" class="form-control" name="ex_1_a" value="<?php echo $idexercicio[0];?>" />
	<input 	type="text" name="ex_1_a_notas" class="form-control" id="ex_1_a_notas" value="<?php echo $observacaoExercicioUser[0];?>" required />
	<input id="idexercico1A" name="idexercico1A" value="<?php echo $idexercicioUser[0];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 2</span>
	<li class="form-control"><?php echo $exerciciosNome[1]; ?></li>
	<input type="number" class="form-control" name="ex_2_a" value="<?php echo $idexercicio[1];?>" >
	<input 	type="text" name="ex_2_a_notas" class="form-control" id="ex_2_a_notas" value="<?php echo $observacaoExercicioUser[1];?>" required />
	<input id="idexercico2A" name="idexercico2A" value="<?php echo $idexercicioUser[1];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 3</span>
	<li class="form-control"><?php echo $exerciciosNome[2]; ?></li>
	<input type="number" class="form-control" name="ex_3_a" value="<?php echo $idexercicio[2];?>" >
	<input 	type="text" name="ex_3_a_notas" class="form-control" id="ex_3_a_notas" value="<?php echo $observacaoExercicioUser[2];?>" required />
	<input id="idexercico3A" name="idexercico3A" value="<?php echo $idexercicioUser[2];?>"hidden/>	
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 4</span>
	<li class="form-control"><?php echo $exerciciosNome[3]; ?></li>
	<input type="number" class="form-control" name="ex_4_a" value="<?php echo $idexercicio[3];?>" >
	<input 	type="text" name="ex_4_a_notas" class="form-control" id="ex_4_a_notas" value="<?php echo $observacaoExercicioUser[3];?>" required />
	<input id="idexercico4A" name="idexercico4A" value="<?php echo $idexercicioUser[3];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 5</span>
	<li class="form-control"><?php echo $exerciciosNome[4]; ?></li>
	<input type="number" class="form-control" name="ex_5_a" value="<?php echo $idexercicio[4];?>" >
	<input 	type="text" name="ex_5_a_notas" class="form-control" id="ex_5_a_notas" value="<?php echo $observacaoExercicioUser[4];?>" required />
	<input id="idexercico5A" name="idexercico5A" value="<?php echo $idexercicioUser[4];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 6</span>
	<li class="list-group-item"><?php echo $exerciciosNome[5]; ?></li>
	<input type="number" class="form-control" name="ex_6_a" value="<?php echo $idexercicio[5];?>" >
	<input 	type="text" name="ex_6_a_notas" class="form-control" id="ex_6_a_notas" value="<?php echo $observacaoExercicioUser[5];?>" required />
	<input id="idexercico6A" name="idexercico6A" value="<?php echo $idexercicioUser[5];?>" hidden/>
	</div>
	</ul>
	<textarea rows="3" cols="30" name="observacaoPlanoTreinoA" id="observacaoPlanoTreinoA" class="col-md-12 alert alert-info" required ><?php echo $observacaoPlanoTreino[0];?></textarea><br><br><br><br><br>
	<input class="btn btn-primary btn-xs" type="submit" name="formA" value="Atualizar Plano A"/>
</form>
</div>

<div id="treino_b" role="tabpanel" class="tab-pane fade">
<form class="form-horizontal" method="POST" action="./enviar_editar_plano_treino.php"  enctype="multipart/form-data">
	<br>
	<div id="ativoPlanoTreinoB">Estado de ativação</div>
	<input type="number" name="ativoPlanoTreinoB" value="<?php echo $ativoPlanoTreino[6];?>" min="0" max="1"/><br>
	<input name="n_socio" value="<?php echo $n_socio;?>" hidden/>
	<input name="idPlanoTreinoB" value="<?php echo $idplanoTreino[6];?>" hidden/><br>
	<ul class="list-group">
	<div class="input-group">
	<span class="input-group-addon">Exercício 1</span>
	<li class="form-control"><?php echo $exerciciosNome[6]; ?></li>
	<input type="number" class="form-control" name="ex_1_b" value="<?php echo $idexercicio[6];?>" />
	<input 	type="text" name="ex_1_b_notas" class="form-control" id="ex_1_a_notas" value="<?php echo $observacaoExercicioUser[6];?>" required />
	<input id="idexercico1B" name="idexercico1B" value="<?php echo $idexercicioUser[6];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 2</span>
	<li class="form-control"><?php echo $exerciciosNome[7]; ?></li>
	<input type="number" class="form-control" name="ex_2_b" value="<?php echo $idexercicio[7];?>" >
	<input 	type="text" name="ex_2_b_notas" class="form-control" id="ex_2_b_notas" value="<?php echo $observacaoExercicioUser[7];?>" required />
	<input id="idexercico2B" name="idexercico2B" value="<?php echo $idexercicioUser[7];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 3</span>
	<li class="form-control"><?php echo $exerciciosNome[8]; ?></li>
	<input type="number" class="form-control" name="ex_3_b" value="<?php echo $idexercicio[8];?>" >
	<input 	type="text" name="ex_3_b_notas" class="form-control" id="ex_3_b_notas" value="<?php echo $observacaoExercicioUser[8];?>" required />
	<input id="idexercico3B" name="idexercico3B" value="<?php echo $idexercicioUser[8];?>"hidden/>	
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 4</span>
	<li class="form-control"><?php echo $exerciciosNome[9]; ?></li>
	<input type="number" class="form-control" name="ex_4_b" value="<?php echo $idexercicio[9];?>" >
	<input 	type="text" name="ex_4_b_notas" class="form-control" id="ex_4_b_notas" value="<?php echo $observacaoExercicioUser[9];?>" required />
	<input id="idexercico4B" name="idexercico4B" value="<?php echo $idexercicioUser[9];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 5</span>
	<li class="form-control"><?php echo $exerciciosNome[10]; ?></li>
	<input type="number" class="form-control" name="ex_5_b" value="<?php echo $idexercicio[10];?>" >
	<input 	type="text" name="ex_5_b_notas" class="form-control" id="ex_5_b_notas" value="<?php echo $observacaoExercicioUser[10];?>" required />
	<input id="idexercico5B" name="idexercico5B" value="<?php echo $idexercicioUser[10];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 6</span>
	<li class="list-group-item"><?php echo $exerciciosNome[11]; ?></li>
	<input type="number" class="form-control" name="ex_6_b" value="<?php echo $idexercicio[11];?>" >
	<input 	type="text" name="ex_6_b_notas" class="form-control" id="ex_6_b_notas" value="<?php echo $observacaoExercicioUser[11];?>" required />
	<input id="idexercico6B" name="idexercico6B" value="<?php echo $idexercicioUser[11];?>" hidden/>
	</div>
	</ul>
	<textarea rows="3" cols="30" name="observacaoPlanoTreinoB" id="observacaoPlanoTreinoB" class="col-md-12 alert alert-info" required ><?php echo $observacaoPlanoTreino[11];?></textarea><br><br><br><br><br>
	<input class="btn btn-primary btn-xs" type="submit" name="formB" value="Atualizar Plano B"/>
</form>
</div>

<div id="treino_c" role="tabpanel" class="tab-pane fade">
<form class="form-horizontal" method="POST" action="./enviar_editar_plano_treino.php"  enctype="multipart/form-data">
	<br>
	<div id="ativoPlanoTreinoC">Estado de ativação</div>
	<input type="number" name="ativoPlanoTreinoC" value="<?php echo $ativoPlanoTreino[12];?>" min="0" max="1"/><br>
	<input name="n_socio" value="<?php echo $n_socio;?>" hidden/>
	<input name="idPlanoTreinoC" value="<?php echo $idplanoTreino[12];?>" hidden/><br>
	<ul class="list-group">
	<div class="input-group">
	<span class="input-group-addon">Exercício 1</span>
	<li class="form-control"><?php echo $exerciciosNome[12]; ?></li>
	<input type="number" class="form-control" name="ex_1_c" value="<?php echo $idexercicio[12];?>" />
	<input 	type="text" name="ex_1_c_notas" class="form-control" id="ex_1_c_notas" value="<?php echo $observacaoExercicioUser[12];?>" required />
	<input id="idexercico1C" name="idexercico1C" value="<?php echo $idexercicioUser[12];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 2</span>
	<li class="form-control"><?php echo $exerciciosNome[13]; ?></li>
	<input type="number" class="form-control" name="ex_2_c" value="<?php echo $idexercicio[13];?>" >
	<input 	type="text" name="ex_2_c_notas" class="form-control" id="ex_2_c_notas" value="<?php echo $observacaoExercicioUser[13];?>" required />
	<input id="idexercico2C" name="idexercico2C" value="<?php echo $idexercicioUser[13];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 3</span>
	<li class="form-control"><?php echo $exerciciosNome[14]; ?></li>
	<input type="number" class="form-control" name="ex_3_c" value="<?php echo $idexercicio[14];?>" >
	<input 	type="text" name="ex_3_c_notas" class="form-control" id="ex_3_c_notas" value="<?php echo $observacaoExercicioUser[14];?>" required />
	<input id="idexercico3C" name="idexercico3C" value="<?php echo $idexercicioUser[14];?>"hidden/>	
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 4</span>
	<li class="form-control"><?php echo $exerciciosNome[15]; ?></li>
	<input type="number" class="form-control" name="ex_4_c" value="<?php echo $idexercicio[15];?>" >
	<input 	type="text" name="ex_4_c_notas" class="form-control" id="ex_4_c_notas" value="<?php echo $observacaoExercicioUser[15];?>" required />
	<input id="idexercico4C" name="idexercico4C" value="<?php echo $idexercicioUser[15];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 5</span>
	<li class="form-control"><?php echo $exerciciosNome[16]; ?></li>
	<input type="number" class="form-control" name="ex_5_c" value="<?php echo $idexercicio[16];?>" >
	<input 	type="text" name="ex_5_c_notas" class="form-control" id="ex_5_c_notas" value="<?php echo $observacaoExercicioUser[16];?>" required />
	<input id="idexercico5C" name="idexercico5C" value="<?php echo $idexercicioUser[16];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 6</span>
	<li class="list-group-item"><?php echo $exerciciosNome[17]; ?></li>
	<input type="number" class="form-control" name="ex_6_c" value="<?php echo $idexercicio[17];?>" >
	<input 	type="text" name="ex_6_c_notas" class="form-control" id="ex_6_c_notas" value="<?php echo $observacaoExercicioUser[17];?>" required />
	<input id="idexercico6C" name="idexercico6C" value="<?php echo $idexercicioUser[17];?>" hidden/>
	</div>
	</ul>
	<textarea rows="3" cols="30" name="observacaoPlanoTreinoC" id="observacaoPlanoTreinoC" class="col-md-12 alert alert-info" required ><?php echo $observacaoPlanoTreino[12];?></textarea><br><br><br><br><br>
	<input class="btn btn-primary btn-xs" type="submit" name="formC" value="Atualizar Plano C"/>
</form>
</div>

<div id="treino_d" role="tabpanel" class="tab-pane fade">
<form class="form-horizontal" method="POST" action="./enviar_editar_plano_treino.php"  enctype="multipart/form-data">
	<br>
	<div id="ativoPlanoTreinoD">Estado de ativação</div>
	<input type="number" name="ativoPlanoTreinoD" value="<?php echo $ativoPlanoTreino[18];?>" min="0" max="1"/><br>
	<input name="n_socio" value="<?php echo $n_socio;?>" hidden/>
	<input name="idPlanoTreinoD" value="<?php echo $idplanoTreino[18];?>" hidden/><br>
	<ul class="list-group">
	<div class="input-group">
	<span class="input-group-addon">Exercício 1</span>
	<li class="form-control"><?php echo $exerciciosNome[18]; ?></li>
	<input type="number" class="form-control" name="ex_1_d" value="<?php echo $idexercicio[18];?>" />
	<input 	type="text" name="ex_1_a_notas" class="form-control" id="ex_1_d_notas" value="<?php echo $observacaoExercicioUser[18];?>" required />
	<input id="idexercico1D" name="idexercico1D" value="<?php echo $idexercicioUser[18];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 2</span>
	<li class="form-control"><?php echo $exerciciosNome[19]; ?></li>
	<input type="number" class="form-control" name="ex_2_d" value="<?php echo $idexercicio[19];?>" >
	<input 	type="text" name="ex_2_a_notas" class="form-control" id="ex_2_d_notas" value="<?php echo $observacaoExercicioUser[19];?>" required />
	<input id="idexercico2D" name="idexercico2D" value="<?php echo $idexercicioUser[19];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 3</span>
	<li class="form-control"><?php echo $exerciciosNome[20]; ?></li>
	<input type="number" class="form-control" name="ex_3_d" value="<?php echo $idexercicio[20];?>" >
	<input 	type="text" name="ex_3_a_notas" class="form-control" id="ex_3_d_notas" value="<?php echo $observacaoExercicioUser[20];?>" required />
	<input id="idexercico3D" name="idexercico3D" value="<?php echo $idexercicioUser[20];?>"hidden/>	
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 4</span>
	<li class="form-control"><?php echo $exerciciosNome[21]; ?></li>
	<input type="number" class="form-control" name="ex_4_d" value="<?php echo $idexercicio[21];?>" >
	<input 	type="text" name="ex_4_a_notas" class="form-control" id="ex_4_d_notas" value="<?php echo $observacaoExercicioUser[21];?>" required />
	<input id="idexercico4D" name="idexercico4D" value="<?php echo $idexercicioUser[21];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 5</span>
	<li class="form-control"><?php echo $exerciciosNome[22]; ?></li>
	<input type="number" class="form-control" name="ex_5_d" value="<?php echo $idexercicio[22];?>" >
	<input 	type="text" name="ex_5_a_notas" class="form-control" id="ex_5_d_notas" value="<?php echo $observacaoExercicioUser[22];?>" required />
	<input id="idexercico5D" name="idexercico5D" value="<?php echo $idexercicioUser[22];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 6</span>
	<li class="list-group-item"><?php echo $exerciciosNome[23]; ?></li>
	<input type="number" class="form-control" name="ex_6_d" value="<?php echo $idexercicio[23];?>" >
	<input 	type="text" name="ex_6_a_notas" class="form-control" id="ex_6_d_notas" value="<?php echo $observacaoExercicioUser[23];?>" required />
	<input id="idexercico6D" name="idexercico6D" value="<?php echo $idexercicioUser[23];?>" hidden/>
	</div>
	</ul>
	<textarea rows="3" cols="30" name="observacaoPlanoTreinoD" id="observacaoPlanoTreinoD" class="col-md-12 alert alert-info" required ><?php echo $observacaoPlanoTreino[18];?></textarea><br><br><br><br><br>
	<input class="btn btn-primary btn-xs" type="submit" name="formD" value="Atualizar Plano D"/>
</form>
</div>

<div id="treino_e" role="tabpanel" class="tab-pane fade">
<form class="form-horizontal" method="POST" action="./enviar_editar_plano_treino.php"  enctype="multipart/form-data">
	<br>
	<div id="ativoPlanoTreinoE">Estado de ativação</div>
	<input type="number" name="ativoPlanoTreinoE" value="<?php echo $ativoPlanoTreino[24];?>" min="0" max="1"/><br>
	<input name="n_socio" value="<?php echo $n_socio;?>" hidden/>
	<input name="idPlanoTreinoE" value="<?php echo $idplanoTreino[24];?>" hidden/><br>
	<ul class="list-group">
	<div class="input-group">
	<span class="input-group-addon">Exercício 1</span>
	<li class="form-control"><?php echo $exerciciosNome[24]; ?></li>
	<input type="number" class="form-control" name="ex_1_e" value="<?php echo $idexercicio[24];?>" />
	<input 	type="text" name="ex_1_a_notas" class="form-control" id="ex_1_e_notas" value="<?php echo $observacaoExercicioUser[24];?>" required />
	<input id="idexercico1E" name="idexercico1E" value="<?php echo $idexercicioUser[24];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 2</span>
	<li class="form-control"><?php echo $exerciciosNome[25]; ?></li>
	<input type="number" class="form-control" name="ex_2_e" value="<?php echo $idexercicio[25];?>" >
	<input 	type="text" name="ex_2_a_notas" class="form-control" id="ex_2_e_notas" value="<?php echo $observacaoExercicioUser[25];?>" required />
	<input id="idexercico2E" name="idexercico2E" value="<?php echo $idexercicioUser[25];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 3</span>
	<li class="form-control"><?php echo $exerciciosNome[26]; ?></li>
	<input type="number" class="form-control" name="ex_3_e" value="<?php echo $idexercicio[26];?>" >
	<input 	type="text" name="ex_3_a_notas" class="form-control" id="ex_3_e_notas" value="<?php echo $observacaoExercicioUser[26];?>" required />
	<input id="idexercico3E" name="idexercico3E" value="<?php echo $idexercicioUser[26];?>"hidden/>	
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 4</span>
	<li class="form-control"><?php echo $exerciciosNome[27]; ?></li>
	<input type="number" class="form-control" name="ex_4_e" value="<?php echo $idexercicio[27];?>" >
	<input 	type="text" name="ex_4_a_notas" class="form-control" id="ex_4_e_notas" value="<?php echo $observacaoExercicioUser[27];?>" required />
	<input id="idexercico4E" name="idexercico4E" value="<?php echo $idexercicioUser[27];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 5</span>
	<li class="form-control"><?php echo $exerciciosNome[28]; ?></li>
	<input type="number" class="form-control" name="ex_5_e" value="<?php echo $idexercicio[28];?>" >
	<input 	type="text" name="ex_5_a_notas" class="form-control" id="ex_5_e_notas" value="<?php echo $observacaoExercicioUser[28];?>" required />
	<input id="idexercico5E" name="idexercico5E" value="<?php echo $idexercicioUser[28];?>"hidden/>
	</div>
	<div class="input-group">
	<span class="input-group-addon">Exercício 6</span>
	<li class="list-group-item"><?php echo $exerciciosNome[29]; ?></li>
	<input type="number" class="form-control" name="ex_6_e" value="<?php echo $idexercicio[29];?>" >
	<input 	type="text" name="ex_6_a_notas" class="form-control" id="ex_6_e_notas" value="<?php echo $observacaoExercicioUser[29];?>" required />
	<input id="idexercico6E" name="idexercico6E" value="<?php echo $idexercicioUser[29];?>" hidden/>
	</div>
	</ul>
	<textarea rows="3" cols="30" name="observacaoPlanoTreinoE" id="observacaoPlanoTreinoE" class="col-md-12 alert alert-info" required ><?php echo $observacaoPlanoTreino[18];?></textarea><br><br><br><br><br>
	<input class="btn btn-primary btn-xs" type="submit" name="formE" value="Atualizar Plano E"/>
</form>
</div>
	
</div>
</div>
</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
</body>
</html>