import { useEffect, useState } from "react";
import { getMedias, uploadMedia, deleteMedia } from "../../API/mediaApi";
import CardTable from "../Utils/CardTable";
import { Trash } from "lucide-react";

const MediaLibrary = ({ onSelect }) => {
  const [medias, setMedias] = useState([]);
  const [loading, setLoading] = useState(true);
  const [file, setFile] = useState(null);
  const [error, setError] = useState(null);
  const [uploading, setUploading] = useState(false);

  // Chargement des médias (COMME ARTICLE)
  const loadMedias = async () => {
    try {
      setLoading(true);

      const { data } = await getMedias();
      const items = data.member ?? data["hydra:member"] ?? [];

      //  GARANTIR un id pour CardTable
      const normalized = items.map((media) => ({
        ...media,
        id: media.id ?? media["@id"]?.split("/").pop(),
      }));

      setMedias(normalized);
    } catch (err) {
      console.error("Erreur chargement médias :", err);
      setMedias([]);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadMedias();
  }, []);

  //  Upload
  const handleUpload = async () => {
    if (!file) return;

    setUploading(true);
    setError(null);

    try {
      await uploadMedia(file);
      setFile(null);
      loadMedias();
    } catch (err) {
      console.error("Erreur upload :", err);
      setError("Impossible d'uploader le fichier.");
    } finally {
      setUploading(false);
    }
  };

  //  Suppression
  const handleDelete = async (id) => {
    if (!window.confirm("Supprimer ce média ?")) return;

    try {
      await deleteMedia(id);
      loadMedias();
    } catch (err) {
      console.error("Erreur suppression :", err);
    }
  };

  //  Colonnes (ALIGNÉES SUR LA RÉPONSE API)
  const mediaColumns = [
    { key: "id", label: "ID" },

    {
      key: "lien",
      label: "Aperçu",
      render: (lien, row) => (
        <img
          src={
            lien.startsWith("http")
              ? lien
              : `http://localhost:8080${lien}`
          }
          alt={row.titre}
          className="w-16 h-16 object-cover rounded cursor-pointer"
          onClick={() => onSelect && onSelect(row)}
        />
      ),
    },

    {
      key: "titre",
      label: "Nom du fichier",
    },

    {
      key: "typeImg",
      label: "Type",
      render: (type) =>
        type ? (
          <span className="badge badge-outline">
            {type.replace("image/", "")}
          </span>
        ) : (
          <span className="badge badge-ghost">—</span>
        ),
    },

    {
      key: "actions",
      label: "Actions",
      render: (_, row) => (
        <button
          className="btn btn-sm btn-error"
          onClick={() => handleDelete(row.id)}
        >
          <Trash size={16} />
        </button>
      ),
    },
  ];

  if (loading) {
    return <p>Chargement des médias...</p>;
  }

  return (
    <div className="space-y-4">
      {/* Upload */}
      <div className="flex items-center gap-2">
        <input type="file" className="file-input" onChange={(e) => setFile(e.target.files[0])} />
        <button
          disabled={!file || uploading}
          onClick={handleUpload}
          className="btn btn-accent"
        >
          {uploading ? "Upload..." : "Upload"}
        </button>
      </div>

      {error && <p className="text-red-500">{error}</p>}

      {/* Tableau */}
      {medias.length === 0 ? (
        <p className="opacity-50">Aucun média disponible</p>
      ) : (
        <CardTable columns={mediaColumns} data={medias} />
      )}
    </div>
  );
};

export default MediaLibrary;
