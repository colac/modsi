<?php
//ini_set("display_errors", "off");
require("./db_connect.php");
//verifica se a sessão está iniciada
require('./sessao.php');
if($tipo_conta != 2){
	header("./index.html");
}
if($_POST["email"] != NULL){
$emailSocio = mysqli_real_escape_string($db_connect, $_POST["email"]);

$sql = "SELECT idCliente, nomeCliente, cc, nif, nib, dataInscricao, ativoCliente, moradaCliente, telefoneCliente, emailCliente
		FROM rinte.cliente, rinte.autcliente
		WHERE clientes_idClientes = idCliente AND emailCliente LIKE '%$emailSocio%';";
$query = mysqli_query($db_connect, $sql);
echo '<div id="delete_div" class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>				
				<th>Nome</th>
				<th>Nº de Sócio</th>
				<th>Email</th>
				<th>Contacto</th>
				<th>Morada</th>
				<th>CC</th>
				<th>NIF</th>
				<th>NIB</th>
				<th>Data da Inscrição</th>
                </tr>
              </thead>
              <tbody>';             
while($row = mysqli_fetch_assoc($query)) {
$data_registo = date("d-m-Y", strtotime($row['dataInscricao'])); 
$n_socio = $row['idCliente'];
		echo	"<tr>
				<td>".$row['nomeCliente']."</td>
				<td>".$row['idCliente']."</td>
				<td>".$row['emailCliente']."</td>
				<td>".$row['telefoneCliente']."</td>
				<td>".$row['moradaCliente']."</td>
				<td>".$row['cc']."</td>
				<td>".$row['nif']."</td>
				<td>".$row['nib']."</td>
				<td>".$data_registo."</td>
				<td><a class='button_empresas' target='_blank' href='editar_user.php?n_socio=$n_socio'>Editar Informações</a></td>
				<td><a class='button_empresas' target='_blank' href='editar_plano_treino.php?n_socio=$n_socio'>Editar Plano Treino</a></td>
				</tr>";
	}
}
else {//caso se tente procurar com o campo vazio
	echo NULL;
	}
mysqli_close($db_connect);	           
?>