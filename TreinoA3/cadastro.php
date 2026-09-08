<?php 
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?,?,?)');
    $stmt->bind_param('sss',$nome,$email,$senhaHash);
    $result = $stmt->execute();

    if ($result) {
        echo '<script> alert("Cadastro Concluido"); 
        window.location.href = "login.php"; </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <header>
        <h1>Cadastro</h1>
    </header>
    <main>
        <form action="cadastro.php" method="POST">
            <input type="text" name="nome" placeholder="Nome">
            <br>
            <input type="email" name="email" placeholder="Email">
            <br>
            <input type="password" name="senha" placeholder="Senha">
            <br>
            <button type="submit">Enviar</button>
        </form>
        <p>Já tem uma conta? <a href="login.php">Faça Login</a></p>
    </main>
    <footer>

    </footer>
</body>
</html>