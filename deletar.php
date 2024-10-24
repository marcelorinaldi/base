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

// Verificar se o usuário existe
$sql_verificar = "SELECT nome FROM usuario WHERE id = $id";
$result = $conn->query($sql_verificar);

if ($result->num_rows > 0) {
    // Deletar o usuário
    $sql = "DELETE FROM usuario WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Inserir uma mensagem na tabela "mensagem"
        $usuario = $result->fetch_assoc();
        $nome_usuario = $usuario['nome'];
        $mensagem = "Usuário ID $id ($nome_usuario) deletado.";
        $sql_mensagem = "INSERT INTO mensagem (mensagem) VALUES ('$mensagem')";
        $conn->query($sql_mensagem);

        // Redirecionar de volta para o relatório
        header("Location: relatorio.php");
    } else {
        echo "Erro ao deletar o usuário: " . $conn->error;
    }
} else {
    echo "Usuário não encontrado.";
}

$conn->close();
