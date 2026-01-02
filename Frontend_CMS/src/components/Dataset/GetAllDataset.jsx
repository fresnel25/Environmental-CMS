import { useEffect, useState } from "react";
import { deleteDataset, getAllDatasets } from "../../API/datasetApi";
import CardTable from "../Utils/CardTable";
import { useNavigate, useParams } from "react-router-dom";
import { Eye, Trash } from "lucide-react";

const GetAllDataset = () => {
  const [dataset, setDataset] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const navigate = useNavigate();
  const {tenantSlug} = useParams();

  const fetchDatasets = async () => {
    setLoading(true);
    try {
      const res = await getAllDatasets();
      setDataset(res?.data?.member ?? []);
    } catch {
      setError("Erreur de chargement");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchDatasets();
  }, []);

  const handleDelete = (id) => {
    deleteDataset(id).then(() => fetchDatasets());
  };

  const datasetColumns = [
    { key: "id", label: "ID" },
    { key: "titre", label: "Titre" },
    {
      key: "type_source",
      label: "Source",
      render: (type) => <span className="badge badge-outline">{type}</span>,
    },
    {
      key: "actions",
      label: "Actions",
      render: (_, row) => (
        <div className="flex gap-3">
          <button
            className="btn btn-sm btn-primary"
            onClick={() =>
              navigate(`/dashboard/${tenantSlug}/datasets/${row.id}`)
            }
          >
            <Eye />
          </button>
          <button
            onClick={() => handleDelete(row.id)}
            className="btn btn-sm btn-error"
          >
            <Trash size={16} />
          </button>
        </div>
      ),
    },
  ];

  if (loading) return <p>Chargement...</p>;
  if (error) return <p>{error}</p>;

  return <CardTable columns={datasetColumns} data={dataset} />;
};

export default GetAllDataset;
