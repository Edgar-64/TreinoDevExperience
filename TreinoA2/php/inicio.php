<?php
session_start();
require "conexao.php";

$id = $_SESSION['id'];

$nome = $conn->prepare('SELECT nome, email, senha FROM usuarios WHERE id = ? Limit 1');
$nome->bind_param('i', $id);
$nome->execute();

$resultnome = $nome->get_result();

if ($resultnome->num_rows == 1) {
    $usernome = $resultnome->fetch_assoc();


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <header>
            <h1>Dev Experience - Inicio</h1>
            <a href="evento.php">Eventos</a>
            <a href="perfil.php">Perfil</a>
            <a href="reservar.php">Reservas</a>
            <p>Olá, <?php echo $usernome['nome']; ?></p>
        </header>
        <main>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
                <?php
                $lista = $conn->prepare('SELECT id, nome, email, senha FROM usuarios');
                $lista->execute();

                $resultLista = $lista->get_result();

                if ($resultLista->num_rows > 0) {
                    while ($userLista = $resultLista->fetch_assoc()) {


                        ?>
                        <tr>
                            <td><?php echo $userLista['id'] ?> </td>
                            <td><?php echo $userLista['nome'] ?></td>
                            <td><?php echo $userLista['email'] ?></td>
                            <td><a href="reservar.php">Reservar</a></td>
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

    </html>
    <?php
}
?>