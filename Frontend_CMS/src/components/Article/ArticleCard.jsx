import BlocRenderer from "./BlocRenderer";

const ArticleCard = ({ article, canNote }) => {
  const theme = article.theme?.variable_css || {};

  const articleStyle = {
    backgroundColor: theme.backgroundColor,
    color: theme.textColor,
    borderRadius: theme.borderRadius,
    fontSize: theme.fontSize,
  };

  return (
    <div className="card shadow-lg transition-all" style={articleStyle}>
      <div className="card-body space-y-6">
        <h2
          className="card-title text-2xl font-bold"
          style={{ color: theme.titleColor }}
        >
          {article.titre}
        </h2>

        {article.blocs?.map((bloc) => (
          <BlocRenderer
            key={bloc.id ?? bloc.uuid}
            bloc={bloc}
            canNote={canNote}
            articleTheme={theme}
          />
        ))}
      </div>
    </div>
  );
};

export default ArticleCard;
