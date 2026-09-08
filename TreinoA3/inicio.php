<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];
$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];

//filtro
$filtro = $_GET['filtro'] ?? '';

if ($filtro != '') {
    $stmt = $conn->prepare(
        'SELECT 
            eventos.id,
            eventos.nome AS nomeEvento,
            eventos.dataEvento,
            eventos.localEvento,
            eventos.horaEvento,
            eventos.owner,
            usuarios.nome AS nome_user

        FROM eventos

        LEFT JOIN usuarios 
        ON eventos.owner = usuarios.id

        WHERE eventos.nome LIKE ?
        OR eventos.localEvento LIKE ?

        ORDER BY eventos.id ASC'
    );
    $stmt->bind_param('ss', $filtro, $filtro);
} else {
    $stmt = $conn->prepare(
        'SELECT 
        eventos.id,
        eventos.nome AS nomeEvento,
        eventos.dataEvento,
        eventos.localEvento,
        eventos.horaEvento,
        eventos.owner,
        usuarios.nome AS nome_user
    FROM eventos
    LEFT JOIN usuarios 
    ON eventos.owner = usuarios.id
    ORDER BY eventos.id ASC'
    );
    if (!$stmt) {
        die("Erro SQL: " . $conn->error);
    }
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>

<body>
    <header>
        <h1>Painel</h1>
        <p>Olá, <?php echo $nome; ?></p>
        <a href="perfil.php">Perfil</a>
        <a href="logout.php">Sair</a>
    </header>
    <main>
        <form action="inicio.php" method="get">
            <input type="text" name="filtro">
            <br>
            <button type="submit">Filtrar</button>
            <button><a href="inicio.php">Limpar</a></button>
        </form>
        <div class="lista">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Horário</th>
                    <th>Status</th>
                    <th>Dono</th>
                    <?php if ($tipo == 'admin'): ?>
                        <th>Ações</th>
                    <?php else: ?>

                    <?php endif ?>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($user = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['nomeEvento']; ?></td>
                            <td><?php echo $user['dataEvento']; ?></td>
                            <td><?php echo $user['localEvento']; ?></td>
                            <td><?php echo $user['horaEvento']; ?></td>
                            <?php if ($user['owner'] == 0): ?>
                                <td><a href="reservar.php?idEvento=<?php echo $user['id']; ?>">Reservar</a></td>
                            <?php else: ?>
                                <td>Já Reservado</td>
                            <?php endif ?>

                            <?php if ($user['nome_user'] != null): ?>
                                <td><?php echo $user['nome_user']; ?></td>
                            <?php else: ?>
                                <td>Livre</td>
                            <?php endif ?>

                            <?php if ($tipo == 'admin'): ?>
                                <td>
                                    <a href="editar.php?=idEvento=<?php echo $user['id']; ?>">Editar</a>
                                    <a href="excluir.php?=idEvento=<?php echo $user['id']; ?>">Excluir</a>
                                </td>
                                
                            <?php else: ?>

                            <?php endif ?>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
        <?php if ($tipo == 'admin'): ?>
            <form action="cadEvento.php" method="post">
                <input type="text" name="nome" placeholder="Nome">
                <br>
                <input type="date" name="data">
                <br>
                <input type="text" name="local" placeholder="Local">
                <br>
                <input type="time" name="hora">
                <br>
                <button type="submit">Enviar</button>
            </form>
        <?php else: ?>

        <?php endif ?>
    </main>
    <footer>

    </footer>
</body>

</html>