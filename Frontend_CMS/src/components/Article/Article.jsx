import { useState } from "react";
import CreateArticle from "./CreateArticle";
import GetAllArticles from "./GetAllArticles";
import Page_Title from "../Page-Title/Page_Title";
import { useNavigate } from "react-router-dom";


const Article = () => {
  const navigate = useNavigate();

  const handleClick = () => {
    navigate("/dashboard/create_article");
  };

  return (
    <div>
      <div className="flex flex-col">
        <div>
          <Page_Title Title={"Liste des Articles"} />
        </div>
        <div className="flex justify-end">
          <button onClick={handleClick} className="btn btn-outline mt-5 bg-cyan-950 text-white">
            Créer un article
          </button>
        </div>
        <div>
          <GetAllArticles/>
        </div>
      </div>
    </div>
  );
};

export default Article;
