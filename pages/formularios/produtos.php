<?php require_once __DIR__ . '/../../components/templates/header.php'; ?>

<div class="container">
  <h2>Cadastro de Produtos</h2>
  <form id="formProduto" method="POST">
    <div class="row mb-3">
      <div class="col-md-4">
        <label for="id">Código:</label>
        <input type="text" id="id" name="cod_produto" required />
      </div>
      <div class="col-md-8">
        <label>Nome do Produto:</label>
        <input type="text" name="nm_produto" required />
      </div>
    </div>

    <div class="row mb-3">
    <div class="col-md-4">
        <label>Preço:</label>
        <input type="number" name="nr_preco" step="0.01" required />
      </div>
      <div class="col-md-4">
        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" min=0 required>
      </div>
      <div class="col-md-4">
        <label for="tipoEmbalagem">Embalagem:</label>
        <select name="tipo_embalagem" id="tipo_embalagem" required>
          <option value="">Selecione</option>
          <option value="caixa">Caixa</option>
          <option value="saco">Saco</option>
          <option value="frasco">Frasco</option>
          <option value="rolo">Rolo</option>
        </select>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-9 mb-3">
        <label for="ds_produto">Descrição do Produto:</label>
        <input type="text" id="ds_produto" name="ds_produto" required>
      </div>
      <button type="submit">Salvar Produto</button>
      <div id="message" style="display:none;"></div>
    </form>
    <script src="<?= BASE_URL ?>/components/js/enviardados.js"></script>
</div>