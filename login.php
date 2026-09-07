//login.php
<?php 
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$stmt = $conn->prepare('SELECT id, nome, email, senha, tipo FROM usuarios WHERE email = ?');
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$result = $stmt->get_result();

		if ($result->num_rows == 1) {
		$user = $result->fetch_assoc();
			if (password_verify($senha, $user['senha'])) {
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['nome'] = $user['nome'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['tipo'] = $user['tipo'];
				echo '<script> alert("Autorização concedida");
				window.location.href = "inicio.php";</script>';
			} else {
				echo '<script> alert("Login incorreto")';
			}
		} else {
			echo 'email ou senha incorretos'
		}
}
?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body>
	<header>
		<h1>Página de login</h1>
	</header>
	<main>
		<form method="POST">
			<input type="email" name="email" placeholder="Email">
			<br>
			<input type="password" name="senha" placeholder="Senha">
			<br>
			<button type="submit">Enviar</button>
		</form>
	</main>
	<footer>
		
	</footer>
</body>