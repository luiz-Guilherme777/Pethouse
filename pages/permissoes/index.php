<?php require_once __DIR__ . '/../../components/templates/header.php'; ?>
<div class="container">
    <div id="msgPermissao" 
        style="display:none; position: fixed; top: 20px; right: 20px; min-width: 250px; padding: 10px 20px; 
                background-color: #198754; color: white; border-radius: 5px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); 
                z-index: 1050; font-weight: 600; font-family: Arial, sans-serif;">
    </div>
    <h4 class="mt-3 mb-3"><i class="bi bi-person-lock"></i>Gerenciar Permissões</h4>

    <div class="mb-3 d-flex flex-column align-items-center">
        <input type="text" class="form-control" id="filtro" placeholder="Buscar usuário por nome, login ou email" style="max-width: 900px;" />
        <button id="btnBuscar" class="btn btn-primary mt-0 mb-4" style="max-width: 800px;">Buscar</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Permissão</th>
                </tr>
            </thead>
            <tbody id="listaUsuarios">
                <!-- Conteúdo carregado via AJAX -->
            </tbody>
        </table>
    </div>
    <nav>
        <ul class="pagination" id="paginacao"></ul>
    </nav>
</div>

<script>

(() => {
    let paginaAtual = 1;

    function carregarUsuarios(pagina = 1) {
        const filtro = $('#filtro').val();
        $.get('<?= BASE_URL ?>pages/permissoes/listar.php', { filtro, pagina }, function(data) {
            $('#listaUsuarios').html(data.tabela);
            let pagHTML = '';
            for(let i = 1; i <= data.totalPaginas; i++) {
                pagHTML += 
                `<li class="page-item ${i === pagina ? 'active' : ''}">
                    <a class="page-link btnPagina" href="#" data-pagina="${i}">${i}</a>
                </li>`;
            }
            $('#paginacao').html(pagHTML);
            
        });
    }

    function mostrarMensagem(mensagem, tipo = 'success') {
    const $msg = $('#msgPermissao');

    let bgColor = '#198754';
    if (tipo === 'error') bgColor = '#dc3545';
    else if (tipo === 'warning') bgColor = '#ffc107';

    $msg
    .text(mensagem)
    .css({ 'background-color': bgColor })
    .fadeIn(300);

    setTimeout(() => {
        $msg.fadeOut(300);
    }, 3000);
};

    $(document).on('click', '.btnPagina', function(e) {
        e.preventDefault();
        paginaAtual = +$(this).data('pagina');
        carregarUsuarios(paginaAtual);
    });

    $('#btnBuscar').click(function() {
        carregarUsuarios(1);
    });

    $(document).on('change', '.select-permissao', function() {
        const id = $(this).data('id');
        const permissao = $(this).val();

        $.post('<?= BASE_URL ?>pages/permissoes/atualizar.php', { id, permissao }, function(res) {
            mostrarMensagem(res.message, res.success ? 'success' : 'error');
        }, 'json');
    });

    carregarUsuarios();
}) ();
</script>