<?php
session_start();

require "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare('SELECT id, nome, senha, email FROM usuarios WHERE email = ? LIMIT 1');

    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['email'] = $user['email'];

            header('Location: inicio.php');
            exit;
        } else {
            die('Senha Incorreta');
        }
    } else {
        die('Usuário não encontrado');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebDevs</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>Dev Experience - Login</h1>
        <a href="index.php">Voltar</a>
        <a href="cadastro.php">Cadastro</a>
    </header>
    <main>
        <form action="login.php" method="post">
            <input type="email" name="email" id="email" placeholder="email" required>
            <br>
            <input type="password" name="senha" id="senha" placeholder="senha" required>
            <br>
            <button type="submit">Enviar</button>
        </form>
    </main>
    <footer>

    </footer>
</body>

</html>