<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$idU = $_SESSION['id'];
$nomeU = $_SESSION['nome'];
$emailU = $_SESSION['email'];
$tipoU = $_SESSION['tipo'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $stmt = $conn->prepare('UPDATE usuarios SET nome = ?, email = ? WHERE nome = ?');
    $stmt->bind_param('sss',$nome, $email, $nomeU);
    $result = $stmt->execute();

    if ($result) {
        // 1. ATUALIZA A SESSÃO COM OS NOVOS VALORES
        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;

        // 2. ATUALIZA AS VARIÁVEIS LOCAIS PARA EXIBIR CORRETAMENTE NA PÁGINA ATUAL
        $nomeU = $nome;
        $emailU = $email;

        echo "<script>alert('Atualizado');</script>";
    }
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>

<body>
    <header>
        <h1>Perfil</h1>
        <a href="logout.php">Sair</a>
    </header>
    <main>
        <div class="perfil">
            <h3><?php echo $nomeU ?></h3>
            <p><?php echo $emailU ?></p>
            <p><?php echo $tipoU ?></p>
        </div>
        <form action="perfil.php" method="post">
            <input type="text" name="nome" value="<?php echo $nomeU ?>">
            <br>
            <input type="email" name="email" value="<?php echo $emailU ?>">
            <br>
            <button type="submit">Mudar</button>
        </form>
    </main>
    <footer>

    </footer>
</body>

</html>