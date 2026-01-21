const ThemePreview = ({ scope, content, styles }) => {
  const safeStyles = {
    backgroundColor: styles?.backgroundColor ?? "#fff",
    textColor: styles?.textColor ?? "#000",
    titleColor: styles?.titleColor ?? "#000",
    borderRadius: styles?.borderRadius ?? "8px",
    fontSize: styles?.fontSize ?? "16px",
  };

  const containerStyle = {
    backgroundColor: safeStyles.backgroundColor,
    color: safeStyles.textColor,
    borderRadius: safeStyles.borderRadius,
    fontSize: safeStyles.fontSize,
    padding: "16px",
  };

  return (
    <div className="card bg-base-100 shadow-xl p-6">
      <h2
        style={{ color: safeStyles.titleColor }}
        className="text-xl font-bold mb-4"
      >
        Aperçu {scope}
      </h2>

      <div style={containerStyle}>
        {scope === "article" && (
          <>
            <h3 className="text-lg font-bold mb-2">{content.titre}</h3>
            <p className="opacity-80">{content.resume}</p>
          </>
        )}

        {scope === "bloc" && (
          <>
            {content.type_bloc === "text" && (
              <p>{content.contenu_json?.text}</p>
            )}
            {content.type_bloc === "media" && content.media && (
              <img
                src={content.media.url}
                alt=""
                className="rounded-lg max-w-full"
              />
            )}
            {content.type_bloc === "visualisation" && (
              <div className="italic opacity-70">
                Prévisualisation visualisation
              </div>
            )}
          </>
        )}
      </div>
    </div>
  );
};

export default ThemePreview;
