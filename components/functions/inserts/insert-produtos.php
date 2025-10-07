<?php
header("Content-Type: application/json"); 
require_once __DIR__ . "/../../config/conexao.php"; // Inclui a conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {  
        $nm_produto = $_POST["nm_produto"] ?? '';
        $cod_produto = $_POST["cod_produto"] ?? '';
        $ds_produto = $_POST["ds_produto"] ?? '';
        $nr_preco = $_POST["nr_preco"] ?? '';
        $quantidade = $_POST["quantidade"] ?? '';
        $tipo_embalagem = $_POST["tipo_embalagem"] ?? '';
        

        // Validação do nomex
        if (empty($nm_produto)) {
            throw new Exception("Nome não pode ser vazio.");
        }

        if(!isset($cod_produto) || !is_numeric($cod_produto)){
            throw new Exception("Digite um valor válido para o código do produto.");
        }

        if (!isset($tipo_embalagem)){
            throw new Exception("Selecione um tipo de embalagem.");
        }

        // Inserção no banco de dados
        $sql = "INSERT INTO tb_produto (cod_produto, nm_produto, nr_preco, ds_produto, quantidade ,tipo_embalagem) 
                VALUES (:cod_produto, :nm_produto, :nr_preco, :ds_produto, :quantidade, :tipo_embalagem)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cod_produto', $cod_produto);
        $stmt->bindParam(':nm_produto', $nm_produto);
        $stmt->bindParam(':nr_preco', $nr_preco);
        $stmt->bindParam(':ds_produto', $ds_produto);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':tipo_embalagem', $tipo_embalagem);
        $stmt->execute();

        
        // Retorno de sucesso
        echo json_encode(["success" => true, "message" => "Dados cadastrados com sucesso!"]);
    } catch (PDOException $e) {
        // Captura erro do banco e retorna JSON
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erro ao cadastrar: " . $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(400);
        // Captura erro geral e retorna JSON
        echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Erro no envio do formulário."]);
}
exit; // Garante que o script encerre corretamente