<?php

require_once __DIR__ . "/../../components/config/conexao.php";

header("Content-Type: application/json");

$filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 6; 
$offset = ($pagina - 1) * $limite;

// Consulta base com filtro

$sqlBase = "FROM tb_vendas v 
INNER JOIN tb_clientes c ON v.id_cliente = c.id_cliente
INNER JOIN tb_produto p ON v.id_produto = p.cod_produto
INNER JOIN tb_vendedor ve ON v.id_vendedor = ve.cod_vendedor
WHERE c.nome LIKE :filtro OR p.nm_produto LIKE :filtro OR ve.nm_nome LIKE :filtro
";

// Conta total

$stmtTotal = $pdo->prepare("SELECT COUNT(*) $sqlBase");
$stmtTotal->execute([':filtro' => "%$filtro%"]);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $limite);

// Busca paginada
$stmt = $pdo->prepare("SELECT
    v.qnt_itens,
    v.vlr_total,
    c.nome AS nomeCliente,
    p.nm_produto AS nomeProduto,
    ve.nm_nome AS nomeVendedor
    $sqlBase
    ORDER BY v.data_venda DESC
    LIMIT :limite OFFSET :offset");

$stmt->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gera HTML das linhas

$html = '';

foreach($vendas as $v) {
    $html .= "
    <tr>
    <td>" . htmlspecialchars($v["nomeCliente"]). "</td>
    <td>" . htmlspecialchars($v["nomeProduto"]). "</td>
    <td>" . htmlspecialchars($v["nomeVendedor"]). "</td>
    <td>" . htmlspecialchars($v["qnt_itens"]). "</td>
    <td>R$ " . number_format($v["vlr_total"], 2, ',', '.'). "</td>
    </tr>";
}

echo json_encode([
    'tabela' => $html,
    'totalPaginas' => $totalPaginas
]);