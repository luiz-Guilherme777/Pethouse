<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../components/config/config.php';
require_once __DIR__ . '/../../components/config/conexao.php';

$filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 6;
$offset = ($pagina - 1) * $limite;

$sqlBase = "FROM usuarios WHERE nm_nome LIKE :filtro OR nm_login LIKE :filtro OR ds_email LIKE :filtro";

$stmtTotal = $pdo->prepare("SELECT COUNT(*) $sqlBase");
$stmtTotal->execute([':filtro' => "%$filtro%"]);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $limite);

$stmt = $pdo->prepare("
    SELECT id, nm_nome, nm_login, ds_email, tipo_usuario, foto_perfil
    $sqlBase
    ORDER BY nm_nome ASC
    LIMIT :limite OFFSET :offset
");

$stmt->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = '';

foreach ($usuarios as $u) {
    $perfil = htmlspecialchars($u['nm_nome']);
    $login = htmlspecialchars($u['nm_login']);
    $email = htmlspecialchars($u['ds_email']);
    $foto = $u['foto_perfil'] ? htmlspecialchars($u['foto_perfil']) : 'sem-foto.jpg';
    $tipo = htmlspecialchars($u['tipo_usuario']);
    $fotoCaminho = BASE_URL . "assets/uploads/{$foto}";

    $html .= "
    <tr>
        <td><img src='{$fotoCaminho}' alt='Foto perfil' style='width:40px; height:40px; border-radius:50%; object-fit:cover; margin-right:10px; vertical-align:middle;'> {$perfil}</td>
        <td>{$login}</td>
        <td>{$email}</td>
        <td>
            <select data-id='{$u['id']}' class='select-permissao form-select form-select-sm'>
                <option value='vendedor' " . ($tipo === 'vendedor' ? 'selected' : '') . ">Vendedor</option>
                <option value='admin' " . ($tipo === 'admin' ? 'selected' : '') . ">Admin</option>
            </select>
        </td>
    </tr>";
}

echo json_encode([
    'tabela' => $html,
    'totalPaginas' => $totalPaginas
]);
