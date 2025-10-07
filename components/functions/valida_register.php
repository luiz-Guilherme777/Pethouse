<?php 
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

// Recebe os dados da requisição

$nome = trim($_POST['nm_nome'] ?? "");
$login = trim($_POST['nm_login'] ?? "");
$email = trim($_POST['ds_email'] ?? "");
$senha = $_POST['ds_password'] ?? "";
$senha_confirm = $_POST['ds_password_confirm'] ?? "";

if (!$nome || !$login || !$email || !$senha || !$senha_confirm) {
    echo json_encode(['success' => false, 'message' => "Todos os campos são obrigatórios"]);
    exit;
}

if ($senha !== $senha_confirm) {
    echo json_encode(['success' => false, 'message' => "As senhas não coincidem."]);
    exit;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => "Email inválido"]);
    exit;
}

try{
    // Verifica se o login ou email já existe

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE nm_login = :login OR ds_email =:email");
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $exists = $stmt->fetchColumn();

    if($exists) {
        echo json_encode(["success" => false, 'message' => "Login ou email já cadastrados"]);
        exit;
    }
    
    // Insere o novo usuário

    $sql = "INSERT INTO usuarios 
    (nm_nome, nm_login, ds_email, ds_password, tipo_usuario)
    VALUES (:nome, :login, :email, :senha, 'vendedor')";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt ->execute();

    echo json_encode(["success" => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => "Erro no banco de dados: " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Erro inesperado: " . $e->getMessage()]);
}
?>