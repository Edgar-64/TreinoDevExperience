<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?,?,?)');
    $stmt->bind_param("sss", $nome, $email, $senhaHash);

    $result = $stmt->execute();
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
        <h1>Página Cadastro</h1>
        
    </header>
    <main>
        <form id="evento" method="POST">
            <p id="resposta"></p>
            <input type="text" name="nome" id="nome" required>
            <br>
            <input type="email" name="email" id="email" required>
            <br>
            <input type="password" name="senha" id="senha" required>
            <br>
            <button type="submit">Enviar</button>
        </form>
        <p>Já possui uma conta? <a href="login.php">Faça login</a></p>
    </main>
    <footer>

    </footer>
    <script>
        const form = document.getElementById('evento');

        form.addEventListener("submit", function (event) {

            const confirmar = confirm('Todos os dados estão corretos?');

            if (!confirmar) {
                event.preventDefault(); // Cancela o envio se o usuário clicar em "Cancelar"
                return;
            }

            window.location.href = 'login.php';
        })

    </script>
</body>

</html>