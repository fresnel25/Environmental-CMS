import React from "react";
import Page_Title from "../Page-Title/Page_Title";
import { useNavigate } from "react-router-dom";
import GetAllUser from "./GetAllUser";

const Utilisateur = () => {
  const navigate = useNavigate();
  const handleClick = () => {
    navigate("/dashboard/create_user");
  };
  return (
    <div>
      <div className="flex flex-col">
        <div>
          <Page_Title Title={"Liste des utilisateurs"} />
        </div>
        <div className="flex justify-end">
          <button
            onClick={handleClick}
            className="btn btn-outline mt-5 bg-cyan-950 text-white"
          >
            Ajouter un utilisateur
          </button>
        </div>
        <div>
          <GetAllUser />
        </div>
      </div>
    </div>
  );
};

export default Utilisateur;
