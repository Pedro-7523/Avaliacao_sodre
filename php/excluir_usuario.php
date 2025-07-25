<?php
require_once('conn.php');

$sql = "DELETE FROM funcionario WHERE id_funcionario = :id_funcionario";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id_funcionario'])) {
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_funcionario', $_POST['id_funcionario'], PDO::PARAM_INT);
        if($stmt->execute()){
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao excluir funcionário.";
        }
    }
}else {
    echo "Método de requisição inválido.";
}