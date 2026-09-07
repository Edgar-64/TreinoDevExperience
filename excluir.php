//excluir.php
<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
	exit;
}

$tipo = $_SESSION['tipo'];
$id = $_GET['id'];

if ($tipo != 'admin') {
	header('Location: inicio.php');
	exit;
}

$stmt = $conn->prepare('DELETE FROM eventos WHERE id = ?');
$stmt->bind_param('i', $id);
$result = $stmt->execute();

if ($result) {
	echo '<script>
	alert("Evento deletado");
	window.location.href = "eventos.php";
	</script>';
} else {
	echo '<script>
	alert("Erro ao deletar");
	window.location.href = "eventos.php";
	</script>';
}
?>