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

// Obter o ID do usuário a ser editado
$id = $_GET['id'];

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = $_POST['nome'];
    $nova_idade = $_POST['idade'];
    $novo_sexo = $_POST['sexo'];

    // Atualizar os dados do usuário
    $sql = "UPDATE usuario SET nome = '$novo_nome', idade = '$nova_idade', sexo = '$novo_sexo' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Inserir uma mensagem na tabela "mensagem"
        $mensagem = "Usuário ID $id atualizado.";
        $sql_mensagem = "INSERT INTO mensagem (mensagem) VALUES ('$mensagem')";
        $conn->query($sql_mensagem);

        // Redirecionar para o relatório
        header("Location: relatorio.php");
    } else {
        echo "Erro ao atualizar o usuário: " . $conn->error;
    }
} else {
    // Obter os dados atuais do usuário
    $sql = "SELECT nome, idade, sexo FROM usuario WHERE id = $id";
    $result = $conn->query($sql);
    $usuario = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <div class="container">
        <h2>Editar Usuário</h2>

        <!-- Formulário de Edição -->
        <form action="editar.php?id=<?php echo $id; ?>" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required><br><br>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" value="<?php echo $usuario['idade']; ?>" required><br><br>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M" <?php echo ($usuario['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                <option value="F" <?php echo ($usuario['sexo'] == 'F') ? 'selected' : ''; ?>>Feminino</option>
            </select><br><br>

            <input type="submit" value="Salvar">
        </form>

        <!-- Botão "Voltar" para relatorio.php -->
        <br>
        <form action="relatorio.php" method="get">
            <button type="submit" class="btn">Voltar</button>
        </form>
    </div>
</body>

</html>