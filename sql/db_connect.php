<?php 
$serverName = "localhost";
$userName = "root";
$password = "root";
$db_name = "gerenciador_de_chamados";

$conn = new mysqli($serverName, $userName, $password, $db_name);

if($conn -> connect_error) {
    die("Conexão Falhou!". $conn -> connect_error);
}
?>