<?php 
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

	$stmt = $conn->prepare('INSERT INTO usuarios (nome, email, senha) VALUE (?,?,?)');
	$stmt->bind_param('sss', $nome, $email, $senhaHash);
	$stmt->execute();
}

$filtro = $_GET['filtro'] ?? '';

if($filtro != '') {
	$pesquisa = '%'. $filtro .'%';

	$stmt1 = $conn->prepare('SELECT id, nome, email FROM usuarios WHERE nome LIKE ? OR email LIKE ?');
	$stmt1->bind_param('ss',$pesquisa,$pesquisa);

} else {
	$stmt1 = $conn->prepare('SELECT id, nome, email FROM usuarios');

}

$stmt1->execute();
$result = $stmt1->get_result();
?>
	
		<DOCTYPE HTML>
			<head>
				<meta charset="utf-8">
				<title>Filtragem de dados</title>
			</head>
			<body>
				<div>
					<form action='php.php' method="GET">
						<input type="text" name="filtro">
						<br>
						<button type="submit">Filtrar</button>
						<a href="php.php">Limpar Filtro</a>
					</form>
				</div>
				<div>
					<form action="php.php" method="POST">
						<input type="text" name="nome">
						<br>
						<input type="email" name="email">
						<br>
						<input type="password" name="senha">
						<br>
						<button type="submit">Enviar</button>
					</form>
				</div>
				<div>
					<table>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>Email</th>
						</tr>
						<?php 
						if ($result->num_rows > 0) {

						while($user = $result->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $user['id'];?></td>
							<td><?php echo $user['nome'];?></td>
							<td><?php echo $user['email'];?></td>
						</tr>
						<?php
						} }else {
							?> 
							<tr>
								<td colspan="3">N/A</td>
							</tr>
							<?php
						}
						?>
					</table>
				</div>
			</body>