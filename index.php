<?php
include './sql/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $ultimo_nome = $_POST['ultimo_nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    $sql = "INSERT INTO cliente (nome_cliente, ultimo_nome_cliente, email_cliente, telefone_cliente, cpf_cliente, senha_cliente)
            VALUES ('$nome', '$ultimo_nome', '$email', '$telefone', '$cpf', $senha)";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php"); 
        exit;
    } else {
        $erro = "Erro ao cadastrar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
</head>
<body>
    <h1>Cadastro</h1>
    <form method="POST" action="index.php">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="ultimo_nome" placeholder="Último Nome">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="telefone" placeholder="Telefone">
        <input type="text" name="cpf" placeholder="CPF">
        <input type="password" name="senha" placeholder="Senha">
        <button type="submit">Cadastrar</button>
    </form>
    <p>Já possui uma conta? <a href="login.php"><button>Entre</button></a></p>
    <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
</body>
</html>
