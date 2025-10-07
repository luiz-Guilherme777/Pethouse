function carregarGrafico(tipo) {
  const canvasId = "grafico" + tipo.charAt(0).toUpperCase() + tipo.slice(1);
  const canvas = document.getElementById(canvasId);

  if (!canvas) {
    console.error("Canvas para o gráfico não encontrado:", canvasId);
    return;
  }

  const ctx = canvas.getContext("2d");

  window.graficos = window.graficos || {};
  const graficoNome = canvasId;

  if (
    window.graficos[graficoNome] &&
    typeof window.graficos[graficoNome].destroy === "function"
  ) {
    window.graficos[graficoNome].destroy();
  }

  // Pega os dados definidos no HTML
  const dadosBrutos = window.dadosGraficos?.[tipo];
  if (!dadosBrutos) {
    console.error("Dados do gráfico não encontrados para tipo:", tipo);
    return;
  }

  const cores = [
    "#4e79a7",
    "#f28e2b",
    "#e15759",
    "#76b7b2",
    "#59a14f",
    "#edc948",
    "#b07aa1",
    "#ff9da7",
    "#9c755f",
    "#bab0ab",
  ];

  const backgroundColors = dadosBrutos.labels.map(
    (_, i) => cores[i % cores.length]
  );

  const iconesPorTipo = {
    clientes: ["🔹", "🔸", "⚪", "🔺", "🔻", "⭐", "🌟", "⚡", "🔥", "💧"],
    produtos: ["📦", "🛒", "🏷️", "🔖", "📈", "📉", "🛍️", "🔧", "⚙️", "🛠️"],
    vendedores: ["👨‍💼", "👩‍💼", "💼", "📞", "🗣️", "💬", "📊", "🏆", "🎯", "💡"],
  };

  const icones = iconesPorTipo[tipo] || ["🔹", "🔸", "⚪", "🔺", "🔻"];

  const dados = {
    labels: dadosBrutos.labels,
    datasets: [
      {
        label: dadosBrutos.label,
        data: dadosBrutos.valores,
        backgroundColor: backgroundColors,
        borderColor: "#ffffff",
        borderWidth: 2,
      },
    ],
  };

  window.graficos[graficoNome] = new Chart(ctx, {
    type: "pie", // caso queira mudar o gráfico 'bar', 'doughnut',
    data: dados,
    options: {
      responsive: true,
      animation: {
        animateScale: true,
        animateRotate: true,
      },
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            usePointStyle: true,
            pointStyle: "circle",
            color: "#333",
            font: { size: 14, weight: "500" },
            generateLabels: function (chart) {
              const data = chart.data;
              const meta = chart.getDatasetMeta(0);

              if (!data.labels.length) return [];

              return data.labels.map((label, i) => {
                const value = data.datasets[0].data[i];
                const hidden = !meta.data[i] || meta.data[i].hidden;

                return {
                  text: `${icones[i % icones.length]} ${label} (${value})`,
                  fillStyle: data.datasets[0].backgroundColor[i],
                  strokeStyle: data.datasets[0].borderColor,
                  lineWidth: 1,
                  hidden: false,
                  index: i,
                };
              });
            },
          },
        },
        title: {
          display: true,
          text: dadosBrutos.titulo,
          font: { size: 18, weight: "bold" },
          color: "#222",
        },
        tooltip: {
          backgroundColors: "#222",
          titleColor: "#fff",
          bodyColor: "#eee",
          borderColor: "#555",
          borderWidth: 1,
          padding: 10,
          cornerRadius: 4,
          tittleFont: { size: 14, weight: "bold" },
          bodyFont: { size: 13 },
        },
      },
      layout: {
        padding: 15,
      },
    },
  });
}
