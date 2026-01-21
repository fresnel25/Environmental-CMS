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
          <div className="flex justify-center items-center">
            <MediaPreview mediaId={bloc.media.id} />
          </div>
        </figure>
      )}

      {/* VISUALISATION */}
      {bloc.type_bloc === "visualisation" && bloc.visualisation && (
        <div className="mb-2 w-full h-64 sm:h-80 md:h-96 relative justify-center items-center">
          {/* div avec hauteur fixe pour que Chart.js s'affiche */}
          <VisualisationRenderer
            visualisationId={bloc.visualisation.id}
            constrained={true}
          />
        </div>
      )}
    </>
  );
};

export default BlocContent;
