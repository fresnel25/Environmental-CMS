import { useParams } from "react-router-dom";
import { useState, useEffect } from "react";
import ThemeForm from "./ThemeForm";
import ThemePreview from "./ThemePreview";
import Page_Title from "../Page-Title/Page_Title";
import { getArticle } from "../../API/articleApi"; // à adapter

const ThemeEditor = ({ scope }) => {
  const { id } = useParams();
  const [styles, setStyles] = useState({
    backgroundColor: "#ffffff",
    textColor: "#000000",
    titleColor: "#000000",
    borderRadius: "8px",
    fontSize: "16px",
  });

  const [content, setContent] = useState(null);
  const [loading, setLoading] = useState(true);

  // Charger l'article ou bloc dès que id change
  useEffect(() => {
    if (!id) return;

    const loadContent = async () => {
      setLoading(true);
      try {
        if (scope === "article") {
          const res = await getArticle(id);
          setContent(res.data);
        }
        // else si bloc: const res = await getBlocs(id);
      } catch (e) {
        console.error("Erreur chargement contenu:", e);
        setContent(null);
      } finally {
        setLoading(false);
      }
    };

    loadContent();
  }, [id, scope]);

  if (loading) return <p>Chargement du contenu...</p>;
  if (!content) return <p>Contenu introuvable.</p>;

  return (
    <div className="p-6 space-y-6">
      <Page_Title Title={`Designer ${scope}`} />

      <div className="grid grid-cols-12 gap-6 mt-5">
        {/* Formulaire */}
        <div className="col-span-4">
          <ThemeForm
            scope={scope}
            targetId={id}
            styles={styles}
            setStyles={setStyles}
          />
        </div>

        {/* Preview */}
        <div className="col-span-8">
          <ThemePreview
            scope={scope}
            targetId={id}
            styles={styles}
            content={content}
          />
        </div>
      </div>
    </div>
  );
};

export default ThemeEditor;
