import Page_Title from "../Page-Title/Page_Title";
import { useNavigate, useParams } from "react-router-dom";
import GetAllDataset from "./GetAllDataset";

const Dataset = () => {
  const { tenantSlug } = useParams();
  const navigate = useNavigate();

  const handleClick = () => {
    navigate(`/dashboard/${tenantSlug}/datasets/create`);
  };

  return (
    <div>
      <div className="flex flex-col">
        <div>
          <Page_Title Title={"Liste des Datasets"} />
        </div>
        <div className="flex justify-end">
          <button
            onClick={handleClick}
            className="btn btn-outline mt-5 bg-cyan-950 text-white"
          >
            Ajouter un dataset
          </button>
        </div>
        <div>
          <GetAllDataset />
        </div>
      </div>
    </div>
  );
};

export default Dataset;
