<?php 
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare('SELECT id, nome, senha, email, tipo FROM usuarios WHERE email = ? LIMIT 1');
    $stmt->bind_param('s',$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['tipo'] = $user['tipo'];

            echo "<script> alert('Acesso Garantido');
            window.location.href = 'inicio.php'; </script>";
        } else {
            die('Senha Errada');
        }
                
    } else {
        die('Usuário n encontrado');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <main>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email">
            <br>
            <input type="password" name="senha" placeholder="Senha">
            <br>
            <button type="submit">Enviar</button>
        </form>
        <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
    </main>
    <footer>

    </footer>
</body>
</html>