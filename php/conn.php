<?php

$host = "localhost";
$dbName = "avaliacao_sodre";
$user = "root";
$passWord = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $passWord);
    // echo "Conexão estabelecida com sucesso";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}

?>