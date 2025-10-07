
<?php

$success = true;
$message = 'Cliente cadastrado com sucesso!';

// Suponha que você conecte e insira os dados corretamente aqui...
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nome = $_POST["nome"] ?? '';
        $endereco = $_POST["endereco"] ?? '';
        $telefone = $_POST["telefone"] ?? '';
        $email = $_POST["email"] ?? '';
        $estado_civil = isset($_POST["estado_civil"]) ? "C" : "S";

        // Validação
        if (empty($nome) || empty($endereco) || empty($telefone) || empty($email)) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        $sql = "INSERT INTO tb_clientes (nome, endereco, telefone, email, estado_civil)
                VALUES (:nome, :endereco, :telefone, :email, :estado_civil)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':estado_civil', $estado_civil);
        $stmt->execute();
        
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
      
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Método não permitido."]);
}
exit;

