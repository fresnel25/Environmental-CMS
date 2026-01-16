import { useNavigate, useParams } from "react-router-dom";
import { createArticle } from "../../API/articleApi";
import Page_Title from "../Page-Title/Page_Title";
import ArticleFormCreation from "./FormArticle/ArticleFormCreation";

const CreateArticle = () => {
  const { tenantSlug } = useParams();
  const navigate = useNavigate();


  const handleSubmit = async (data) => {
    const res = await createArticle(data);
    navigate(`/dashboard/${tenantSlug}/articles`);
  };

  return (
    <div className="flex flex-col">
      <div>
        <Page_Title Title="Création d'article" />
      </div>
      <div>
        <ArticleFormCreation onSubmit={handleSubmit} />
      </div>
    </div>
  );
};

export default CreateArticle;
