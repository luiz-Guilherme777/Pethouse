<!-- clientes.html ou clientes.php (parte interna apenas) -->
<?php require_once __DIR__ . '/../../components/templates/header.php'; ?>
<div class="container">
    <h2>Cadastro de Clientes</h2>
    <form id="formCadastro"  method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" require>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <div class="checkbox">
            <input type="checkbox" id="estado_civil" name="estado_civil">
            <label for="estado_civil">Casado(a)?</label>
        </div>

        <button type="submit">Confirmar</button>
        <!-- Div para mensagens -->
        <div id="message" style="display:none;"></div>
    </form>
    <script src="<?= BASE_URL ?>components/js/enviardados.js"></script>
</div>
