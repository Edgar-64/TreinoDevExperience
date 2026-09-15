<?php
session_start();
require 'conexao.php';

//autenticação de login
if (!isset($_SESSION['id'])) {
    header("Location: index.html");
    exit();
}

//identificação das informações do usuário
$id = $_SESSION['id'];
$tipo = $_SESSION['tipo'];

//pesquisa da lista
$stmt = $conn->prepare("SELECT * FROM eventos");
$stmt->execute();
$result = $stmt->get_result();

//pesquisa do tipo do usuario
$stmt1 = $conn->prepare("SELECT tipo FROM usuarios WHERE id = ?");
$stmt1->bind_param('i', $id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$usuario = $result1->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
</head>

<body>
    <header>
        <h1>Página Inicial</h1>
        <a href="logout.php">Sair</a>
    </header>
    <main>
        <div>
            <!-- Corrigido o ID para bater com o JavaScript -->
            <input type="text" name="filtro" id="pesquisa" placeholder="Pesquisar evento...">
        </div>
        <h2>Lista de Eventos</h2>
        <table id="listaEvento" border="1">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Local</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Vagas disponíveis</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($evento = $result->fetch_assoc()): ?>
                        <tr class="linha-evento">
                            <td><?php echo htmlspecialchars($evento['nomeEvento']); ?></td>
                            <td><?php echo htmlspecialchars($evento['descricao']); ?></td>
                            <td><?php echo htmlspecialchars($evento['local']); ?></td>
                            <td><?php echo htmlspecialchars($evento['dataEvento']); ?></td>
                            <td><?php echo htmlspecialchars($evento['horaEvento']); ?></td>
                            <td><?php echo htmlspecialchars($evento['capacidade']); ?></td>
                            <td>
                                <a href="excluir.php?idEvento=<?php echo $evento['id']; ?>">Excluir</a>
                                <a href="editar.php?idEvento=<?php echo $evento['id']; ?>">Editar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Nenhum Evento listado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if ($tipo == 'admin'): ?>
            <br>
            <a href="cadEvento.php">Cadastrar Eventos</a>
        <?php endif ?>
    </main>
    <footer></footer>

    <script>
        const pesquisa = document.getElementById("pesquisa");
        // Seleciona todas as linhas de dados da tabela (exceto o cabeçalho)
        const linhas = document.querySelectorAll("#listaEvento .linha-evento");

        pesquisa.addEventListener("input", function() {
            const texto = pesquisa.value.toLowerCase();

            linhas.forEach(function(linha) {
                // Pega o texto da coluna do nome do evento (primeira coluna)
                const nomeEvento = linha.querySelector("td").textContent.toLowerCase();

                if (nomeEvento.includes(texto)) {
                    linha.style.display = ""; // Mostra a linha
                } else {
                    linha.style.display = "none"; // Oculta a linha
                }
            });
        });
    </script>
</body>

</html>