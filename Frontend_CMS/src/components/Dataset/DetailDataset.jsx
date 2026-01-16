import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { getDataset } from "../../API/datasetApi";
import CardTable from "../Utils/CardTable";
import Page_Title from "../Page-Title/Page_Title";

const DetailDataset = () => {
  const { id } = useParams();

  const [dataset, setDataset] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchDataset = async () => {
      try {
        const res = await getDataset(id);
        setDataset(res.data);
      } catch (e) {
        setError("Impossible de charger le dataset");
      } finally {
        setLoading(false);
      }
    };

    fetchDataset();
  }, [id]);

  if (loading) return <p>Chargement...</p>;
  if (error) return <p>{error}</p>;
  if (!dataset) return null;

  const columns = [
    { key: "nom_colonne", label: "Nom de la colonne" },
    {
      key: "type_colonne",
      label: "Type",
      render: (type) => (
        <span className="badge badge-neutral badge-outline">{ type === "string" ? "chaine" : "numérique"}</span>
      ),
    },
  ];

  return (
    <div className="flex flex-col">
      {/*  <div className="card bg-base-200 p-6">
        <h1 className="text-2xl font-bold">{dataset.titre}</h1>

        <div className="mt-3 flex gap-4">
          <span className="badge badge-outline">
            Source : {dataset.type_source}
          </span>
          {dataset.delimiter && (
            <span className="badge badge-outline">
              Délimiteur : {dataset.delimiter}
            </span>
          )}
        </div>

        <p className="mt-3 text-sm text-gray-500 break-all">
          {dataset.url_source}
        </p>
      </div> */}
      <div>
        <Page_Title Title={"Liste Colonnes du dataset"} />
      </div>

      <div>
        <CardTable columns={columns} data={dataset.colonnes ?? []} />
      </div>
    </div>
  );
};

export default DetailDataset;
