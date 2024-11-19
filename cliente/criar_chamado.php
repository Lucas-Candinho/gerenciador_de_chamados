<?php
session_start();
include '../sql/db_connect.php';


if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php"); 
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $criticidade = $_POST['criticidade'];
    $data_abertura = date('Y-m-d H:i:s'); 
    $colaborador_id = !empty($_POST['colaborador_id']) ? $_POST['colaborador_id'] : null; 

    $sql = "INSERT INTO chamado (id_cliente_chamado, descricao_chamado, criticidade_chamado, data_abertura_chamado, id_colaborador_responsavel_chamado)
            VALUES ('$cliente_id', '$descricao', '$criticidade', '$data_abertura', ".($colaborador_id ? "'$colaborador_id'" : "NULL").")";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Chamado criado com sucesso!</p>";
    } else {
        echo "<p>Erro ao criar o chamado: " . $conn->error . "</p>";
    }
}

$colaboradores = $conn->query("SELECT id_colaborador, nome_colaborador FROM colaborador");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Chamado</title>
</head>
<body>
    <h1>Criar Chamado</h1>
    <form method="POST" action="criar_chamado.php">
        <label for="descricao">Descrição do Problema:</label>
        <textarea name="descricao" id="descricao" required></textarea>

        <label for="criticidade">Criticidade:</label>
        <select name="criticidade" id="criticidade" required>
            <option value="baixa">Baixa</option>
            <option value="media">Média</option>
            <option value="alta">Alta</option>
        </select>

        <label for="colaborador_id">Colaborador Responsável (opcional):</label>
        <select name="colaborador_id" id="colaborador_id">
            <option value="">Selecione um colaborador</option>
            <?php while ($colaborador = $colaboradores->fetch_assoc()): ?>
                <option value="<?= $colaborador['id_colaborador']; ?>"><?= $colaborador['nome_colaborador']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Criar Chamado</button>
    </form>
    <p>Já acabou por aqui? <a href="cliente.php"><button>Voltar</button></a></p>
</body>
</html>
