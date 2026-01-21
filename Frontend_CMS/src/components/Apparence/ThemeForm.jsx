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

  const handleSave = async () => {
    setSaving(true);
    try {
      await saveArticleTheme(targetId, styles);
    } catch (e) {
      console.error("Erreur sauvegarde theme:", e);
    } finally {
      setSaving(false);
    }
  };

  return (
    <div className="card bg-base-200 p-4 space-y-6 text-white">
      <h2 className="font-bold text-lg">Design {scope}</h2>

      {/* Couleurs */}
      {["backgroundColor", "textColor", "titleColor"].map((key) => (
        <div key={key}>
          <p className="text-sm mb-2">
            {key.replace("Color", "").toUpperCase()}
          </p>
          <ChromePicker
            color={styles[key]}
            onChange={(c) => setStyles({ ...styles, [key]: c.hex })}
          />
        </div>
      ))}

      {/* Taille du texte */}
      <div>
        <p className="text-sm mb-1">Taille du texte</p>
        <input
          type="range"
          min="12"
          max="22"
          value={parseInt(styles.fontSize)}
          className="range range-info"
          onChange={(e) =>
            setStyles({ ...styles, fontSize: `${e.target.value}px` })
          }
        />
        <span className="text-xs">{styles.fontSize}</span>
      </div>

      {/* Border Radius */}
      <div>
        <p className="text-sm mb-1">Arrondi</p>
        <input
          type="range"
          min="0"
          max="32"
          value={parseInt(styles.borderRadius)}
          className="range range-info"
          onChange={(e) =>
            setStyles({ ...styles, borderRadius: `${e.target.value}px` })
          }
        />
        <span className="text-xs">{styles.borderRadius}</span>
      </div>

      <button
        className="btn btn-primary"
        onClick={handleSave}
        disabled={saving}
      >
        {saving ? "Enregistrement..." : "Enregistrer le thème"}
      </button>
    </div>
  );
};

export default ThemeForm;
