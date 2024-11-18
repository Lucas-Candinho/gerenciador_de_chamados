<?php
session_start();
include '../sql/db_connect.php';
if (!isset($_SESSION['cliente_id'])) {
    header("Location: ../login.php");
    exit;
}

$sql = "SELECT *
        FROM chamado
        INNER JOIN cliente ON cliente.id_cliente = chamado.id_cliente_chamado"; 
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['delete'])) {
    $id_chamado = $_GET['id'];


    $sqlDelete = "DELETE FROM chamado WHERE id_chamado = '$id_chamado'";
    if ($conn->query($sqlDelete) === false) {
        echo "Erro ao excluir o chamado: " . $conn->error;
    } else {
        header("Location: index.php"); 
        exit;
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
    <h1>Bem-vindo, <?php echo $_SESSION['cliente']['nome_cliente']; ?></h1>
    <div class="button-container">
            <a href="criar_chamado.php"><button>Criar Chamado</button></a>
        </div>
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
                            <td><a href='index.php?id={$row['id_nota']}&delete=1'>Excluir</a></td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "Nenhum registro encontrado.";
            }
            $conn->close();
        ?>
    </section>

    <a href="../logout.php">Sair</a>
</body>
</html>
