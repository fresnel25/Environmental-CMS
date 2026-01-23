import { useEffect, useState } from "react";
import { getArticles, deleteArticle } from "../../API/articleApi";
import { getMedias } from "../../API/mediaApi";
import { getVisualisations } from "../../API/visualisationApi";
import { createBloc } from "../../API/blocApi";

import CardTable from "../Utils/CardTable";
import { useNavigate, useParams } from "react-router-dom";
import { Eye, PackagePlus, Trash } from "lucide-react";

const GetAllArticles = () => {
  const [articles, setArticles] = useState([]);
  const [medias, setMedias] = useState([]);
  const [visualisations, setVisualisations] = useState([]);

  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [selectedArticle, setSelectedArticle] = useState(null);
  const [blocType, setBlocType] = useState("");
  const [formData, setFormData] = useState({});

  const navigate = useNavigate();
  const { tenantSlug } = useParams();

  /* ---------------- FETCH ---------------- */

  const fetchArticles = () => {
    setLoading(true);
    getArticles()
      .then((res) => setArticles(res.data.member))
      .catch(() => setError("Erreur de chargement"))
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    fetchArticles();
    getMedias().then((res) => setMedias(res.data.member));
    getVisualisations().then((res) => setVisualisations(res.data.member));
  }, []);

  const handleDelete = (id) => {
    deleteArticle(id).then(() => fetchArticles());
  };

  /* ---------------- CREATE BLOC ---------------- */

  const handleCreateBloc = async () => {
    if (!blocType || !selectedArticle) return;

    const payload = {
      type_bloc: blocType,
      article: selectedArticle["@id"],
      position: 1,
    };

    if (blocType === "text") {
      payload.contenu_json = formData;
    }

    if (blocType === "image") {
      payload.media = formData.media;
    }

    if (blocType === "visualisation") {
      payload.visualisation = formData.visualisation;
    }

    await createBloc(payload);

    setBlocType("");
    setFormData({});
    document.getElementById("bloc_modal").close();
  };

  /* ---------------- TABLE ---------------- */

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
            onClick={() =>
              navigate(`/dashboard/${tenantSlug}/articles/${row.id}`)
            }
            className="btn btn-sm btn-soft btn-info"
          >
            <Eye size={16} />
          </button>

          <button
            onClick={() => handleDelete(row.id)}
            className="btn btn-sm btn-soft btn-error"
          >
            <Trash size={16} />
          </button>

          <button
            className="btn btn-sm btn-soft btn-success"
            onClick={() => {
              setSelectedArticle(row);
              setBlocType("");
              setFormData({});
              document.getElementById("bloc_modal").showModal();
            }}
          >
            <PackagePlus size={16} />
          </button>
        </div>
      ),
    },
  ];

  if (loading) return <p>Chargement...</p>;
  if (error) return <p>{error}</p>;

  return (
    <div>
      <CardTable columns={columns} data={articles} />

      <dialog id="bloc_modal" className="modal modal-bottom sm:modal-middle">
        <div className="modal-box">
          <h3 className="font-bold text-lg text-white text-center">
            Ajouter un bloc à {selectedArticle?.titre}
          </h3>

          {/* TYPE DE BLOC */}
          <select
            className="select select-bordered w-full mt-4 text-white text-lg"
            value={blocType}
            onChange={(e) => {
              setBlocType(e.target.value);
              setFormData({});
            }}
          >
            <option value="">Choisir un type de bloc</option>
            <option value="title">Titre</option>
            <option value="text">Texte</option>
            <option value="image">Image</option>

            {selectedArticle?.categorie === "dashboard" && (
              <option value="visualisation">Visualisation</option>
            )}
          </select>

          {/* TEXTE */}
          {blocType === "text" && (
            <textarea
              className="textarea textarea-bordered w-full mt-4  text-white"
              placeholder="Contenu du texte"
              onChange={(e) => setFormData({ text: e.target.value })}
            />
          )}

          {/* IMAGE */}
          {blocType === "image" && (
            <select
              className="select select-bordered w-full mt-4  text-white text-lg"
              onChange={(e) => setFormData({ media: e.target.value })}
            >
              <option value="">Choisir une image</option>
              {medias.map((m) => (
                <option key={m.id} value={m["@id"]}>
                  {m.lien}
                </option>
              ))}
            </select>
          )}

          {/* VISUALISATION */}
          {blocType === "visualisation" && (
            <select
              className="select select-bordered w-full mt-4  text-white text-lg"
              onChange={(e) => setFormData({ visualisation: e.target.value })}
            >
              <option value="">Choisir une visualisation</option>
              {visualisations.map((v) => (
                <option key={v.id} value={v["@id"]}>
                  {v.note}
                </option>
              ))}
            </select>
          )}

          <div className="modal-action">
            <button className="btn btn-primary" onClick={handleCreateBloc}>
              Ajouter le bloc
            </button>
            <form method="dialog">
              <button className="btn">Annuler</button>
            </form>
          </div>
        </div>
      </dialog>
      
    </div>
  );
};

export default GetAllArticles;
