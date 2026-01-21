import MediaPreview from "../Media/MediaPreview";
import VisualisationRenderer from "../Visualisation/VisualisationRenderer";

const BlocContent = ({ bloc }) => {
  return (
    <>
      {/* TEXTE */}
      {bloc.type_bloc === "text" && (
        <p className="mt-2 leading-relaxed">{bloc.contenu_json?.text}</p>
      )}

      {/* IMAGE / MEDIA */}
      {bloc.type_bloc === "image" && bloc.media && (
        <figure className="mb-2">
          <MediaPreview mediaId={bloc.media.id} />
        </figure>
      )}

      {/* VISUALISATION */}
      {bloc.type_bloc === "visualisation" && bloc.visualisation && (
        <div className="mb-2 w-full h-64">
          {/* div avec hauteur fixe pour que Chart.js s'affiche */}
          <VisualisationRenderer visualisationId={bloc.visualisation.id} />
        </div>
      )}
    </>
  );
};

export default BlocContent;
