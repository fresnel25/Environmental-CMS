import { useNavigate, useParams } from "react-router-dom";
import GetAllBlocsArticle from "../Blocs/GetAllBlocsArticle";
import { getArticle } from "../../API/articleApi";
import { useEffect, useState } from "react";
import Page_Title from "../Page-Title/Page_Title";

const DetailArticle = () => {
  const { id } = useParams();
  const { tenantSlug } = useParams();
  const navigate = useNavigate();
  const [article, setArticle] = useState(null);

  const loadArticle = () => {
    getArticle(id).then((res) => setArticle(res.data));
  };

  useEffect(() => {
    loadArticle();
  }, [id]);

  if (!article) return <p>Chargement...</p>;

  return (
    <div>
      <Page_Title Title={`Détail de l'article ${article.titre}`} />

      {/* DESIGN ARTICLE */}
      <div className="flex justify-end mt-4">
        <button
          className="btn btn-outline bg-cyan-950 text-white"
          onClick={() => navigate(`/dashboard/${tenantSlug}/designer/article/${article.id}`)}
        >
          Designer l’article
        </button>
      </div>

      {/* BLOCS */}
      <div className="space-y-6 mt-6">
        <GetAllBlocsArticle
          blocs={article.blocs || []}
          onChange={loadArticle}
        />
      </div>
    </div>
  );
};

export default DetailArticle;
