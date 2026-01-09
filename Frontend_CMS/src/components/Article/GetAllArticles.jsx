import CardTable from "../Utils/CardTable";
import { Pencil, Trash } from "lucide-react";

const articleColumns = [
  { key: "id", label: "ID" },
  { key: "titre", label: "Titre de l'article" },
  { key: "categorie", label: "Catégorie" },
  { key: "date", label: "Date de Création" },
  {
    key: "actions",
    label: "Actions",
    render: (_, row) => (
      <div className="flex gap-3">
        <button className="btn btn-sm btn-warning">
          <Pencil size={16} />
        </button>
        <button className="btn btn-sm btn-error">
          <Trash size={16} />
        </button>
      </div>
    ),
  },
];

const GetAllArticles = ({ tableauArticle }) => {
  return (
    <div>
      <div>
        <CardTable columns={articleColumns} data={tableauArticle} />
      </div>
    </div>
  );
};

export default GetAllArticles;
