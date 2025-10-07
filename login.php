<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Autenticação de usuário</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="components/js/config.js.php"></script>
    <script src="components/js/login-ajax.js"></script>
  </head>
  <body>
    <div class="container">
      <h2>Autenticação de usuários</h2>
      <form id="loginForm" method="POST">
        <label for="nm_login">Login</label>
        <input type="text" id="nm_login" name="nm_login" required />

        <label for="ds_password">Senha</label>
        <input type="password" id="ds_password" name="ds_password" required />

        <button type="submit" class="btn btn-primary">Entrar</button>

        <br />
        <br />
        <p>
          Não possui conta ?
          <a href="pages/register.php">Cadastre-se aqui</a>
        </p>

        <div id="message" style="display: none; margin-top: 10px"></div>
      </form>
    </div>
  </body>
</html>
