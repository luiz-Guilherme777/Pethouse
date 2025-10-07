<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {

        // Calcula o valor total
        $preco = $_POST['preco_unitario']; // Você precisará adicionar este campo oculto
        $quantidade = $_POST['quantidade'];
        $vlr_total = $preco * $quantidade;

        // Dados da venda
        
        $vendedor = $_POST ["vendedor"] ?? "";
        $cliente = $_POST ["cliente"] ?? "";
        $produto = $_POST ["produto"] ?? "";
        $vlr_total = $vlr_total ?? "";
        $qnt_itens = $quantidade ?? "";

        // Insere na tabela tb_vendas
        $sql = "INSERT INTO tb_vendas 
           (data_venda, vlr_total, qnt_itens, status_venda, id_vendedor, id_cliente, id_produto) 
           VALUES 
           (NOW(), :vlr_total, :qnt_itens, 'finalizada', :id_vendedor, :id_cliente, :id_produto)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_vendedor', $vendedor);
        $stmt->bindParam(':id_cliente', $cliente);
        $stmt->bindParam(':id_produto', $produto);
        $stmt->bindParam(':vlr_total', $vlr_total);
        $stmt->bindParam(':qnt_itens', $qnt_itens);
        $stmt->execute();        

        echo json_encode([
            'success' => true,
            'message' => 'Venda registrada com sucesso!'
        ]);
      
    } catch (PDOException $e) {
            echo json_encode([
            'success' => false,
            'message' => 'Erro ao registrar venda: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método não permitido'
    ]);
}
?>