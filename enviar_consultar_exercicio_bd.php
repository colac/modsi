<?php
ini_set("display_errors", "on");
require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
if($tipo_conta != 2){
	header("./index.html");
}

if ($_POST["exercicioPlano"] != NULL){
	$pesquisaExercicioPlano = mysqli_real_escape_string($db_connect, $_POST["exercicioPlano"]);
	$sql = "SELECT nomeExercicio, idexercico FROM rinte.exercico WHERE nomeExercicio LIKE '%$pesquisaExercicioPlano%' OR tipo LIKE '%$pesquisaExercicioPlano%'   order by nomeExercicio ASC";
	$query = mysqli_query($db_connect, $sql);
	
	echo '<table class="table table-striped">
			<thead>
				<tr>';
	while($row = mysqli_fetch_assoc($query)) {
		echo	"<tr>
				<td>" . $row['nomeExercicio'] . "</td>
				<td>" . $row['idexercico'] . "</td></tr>";
				//echo $teste;
	}
}

else{
$exercicio = $_POST["nomeExercicio"];
$type = $_POST["tipo"];

if($exercicio != NULL AND $type == NULL){
//$teste = 'exercicio';	
$valido = 1;
$nomeExercicio = mysqli_real_escape_string($db_connect, $_POST["nomeExercicio"]);
$sql = "SELECT nomeExercicio, tipo 
		FROM rinte.exercico 
		WHERE nomeExercicio LIKE '%$nomeExercicio%' order by tipo ASC;";
	}
	elseif($type != NULL AND $exercicio == NULL){	
//$teste = 'tipo';				
$valido = 1;
$tipo = mysqli_real_escape_string($db_connect, $_POST["tipo"]);
$sql = "SELECT nomeExercicio, tipo 
		FROM rinte.exercico 
		WHERE tipo LIKE '$tipo%' order by nomeExercicio ASC;";
	}
		elseif($type != NULL AND $exercicio != NULL){		
//$teste = 'ambos';					
$valido = 1;
$nomeExercicio = mysqli_real_escape_string($db_connect, $_POST["nomeExercicio"]);
$tipo = mysqli_real_escape_string($db_connect, $_POST["tipo"]);
$sql = "SELECT nomeExercicio, tipo 
		FROM rinte.exercico 
		WHERE tipo LIKE '$tipo%' AND nomeExercicio LIKE '%$nomeExercicio%' order by nomeExercicio ASC;";
	}
if($valido == 1){
	$query = mysqli_query($db_connect, $sql);
	echo '<div id="delete_div" class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>				
				<th>Exercício</th>
				<th>Tipo</th>
                </tr>
              </thead>
              <tbody>';             
	while($row = mysqli_fetch_assoc($query)) {
		echo	"<tr>
				<td>".$row['nomeExercicio']."</td>
				<td>".$row['tipo']."</td>
				</tr>";
				//echo $teste;
	}
}
	else{//caso se tente procurar com o campo vazio
		echo NULL;
		}
}
mysqli_close($db_connect);	           
?>