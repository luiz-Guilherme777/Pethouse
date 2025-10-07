<!-- Formulário de Vendedor -->
<?php require_once __DIR__ . '/../../components/templates/header.php'; ?>    

<div class="container">
    <form id="formVendedor" method="POST">

        <h3>Cadastro de Vendedores</h3>
        <label>Nome do Vendedor:</label>
        <input type="text" name="nm_nome" required />
        <br />
        <label>Número de Celular:</label>
        <input type="text" name="nr_celular" required />
        <br />
        <label>Email:</label>
        <input type="email" name="ds_email" required />
        <br />
        <button type="submit">Salvar Vendedor</button>
        <div id="message" style="display:none;"></div>
      </form>
      <script src="<?= BASE_URL ?>components/js/enviardados.js"></script>
</div>