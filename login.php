<?php
session_start();
include './sql/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    
    $sql = "SELECT id_cliente FROM cliente WHERE email_cliente = '$email' AND senha_cliente = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        
        $row = $result->fetch_assoc();
        $_SESSION['cliente_id'] = $row['id_cliente'];
        header("Location: ./cliente/cliente.php");
        exit;
    } else {
        echo "<p>Login inválido. Verifique suas credenciais.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="login.php">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>

        <button type="submit">Entrar</button>
    </form>
    <p>Não tem uma conta? <a href="login.php"><button>Entre</button></a></p>
</body>
</html>
