import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { Trash, Eye } from "lucide-react";
import CardTable from "../Utils/CardTable";
import {
  deleteVisualisation,
  getVisualisations,
} from "../../API/visualisationApi";

const GetAllVisualisation = () => {
  const [visualisation, setVisualisation] = useState([]);
  const navigate = useNavigate();
  const { tenantSlug } = useParams();

  useEffect(() => {
    getVisualisations().then((res) => setVisualisation(res.data.member ?? []));
  }, []);

  const handleDelete = async (id) => {
    await deleteVisualisation(id);
    const res = await getVisualisations();
    setVisualisation(res.data.member ?? []);
  };

  const VisualisationColumns = [
    { key: "id", label: "ID" },
    { key: "type_visualisation", label: "Type" },
    { key: "note", label: "Note" },
    {
      key: "actions",
      label: "Actions",
      render: (_, row) => (
        <div className="flex gap-3">
          <button
            className="btn btn-sm btn-soft btn-info"
            onClick={() =>
              navigate(`/dashboard/${tenantSlug}/visualisations/${row.id}`)
            }
          >
            <Eye size={16} />
          </button>

          <button
            onClick={() => handleDelete(row.id)}
            className="btn btn-sm btn-soft btn-error"
          >
            <Trash size={16} />
          </button>
        </div>
      ),
    },
  ];

  return <CardTable columns={VisualisationColumns} data={visualisation} />;
};

export default GetAllVisualisation;
