<?php
class Database {
    private $host = "localhost";
    private $db_name = "base";
    private $username = "root"; // ou seu usuário do MySQL
    private $password = "q1w2e3"; // sua senha do MySQL
    public $conn;

    // Conectar ao banco de dados
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

class Usuario {
    private $conn;
    private $table_name = "usuario";

    public $id;
    public $nome;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para criar um novo usuário
    public function criarUsuario() {
        $query = "INSERT INTO " . $this->table_name . " (nome) VALUES (:nome)";
        $stmt = $this->conn->prepare($query);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $stmt->bindParam(":nome", $this->nome);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para listar todos os usuários
    public function listarUsuarios() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

class Mensagem {
    private $conn;
    private $table_name = "mensagem";

    public $id;
    public $mensagem;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar uma mensagem
    public function registrarMensagem() {
        $query = "INSERT INTO " . $this->table_name . " (mensagem) VALUES (:mensagem)";
        $stmt = $this->conn->prepare($query);
        $this->mensagem = htmlspecialchars(strip_tags($this->mensagem));
        $stmt->bindParam(":mensagem", $this->mensagem);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

// Inicializar conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];

    if (!empty($nome)) {
        // Criar um novo objeto Usuario e Mensagem
        $usuario = new Usuario($db);
        $mensagem = new Mensagem($db);

        // Atribuir o nome ao objeto Usuario
        $usuario->nome = $nome;

        // Inserir o usuário e registrar a mensagem
        if ($usuario->criarUsuario()) {
            $mensagem->mensagem = "Novo usuário cadastrado: $nome";
            if ($mensagem->registrarMensagem()) {
                echo "Usuário cadastrado e mensagem registrada com sucesso!";
            } else {
                echo "Erro ao registrar a mensagem.";
            }
        } else {
            echo "Erro ao cadastrar o usuário.";
        }
    } else {
        echo "Por favor, preencha o nome.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <div class="container"> <!-- Tag <div> corrigida -->
        <h2>Cadastro de Usuário</h2>

        <!-- Formulário de Cadastro -->
        <form action="cadastrar.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>
            <input type="submit" value="Cadastrar">
        </form>

        <!-- Botão para Relatório de Usuários Cadastrados -->
        <br>
        <form action="relatorio.php" method="get">
            <button type="submit" class="btn">Ver Relatório de Usuários Cadastrados</button>
        </form> <!-- Tag <form> foi fechada corretamente agora -->

        <?php
        // Exibe a mensagem de sucesso ou erro
        if (isset($mensagem)) {
            echo "<div class='message " . ($mensagem_sucesso ? 'success' : 'error') . "'>$mensagem</div>";
        }
        ?>
    </div>
</body>
</html>


