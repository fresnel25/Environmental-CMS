import { useNavigate, useParams } from "react-router-dom";
import { deleteBloc } from "../../API/blocApi";
import MediaPreview from "../Media/MediaPreview";
import VisualisationRenderer from "../Visualisation/VisualisationRenderer";

const GetAllBlocsArticle = ({ blocs, onChange }) => {
  const navigate = useNavigate();
  const { tenantSlug } = useParams();

  const handleDelete = async (id) => {
    await deleteBloc(id);
    onChange();
  };

  return (
    <div className="card p-4">
      <h2 className="font-bold mb-4">Blocs</h2>

      {blocs.length === 0 && <p>Aucun bloc</p>}

      <ul className="space-y-3">
        {blocs.map((bloc) => (
          <li key={bloc.id} className="border p-3 rounded">
            <div className="flex justify-between items-center">
              <span className="font-semibold">{bloc.type_bloc}</span>

              <div className="flex gap-2">
                <button
                  className="btn btn-xs btn-outline"
                  onClick={() =>
                    navigate(
                      `/dashboard/${tenantSlug}/designer/bloc/${bloc.id}`,
                    )
                  }
                >
                  Designer le bloc
                </button>

                <button
                  onClick={() => handleDelete(bloc.id)}
                  className="btn btn-xs btn-error"
                >
                  Supprimer
                </button>
              </div>
            </div>

           
            {bloc.type_bloc === "text" && (
              <p className="mt-2">{bloc.contenu_json?.text}</p>
            )}

            {/* MEDIA */}
            {bloc.type_bloc === "image" && bloc.media && (
              <MediaPreview mediaId={bloc.media.id} />
            )}

            {/* VISUALISATION */}
            {bloc.type_bloc === "visualisation" && bloc.visualisation && (
              <VisualisationRenderer visualisationId={bloc.visualisation.id} />
            )}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default GetAllBlocsArticle;
