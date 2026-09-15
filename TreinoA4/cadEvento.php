<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $local = $_POST['local'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $npart = $_POST['nParticipantes'];

    $stmt = $conn->prepare('INSERT INTO eventos (nomeEvento, descricao, local, dataEvento, horaEvento, capacidade) VALUES (?,?,?,?,?,?)');
    $stmt->bind_param("sssssi", $nome, $descricao, $local, $data, $hora, $npart);
    $result = $stmt->execute();

    if ($result) {
        echo '<script> alert("Registrado"); 
        window.location.href = "inicio.php"; </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Eventos</title>
</head>

<body>
    <header>
        <h1>Cadastro de Eventos</h1>
    </header>
    <main>

        <div class="cadst">
            <form id="evento" action="cadEvento.php" method="POST">
                <input type="text" name="nome" id="nome" required>
                <br>
                <textarea id="descricao" maxlength="200"></textarea>

                <p>
                    Caracteres:
                    <span id="contador">0</span>/200
                </p>
                <br>
                <input type="text" name="local" id="local">
                <br>
                <input type="date" name="data" id="data">
                <br>
                <input type="time" name="hora" id="hora">
                <br>
                <input type="number" name="nParticipantes" id="nParticipantes">
                <br>
                <button type="submit">Registrar</button>
            </form>
        </div>
    </main>
    <footer>

    </footer>
    <script>
        const descricao = document.getElementById("descricao");
        const contador = document.getElementById("contador");

        descricao.addEventListener("input", function () {

            contador.textContent = descricao.value.length;

        });
    </script>
</body>

</html>