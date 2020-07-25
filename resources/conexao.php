<?php

// definições de host, database, usuário e senha
$host = "localhost";
$user = "root";
$pass = "";
$db   = "zero-bugs";

$mysqli = new mysqli($host, $user, $pass, $db);

if($mysqli->connect_errno) echo "Falha na conexão: (".$mysqli->connect_errno.") ".$mysqli->connect_error;


// conecta ao banco de dados
/*$con = mysqli_connect($host, $user, $pass) or trigger_error(mysqli_error($con),E_USER_ERROR); 

// seleciona a base de dados em que vamos trabalhar
mysqli_select_db($con, $db);

// cria a instrução SQL que vai selecionar os planos e as regioes no banco de dados
$planos = sprintf("SELECT * FROM planos");
$regioes = sprintf("SELECT * FROM regioes");

// executa a query
$dadosPlanos = mysqli_query($con, $planos ) or die(mysqli_error($con));
$dadosRegioes = mysqli_query($con, $regioes ) or die(mysqli_error($con));

// transforma os dados em um array
$linhaPlanos = mysqli_fetch_assoc($dadosPlanos);
$linhaRegioes = mysqli_fetch_assoc($dadosRegioes);

// calcula quantos dados retornaram
$totalPlanos = mysqli_num_rows($dadosPlanos);
$totalRegioes = mysqli_num_rows($dadosRegioes);*/

?>