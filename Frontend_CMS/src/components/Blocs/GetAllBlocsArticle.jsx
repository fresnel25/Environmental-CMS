import { deleteBloc } from "../../API/blocApi";

const GetAllBlocsArticle = ({ blocs, onChange }) => {
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
            <div className="flex justify-between">
              <span className="font-semibold">
                {bloc.type_bloc}
              </span>

              <button
                onClick={() => handleDelete(bloc.id)}
                className="btn btn-xs btn-error"
              >
                Supprimer
              </button>
            </div>

            {/* APERÇU */}
            {bloc.type_bloc === "text" && (
              <p className="mt-2">{bloc.contenu_json?.text}</p>
            )}

            {bloc.type_bloc === "media" && (
              <p className="mt-2 text-sm italic">
                Media lié (ID {bloc.media?.id})
              </p>
            )}

            {bloc.type_bloc === "visualisation" && (
              <p className="mt-2 text-sm italic">
                Visualisation liée
              </p>
            )}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default GetAllBlocsArticle;
