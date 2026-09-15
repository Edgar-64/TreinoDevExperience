<?php 
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare('SELECT id, nome, email, senha, tipo FROM usuarios WHERE email = ?');
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if(password_verify($senha,$user['senha'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['tipo'] = $user['tipo'];

            echo "<script>
            setTimeout(function() {
            alert('Login concluido');
            window.location.href = 'inicio.php';
            }, 100);
            </script>";
        } else {
            die ("Senha Errada");
        }
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
        <h1>Página Login</h1>
        
    </header>
    <main>
        <form id="evento" method="post">
            <input type="email" name="email" id="email" required>
            <br>
            <input type="password" name="senha" id="senha" required>
            <br>
            <button onclick="submit">Enviar</button>
        </form>
        <p>Ainda sem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </main>
    <footer>

    </footer>
</body>
</html>