<?php
require_once("conn.php");

$query = "SELECT * FROM cargos_funcionarios";

try {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar os cargos: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "INSERT INTO funcionario(nome_funcionario, email, salario, cargo_id) VALUES (:nome_funcionario, :email, :salario, :cargo_id)";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome_funcionario', $_POST['nome']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':salario', $_POST['salario']);
        $stmt->bindParam(':cargo_id', $_POST['cargo_id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro ao cadastrar funcionário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Cadastrar Funcionário</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastrar.css">
</head>

<body>
    <div class="container">
        <form method="post">

            <label> Cadastrar Funcionário</label>

            <input type="text" name="nome" id="nome" required placeholder="Nome">

            <input type="email" name="email" id="email" required placeholder="Email">

            <input type="number" name="salario" id="salario" required placeholder="Salário">

            <select name="cargo_id" id="cargo_id" required>
                <option value="" disabled selected hidden>Selecione um cargo</option>

                <?php foreach ($cargos as $cargo) { ?>
                    <option value="<?php echo $cargo['id_cargo']; ?>">
                        <?php echo htmlspecialchars($cargo['nome_cargo']); ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" class="cadastrar">Cadastrar</button>
        </form>
    </div>
</body>

</html>