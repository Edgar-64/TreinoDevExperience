<?php
session_start();
require "conexao.php";

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['Nome'];
    $data = $_POST['Data'];
    $local = $_POST['Local'];
    $hora = $_POST['Hora'];

    $evento = $conn->prepare('INSERT INTO eventos (nome, dataEvento, localEvento, horaEvento) VALUE (?,?,?,?)');
    $evento->bind_param('ssss', $nome, $data, $local, $hora);
    $result = $evento->execute();
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
        <h1>Dev Experience - Eventos</h1>
        <a href="evento.php" class="selected">Eventos</a>
        <a href="perfil.php">Perfil</a>
        <a href="reservar.php">Reservas</a>
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
            $ListaE = $conn->prepare('SELECT id, nome, dataEvento, localEvento, horaEvento FROM eventos');
            $ListaE->execute();

            $resultListaE = $ListaE->get_result();

            if ($resultListaE->num_rows > 0) {
                while ($userListaE = $resultListaE->fetch_assoc()) {

                    ?>
                    <tr>
                        <td><?php echo $userListaE['id'] ?></td>
                        <td><?php echo $userListaE['nome'] ?></td>
                        <td><?php echo $userListaE['dataEvento'] ?></td>
                        <td><?php echo $userListaE['localEvento'] ?></td>
                        <td><?php echo $userListaE['horaEvento'] ?></td>
                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr>
                    <td colspan="5">Nenhum evento encontrado.</td>
                </tr>

                <?php
            }

            ?>
        </table>
        <br>
        <form action="evento.php" method="post">
            <input type="text" name="Nome" placeholder="nome">
            <br>
            <input type="date" name="Data" placeholder="data">
            <br>
            <input type="text" name="Local" placeholder="local">
            <br>
            <input type="time" name="Hora" placeholder="hora">
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