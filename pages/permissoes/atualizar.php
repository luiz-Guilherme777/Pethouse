<?php 
require_once __DIR__ . '/../../components/config/config.php';
require_once __DIR__ . "/../../components/config/conexao.php";

$id = $_POST['id'] ?? '';
$tipo_usuario = $_POST['permissao'] ?? '';

$tipos_validos = ['vendedor', 'admin'];
if (!($id) || !in_array($tipo_usuario, $tipos_validos)) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

$atualizou = ("UPDATE usuarios SET tipo_usuario =:tipo_usuario WHERE id = :id");
$stmt = $pdo->prepare($atualizou);
$stmt->bindParam(':tipo_usuario', $tipo_usuario);
$stmt->bindParam(':id', $id);

$atualizar = $stmt->execute();

if ($atualizar) {
    echo json_encode(['success' => true, 'message' => 'Permissão atualizada com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar permissão']);
}
?>