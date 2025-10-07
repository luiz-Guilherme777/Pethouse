<?php require_once __DIR__ . '/../../components/templates/header.php'; ?>
<div class="container">
    <h2>Cadastro de Usuários</h2>
    <form id="formCadUsuario" enctype="multipart/form-data">
        <div class="row mb-3">

            <!-- Nome e Usuário -->
            <div class="col-md-6">
                <label for="nm_nome" class="form-label">Nome</label>
                <input type="text" class="form-control input--bg" id="nm_nome" name="nm_nome">
            </div>

            <div class="col-md-6">
                <label for="nm_login" class="form-label">Login</label>
                <input type="text" class="form-control input--bg" id="nm_login" name="nm_login">
            </div>
        </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="ds_email" class="form-label">Email</label>
                <input type="text" class="form-control input--bg" id="ds_email" name="ds_email">
            </div>

            <!-- Senha -->
            <div class="mb-3">
                <label for="ds_password" class="form-label">Nova Senha</label>
                <input type="password" class="form-control input--bg" id="ds_password" name="ds_password">
            </div>

            <!-- Foto de Perfil (imagem ao lado do input file) -->
            <div class="mb-3 d-flex align-items-center gap-3">
                <!-- Input de arquivo (lado esquerdo) -->
                 <div>
                    <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                    <input type="file" class="form-control" id="foto_cadastro" name="foto_cadastro">
                 </div>

                 <!-- Imagem de pré-visualização (lado direito) -->
                 <div id="preview-container">
                    <?php if(!empty($_SESSION['foto_cadastro']) && isset ($_SESSION['foto_perfil'])): ?>
                        <img src="<?= BASE_URL ?>assets/uploads/<?php echo $_SESSION['foto_perfil']; ?>" alt="Foto de Cadastro"
                        
                        width="150" height="150"
                        style="object-fit: cover; border-radius: 8px;">
                    <?php endif; ?>
                 </div>
            </div>
            
            <!-- Tipo de usuário (Apenas admin podem alterar e ver esse campo) -->
            <?php if($_SESSION['tipo_usuario'] === 'admin' ): ?>
                <div class="mb-3">
                    <label for="tipo_usuario" class="form-label">Tipo de Usuário</label>
                    <select name="tipo_usuario" id="tipo_usuario" class="form-select">
                        <option value="vendedor">Vendedor</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
            <?php endif; ?>
                <button type="submit" class="btn btn-primary">Confirmar</button>
                <!-- Div para mensagens -->
                 <div id="message" style="display: none;"></div>
    </form>
    <script src="<?= BASE_URL ?>components/js/enviardados.js"></script>
</div>

<script>
    // Pré-visualização da imagem
    document.getElementById('foto_cadastro').addEventListener('change', function (event){
      const file = event.target.files[0];
      if(!file) return;

      const preview = document.createElement('img');
      preview.width = 140;

        //   preview.classList.add('rounded-circle', 'md-2');

      const reader = new FileReader();
      reader.onload = function(e){
        preview.src = e.target.result;

        // Remove pré-visualização anterior se houver

        const container = document.getElementById('preview-container')
        container.innerHTML = '';
        container.appendChild(preview);
    };
    reader.readAsDataURL(file);
    });
</script>