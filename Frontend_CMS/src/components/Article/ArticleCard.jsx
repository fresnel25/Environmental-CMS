import BlocRenderer from "./BlocRenderer";

const ArticleCard = ({ article, canNote }) => {
  const theme = article.theme?.variable_css || {};

  const articleStyle = {
    backgroundColor: theme.article?.backgroundColor,
    maxWidth: theme.article?.maxWidth,
    padding: theme.article?.padding,
    marginTop: theme.article?.marginTop,
    borderRadius: theme.article?.borderRadius,
    boxShadow: theme.article?.shadow ? "0 20px 40px rgba(0,0,0,0.1)" : "none",
    marginLeft: theme.article?.align === "center" ? "auto" : undefined,
    marginRight: theme.article?.align === "center" ? "auto" : undefined,
  };

  const blocsLayout =
    theme.blocs?.layout === "grid"
      ? "grid"
      : theme.blocs?.layout === "row"
        ? "flex"
        : "flex";

  const blocsStyle = {
    display: blocsLayout,
    flexDirection: blocsLayout === "flex" ? "column" : undefined,
    gridTemplateColumns:
      blocsLayout === "grid"
        ? `repeat(${theme.blocs?.columns || 1}, minmax(0, 1fr))`
        : undefined,
    gap: theme.blocs?.gap || "1.5rem",
    justifyContent:
      article.blocs.length === 1
        ? theme.blocs?.alignSingle === "center"
          ? "center"
          : "flex-start"
        : "space-between",
  };

  return (
    <article style={articleStyle}>
      <h2
        style={{
          color: theme.text?.titleColor,
          fontSize: "2rem",
          marginBottom: "1.5rem",
        }}
      >
        {article.titre}
      </h2>

      <div style={blocsStyle}>
        {article.blocs.map((bloc) => (
          <BlocRenderer
            key={bloc.id ?? bloc.uuid}
            bloc={bloc}
            canNote={canNote}
          />
        ))}
      </div>
    </article>
  );
};

export default ArticleCard;
