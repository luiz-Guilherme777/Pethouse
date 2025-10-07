<?php
require_once __DIR__ . '/../../components/config/conexao.php';
require_once __DIR__ . '/../../components/lib/tcpdf/tcpdf.php';

// 1. Consulta: total de vendas por produto (Top 10)
$sqlTotais = "SELECT 
                p.cod_produto,
                p.nm_produto,
                SUM(v.qnt_itens) AS total_vendido
              FROM tb_vendas v
              INNER JOIN tb_produto p ON v.id_produto = p.cod_produto
              GROUP BY p.cod_produto, p.nm_produto
              ORDER BY total_vendido DESC
              LIMIT 10";

$stmt1 = $pdo->prepare($sqlTotais);
$stmt1->execute();
$produtos = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// 2. Consulta: datas de vendas por produto
$sqlDetalhes = "SELECT 
                  v.id_produto,
                  v.data_venda,
                  v.qnt_itens
                FROM tb_vendas v
                WHERE v.status_venda = 'finalizada'
                ORDER BY v.id_produto, v.data_venda DESC";

$stmt2 = $pdo->prepare($sqlDetalhes);
$stmt2->execute();
$detalhes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Organiza vendas por produto
$detalhesPorProduto = [];
foreach ($detalhes as $d) {
    $detalhesPorProduto[$d['id_produto']][] = $d;
}

// Gera o PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = '<h1>Top 10 Produtos Mais Vendidos</h1>';
$html .= '<p>Data de geração: ' . date('d/m/Y ') . '</p><hr><br>';

// Loop dos produtos
foreach ($produtos as $produto) {
    $id = $produto['cod_produto'];
    $html .= '<h2>Produto: ' . htmlspecialchars($produto['nm_produto']) . '</h2>';
    $html .= '<p>Total vendido: <b>' . $produto['total_vendido'] . '</b></p>';

    // Vendas detalhadas
    if (isset($detalhesPorProduto[$id])) {
        $html .= '<table border="1" cellpadding="4">
                    <thead>
                        <tr style="background-color:#f0f0f0;">
                            <th>Data da Venda</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($detalhesPorProduto[$id] as $venda) {
            $data = date('d/m/Y', strtotime($venda['data_venda']));
            $html .= '<tr>
                        <td>' . $data . '</td>
                        <td align="right">' . $venda['qnt_itens'] . '</td>
                      </tr>';
        }

        $html .= '</tbody></table><br><br>';
    } else {
        $html .= '<p><i>Sem vendas registradas.</i></p><br>';
    }
}

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('relatorio_top_produtos_detalhado.pdf', 'I');
