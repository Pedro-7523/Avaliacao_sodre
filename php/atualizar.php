<?php
require_once('conn.php');

$query = "SELECT * FROM cargos_funcionarios";
try {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $cargos = $stmt->fetchALL(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar os cargos: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "UPDATE funcionario SET nome_funcionario = :nome_funcionario, email = :email, salario = :salario, cargo_id = :cargo_id WHERE id_funcionario = :id_funcionario";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome_funcionario', $_POST['nome']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':salario', $_POST['salario']);
        $stmt->bindParam(':cargo_id', $_POST['cargo_id'], PDO::PARAM_INT);
        $stmt->bindParam(':id_funcionario', $_POST['id_funcionario'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro ao atualizar funcionário: " . $e->getMessage();
    }
}

if (isset($_GET['id_funcionario'])) {
    $id_funcionario = $_GET['id_funcionario'];
    $query = "SELECT * FROM funcionario WHERE id_funcionario = :id_funcionario";
    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_funcionario', $id_funcionario, PDO::PARAM_INT);
        $stmt->execute();
        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$funcionario) {
            echo "Funcionário não encontrado.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro ao buscar funcionário: " . $e->getMessage();
    }
} else {
    echo "ID do funcionário não informado.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Atualizar Dados</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/atualizar.css">
</head>

<body>
    <div class="container">

        <form method="post">

            <label id="label_inicial">Atualizar Informações</label>
            <input type="hidden" name="id_funcionario" value="<?php echo $funcionario['id_funcionario']; ?>">

            <label>Nome</label>
            <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($funcionario['nome_funcionario']); ?>">

            <label>Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($funcionario['email']); ?>">

            <label>Salário</label>
            <input type="number" name="salario" id="salario" value="<?php echo $funcionario['salario']; ?>">

            <label>Cargo</label>
            <select name="cargo_id" id="cargo_id">
                <option value="" disabled hidden>Selecione um cargo</option>
                <?php foreach ($cargos as $cargo) { ?>
                    <option value="<?php echo $cargo['id_cargo']; ?>"
                        <?php if ($cargo['id_cargo'] == $funcionario['cargo_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($cargo['nome_cargo']); ?>
                    </option>
                <?php } ?>
            </select>


            <button type="submit" name="btn_atualizar" id="atualizar">Atualizar</button>
        </form>
    </div>
</body>

</html>