import { useNavigate, useParams } from "react-router-dom";
import GetAllVisualisation from './GetAllVisualisation';
import Page_Title from "../Page-Title/Page_Title";

const Visualisation = () => {

    const navigate = useNavigate();
    const { tenantSlug } = useParams(); 

    const handleClick = () => {
        navigate(`/dashboard/${tenantSlug}/visualisations/create`);
    }

   return (
    <div>
      <div className="flex flex-col">
        <div>
          <Page_Title Title="Liste des visualisations" />
        </div>
        <div className="flex justify-end">
          <button
            onClick={handleClick}
            className="btn btn-outline mt-5 bg-cyan-950 text-white"
          >
            Ajouter une visualisation
          </button>
        </div>
        <div>
          <GetAllVisualisation />
        </div>
      </div>
    </div>
  );
}

export default Visualisation