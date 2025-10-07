<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pet House</title>

  <?php require_once __DIR__ . '/../components/templates/header.php'; ?>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style-painel.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">

  <!-- Font Awesome icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <!-- Links Js -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

  <!-- Gráfico -->
  <script src="<?= BASE_URL?>components/js/graficos.js"></script>
</head>
<body>

<!-- Barra superior -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <button class="btn btn-outline-secondary d-lg-none" id="menu-toggle">
      <i class="bi bi-list"></i>
    </button>
    <div class="ms-auto dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-person-circle"></i> <?php echo $_SESSION["nm_login"]; ?>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalCadastroUsuario">
            <i class="bi bi-person me-2"></i> Editar Perfil
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger" href="../components/functions/logout.php">
            <i class="bi bi-box-arrow-right me-2"></i>  Sair
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Menu Lateral -->
<div id="sidebar">
    <div class="text-center fw-bold py-3">
    <i class="fa-solid fa-paw"></i> <a class="home submenu" href="#" data-page="painel">PetHouse</a>
    </div>
  <nav class="nav flex-column">

    <?php if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>

      <!-- Menu Admnistrador -->
    <a class="nav-link d-flex justify-content-between align-items-center" 
    data-bs-toggle="collapse" href="#cadastros" role="button" 
    aria-expanded="false" aria-controls="cadastros">
     <span><i class="bi bi-folder"></i> Cadastros</span>
      <i class="bi bi-chevron-down"></i>
    </a>
    <div class="collapse" id="cadastros">
      <a href="#" class="nav-link submenu" data-page="formularios/clientes">Clientes
      <i class="bi bi-person-fill-add"></i>
      </a>
      <a href="#" class="nav-link submenu" data-page="formularios/vendedores">Vendedores
      <i class="bi bi-person-fill-add"></i>
      </a>
      <a href="#" class="nav-link submenu" data-page="formularios/produtos">Produtos
      <i class="bi bi-file-earmark-plus-fill"></i>
      </a>
    </div>

    <!-- Menu Vendas -->
    <a class="nav-link d-flex justify-content-between align-items-center" 
    data-bs-toggle="collapse" href="#movimentacoes" role="button"
    aria-expanded="false" aria-controls="movimentacao">
     <span><i class="bi-cart"></i> Movimentações</span>
      <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse" id="movimentacoes">
      <a href="#" class="nav-link submenu" data-page="formularios/vendas">
        <span><i class="bi bi-plus-circle me-2"></i> Vendas</span>
      </a>
      <a href="#" class="nav-link submenu" data-page="historico-vendas">
        <span><i class="bi bi-clock-history me-2"></i> Histórico de vendas</span>
      </a>
    </div>

    <!-- Menu Relatórios -->
    <a class="nav-link d-flex justify-content-between align-items-center" 
    data-bs-toggle="collapse" href="#relatorios" role="button" 
    aria-expanded="false" aria-controls="relatorios">
    
      <span><i class="bi bi-graph-up"></i> Relatórios</span>
        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse" id="relatorios">
      <a href="#" class="nav-link submenu" data-page="reports/rprt_clientes">
        <span><i class="bi bi-file-earmark-person"></i> Clientes</span>
      </a>
      <a href="#" class="nav-link submenu" data-page="reports/rprt_vendedores">
        <span><i class="bi bi-file-earmark-person"></i> Vendedores</span>
      </a>
      <a href="#" class="nav-link submenu" data-page="reports/rprt_produtos">
        <span><i class="fa-solid fa-chart-simple"></i></i> Produtos</span>
      </a> 
    </div>

    <a class="nav-link d-flex justify-content-between align-items-center" 
    data-bs-toggle="collapse" href="#administracao" role="button" 
    aria-expanded="false" aria-controls="administracao">
    <span><i class="bi bi-person-gear"></i>Administração</span>
      <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse" id="administracao">
      <a href="#" class="nav-link submenu" data-page="formularios/usuarios">
        <span><i class="fa-regular fa-user"></i> Usuários</span>
      </a>
      <a href="#" class="nav-link submenu" data-page="permissoes/index">
        <span><i class="bi bi-person-lock"></i> Permissões</span>
      </a>
    </div>

    <!-- Menu Para os Vendedores -->
    <?php elseif ($_SESSION['tipo_usuario'] === 'vendedor'): ?>
      <a class="nav-link d-flex justify-content-between align-items-center" 
      data-bs-toggle="collapse" href="#cadastros" role="button" 
      aria-expanded="false" aria-controls="cadastros">     
  <span><i class="bi bi-folder"></i> Cadstros</span>
  <i class="bi bi-chevron-down"></i>
</a>
<div class="collapse" id="cadastros">
  <a href="#" class="nav-link submenu" data-page="formularios/clientes">
    <span><i class="bi bi-person-fill-add"></i> Clientes</span>
  </a>
  <a href="#" class="nav-link submenu" data-page="formularios/produtos">
    <span><i class="bi bi-file-earmark-plus-fill"></i> Produtos</span>
  </a>
</div>

<a class="nav-link d-flex justify-content-between align-items-center" 
data-bs-toggle="collapse" href="#movimentacoes" role="button" 
aria-expanded="false" aria-controls="movimentacoes">
<span><i class="bi bi-cart"></i>Movimentações</span>
<i class="bi bi-chevron-down"></i>
</a>

<div class="collapse" id="movimentacoes">
  <a href="#" class="nav-link submenu" data-page="formularios/vendas">
    <span><i class="bi bi-plus-circle me-2"></i> Vendas</span>
  </a>
  <a href="#" class="nav-link submenu" data-page="historico-vendas">
    <span><i class="bi bi-clock-history me-2"></i> Histórico de vendas</span>
  </a>
</div>

<!-- Menu para outros tipos de usuários (Atualizações Futuras) -->
<!-- ?php else: ?>
  <a class="nav-link d-flex justify-content-between align-items-center" 
   data-bs-toggle="collapse" href="#compras" role="button" 
   aria-expanded="flase" aria-controls="compras">
   <span><i class="bi bi-cart"></i> Minhas Compras</span>
   <i class="bi bi-chevron-down"></i>
  </a>
  <div class="collapse" id="compras">
    <a href="#" class="nav-link submenu" data-page="vendas">
      <span><i class="bi bi-bag-plus-fill"></i> Comprar Produtos</span>
    </a>
    <a href="#" class="nav-link submenu" data-page="meus-pedidos">
      <span><i class="bi bi-receipt me-2"></i> Meus Pedidos</span>
    </a>
  </div> -->
  <?php endif; ?> 

  </nav> 
</div>
<!-- Conteúdo principal -->
<div id="main" class ="container mt-5 justify-content">
  <div class="text-center mb-4"> 
  <h1 class="display-5">Olá, <?php echo $_SESSION["nm_nome"]; ?>! <i class="fa-solid fa-shield-dog"></i></h1> 
  <p class="lead">Seja bem-vindo(a) ao painel da <strong>PetHouse</strong>.</p>
  <p class="text-muted">Você está logado como <strong><?= ucfirst($_SESSION['tipo_usuario']) ?></strong>.</p>
  </div>

  <!-- Cards Dashboard -->
   <div class="row g-4 justify-content text-center">
    <!-- Clientes -->
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 p-3">
        <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
        <h5>Clientes</h5>
        <p class="display-6 fw-bold">x</p>
      </div>
    </div>
    <!-- Vendedores -->
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 p-3">
        <i class="fa-solid fa-user-tie fa-2x text-primary mb-2"></i>
        <h5>Vendedores</h5>
        <p class="display-6 fw-bold">y</p>
      </div>
    </div>
    <!-- Produtos -->
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 p-3">  
        <i class="fa-solid fa-box fa-2x text-warning mb-2"></i>
        <h5>Produtos</h5>
        <p class="display-6 fw-bold">z</p>
      </div>
   </div>
   <!-- Vendas -->
   <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 p-3">
        <i class="fa-solid fa-cart-shopping fa-2x text-danger mb-2"></i>
        <h5>Vendas</h5>
        <p class="display-6 fw-bold">*</p>
      </div>
   </div>
</div>
  
<!-- Gráfico -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
          <h5 class="card-title text-center mb-4">Resumo das Vendas</h5>
          <canvas id="chartVendas"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const ctx = document.getElementById('chartVendas').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
      datasets: [{
        label: 'Vendas',
        data: [5, 12, 8, 20, 15, 25],
        borderColor: '#0d6efd',
        tension: 0.4,
        fill: true,
        backgroundColor: 'rgba(13,110,253,0.2)'
      }]
    }
  });
</script>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  document.addEventListener('DOMContentLoader', function () {
    const toggleButton = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    
    if (toggleButton && sidebar) {
      toggleButton.addEventListener('click', function () {
        sidebar.classList.toggle('show');
      })
    }
  })

  // toggleButton.addEventListener('click', () => {
  //   sidebar.classList.toggle('show');
  // });
</script>

<script src="<?= BASE_URL ?>components/js/script.js"></script>
<script src="<?= BASE_URL ?>components/js/enviardados.js"></script>
<script src="<?= BASE_URL ?>components/js/alterarDadosUsuario.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>



<div class="modal fade" id="modalCadastroUsuario" tabindex="-1" aria-labelledby="modalCadastroUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content width-modal">
      <form id="formCadUsuario" enctype="multipart/form-data">
        
        <div class="modal-header">
          <h5 class="modal-title" id="modalConfiguracoesLabel">Dados do Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labell="Fechar"></button>
        </div>

        <div class="modal-body">
          <!-- Nome e login na mesma linha -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="nm_nome" class="form-label">Nome</label>
              <input type="text" class="form-control input--bg" id="nm_nome" name="nm_nome" value="<?php echo $_SESSION['nm_nome'] ?? ''; ?>">
            </div>
            <div class="col-md-6">
              <label for="nm_login" class="form-label">Login</label>
              <input type="text" class="form-control input--bg" id="nm_login" name="nm_login" value="<?php echo $_SESSION['nm_login'] ?? ''; ?>">
            </div>
          </div>

          <!-- Email -->
           <div class="mb-3">
            <label for="ds_email" class="form-label">Email</label>
            <input type="text" class="form-control input--bg" id="ds_email" name="ds_email" value="<?php echo $_SESSION['ds_email'] ?? ''; ?>">
           </div>

           <!-- Senha -->
            <div class="mb-3">
              <label for="ds_password" class="form-label">Nova Senha</label>
              <input type="password" class="form-control input--bg" id="ds_password" name="senha" value="<?php echo $_SESSION['ds_password'] ?? ''; ?>">
            </div>

            <!-- Foto de perfil (Imagem ao lado do input file) -->
          <div class="mb-3 d-flex align-items-center gap-3">
            <!-- Input de arquivo -->
            <div>
              <label for="foto_perfil" class="form-label">Foto de Perfil</label>
              <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" accept="image/*">
            </div>

            <div id="preview-container">
              <?php if(!empty($_SESSION['foto_perfil']) && isset($_SESSION['foto_perfil'])): ?>
                <img src="../assets/uploads/<?php echo $_SESSION['foto_perfil']; ?>" alt="Foto de Perfil"
                width="150" height="150"
                style="object-fit: cover; border-radius: 8px;">
                <?php endif; ?>
            </div>
          </div>
          
          <!-- Checkbox Administrador (Somente admins podem alterar) -->
          <?php if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>
                <div class="form-check mb-3">
                    <input type="checkbox" type="checkbox"class="form-check-input" id="tipo_admin" name="tipo_admin" <?php echo ($_SESSION['tipo_usuario'] === 'admin') ? 'checked' : ''; ?>>
                    <label for="tipo_admin" class="form-check-label">Administrador</label>
                </div>
            <?php endif; ?>
        </div>
        
          

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Editar dados</button>
        </div>
      </form>

    </div>
  </div>
</div>

</body>
</html>

<script>
  document.getElementById('foto_perfil').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (!file) return;

    const preview = document.createElement('img');
    preview.width = 240;

    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;

      const container = document.getElementById('preview-container');
      container.innerHTML = '';
      container.appendChild(preview);
    };
    reader.readAsDataURL(file);
  });
</script>
