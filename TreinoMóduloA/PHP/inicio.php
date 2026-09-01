<?php
session_start();

require('conexao.php');

if (!isset($_SESSION['id'])) {
    header('Location: ../HTML/login.html');
    exit;
}

$id = $_SESSION['id'];

$stmt = $conn->prepare('SELECT nome FROM usuarios WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio</title>
        <link rel="stylesheet" href="../CSS/style.css">
    </head>

    <body>

        <header>
            <h1>Bem-Vindo, <?php echo $user['nome']; ?></h1>
            <h2>Aqui é a página inicial</h2>
            <button><a href="../HTML/eventos.html">Eventos</a></button>
        </header>

        <main>

            <h3>Lista de Usuários</h3>

            <form action="inicio.php" method="post">
                <input type="text" name="filtro">
                <button type="submit">Pesquisar</button>
                <a href="inicio.php">Limpar</a>
            </form>

            <table>

                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>

                <?php

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $filtro = $_POST['filtro'];

                    $stmt2 = $conn->prepare(
                        'SELECT nome, email FROM usuarios WHERE nome = ?'
                    );

                    $stmt2->bind_param('s', $filtro);
                    $stmt2->execute();

                    $result2 = $stmt2->get_result();

                    if ($result2->num_rows > 0) {

                        while ($users = $result2->fetch_assoc()) {
                            ?>

                            <tr>
                                <td><?php echo $users['nome']; ?></td>
                                <td><?php echo $users['email']; ?></td>
                            </tr>

                            <?php
                        }

                    } else {
                        ?>

                        <tr>
                            <td colspan="2">Nenhum usuário encontrado.</td>
                        </tr>

                        <?php
                    }

                    $stmt2->close();

                } else {

                    $stmt1 = $conn->prepare(
                        'SELECT nome, email FROM usuarios'
                    );

                    $stmt1->execute();

                    $result1 = $stmt1->get_result();

                    while ($users = $result1->fetch_assoc()) {
                        ?>

                        <tr>
                            <td><?php echo $users['nome']; ?></td>
                            <td><?php echo $users['email']; ?></td>
                        </tr>

                        <?php
                    }

                    $stmt1->close();
                }

                ?>

            </table>

        </main>

        <footer>
            <p>&copy; Todos os Direitos reservados</p>
        </footer>

    </body>

    </html>

    <?php
}

$stmt->close();
$conn->close();
?>