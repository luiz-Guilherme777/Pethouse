$(document).ready(function () {
  console.log("JavaScript carregado");

  $("#registerForm").on("submit", function (e) {
    e.preventDefault();
    console.log("Formulário interceptado");

    const senha = $("#ds_password").val();
    const confirma = $("#ds_password_confirm").val();

    if (senha !== confirma) {
      mostrarMensagem("As senhas não coincidem.", false);
      return;
    }

    $.ajax({
      url: "../components/functions/valida_register.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        console.log("Resposta recebida:", response);

        if (response.success) {
          mostrarMensagem(
            "Cadastro realizado com sucesso! Redirecionando para login...",
            true
          );
          $("#registerForm")[0].reset();

          setTimeout(() => {
            window.location.href = "/Pethouse/login.php";
          }, 2000);
        } else {
          mostrarMensagem(response.message || "Erro desconhecido.", false);
        }
      },
      error: function (xhr, status, error) {
        console.error("Erro AJAX:", xhr.responseText);
        mostrarMensagem("Erro ao processar o cadastro.", false);
      },
    });
  });

  function mostrarMensagem(texto, sucesso) {
    const $msg = $("#message");
    $msg
      .removeClass("success error")
      .addClass(sucesso ? "success" : "error")
      .text(texto)
      .fadeIn()
      .delay(3000)
      .fadeOut();
  }
});
