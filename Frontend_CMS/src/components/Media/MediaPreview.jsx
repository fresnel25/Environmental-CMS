// src/components/Media/MediaPreview.jsx
import { useEffect, useState } from "react";
import { getMedia } from "../../API/mediaApi";

const MediaPreview = ({ mediaId }) => {
  const [media, setMedia] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!mediaId) return;

    getMedia(mediaId)
      .then((res) => setMedia(res.data))
      .finally(() => setLoading(false));
  }, [mediaId]);

  if (loading) return <p className="text-sm italic">Chargement média…</p>;
  if (!media) return <p className="text-sm text-error">Média introuvable</p>;

  const src = media.lien.startsWith("http")
    ? media.lien
    : `http://localhost:8080${media.lien}`;

  return (
    <img src={src} alt={media.titre} className="mt-2 max-w-xs rounded shadow" />
  );
};

export default MediaPreview;
