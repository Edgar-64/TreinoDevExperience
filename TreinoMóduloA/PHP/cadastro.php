<?php
require('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['pass'];

    if (empty($email) || empty($senha) || empty($nome)) {
        echo 'Preencha todos os campos';
        exit;
    }

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO usuarios (nome, email, senha) VALUE (?,?,?)');
    $stmt->bind_param('sss', $nome, $email, $senha);

    if ($stmt->execute()) {
        header('Location: ../HTML/login.html');
        exit;
    } else {
        echo 'Erro ao realizar cadastro: ' . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>