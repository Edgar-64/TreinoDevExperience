<?php 
session_start();
require 'conexao.php';

$id = $_SESSION['id'];
$idEvento = $_GET['idEvento'];

$stmt = $conn->prepare('UPDATE eventos SET owner = ? AND user = ? WHERE id = ?');
$stmt->bind_param('iii', $id, $id, $idEvento);
$result = $stmt->execute();

if ($result) {
    echo '<script> alert("Reservado"); 
        window.location.href = "inicio.php"; </script>';
}
?>