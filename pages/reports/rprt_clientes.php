<?php
require_once __DIR__ . '/../../components/config/conexao.php';
$sql = "SELECT c.nome, SUM(v.qnt_itens) AS total_compras
        FROM tb_vendas v
        INNER JOIN tb_clientes c ON v.id_cliente = c.id_cliente
        GROUP BY c.nome
        ORDER BY total_compras DESC
        LIMIT 10";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nomes = [];
$quantidades = [];

foreach ($resultado as $row) {
    $nomes[] = $row['nome'];
    $quantidades[] = $row['total_compras'];
}
?>

<!-- Container com visual bonito -->
<div class="card-grafico">
    <h4 class="text-center mb-4">🛍️ Clientes que mais compraram</h4>
    <canvas id="graficoClientes" width="400" height="400"></canvas>
    <form method="post" action="reports/export_pdf_clientes.php" target="_blank">
      <button type="submit">Exportar para PDF</button>
    </form>
</div>

<script>
  window.dadosGraficos = window.dadosGraficos || {};
  window.dadosGraficos['clientes'] = {
    labels: <?= json_encode($nomes) ?>,
    valores: <?= json_encode($quantidades) ?>,
    titulo: 'Top 10 Clientes que mais compraram',
    label: 'Total de Itens Comprados'
  };
</script>
<script>
  carregarGrafico('clientes');
</script>
