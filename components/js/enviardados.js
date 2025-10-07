/**
 * Configura o tratamento AJAX para um formulário
 * @param {string} formSelector - Seletor do formulário (ex: "#formCadastro")
 * @param {string} endpoint - URL do script PHP (ex: "insert-clientes.php")
 * @param {string} messageSelector - Seletor da div de mensagens (ex: "#message")
 * @param {function} [successCallback] - Função opcional a ser executada no sucesso
 **/

function setupAjaxForm(
  formSelector,
  endpoint,
  messageSelector,
  successCallback
) {
  $(formSelector).on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: endpoint,
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        const $message = $(messageSelector);

        // Configura mensagem
        $message
          .removeClass(response.success ? "error" : "success")
          .addClass(response.success ? "success" : "error")
          .text(
            response.message ||
              (response.success
                ? "Operação realizada com sucesso!"
                : "Erro desconhecido")
          )
          .fadeIn()
          .delay(3000)
          .fadeOut();

        // Reseta formulário se sucesso
        if (response.success) {
          $(formSelector)[0].reset();

          // Executa callback se fornecido
          if (typeof successCallback === "function") {
            successCallback(response);
          }
        }
      },
      error: function (xhr, status, error) {
        console.error("Erro AJAX:", { xhr, status, error });
        $(messageSelector)
          .removeClass("success")
          .addClass("error")
          .text(
            "Erro ao conectar com o servidor: " + (xhr.responseText || error)
          )
          .fadeIn()
          .delay(5000)
          .fadeOut();
      },
    });
  });
}

// Função que executa caso o formulario possua envio de arquivos
function setupAjaxFormWithFile(
  formSelector,
  endpoint,
  messageSelector,
  successCallback
) {
  $(formSelector).on("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    $.ajax({
      url: endpoint,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        const $message = $(messageSelector);

        $message
          .removeClass("success error")
          .addClass(response.success ? "success" : "error")
          .text(response.message || "Erro desconhecido")
          .fadeIn()
          .delay(3000)
          .fadeOut();

        if (response.success) {
          form.reset();
          $("#preview-container").html("");

          if (typeof successCallback === "function") {
            successCallback(response);
          }
        }
      },
      error: function (xhr, status, error) {
        console.error("Erro AJAX:", { xhr, status, error });
        $(messageSelector)
          .removeClass("success")
          .addClass("error")
          .text("Erro ao conectar com o servidor.")
          .fadeIn()
          .delay(5000)
          .fadeOut();
      },
    });
  });
}

$(document).ready(function () {
  // Configuração dos formulários
  setupAjaxForm(
    "#formCadastro",
    window.BASE_URL + "components/functions/inserts/insert-clientes.php",
    "#message"
  );
  setupAjaxForm(
    "#formProduto",
    window.BASE_URL + "components/functions/inserts/insert-produtos.php",
    "#message",
    function (response) {
      // Callback específico para produtos (opcional)
      console.log("Produto cadastrado com ID:", response.id);
    }
  );
  setupAjaxForm(
    "#formVendedor",
    window.BASE_URL + "components/functions/inserts/insert-vendedores.php",
    "#message"
  );
  // setupAjaxForm(
  //   "#formVenda",
  //   window.BASE_URL + "components/functions/inserts/insert-vendas.php",
  //   "#message"
  // );
  setupAjaxForm(
    "#formCadastroUsuario",
    window.BASE_URL + "components/functions/update-usuario.php",
    "#message"
  );
});

setupAjaxFormWithFile(
  "#formCadUsuario",
  window.BASE_URL + "components/functions/inserts/insert-update-usuarios.php",
  "#message"
);
// Adicione mais formulários conforme necessário
// setupAjaxForm("#outroForm", "outro-endpoint.php", "#outraMensagem");

// $.ajax({
//     url: "../exemplo-banco/insert-clientes.php",
//     type: "POST",
//     data: $("#formCadastro").serialize(),
//     dataType: "json",
//     success: function(response) {
//         if (response.success) {
//             $("#message").removeClass("error").addClass("success")
//                 .text(response.message).fadeIn().delay(3000).fadeOut();
//             $("#formCadastro")[0].reset();
//         } else {
//             $("#message").removeClass("success").addClass("error")
//                 .text(response.message).fadeIn().delay(3000).fadeOut();
//         }
//     },
//     error: function(xhr, status, error) {
//         console.log("Erro AJAX:", xhr.responseText, status, error);
//         $("#message").removeClass("success").addClass("error")
//             .text("Erro ao processar a requisição!").fadeIn().delay(3000).fadeOut();
//     }
// });
