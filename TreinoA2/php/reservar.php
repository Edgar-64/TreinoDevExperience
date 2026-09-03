<?php
session_start();
require "conexao.php";

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $evento = $_POST['evento'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    $reserva = $conn->prepare('INSERT INTO reservar (nome, datareserva, localreserva, horareserva) VALUE (?,?,?,?)');
    $reserva->bind_param('ssss', $nome, $data, $local, $hora);
    $result = $reserva->execute();
}
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
        <h1>Dev Experience - reservas</h1>
        <a href="reserva.php">reservas</a>
        <a href="perfil.php">Perfil</a>
        <a href="reservar.php" class="selected">Reservas</a>
    </header>
    <main>
        <table>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Data</th>
                <th>Local</th>
                <th>Hora</th>
            </tr>
            <?php
            $ListaE = $conn->prepare('SELECT id, nome, datareserva, localreserva, horareserva FROM reservas');
            $ListaE->execute();

            $resultListaE = $ListaE->get_result();

            if ($resultListaE->num_rows > 0) {
                while ($userListaE = $resultListaE->fetch_assoc()) {

                    ?>
                    <tr>
                        <td><?php echo $userListaE['id'] ?></td>
                        <td><?php echo $userListaE['nome'] ?></td>
                        <td><?php echo $userListaE['datareserva'] ?></td>
                        <td><?php echo $userListaE['localreserva'] ?></td>
                        <td><?php echo $userListaE['horareserva'] ?></td>
                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr>
                    <td colspan="5">Nenhum reserva encontrado.</td>
                </tr>

                <?php
            }

            ?>
        </table>
        <br>
        <form action="reserva.php" method="post">
            <input type="text" name="nome" placeholder="nome">
            <br>
            <input type="email" name="email" placeholder="email">
            <br>
            <input type="text" name="evento" placeholder="evento">
            <br>
            <input type="date" name="data">
            <br>
            <input type="time" name="hora">
            <br>
            <button type="submit">Registrar</button>
        </form>
    </main>
    <footer>

    </footer>
</body>

</html>
<?php

?>