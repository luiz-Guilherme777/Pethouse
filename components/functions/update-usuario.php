<?php 

require_once __DIR__ . '/../config/conexao.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? null ;
$nm_nome = $_POST['nm_nome'] ?? '';
$nm_login = $_POST['nm_login'] ?? '';
$ds_email = $_POST['ds_email'] ?? '';
$tipo_usuario = $_POST['tipo_usuario'] ?? 'usuario';

if (!$id) {
    echo json_encode(["erro" => "ID do usuário não informado"]);
    exit;
}

if (!in_array($tipo_usuario, ['vendedor', 'admin'])) {
    echo json_encode(["erro" => "Tipo de usuário inválido"]);
    exit;
}



$foto_nome = '';
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
    $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
    $foto_nome = uniqid() . "." . $ext;
    move_uploaded_file($_FILES['foto_perfil']['tmp_name'], "../assets/uploads/" . $foto_nome);
}

$update_query = "UPDATE usuarios SET
                nm_nome = '$nm_nome',
                nm_login = '$nm_login',
                ds_email = '$ds_email',
                tipo_usuario = $tipo_usuario";

    if (!empty($foto_nome)) {
        $update_query .= ", foto_perfil= '$foto_nome'";
    }
    $update_query .=" WHERE id= $id";
    if (mysqli_query($conn, $update_query)){
        echo json_encode(["sucesso" => true]);
    } else {
        echo json_encode(["erro" => mysqli_error($conn)]);
    }
?>