import { useEffect, useState } from "react";
import { noterBloc, getBlocNote } from "../../API/noteArticleApi";

const BlocRating = ({ blocId, onUpdated }) => {
  const [value, setValue] = useState(0);
  const [busy, setBusy] = useState(false);

  useEffect(() => {
    if (!blocId) return;

    const fetchNote = async () => {
      try {
        const { data } = await getBlocNote(blocId);
        if (data?.ma_note != null) setValue(data.ma_note);
      } catch (e) {
        console.error("[BlocRating] Impossible de charger la note :", e);
      }
    };

    fetchNote();
  }, [blocId]);

  const handleNote = async (n) => {
    if (!blocId || busy || n === value) return;

    const prev = value;
    setValue(n);
    setBusy(true);

    try {
      const { data } = await noterBloc(blocId, n); // POST /api/blocs/:id/note
      onUpdated?.({ ma_note: n, note_moyenne: data?.moyenne });
    } catch (e) {
      setValue(prev);
      console.error("[BlocRating] Erreur lors de la notation :", e);
    } finally {
      setBusy(false);
    }
  };

  return (
    <div className="rating rating-md">
      {[1, 2, 3, 4, 5].map((n) => (
        <input
          key={n}
          type="radio"
          name={`note-${blocId || "invalid"}`}
          className="mask mask-star-2 bg-orange-400"
          checked={value === n}
          onChange={() => handleNote(n)}
          aria-label={`${n} étoile${n > 1 ? "s" : ""}`}
        />
      ))}
    </div>
  );
};

export default BlocRating;
