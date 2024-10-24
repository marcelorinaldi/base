<?php
// Exibir erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "q1w2e3";
$dbname = "base"; // Substitua pelo nome correto do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro de conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para buscar os usuários cadastrados
$sql = "SELECT id, nome, idade, sexo FROM usuario";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Usuários Cadastrados</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <div class="container">
        <h2>Relatório de Usuários Cadastrados</h2>

        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nome</th><th>Idade</th><th>Sexo</th><th>Ações</th></tr>";
            // Exibe os dados de cada linha
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["nome"] . "</td>
                        <td>" . $row["idade"] . "</td>
                        <td>" . $row["sexo"] . "</td>
                        <td>
                            <a href='editar.php?id=" . $row["id"] . "' class='btn'>Editar</a>
                            <a href='deletar.php?id=" . $row["id"] . "' class='btn' onclick='return confirm(\"Tem certeza que deseja deletar este usuário?\")'>Deletar</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "Nenhum usuário cadastrado.";
        }

        // Fecha a conexão
        $conn->close();
        ?>

        <!-- Botão "Voltar" para cadastrar.php -->
        <br>
        <form action="cadastrar.php" method="get">
            <button type="submit" class="btn">Voltar</button>
        </form>
    </div>
</body>

</html>