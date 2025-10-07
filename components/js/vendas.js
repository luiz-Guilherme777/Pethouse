$(document).ready(function () {
  // Atualiza o valor total quando muda produto ou quantidade
  function calcularTotal() {
    const preco = parseFloat($("#produto option:selected").data("preco")) || 0;
    const quantidade = parseInt($("#quantidade").val()) || 1;
    const total = preco * quantidade;

    $("#preco_unitario").val(preco.toFixed(2));
    $("#vlr_total").val("R$ " + total.toFixed(2).replace(".", ","));
    $("#qnt_itens").val(quantidade);
    return total;
  }

  // Atualiza ao mudar produto ou quantidade
  $("#produto, #quantidade").on("change input", calcularTotal);

  // Configura o formulário usando sua função genérica
  setupAjaxForm(
    "#formVenda",
    window.BASE_URL + "components/functions/inserts/insert-vendas.php",
    "#message",
    function (response) {
      // Callback adicional após sucesso (opcional)

      $("#produto, #cliente, #vendedor").val("");
      $("#quantidade").val("1");
      calcularTotal();
    }
  );

  // Dispara o cálculo inicial
  calcularTotal();
});
