<?php
require "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO usuarios (nome, email, senha) VALUE (?,?,?)');
    $stmt->bind_param('sss', $nome, $email, $senhaHash);
    $result = $stmt->execute();

    if ($result) {
        header('Location: index.php');
        exit;
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
        <h1>Dev Experience - Cadastro</h1>
        <a href="index.php">Voltar</a>
        <a href="login.php">Login</a>
    </header>
    <main>
        <form action="cadastro.php" method="post">
            <input type="text" name="nome" id="name" placeholder="Nome" require>
            <br>
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