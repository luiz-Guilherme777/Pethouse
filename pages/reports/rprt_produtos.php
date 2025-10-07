<?php 
require_once __DIR__ . '/../../components/config/conexao.php';

$sql = "SELECT p.nm_produto, SUM(v.qnt_itens) AS total_vendido
        FROM tb_vendas v
        INNER JOIN tb_produto p ON v.id_produto = p.cod_produto
        GROUP BY p.nm_produto
        ORDER BY total_vendido DESC
        LIMIT 10"; // Top 10 produtos

$stmt = $pdo->prepare($sql);
$stmt-> execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Separar os dados para o gráfico
$nomes = [];
$quantidades = [];

foreach ($resultado as $row) {
    $nomes[] = $row['nm_produto'];
    $quantidades[] = $row['total_vendido'];
}

?>

<div class="card-grafico">
  <h4 class="text-center mb-3">📦 Produtos Mais Vendidos</h4>
  <canvas id="graficoProdutos" width="400" height="400"></canvas>
  <form method="post" action="reports/export_pdf_produtos.php" target="_blank">
    <button type="submit">Exportar para PDF</button>
  </form>
</div>
<!-- Dados para o gráfico -->
<script>
  window.dadosGraficos = window.dadosGraficos || {};
  window.dadosGraficos['produtos'] = {
    labels: <?= json_encode($nomes) ?>,
    valores: <?= json_encode($quantidades) ?>,
    titulo: "Top 10 Produtos Mais Vendidos",
    label: "Quantidade Vendida"
  };
</script>
<script>
  carregarGrafico('produtos');
</script>
