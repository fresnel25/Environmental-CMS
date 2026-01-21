import { useState, useEffect } from "react";
import { ChromePicker } from "react-color";
import { getTheme, saveArticleTheme } from "../../API/themeApi";

const ThemeForm = ({ scope, targetId, styles, setStyles }) => {
  const [saving, setSaving] = useState(false);

  // Charger le thème existant une fois
  useEffect(() => {
    getTheme(scope, targetId)
      .then((res) => {
        if (res.data.length > 0) setStyles(res.data[0].variable_css);
      })
      .catch(() => {});
  }, [scope, targetId, setStyles]);

  // Valeurs sûres pour éviter les crash si styles incomplets
  const safeStyles = {
    article: {
      backgroundColor: "#ffffff",
      maxWidth: "1100px",
      padding: "2.5rem",
      marginTop: "3rem",
      align: "center",
      borderRadius: "16px",
      shadow: true,
      layout: "vertical",
      ...(styles.article || {}),
    },
    blocs: {
      layout: "grid",
      gap: "2rem",
      columns: 2,
      alignSingle: "center",
      ...(styles.blocs || {}),
    },
    text: {
      textColor: "#000000",
      titleColor: "#000000",
      fontSize: "16px",
      ...(styles.text || {}),
    },
  };

  const handleSave = async () => {
    setSaving(true);
    try {
      await saveArticleTheme(targetId, safeStyles);
    } catch (e) {
      console.error("Erreur sauvegarde theme:", e);
    } finally {
      setSaving(false);
    }
  };

  return (
    <div className="card bg-base-200 p-4 space-y-6 text-white">
      <div className="flex flex-row justify-center space-x-20">
        {/* <h2 className="font-bold text-lg">Design {scope}</h2> */}

        {/* === Styles de l'article === */}
        <div className="border-b border-gray-400 pb-3">
          <p className="font-semibold mb-2">Article</p>

          <p className="text-sm mb-2">Couleur de fond</p>
          <ChromePicker
            color={safeStyles.article.backgroundColor}
            onChange={(c) =>
              setStyles({
                ...styles,
                article: { ...safeStyles.article, backgroundColor: c.hex },
              })
            }
          />

          <p className="text-sm mb-1 mt-2">Arrondi des coins</p>
          <input
            type="range"
            min="0"
            max="32"
            value={parseInt(safeStyles.article.borderRadius)}
            className="range range-info"
            onChange={(e) =>
              setStyles({
                ...styles,
                article: {
                  ...safeStyles.article,
                  borderRadius: `${e.target.value}px`,
                },
              })
            }
          />
          <span className="text-xs">{safeStyles.article.borderRadius}</span>
        </div>

        {/* === Styles des blocs === */}
        <div className="border-b border-gray-400 pb-3">
          <p className="font-semibold mb-2">Blocs</p>

          <p className="text-sm mb-1">Disposition des blocs</p>
          <select
            className="select select-bordered w-full"
            value={safeStyles.blocs.layout}
            onChange={(e) =>
              setStyles({
                ...styles,
                blocs: { ...safeStyles.blocs, layout: e.target.value },
              })
            }
          >
            <option value="grid">Grille</option>
            <option value="vertical">Vertical</option>
            <option value="horizontal">Horizontal</option>
          </select>

          <p className="text-sm mb-1 mt-2">Espacement entre blocs</p>
          <input
            type="range"
            min="0"
            max="64"
            value={parseInt(safeStyles.blocs.gap)}
            className="range range-info"
            onChange={(e) =>
              setStyles({
                ...styles,
                blocs: { ...safeStyles.blocs, gap: `${e.target.value}px` },
              })
            }
          />
          <span className="text-xs">{safeStyles.blocs.gap}</span>
        </div>

        {/* === Styles du texte === */}
        <div>
          <p className="font-semibold mb-2">Texte</p>

          {["textColor", "titleColor"].map((key) => (
            <div key={key}>
              <p className="text-sm mb-2">
                {key.replace("Color", "").toUpperCase()}
              </p>
              <ChromePicker
                color={safeStyles.text[key]}
                onChange={(c) =>
                  setStyles({
                    ...styles,
                    text: { ...safeStyles.text, [key]: c.hex },
                  })
                }
              />
            </div>
          ))}

          <p className="text-sm mb-1 mt-2">Taille du texte</p>
          <input
            type="range"
            min="12"
            max="22"
            value={parseInt(safeStyles.text.fontSize)}
            className="range range-info"
            onChange={(e) =>
              setStyles({
                ...styles,
                text: { ...safeStyles.text, fontSize: `${e.target.value}px` },
              })
            }
          />
          <span className="text-xs">{safeStyles.text.fontSize}</span>
        </div>
      </div>
      <div>
        <button
          className="btn btn-primary mt-4 btn-sm"
          onClick={handleSave}
          disabled={saving}
        >
          {saving ? "Enregistrement..." : "Enregistrer le thème"}
        </button>
      </div>
    </div>
  );
};

export default ThemeForm;
