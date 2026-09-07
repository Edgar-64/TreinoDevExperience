//inicio.php
<?php 
session_start();
require 'conexao.php';

if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
	exit;
}

$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];
?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<title>Inicio</title>
</head>
<body>
	<header>
		<h1>Página inicial</h1>
		<p></p>
	</header>
	<main>
			<?php if ($tipo == 'admin'):?>
				<a href="cadastrar.php">Cadastrar Eventos</a>
				<br>
				<a href="eventos.php">Ver Eventos</a>
			<?php else: ?>
				<a href="eventos.php">Ver Eventos</a>
			<?php endif; ?>
	</main>
	<footer>
		
	</footer>
</body>