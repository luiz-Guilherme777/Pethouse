$(document).ready(function () {
  $("#formCadUsuario").on("submit", function (e) {
    e.preventDefault();

    // Usar FormData para envio de arquivos (foto)
    var formData = new FormData(this);

    $.ajax({
      url:
        window.BASE_URL +
        "components/functions/inserts/insert-update-usuarios.php", // caminho correto do PHP
      type: "POST",
      data: formData,
      dataType: "json",
      processData: false, // necessário para FormData
      contentType: false, // necessário para FormData
      success: function (response) {
        if (response.success) {
          $("#message")
            .removeClass("error")
            .addClass("success")
            .text(response.message)
            .fadeIn()
            .delay(3000)
            .fadeOut();
          $("#formCadUsuario")[0].reset();
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
        console.log("Erro AJAX:", xhr.responseText, status, error);
        $("#message")
          .removeClass("success")
          .addClass("error")
          .text("Erro ao processar a requisição!")
          .fadeIn()
          .delay(3000)
          .fadeOut();
      },
    });
  });
});
