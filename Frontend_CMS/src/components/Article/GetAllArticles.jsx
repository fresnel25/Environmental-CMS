import { useEffect, useState } from "react";
import { getArticles, deleteArticle } from "../../API/articleApi";
import CardTable from "../Utils/CardTable";
import { useNavigate, useParams } from "react-router-dom";
import { Eye, Trash } from "lucide-react";

const GetAllArticles = () => {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const navigate = useNavigate();
  const {tenantSlug} = useParams();

  const fetchArticles = () => {
    setLoading(true);
    getArticles()
      .then((res) => setArticles(res.data.member))
      .catch(() => setError("Erreur de chargement"))
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    fetchArticles();
  }, []);

  const handleDelete = (id) => {
    deleteArticle(id).then(() => fetchArticles());
  };

  const columns = [
    { key: "titre", label: "Titre" },
    { key: "categorie", label: "Type" },
    {
      key: "status",
      label: "Status",
      render: (val) => (val ? "Publié" : "Brouillon"),
    },
    {
      key: "actions",
      label: "Actions",
      render: (_, row) => (
        <div className="flex gap-3">
          <button
            onClick={() => navigate(`/dashboard/${tenantSlug}/articles/${row.id}`)}
            className="btn btn-sm btn-info"
          >
            <Eye size={16}/>
          </button>

          <button
            onClick={() => handleDelete(row.id)}
            className="btn btn-sm btn-error"
          >
            <Trash size={16}/>
          </button>
        </div>
      ),
    },
  ];

  if (loading) return <p>Chargement...</p>;
  if (error) return <p>{error}</p>;

  return <CardTable columns={columns} data={articles} />;
};

export default GetAllArticles;
