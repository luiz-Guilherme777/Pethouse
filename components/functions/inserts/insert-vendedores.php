<?php
header("Content-Type: application/json"); 
require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {  
        $nm_nome = $_POST["nm_nome"] ?? '';
        $nr_celular = $_POST["nr_celular"] ?? '';
        $ds_email = $_POST["ds_email"] ?? '';       

        // Validação do nome
        if (empty($nm_nome)) {
            throw new Exception("Nome não pode ser vazio.");
        }

        if(!isset($nr_celular) || !is_numeric($nr_celular)){
            throw new Exception("Digite um número de celular válido.");
        }

         if (empty($ds_email) || !filter_var($ds_email, FILTER_VALIDATE_EMAIL)){
             throw new Exception("Por favor, digite um email válido.");
        }
    

        // Inserção no banco de dados
        $sql = "INSERT INTO tb_vendedor (nm_nome, nr_celular, ds_email) 
                VALUES (:nm_nome, :nr_celular, :ds_email)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nm_nome', $nm_nome);
        $stmt->bindParam(':nr_celular', $nr_celular);
        $stmt->bindParam(':ds_email', $ds_email);
        $stmt->execute();

        
        // Retorno de sucesso
        echo json_encode(["success" => true, "message" => "Dados cadastrados com sucesso!"]);
    } catch (PDOException $e) {
        // Captura erro do banco e retorna JSON
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erro ao cadastrar: " . $e->getMessage()]);
    } catch (Exception $e) {
        // Captura erro geral e retorna JSON
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Erro no envio do formulário."]);
}
exit; // Garante que o script encerre corretamente