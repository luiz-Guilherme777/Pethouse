<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de usuário</title>
    <link rel="stylesheet" href="../css/style.css" />
    <?php require_once __DIR__ . '/../components/templates/header.php';?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?= BASE_URL?>components/js/register-ajax.js"></script>
  </head>
  <body>
    <div class="container">
      <h2>Cadastro de Usuário</h2>
      <form id="registerForm" method="POST">
        <label for="nm_nome">Nome completo</label>
        <input type="text" id="nm_nome" name="nm_nome" required />
       
        <label for="nm_login">Nome de usuário</label>
        <input type="text" id="nm_login" name="nm_login" required />
       
        <label for="ds_email">Email</label>
        <input type="email" id="ds_email" name="ds_email" required />

        <label for="ds_password">Senha</label>
        <input type="password" id="ds_password" name="ds_password" required />
        
        <label for="ds_password">Confirmar Senha</label>
        <input type="password" id="ds_password_confirm" name="ds_password_confirm" required />

        <button type="submit" class="btn btn-primary">Cadastrar</button>

        <br/ >
        <br/ >
        <p>Já possui conta ? 
            <a href="../login.php">Realize o seu login aqui</a>
        </p>
        <div id="message" style="display: none; margin-top: 10px"></div>
      </form>
    </div>
  </body>
</html>
