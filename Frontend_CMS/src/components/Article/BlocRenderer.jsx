import { useState } from "react";
import BlocContent from "./BlocContent";
import BlocRating from "./BlocRating";

const BlocRenderer = ({ bloc, canNote, articleTheme }) => {
  const [avg, setAvg] = useState(bloc.note_moyenne ?? null);
  const [my, setMy] = useState(bloc.ma_note ?? 0);

  // 🔐 sécurité : fallback si pas de thème
  const theme = articleTheme || {};

  const blocStyle = {
    backgroundColor: theme.backgroundColor,
    color: theme.textColor,
    borderRadius: theme.borderRadius,
    fontSize: theme.fontSize,
  };

  return (
    <div className="card shadow-sm transition-all" style={blocStyle}>
      <div className="card-body space-y-3">
        {/* Contenu du bloc */}
        <BlocContent bloc={bloc} />

        {/* Note */}
        <div className="card-actions justify-between items-center">
          <p className="text-sm opacity-70">Note moyenne : {avg ?? "—"} / 5</p>

          {canNote && (
            <BlocRating
              blocId={bloc.id}
              initialValue={my}
              onUpdated={({ ma_note, note_moyenne }) => {
                setMy(ma_note);
                if (typeof note_moyenne !== "undefined") {
                  setAvg(note_moyenne);
                }
              }}
            />
          )}
        </div>
      </div>
    </div>
  );
};

export default BlocRenderer;
