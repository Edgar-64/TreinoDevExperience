<?php 
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $local = $_POST['local'];
    $hora = $_POST['hora'];

    $stmt = $conn->prepare('INSERT INTO eventos (nome, dataEvento, localEvento, horaEvento) VALUES (?,?,?,?)');
    $stmt->bind_param('ssss', $nome, $data, $local, $hora);
    $result = $stmt->execute();

    if ($result) {
        echo '<script> alert("Evento Cadastrado"); 
        window.location.href = "inicio.php"; </script>';
    }
}
?>