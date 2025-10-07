<?php
require_once __DIR__ . '/../../components/config/conexao.php';
require_once __DIR__ . '/../../components/lib/tcpdf/tcpdf.php';

// 1. Consulta: top 10 clientes por quantidade comprada
$sqlTotais = "SELECT 
                c.id_cliente,
                c.nome AS cliente,
                SUM(v.qnt_itens) AS total_compras
              FROM tb_vendas v
              INNER JOIN tb_clientes c ON v.id_cliente = c.id_cliente
              GROUP BY c.id_cliente, c.nome
              ORDER BY total_compras DESC
              LIMIT 10";

$stmt1 = $pdo->prepare($sqlTotais);
$stmt1->execute();
$clientes = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// 2. Consulta: detalhes das compras por cliente
$sqlDetalhes = "SELECT 
                  v.id_cliente,
                  p.nm_produto AS produto,
                  v.qnt_itens,
                  v.vlr_total,
                  v.data_venda
                FROM tb_vendas v
                INNER JOIN tb_produto p ON v.id_produto = p.cod_produto
                WHERE v.status_venda = 'finalizada'
                ORDER BY v.id_cliente, v.data_venda DESC";

$stmt2 = $pdo->prepare($sqlDetalhes);
$stmt2->execute();
$detalhes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Agrupar detalhes por cliente
$detalhesPorCliente = [];
foreach ($detalhes as $linha) {
    $detalhesPorCliente[$linha['id_cliente']][] = $linha;
}

// Criar PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = '<h1>Top 10 Clientes que Mais Compraram</h1>';
$html .= '<p>Data de geração: ' . date('d/m/Y H:i') . '</p><hr><br>';

foreach ($clientes as $cliente) {
    $id = $cliente['id_cliente'];
    $html .= '<h2>Cliente: ' . htmlspecialchars($cliente['cliente']) . '</h2>';
    $html .= '<p>Total de itens comprados: <b>' . $cliente['total_compras'] . '</b></p>';

    // Detalhamento das compras
    if (isset($detalhesPorCliente[$id])) {
        $html .= '<table border="1" cellpadding="4" cellspacing="0">
                    <thead>
                        <tr style="background-color:#f0f0f0;">
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Total</th>
                            <th>Data da Venda</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($detalhesPorCliente[$id] as $venda) {
            $data = date('d/m/Y', strtotime($venda['data_venda']));
            $html .= '<tr>
                        <td>' . htmlspecialchars($venda['produto']) . '</td>
                        <td align="center">' . $venda['qnt_itens'] . '</td>
                        <td align="right">R$ ' . number_format($venda['vlr_total'], 2, ',', '.') . '</td>
                        <td>' . $data . '</td>
                      </tr>';
        }

        $html .= '</tbody></table><br><br>';
    } else {
        $html .= '<p><i>Sem compras registradas.</i></p><br>';
    }
}

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('relatorio_clientes_detalhado.pdf', 'I');
