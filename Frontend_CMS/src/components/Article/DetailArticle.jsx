import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { getArticle } from "../../API/articleApi";
import GetAllBlocsArticle from "../Blocs/GetAllBlocsArticle";
import CreateBloc from "../Blocs/CreateBloc";

const DetailArticle = () => {
  const { id } = useParams();
  const [article, setArticle] = useState(null);

  const loadArticle = () => {
    getArticle(id).then((res) => setArticle(res.data));
  };

  useEffect(() => {
    loadArticle();
  }, [id]);

  if (!article) return <p>Chargement...</p>;

  return (
    <div className="space-y-6">
      {/* INFOS ARTICLE */}
      <div className="card p-4">
        <h1 className="text-2xl font-bold">{article.titre}</h1>
        <p className="opacity-70">{article.resume}</p>
      </div>

      {/* LISTE BLOCS */}
      <GetAllBlocsArticle blocs={article.blocs || []} onChange={loadArticle} />

      {/* AJOUT BLOC */}
      <CreateBloc articleId={id} onCreated={loadArticle} />
    </div>
  );
};

export default DetailArticle;
