<?php 
require_once __DIR__ . '/../../components/templates/header.php';

// Buscar vendedores
$sqlVendedores = "SELECT cod_vendedor, nm_nome FROM tb_vendedor";
$resultVendedores = $pdo->query($sqlVendedores);

// Buscar clientes
$sqlClientes = "SELECT id_cliente, nome FROM tb_clientes";
$resultClientes = $pdo->query($sqlClientes);

// Buscar produtos
$sqlProdutos = "SELECT cod_produto, nm_produto, nr_preco FROM tb_produto";
$resultProdutos = $pdo->query($sqlProdutos);
?>


<div class="container mt-3">
  <div class="form-venda">
    <h2 class="text-center mb-4">
      <i class="bi bi-cart-plus"></i> Registrar Venda
    </h2>

    <form id="formVenda" method="POST">
      
      <!-- Dados do Vendedor -->
      <div class="mb-3">
        <label for="vendedor" class="form-label">Vendedor</label>
        <select class="form-control" id="vendedor" name="vendedor" required>
          <option value="">Selecione um vendedor</option>
          <?php
          $vendedores = $resultVendedores ->fetchAll(PDO::FETCH_ASSOC);
          foreach ($vendedores as $vendedor) {
            echo "<option value='{$vendedor['cod_vendedor']}'>{$vendedor['nm_nome']}</option>";
          }
          ?>
        </select>
      </div>

      <!-- Dados do Cliente -->
      <div class="mb-3">
        <label for="cliente" class="form-label">Cliente</label>
        <select class="form-control" id="cliente" name="cliente" required>
          <option value="">Selecione um cliente</option>
          <?php
          $clientes = $resultClientes -> fetchAll(PDO::FETCH_ASSOC);
          foreach ($clientes as $cliente) {
            echo "<option value='{$cliente['id_cliente']}'>{$cliente['nome']}</option>";
          }
          
          ?>
        </select>
      </div>

      <!-- Dados do Produto -->
      <div class="mb-3">
        <label for="produto" class="form-label">Produto</label>
        <select class="form-control" id="produto" name="produto" required>
          <option value="">Selecione um produto</option>
          <?php
          $produtos = $resultProdutos ->fetchAll(PDO::FETCH_ASSOC);
          foreach ($produtos as $produto) {
            echo "<option value='{$produto['cod_produto']}' data-preco='{$produto['nr_preco']}'>{$produto['nm_produto']} (R$ " . number_format($produto['nr_preco'], 2, ',', '.') . ")</option>";
          }
          ?>
        </select>
      </div>

      <!-- Quantidade e Valor Total -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="quantidade" class="form-label">Quantidade</label>
          <input type="number" class="form-control input--bg" id="quantidade" name="quantidade" min="1" value="1" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="vlr_total" class="form-label">Valor Total</label>
          <input type="text" class="form-control input--bg" id="vlr_total" name="vlr_total" readonly>
        </div>
      </div>

      <!-- Campos ocultos para processamento -->
      <input type="hidden" id="preco_unitario" name="preco_unitario">
      <input type="hidden" name="qnt_itens" id="qnt_itens" value="1">

      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-save"></i> Registrar Venda
      </button>
      <div id="message" class="alert mt-3" display:none;"></div>
    </form>
  </div>
</div>

<script src="<?= BASE_URL ?>components/js/enviardados.js"></script>
<script src="<?= BASE_URL ?>components/js/vendas.js"></script>