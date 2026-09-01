<?php
session_start();

require('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['pass'];

    if (empty($email) || empty($senha)) {
        die('Preencha todos os campos');
    }

    $stmt = $conn->prepare(
        'SELECT id, email, senha FROM usuarios WHERE email = ? LIMIT 1'
    );

    if (!$stmt) {
        die('Erro no SQL: ' . $conn->error);
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $usuario = $result->fetch_assoc();
        $_SESSION['id'] = $usuario['id'];

        if (password_verify($senha, $usuario['senha'])) {

            

            header('Location: inicio.php');
            exit;

        } else {
            die('Senha incorreta');
        }

    } else {
        die('Usuário não encontrado');
    }

    $stmt->close();
}

$conn->close();
?>