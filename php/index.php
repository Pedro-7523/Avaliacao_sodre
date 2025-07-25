<?php
require_once('conn.php');

$query = "SELECT funcionario.id_funcionario, funcionario.nome_funcionario,
funcionario.salario, cargos_funcionarios.nome_cargo
FROM funcionario
INNER JOIN cargos_funcionarios ON funcionario.cargo_id = cargos_funcionarios.id_cargo
ORDER BY FIELD(cargos_funcionarios.nome_cargo,  'Analista de Sistemas', 'Administrador', 'Gestor')";

try {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Funcionários</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <div class="container">
        <h1 id="label_funcionarios"><label>Funcionários</label></h1>

        <table>
            <tr>
                <th>Nome</th>
                <th>Salário</th>
                <th>Cargo</th>
                <th>Ações</th>
            </tr>

            <?php
            foreach ($funcionarios as $f) {
                $id = $f['id_funcionario'];
                $nome = htmlspecialchars($f['nome_funcionario']);
                $salario = 'R$ ' . number_format($f['salario'], 2, ',', '.');
                $cargo = htmlspecialchars($f['nome_cargo']);

                echo <<<HTML
            <tr>
                <td>{$nome}</td>
                <td>{$salario}</td>
                <td>{$cargo}</td>
                <td>
                    <form action="excluir_usuario.php" method="POST" style="display: inline;">
                        <input type="hidden" name="id_funcionario" value="{$id}">
                        <button type="submit" id= "deletar" class = "btn">Deletar</button>
                    </form>
                    <form action="atualizar.php" method="GET" style="display: inline;">
                        <input type="hidden" name="id_funcionario" value="{$id}">
                        <button id = "editar" class = "btn" type="submit">Editar</button>
                    </form>
                </td>
            </tr>
            HTML;
            }
            ?>
        </table>
        <button id="cadastrar" class="btn" onclick="window.location.href = 'cadastrar.php'">Cadastrar</button>
    </div>

</body>

</html>