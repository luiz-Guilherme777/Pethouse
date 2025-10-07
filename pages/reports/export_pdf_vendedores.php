<?php
require_once __DIR__ . '/../../components/config/conexao.php';
require_once __DIR__ . '/../../components/lib/tcpdf/tcpdf.php';

// Passo 1: buscar total de vendas por vendedor
$sqlTotais = "SELECT 
                vdr.cod_vendedor,
                vdr.nm_nome AS nome_vendedor,
                COUNT(vnd.id_venda) AS total_vendas
              FROM tb_vendas vnd
              INNER JOIN tb_vendedor vdr ON vnd.id_vendedor = vdr.cod_vendedor
              WHERE vnd.status_venda = 'finalizada'
              GROUP BY vdr.cod_vendedor, vdr.nm_nome
              ORDER BY total_vendas DESC";

$stmt1 = $pdo->prepare($sqlTotais);
$stmt1->execute();
$vendedores = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// Passo 2: buscar detalhes dos produtos por vendedor
$sqlDetalhes = "SELECT 
                    vdr.cod_vendedor,
                    p.nm_produto,
                    vnd.data_venda
                FROM tb_vendas vnd
                INNER JOIN tb_vendedor vdr ON vnd.id_vendedor = vdr.cod_vendedor
                INNER JOIN tb_produto p ON vnd.id_produto = p.cod_produto
                WHERE vnd.status_venda = 'finalizada'
                ORDER BY vdr.cod_vendedor, vnd.data_venda DESC";

$stmt2 = $pdo->prepare($sqlDetalhes);
$stmt2->execute();
$detalhes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Organiza detalhes por vendedor
$detalhesPorVendedor = [];
foreach ($detalhes as $d) {
    $detalhesPorVendedor[$d['cod_vendedor']][] = $d;
}

// Cria PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Cabeçalho
$html = '<h1>Relatório de Vendas Finalizadas</h1>';
$html .= '<p>Data de geração: ' . date('d/m/Y ') . '</p><hr><br>';

// Loop dos vendedores
foreach ($vendedores as $v) {
    $id = $v['cod_vendedor'];
    $html .= '<h2>Vendedor: ' . htmlspecialchars($v['nome_vendedor']) . '</h2>';
    $html .= '<p>Total de vendas finalizadas: <b>' . $v['total_vendas'] . '</b></p>';

    // Tabela de produtos vendidos
    if (isset($detalhesPorVendedor[$id])) {
        $html .= '<table border="1" cellpadding="4">
                    <thead>
                        <tr style="background-color:#f0f0f0;">
                            <th>Produto</th>
                            <th>Data da Venda</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($detalhesPorVendedor[$id] as $linha) {
            $data = date('d/m/Y', strtotime($linha['data_venda']));
            $html .= '<tr>
                        <td>' . htmlspecialchars($linha['nm_produto']) . '</td>
                        <td>' . $data . '</td>
                      </tr>';
        }

        $html .= '</tbody></table><br><br>';
    } else {
        $html .= '<p><i>Sem vendas registradas.</i></p><br>';
    }
}

// Escreve no PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('relatorio_vendas_por_vendedor.pdf', 'I');
