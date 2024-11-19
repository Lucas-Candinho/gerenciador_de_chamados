<?php
session_start();
include '../sql/db_connect.php';
if (!isset($_SESSION['cliente_id'])) {
    header("Location: ../login.php");
    exit;
}

$id_cliente = $_SESSION['cliente_id'];
$sql = "SELECT *
        FROM chamado
        INNER JOIN cliente ON cliente.id_cliente = chamado.id_cliente_chamado
        WHERE cliente.id_cliente = $id_cliente";
$result = $conn->query($sql);

$colaboradores = $conn->query("SELECT id_colaborador, nome_colaborador FROM colaborador");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['delete'])) {
    $id_chamado = $_GET['id'];


    $sqlDelete = "DELETE FROM chamado WHERE id_chamado = '$id_chamado'";
    if ($conn->query($sqlDelete) === false) {
        echo "Erro ao excluir o chamado: " . $conn->error;
    } else {
        header("Location: cliente.php"); 
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $colaborador_id = !empty($_POST['colaborador_id']) ? $_POST['colaborador_id'] : null; 
    $criticidade = !empty($_POST['criticidade']) ? $_POST['criticidade'] : null; 
    $status = !empty($_POST['status']) ? $_POST['status'] : null;

    $sql = "SELECT *
        FROM chamado
        INNER JOIN cliente ON cliente.id_cliente = chamado.id_cliente_chamado
        WHERE cliente.id_cliente = $id_cliente";

    if ($criticidade !== null) {
        $sql .= " AND chamado.criticidade_chamado = $criticidade";        
    }

    if ($status !== null) {
        $sql .= " AND chamado.status_chamado = $status";        
    }

    if ($colaborador_id !== null) {
        $sql .= " AND chamado.id_colaborador_responsavel = $colaborador_id";        
    }

    if ($conn->query($sql) === TRUE) {
        echo "<p>Filtro realizado com sucesso!</p>";
    } else {
        echo "<p>Erro ao filtrar: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
</head>
<body>
    <h1>Bem-vindo!</h1>
    <div class="button-container">
            <a href="criar_chamado.php"><button>Criar Chamado</button></a>
        </div>
        <br />
    <section id="table">
        <?php

            if ($result->num_rows > 0) {
                echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Descrição do Chamado</th>
                        <th>Criticidade do Chamado</th>
                        <th>Status do Chamado</th>
                        <th>Data de Criação do Chamado</th>
                        <th>Colaborador Responsável</th>
                        <th>Ações</th>
                    </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_chamado']}</td>
                            <td>{$row['descricao_chamado']}</td>
                            <td>{$row['criticidade_chamado']}</td>
                            <td>{$row['status_chamado']}</td>
                            <td>{$row['data_abertura_chamado']}</td>
                            <td>{$row['id_colaborador_responsavel_chamado']}</td>
                            <td><a href='index.php?id={$row['id_chamado']}&delete=1'>Excluir</a></td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "Nenhum registro encontrado.";
            }
            $conn->close();
        ?>
    </section>
            <br />
    <form method="POST" action="cliente.php">

        <label for="criticidade">Criticidade:</label>
        <select name="criticidade" id="criticidade">
            <option value="">Selecione uma Criticidade</option>
            <option value="baixa">Baixa</option>
            <option value="media">Média</option>
            <option value="alta">Alta</option>
        </select>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">Selecione um Status</option>
            <option value="aberto">Aberto</option>
            <option value="em andamento">Em andamento</option>
            <option value="resolvido">Resolvido</option>
        </select>

        <label for="colaborador_id">Colaborador Responsável:</label>
        <select name="colaborador_id" id="colaborador_id">
            <option value="">Selecione um colaborador</option>
            <?php while ($colaborador = $colaboradores->fetch_assoc()): ?>
                <option value="<?= $colaborador['id_colaborador']; ?>"><?= $colaborador['nome_colaborador']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Filtrar</button>
    </form>
    <br />
    <a href="../logout.php">Sair</a>
</body>
</html>
