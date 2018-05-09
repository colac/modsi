<?php
ini_set("display_errors", "on");
//usar estilo CSS na pág. PHP
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <link rel="stylesheet" type="text/css" href="custom_style.css" />';

require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
//apenas efetuando o login com conta de admin é possivel enviar dados
if ($tipo_conta == 2 OR $tipo_conta == 1){
	
//verificar se o input=submit foi usadavariavel $_POST['formA']
if (isset($_POST['formA'])){

$n_socio = mysqli_real_escape_string($db_connect, $_POST['n_socio']);
$ex_1_a = mysqli_real_escape_string($db_connect, $_POST['ex_1_a']);
$ex_2_a = mysqli_real_escape_string($db_connect, $_POST['ex_2_a']);
$ex_3_a = mysqli_real_escape_string($db_connect, $_POST['ex_3_a']);
$ex_4_a = mysqli_real_escape_string($db_connect, $_POST['ex_4_a']);
$ex_5_a = mysqli_real_escape_string($db_connect, $_POST['ex_5_a']);
$ex_6_a = mysqli_real_escape_string($db_connect, $_POST['ex_6_a']);
$idexercico1A = mysqli_real_escape_string($db_connect, $_POST['idexercico1A']);
$idexercico2A = mysqli_real_escape_string($db_connect, $_POST['idexercico2A']);
$idexercico3A = mysqli_real_escape_string($db_connect, $_POST['idexercico3A']);
$idexercico4A = mysqli_real_escape_string($db_connect, $_POST['idexercico4A']);
$idexercico5A = mysqli_real_escape_string($db_connect, $_POST['idexercico5A']);
$idexercico6A = mysqli_real_escape_string($db_connect, $_POST['idexercico6A']);
$ex_1_a_notas = mysqli_real_escape_string($db_connect, $_POST['ex_1_a_notas']);
$ex_2_a_notas = mysqli_real_escape_string($db_connect, $_POST['ex_2_a_notas']);
$ex_3_a_notas = mysqli_real_escape_string($db_connect, $_POST['ex_3_a_notas']);
$ex_4_a_notas = mysqli_real_escape_string($db_connect, $_POST['ex_4_a_notas']);
$ex_5_a_notas = mysqli_real_escape_string($db_connect, $_POST['ex_5_a_notas']);
$ex_6_a_notas = mysqli_real_escape_string($db_connect, $_POST['ex_6_a_notas']);
$observacaoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['observacaoPlanoTreinoA']);
$ativoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['ativoPlanoTreinoA']);
$idPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['idPlanoTreinoA']);
$idPlanoTreino_exercicio = $idPlanoTreino;
//mysqli_autocommit($db_connect, FALSE);
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, " UPDATE rinte.planotreino
							SET observacaoPlanoTreino = '$observacaoPlanoTreino', planoDia = 'A', ativoPlanoTreino = '$ativoPlanoTreino' 
							WHERE idplanoTreino = '$idPlanoTreino';");
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_1_a', observacaoExercicioUser = '$ex_1_a_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico1A';");
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_2_a', observacaoExercicioUser = '$ex_2_a_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico2A';");
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_3_a', observacaoExercicioUser = '$ex_3_a_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico3A';");
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_4_a', observacaoExercicioUser = '$ex_4_a_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico4A';");
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_5_a', observacaoExercicioUser = '$ex_5_a_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico5A';");
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_6_a', observacaoExercicioUser = '$ex_6_a_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico6A';");
$exeTransc = mysqli_commit($db_connect);
		if ($exeTransc == TRUE) {
		echo 'Plano A, de ' . $n_socio. ", editado com sucesso.<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//printf("%s\n", mysqli_info($db_connect));
		//print_r($_POST);
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim";
		}
		else {
		echo 'Erro na alteração do plano de utilizador nº' . $n_socio. ".<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim <br>";	
				}
		}
	elseif(isset($_POST['formB'])){
$n_socio = mysqli_real_escape_string($db_connect, $_POST['n_socio']);
$ex_1_b = mysqli_real_escape_string($db_connect, $_POST['ex_1_b']);
$ex_2_b = mysqli_real_escape_string($db_connect, $_POST['ex_2_b']);
$ex_3_b = mysqli_real_escape_string($db_connect, $_POST['ex_3_b']);
$ex_4_b = mysqli_real_escape_string($db_connect, $_POST['ex_4_b']);
$ex_5_b = mysqli_real_escape_string($db_connect, $_POST['ex_5_b']);
$ex_6_b = mysqli_real_escape_string($db_connect, $_POST['ex_6_b']);
$idexercico1B = mysqli_real_escape_string($db_connect, $_POST['idexercico1B']);
$idexercico2B = mysqli_real_escape_string($db_connect, $_POST['idexercico2B']);
$idexercico3B = mysqli_real_escape_string($db_connect, $_POST['idexercico3B']);
$idexercico4B = mysqli_real_escape_string($db_connect, $_POST['idexercico4B']);
$idexercico5B = mysqli_real_escape_string($db_connect, $_POST['idexercico5B']);
$idexercico6B = mysqli_real_escape_string($db_connect, $_POST['idexercico6B']);
$ex_1_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_1_b_notas']);
$ex_2_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_2_b_notas']);
$ex_3_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_3_b_notas']);
$ex_4_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_4_b_notas']);
$ex_5_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_5_b_notas']);
$ex_6_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_6_b_notas']);
$observacaoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['observacaoPlanoTreinoB']);
$ativoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['ativoPlanoTreinoB']);
$idPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['idPlanoTreinoB']);
$idPlanoTreino_exercicio = $idPlanoTreino;
//mysqli_autocommit($db_connect, FALSE);
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, " UPDATE rinte.planotreino
							SET observacaoPlanoTreino = '$observacaoPlanoTreino', planoDia = 'B', ativoPlanoTreino = '$ativoPlanoTreino' 
							WHERE idplanoTreino = '$idPlanoTreino';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_1_b', observacaoExercicioUser = '$ex_1_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico1B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_2_b', observacaoExercicioUser = '$ex_2_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico2B';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_3_b', observacaoExercicioUser = '$ex_3_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico3B';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_4_b', observacaoExercicioUser = '$ex_4_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico4B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_5_b', observacaoExercicioUser = '$ex_5_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico5B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_6_b', observacaoExercicioUser = '$ex_6_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico6B';");
$exeTransc = mysqli_commit($db_connect);
printf("%s\n", mysqli_info($db_connect));
		if ($exeTransc == TRUE) {
		echo 'Plano B, de ' . $n_socio. ", editado com sucesso.<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//printf("%s\n", mysqli_info($db_connect));
		//print_r($_POST);
		//echo "idPlanoTreino_exercicio" . $idPlanoTreino_exercicio;
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim";
		}
		else {
		echo 'Erro na alteração do plano de utilizador nº' . $n_socio. ".<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim <br>";	
				}
		}

elseif(isset($_POST['formC'])){
$n_socio = mysqli_real_escape_string($db_connect, $_POST['n_socio']);
$ex_1_b = mysqli_real_escape_string($db_connect, $_POST['ex_1_c']);
$ex_2_b = mysqli_real_escape_string($db_connect, $_POST['ex_2_c']);
$ex_3_b = mysqli_real_escape_string($db_connect, $_POST['ex_3_c']);
$ex_4_b = mysqli_real_escape_string($db_connect, $_POST['ex_4_c']);
$ex_5_b = mysqli_real_escape_string($db_connect, $_POST['ex_5_c']);
$ex_6_b = mysqli_real_escape_string($db_connect, $_POST['ex_6_c']);
$idexercico1B = mysqli_real_escape_string($db_connect, $_POST['idexercico1C']);
$idexercico2B = mysqli_real_escape_string($db_connect, $_POST['idexercico2C']);
$idexercico3B = mysqli_real_escape_string($db_connect, $_POST['idexercico3C']);
$idexercico4B = mysqli_real_escape_string($db_connect, $_POST['idexercico4C']);
$idexercico5B = mysqli_real_escape_string($db_connect, $_POST['idexercico5C']);
$idexercico6B = mysqli_real_escape_string($db_connect, $_POST['idexercico6C']);
$ex_1_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_1_c_notas']);
$ex_2_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_2_c_notas']);
$ex_3_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_3_c_notas']);
$ex_4_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_4_c_notas']);
$ex_5_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_5_c_notas']);
$ex_6_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_6_c_notas']);
$observacaoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['observacaoPlanoTreinoC']);
$ativoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['ativoPlanoTreinoC']);
$idPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['idPlanoTreinoC']);
$idPlanoTreino_exercicio = $idPlanoTreino;
//mysqli_autocommit($db_connect, FALSE);
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, " UPDATE rinte.planotreino
							SET observacaoPlanoTreino = '$observacaoPlanoTreino', planoDia = 'B', ativoPlanoTreino = '$ativoPlanoTreino' 
							WHERE idplanoTreino = '$idPlanoTreino';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_1_b', observacaoExercicioUser = '$ex_1_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico1B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_2_b', observacaoExercicioUser = '$ex_2_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico2B';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_3_b', observacaoExercicioUser = '$ex_3_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico3B';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_4_b', observacaoExercicioUser = '$ex_4_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico4B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_5_b', observacaoExercicioUser = '$ex_5_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico5B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_6_b', observacaoExercicioUser = '$ex_6_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico6B';");
$exeTransc = mysqli_commit($db_connect);
//printf("%s\n", mysqli_info($db_connect));
		if ($exeTransc == TRUE) {
		echo 'Plano B, de ' . $n_socio. ", editado com sucesso.<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//printf("%s\n", mysqli_info($db_connect));
		//print_r($_POST);
		//echo "idPlanoTreino_exercicio" . $idPlanoTreino_exercicio;
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim";
		}
		else {
		echo 'Erro na alteração do plano de utilizador nº' . $n_socio. ".<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim <br>";	
				}
		}
		
	elseif(isset($_POST['formD'])){
$n_socio = mysqli_real_escape_string($db_connect, $_POST['n_socio']);
$ex_1_b = mysqli_real_escape_string($db_connect, $_POST['ex_1_d']);
$ex_2_b = mysqli_real_escape_string($db_connect, $_POST['ex_2_d']);
$ex_3_b = mysqli_real_escape_string($db_connect, $_POST['ex_3_d']);
$ex_4_b = mysqli_real_escape_string($db_connect, $_POST['ex_4_d']);
$ex_5_b = mysqli_real_escape_string($db_connect, $_POST['ex_5_d']);
$ex_6_b = mysqli_real_escape_string($db_connect, $_POST['ex_6_d']);
$idexercico1B = mysqli_real_escape_string($db_connect, $_POST['idexercico1D']);
$idexercico2B = mysqli_real_escape_string($db_connect, $_POST['idexercico2D']);
$idexercico3B = mysqli_real_escape_string($db_connect, $_POST['idexercico3D']);
$idexercico4B = mysqli_real_escape_string($db_connect, $_POST['idexercico4D']);
$idexercico5B = mysqli_real_escape_string($db_connect, $_POST['idexercico5D']);
$idexercico6B = mysqli_real_escape_string($db_connect, $_POST['idexercico6D']);
$ex_1_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_1_d_notas']);
$ex_2_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_2_d_notas']);
$ex_3_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_3_d_notas']);
$ex_4_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_4_d_notas']);
$ex_5_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_5_d_notas']);
$ex_6_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_6_d_notas']);
$observacaoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['observacaoPlanoTreinoD']);
$ativoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['ativoPlanoTreinoD']);
$idPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['idPlanoTreinoD']);
$idPlanoTreino_exercicio = $idPlanoTreino;
//mysqli_autocommit($db_connect, FALSE);
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, " UPDATE rinte.planotreino
							SET observacaoPlanoTreino = '$observacaoPlanoTreino', planoDia = 'B', ativoPlanoTreino = '$ativoPlanoTreino' 
							WHERE idplanoTreino = '$idPlanoTreino';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_1_b', observacaoExercicioUser = '$ex_1_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico1B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_2_b', observacaoExercicioUser = '$ex_2_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico2B';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_3_b', observacaoExercicioUser = '$ex_3_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico3B';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_4_b', observacaoExercicioUser = '$ex_4_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico4B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_5_b', observacaoExercicioUser = '$ex_5_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico5B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_6_b', observacaoExercicioUser = '$ex_6_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico6B';");
$exeTransc = mysqli_commit($db_connect);
//printf("%s\n", mysqli_info($db_connect));
		if ($exeTransc == TRUE) {
		echo 'Plano B, de ' . $n_socio. ", editado com sucesso.<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//printf("%s\n", mysqli_info($db_connect));
		//print_r($_POST);
		//echo "idPlanoTreino_exercicio" . $idPlanoTreino_exercicio;
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim";
		}
		else {
		echo 'Erro na alteração do plano de utilizador nº' . $n_socio. ".<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim <br>";	
				}
		}	
		
		elseif(isset($_POST['formE'])){
$n_socio = mysqli_real_escape_string($db_connect, $_POST['n_socio']);
$ex_1_b = mysqli_real_escape_string($db_connect, $_POST['ex_1_e']);
$ex_2_b = mysqli_real_escape_string($db_connect, $_POST['ex_2_e']);
$ex_3_b = mysqli_real_escape_string($db_connect, $_POST['ex_3_e']);
$ex_4_b = mysqli_real_escape_string($db_connect, $_POST['ex_4_e']);
$ex_5_b = mysqli_real_escape_string($db_connect, $_POST['ex_5_e']);
$ex_6_b = mysqli_real_escape_string($db_connect, $_POST['ex_6_e']);
$idexercico1B = mysqli_real_escape_string($db_connect, $_POST['idexercico1E']);
$idexercico2B = mysqli_real_escape_string($db_connect, $_POST['idexercico2E']);
$idexercico3B = mysqli_real_escape_string($db_connect, $_POST['idexercico3E']);
$idexercico4B = mysqli_real_escape_string($db_connect, $_POST['idexercico4E']);
$idexercico5B = mysqli_real_escape_string($db_connect, $_POST['idexercico5E']);
$idexercico6B = mysqli_real_escape_string($db_connect, $_POST['idexercico6E']);
$ex_1_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_1_e_notas']);
$ex_2_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_2_e_notas']);
$ex_3_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_3_e_notas']);
$ex_4_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_4_e_notas']);
$ex_5_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_5_e_notas']);
$ex_6_b_notas = mysqli_real_escape_string($db_connect, $_POST['ex_6_e_notas']);
$observacaoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['observacaoPlanoTreinoE']);
$ativoPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['ativoPlanoTreinoE']);
$idPlanoTreino = mysqli_real_escape_string($db_connect, $_POST['idPlanoTreinoE']);
$idPlanoTreino_exercicio = $idPlanoTreino;
//mysqli_autocommit($db_connect, FALSE);
mysqli_begin_transaction($db_connect, MYSQLI_TRANS_START_READ_WRITE);
mysqli_query($db_connect, " UPDATE rinte.planotreino
							SET observacaoPlanoTreino = '$observacaoPlanoTreino', planoDia = 'B', ativoPlanoTreino = '$ativoPlanoTreino' 
							WHERE idplanoTreino = '$idPlanoTreino';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_1_b', observacaoExercicioUser = '$ex_1_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico1B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_2_b', observacaoExercicioUser = '$ex_2_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico2B';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_3_b', observacaoExercicioUser = '$ex_3_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico3B';");
//printf("%s\n", mysqli_info($db_connect));
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_4_b', observacaoExercicioUser = '$ex_4_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico4B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_5_b', observacaoExercicioUser = '$ex_5_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico5B';");
//printf("%s\n", mysqli_info($db_connect));							
mysqli_query($db_connect, " UPDATE rinte.exerciciouser
							SET exercicoUser_idexercico = '$ex_6_b', observacaoExercicioUser = '$ex_6_b_notas'
							WHERE exercicioUser_idplanoTreino = '$idPlanoTreino_exercicio' AND idexercicioUser = '$idexercico6B';");
$exeTransc = mysqli_commit($db_connect);
//printf("%s\n", mysqli_info($db_connect));
		if ($exeTransc == TRUE) {
		echo 'Plano B, de ' . $n_socio. ", editado com sucesso.<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//printf("%s\n", mysqli_info($db_connect));
		//print_r($_POST);
		//echo "idPlanoTreino_exercicio" . $idPlanoTreino_exercicio;
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim";
		}
		else {
		echo 'Erro na alteração do plano de utilizador nº' . $n_socio. ".<br><a href = 'editar_plano_treino.php?n_socio=$n_socio'>Regressar à pág. de edição do treino do utilizador.</a><br>";
		//echo "<br>exercicoUser_idexercico " . $ex_1_a . " observacaoExercicioUser" . $ex_1_a_notas . " <br> idexercicioUser " . $idexercico1A . " exercicioUser_idplanoTreino " . $idPlanoTreinoA . " fim <br>";	
				}
		}
		
else {
		print_r($_POST);
		echo "<br>" . $n_socio;
		echo mysqli_error($db_connect);
		}
}
mysqli_close($db_connect);
?>