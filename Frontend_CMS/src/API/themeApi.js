import api from "./api";

// Charger le thème existant
export const getTheme = (scope, targetId) => {
  return api.get(`/themes`, {
    params: {
      scope,
      targetId,
    },
  });
};

export const saveArticleTheme = (articleId, styles) =>
  api.patch(`/articles/${articleId}/theme`, {
    variable_css: styles,
  });

// Sauvegarder un thème
export const saveTheme = (data) => {
  return api.post("/themes", data);
};
