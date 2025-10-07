<?php 
require_once __DIR__ . '/../../components/config/conexao.php';


// Consulta: Top 10 vendedores com mais vendas finalizadas
$sql = "SELECT vdr.nm_nome AS nome_vendedor, COUNT(vnd.id_venda) AS total_vendas
        FROM tb_vendas vnd
        INNER JOIN tb_vendedor vdr ON vnd.id_vendedor = vdr.cod_vendedor
        WHERE vnd.status_venda = 'finalizada'
        GROUP BY vdr.nm_nome
        ORDER BY total_vendas DESC
        LIMIT 10";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Preparar arrays para JS
$nomes = [];
$quantidades = [];

foreach ($resultado as $row) {
    $nomes[] = $row['nome_vendedor'];
    $quantidades[] = $row['total_vendas'];
}
?>

<div class="card-grafico">
  <h4 class="text-center mb-3">👨‍💼 Vendedores com Mais Vendas</h4>
  <canvas id="graficoVendedores" width="400" height="400"></canvas>
  <form method="post" action="reports/export_pdf_vendedores.php" target="_blank">
    <button type="submit">Exportar para PDF</button>
  </form>
</div>
<!-- Dados para o gráfico -->
<script>
  window.dadosGraficos = window.dadosGraficos || {};
  window.dadosGraficos['vendedores'] = {
    labels: <?= json_encode($nomes) ?>,
    valores: <?= json_encode($quantidades) ?>,
    titulo: 'Top 10 Vendedores com Mais Vendas',
    label: 'Total de Vendas Realizadas'
  };
</script>

<script>
  carregarGrafico('vendedores');
</script>
