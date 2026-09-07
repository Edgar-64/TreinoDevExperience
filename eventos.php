//eventos.php
<?php 
require 'conexao.php';

$stmt = $conn->prepare('
	SELECT 
		eventos.id,
		eventos.nome,
		eventos.descricao,
		eventos.data_evento,
		usuarios.nome AS dono
	FROM eventos
	INNER JOIN usuarios 
	ON eventos.usuario_id = usuarios.id');
$stmt->execute();

$result = $stmt->get_result();
?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<title>Página de Lista</title>
</head>
<body>
	<header>
		<h1>Página de Listagem</h1>
	</header>
	<main>
		<table>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Descrição</th>
				<th>Data do Evento</th>
				<th>Dono</th>
				<th>Ações</th>
			</tr>
		<?php 
			if ($result->num_rows > 0) {
				while ($evento = $result->fetch_assoc()) {
					?> 
						<tr>
							<td><?php echo $evento['id'];?></td>
							<td><?php echo $evento['nome'];?></td>
							<td><?php echo $evento['descricao'];?></td>
							<td><?php echo $evento['data_evento'];?></td>
							<td><?php echo $evento['dono'];?></td>
							<td>
								<a href="editar.php?id=<?php echo $evento['id'];?>">Editar</a>
								<br>
								<a href="excluir.php?id=<?php echo $evento['id'];?>">Excluir</a>
							</td>
						</tr>
					<?php
				}
			}
		?>
		</table>
	</main>
	<footer>
		
	</footer>
</body>
