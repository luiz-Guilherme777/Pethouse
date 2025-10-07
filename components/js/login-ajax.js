$(document).ready(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: window.BASE_URL + "components/functions/valida_login.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $("#message")
            .removeClass("error")
            .addClass("success")
            .text("Login realizado com sucesso!")
            .fadeIn();

          // Redireciona após x segundos
          setTimeout(() => {
            window.location.href =
              response.redirect || window.BASE_URL + "pages/painel.php";
          }, 1000);
        } else {
          $("#message")
            .removeClass("success")
            .addClass("error")
            .text(response.message)
            .fadeIn()
            .delay(3000)
            .fadeOut();
        }
      },
      error: function (xhr, status, error) {
        console.log("Erro AJAX", xhr.responseText, status, error);
        $("#message")
          .removeClass("success")
          .addClass("error")
          .text("Erro ao processar login.")
          .fadeIn()
          .delay(3000)
          .fadeOut();
      },
    });
  });
});
