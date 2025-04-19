<?php
$servername = "localhost";
$username = "root"; // ou o seu usuário
$password = ""; // nesse caso está sem senha
$dbname = "studioplay"; // nome do banco

// Criar conexão
$conexao = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão 
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}else {
    //echo "Conexão bem-sucedida com o banco de dados!";
}
?>