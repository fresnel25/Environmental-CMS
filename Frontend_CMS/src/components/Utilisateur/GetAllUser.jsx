import React from "react";
import CardTable from "../Utils/CardTable";
const userColumns = [
  { key: "id", label: "ID" },
  { key: "titre", label: "Titre de l'article" },
  { key: "categorie", label: "Catégorie" },
  { key: "date", label: "Date de Création" },
  { key: "nbre", label: "Nombre article" },
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

const GetAllUser = () => {
  return (
    <div>
      <div>
        <CardTable columns={userColumns} />
      </div>
    </div>
  );
};

export default GetAllUser;
