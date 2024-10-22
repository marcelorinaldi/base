<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "q1w2e3";
$dbname = "base";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro de conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter o ID do usuário a ser deletado
$id = $_GET['id'];

// Deletar o usuário
$sql = "DELETE FROM usuario WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Inserir uma mensagem na tabela "mensagem"
    $mensagem = "Usuário ID $id deletado.";
    $sql_mensagem = "INSERT INTO mensagem (mensagem) VALUES ('$mensagem')";
    $conn->query($sql_mensagem);

    // Redirecionar de volta para o relatório
    header("Location: relatorio.php");
} else {
    echo "Erro ao deletar o usuário: " . $conn->error;
}

$conn->close();
?>
