//editar.php
<?php 
require 'conexao.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$data = $_POST['data'];

	$stmt1 = $conn->prepare('UPDATE eventos SET nome = ?, descricao = ?, data_evento = ? WHERE id = ?');
	$stmt1->bind_param('sssi',$nome, $descricao, $data, $id);
	$result = $stmt1->execute();

	if ($result) {
		echo '<script>Evento alterado com sucesso</script>';
	} else {
		echo '<script>Erro ao atualizar</script>';
	}
}

$stmt= $conn->prepare('SELECT * FROM eventos WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();

$result = $stmt->get_result();
?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<title>Página de Editar Eventos</title>
</head>
<body>
	<header>
		<h1>Editar Eventos</h1>
	</header>
	<main>
		<form method="POST">
		<?php 
			if ($result->num_rows == 1) {
				$user = $result->fetch_assoc();
				?>
			<input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>">
			<br>
			<textarea name="descricao">
				<?php echo htmlspecialchars($user['descricao']); ?>
			</textarea>
			<br>
			<input type="date" name="data" value="<?php echo htmlspecialchars($user['data_evento']); ?>">
			<br>
		<?php
			}
		?>
			<button type="submit">Enviar</button>
		</form>
	</main>
	<footer>
		
	</footer>
</body>