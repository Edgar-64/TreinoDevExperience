<?php

require 'conexao.php';

$busca = 'Resenha';

$stmt = $conn->prepare('
    SELECT id, nome, descricao, data_evento
    FROM eventos
    WHERE nome LIKE ?
');

$termo = "%$busca%";

$stmt->bind_param('s', $termo);
$stmt->execute();

$result = $stmt->get_result();

$eventos = [];

while ($evento = $result->fetch_assoc()) {
    $eventos[] = $evento;
}

header('Content-Type: application/json');

echo json_encode($eventos);

?>
