import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { Bar, Line, Pie, Scatter } from "react-chartjs-2";
import { getVisualisation } from "../../API/visualisationApi";
import "../../chartjs"; // ton setup Chart.js global

// Palette fixe
const PALETTE = [
  "#3B82F6", "#EF4444", "#F59E0B", "#10B981",
  "#8B5CF6", "#EC4899", "#FBBF24", "#6366F1"
];

const MAX_POINTS = 100; // Nombre maximum de points affichés

const VisualisationRenderer = ({ visualisationId }) => {
  const { id: paramId } = useParams();
  const finalId = visualisationId || paramId;

  const [visu, setVisu] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (!finalId) return;

    getVisualisation(finalId)
      .then((res) => setVisu(res.data))
      .catch(() => setError("Impossible de charger la visualisation"));
  }, [finalId]);

  if (error) return <p>{error}</p>;
  if (!visu) return <p>Chargement...</p>;

  const type = visu.type?.toLowerCase().trim();

  if (!visu.labels || !visu.datasets || visu.datasets.length === 0) {
    return <p>Données insuffisantes pour afficher le graphique</p>;
  }

  // ===============================
  // Auto-sampling si beaucoup de points
  // ===============================
  const step = Math.ceil(visu.labels.length / MAX_POINTS) || 1;
  const sampledLabels = visu.labels.filter((_, i) => i % step === 0);
  const sampledDatasets = visu.datasets.map(ds => ({
    ...ds,
    data: ds.data.filter((_, i) => i % step === 0),
  }));

  // ===============================
  // Construire les datasets selon type
  // ===============================
  let chartDatasets;
  switch (type) {
    case "pie":
      chartDatasets = sampledDatasets.map(ds => ({
        ...ds,
        backgroundColor: PALETTE,
      }));
      break;

    case "line":
    case "scatter":
      chartDatasets = sampledDatasets.map((ds, index) => ({
        ...ds,
        borderColor: PALETTE[index % PALETTE.length],
        backgroundColor: PALETTE[index % PALETTE.length],
        pointBackgroundColor: PALETTE, // chaque point a une couleur
        pointBorderColor: PALETTE,
        borderWidth: 2,
        pointRadius: 3, // plus petit si beaucoup de points
        fill: false,
      }));
      break;

    case "bar":
      chartDatasets = sampledDatasets.map(ds => ({
        ...ds,
        backgroundColor: PALETTE,
        borderColor: PALETTE,
        borderWidth: 1,
      }));
      break;

    default:
      return <p>Type de visualisation non supporté : {type}</p>;
  }

  const chartData = {
    labels: sampledLabels,
    datasets: chartDatasets,
  };

  // ===============================
  // Options Chart.js
  // ===============================
  const chartOptions = {
    responsive: true,
    plugins: {
      title: {
        display: !!visu.title,
        text: visu.title || "",
      },
      legend: {
        display: true,
        position: "bottom",
      },
    },
    scales:
      type === "scatter"
        ? {
            x: { type: "linear", position: "bottom" },
            y: { type: "linear" },
          }
        : {
            x: {
              ticks: {
                maxRotation: 45,
                minRotation: 45,
                autoSkip: true,
              },
            },
          },
  };

  // ===============================
  // Scroll horizontal si trop large
  // ===============================
  const containerWidth = Math.max(sampledLabels.length * 10, 600); // 10px par point, min 600px

  return (
    <div style={{ width: "100%", overflowX: "auto" }}>
      <div style={{ width: containerWidth }}>
        {type === "bar" && <Bar data={chartData} options={chartOptions} />}
        {type === "line" && <Line data={chartData} options={chartOptions} />}
        {type === "pie" && <Pie data={chartData} options={chartOptions} />}
        {type === "scatter" && <Scatter data={chartData} options={chartOptions} />}
      </div>
    </div>
  );
};

export default VisualisationRenderer;
