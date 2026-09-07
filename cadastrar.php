//cadastrar.php
<?php 
session_start();
require 'conexao.php';

if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
	exit;
}

$tipo = $_SESSION['tipo'];

if ($tipo != 'admin') {
	header('Location: inicio.php');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$data = $_POST['data'];

	if (empty (trim($nome)) || empty (trim($descricao)) || empty($data)) {
		echo '<script>alert("Campo vazio")</script>';
	} elseif (strlen($nome) < 3) {
		echo '<script>alert("O nome deve conter pelo menos 3 letras")</script>';
	} elseif ($data < date('Y-m-d')) {
		echo '<script>alert("A data não pode ser anterior a hoje")</script>';
	} else {
		$stmt = $conn->prepare('INSERT INTO eventos (nome, descricao, data_evento) VALUE (?,?,?)');
		$stmt->bind_param('sss', $nome, $descricao, $data);
		$result = $stmt->execute();

		if ($result) {
			echo '<script>alert("cadastro concluido");</script>';
		} else {
			echo '<script>alert("erro ao cadastrar");</script>';
		}
	}
}
?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<title>Cadastro</title>
</head>
<body>
	<header>
		<h1>Página de cadastro</h1>
	</header>
	<main>
		<form method="POST">
			<input type="text" name="nome" placeholder="Nome">
			<br>
			<textarea name="descricao" placeholder="Descricão"></textarea>
			<br>
			<input type="date" name="data" placeholder="Data">
			<br>
			<button type="submit">Enviar</button>
		</form>
	</main>
	<footer>
		
	</footer>
</body>