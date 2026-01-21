import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import { useAuth } from "../../Auth/AuthProvider";
import { getAllArticleWithNote } from "../../API/noteArticleApi";
import ArticleCard from "./ArticleCard";

// Thème par défaut si aucun thème n’est défini
const DEFAULT_THEME = {
  backgroundColor: "#ffffff",
  textColor: "#000000",
  titleColor: "#000000",
  borderRadius: "8px",
  fontSize: "16px",
};

const ArticlesNotes = () => {
  const { tenantSlug } = useParams();
  const { user } = useAuth();

  const canNote = user?.roles?.includes("ROLE_ABONNE"); // null-safe

  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Chargement des articles avec notes
  useEffect(() => {
    getAllArticleWithNote(tenantSlug)
      .then((res) => {
        console.log(" THEMES RECUS DE LA DB :", res.data);
        setArticles(res.data);
      })
      .finally(() => setLoading(false));
  }, [tenantSlug]);

  if (loading) return <p>Chargement des articles…</p>;
  if (error) return <p className="text-red-500">{error}</p>;
  if (articles.length === 0) return <p>Aucun article disponible.</p>;

  return (
    <div className="space-y-10">
      {articles.map((article) => (
        <ArticleCard key={article.slug} article={article} canNote={canNote} />
      ))}
    </div>
  );
};

export default ArticlesNotes;
