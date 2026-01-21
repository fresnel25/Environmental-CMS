import { useNavigate } from "react-router-dom";
import heroImage from "../../../public/assets/img_app/hero-dashboard.png";
import storytellingImg from "../../../public/assets/img_app/storytelling.png";
import datavizImg from "../../../public/assets/img_app/dataviz.png";
import collaborationImg from "../../../public/assets/img_app/collaboration.png";

export default function Home() {
  const navigate = useNavigate();

  return (
    <main className="bg-[rgb(var(--bg))] overflow-hidden">

      {/* ================= HERO ================= */}
      <section className="py-32">
        <div className="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
          <div>
            <h1 className="text-5xl md:text-6xl font-bold text-[rgb(var(--text))] mb-6 leading-tight">
              Donnez du sens aux données climatiques
            </h1>

            <p className="text-xl text-[rgb(var(--text-muted))] mb-10">
              Dev4Earth transforme des données environnementales complexes
              en récits visuels clairs, interactifs et accessibles.
            </p>

            <div className="flex gap-4">
              <button
                onClick={() => navigate("/pricing")}
                className="bg-[rgb(var(--primary))] text-white px-6 py-3 rounded-xl font-medium hover:opacity-90 transition"
              >
                Voir les tarifs
              </button>

              <button
                onClick={() => navigate("/signup")}
                className="border border-[rgb(var(--border))] px-6 py-3 rounded-xl font-medium text-[rgb(var(--text))] hover:bg-[rgb(var(--bg-section))] transition"
              >
                Créer un compte
              </button>
            </div>
          </div>

          <img
            src={heroImage}
            alt="Dashboard Dev4Earth"
            className="rounded-3xl shadow-2xl"
          />
        </div>
      </section>

      {/* ================= CONCEPT ================= */}
      <section className="py-32 bg-[rgb(var(--bg-section))]">
        <div className="max-w-6xl mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-6 text-[rgb(var(--text))]">
            La donnée devient un récit
          </h2>

          <p className="text-lg text-[rgb(var(--text-muted))] max-w-3xl mx-auto mb-20">
            Visualisation, narration et collaboration réunies dans une
            plateforme pensée pour expliquer, sensibiliser et agir.
          </p>

          <div className="grid md:grid-cols-3 gap-10">
            {[storytellingImg, datavizImg, collaborationImg].map((img, i) => (
              <img
                key={i}
                src={img}
                className="rounded-2xl shadow-lg hover:scale-105 hover:-translate-y-2 transition duration-300"
              />
            ))}
          </div>
        </div>
      </section>

      {/* ================= DEMONSTRATION ================= */}
      <section className="py-32">
        <div className="max-w-7xl mx-auto px-6 space-y-32">

          <div className="grid md:grid-cols-2 gap-16 items-center">
            <div>
              <h3 className="text-3xl font-bold mb-4 text-[rgb(var(--text))]">
                Racontez des histoires à partir de vos données
              </h3>
              <p className="text-lg text-[rgb(var(--text-muted))]">
                Assemblez textes, graphiques et indicateurs pour créer
                des récits visuels pédagogiques et engageants.
              </p>
            </div>
            <img src={storytellingImg} className="rounded-3xl shadow-xl" />
          </div>

          <div className="grid md:grid-cols-2 gap-16 items-center">
            <img src={datavizImg} className="rounded-3xl shadow-xl" />
            <div>
              <h3 className="text-3xl font-bold mb-4 text-[rgb(var(--text))]">
                Visualisez vos données simplement
              </h3>
              <p className="text-lg text-[rgb(var(--text-muted))]">
                Importez vos fichiers CSV ou données ouvertes et générez
                automatiquement des visualisations interactives.
              </p>
            </div>
          </div>

          <div className="grid md:grid-cols-2 gap-16 items-center">
            <div>
              <h3 className="text-3xl font-bold mb-4 text-[rgb(var(--text))]">
                Collaborez efficacement
              </h3>
              <p className="text-lg text-[rgb(var(--text-muted))]">
                Travaillez à plusieurs sur un même projet :
                rédaction, édition, validation et publication.
              </p>
            </div>
            <img src={collaborationImg} className="rounded-3xl shadow-xl" />
          </div>

        </div>
      </section>

      {/* ================= HOW IT WORKS (DYNAMIQUE) ================= */}
      <section className="py-32 bg-[rgb(var(--bg-section))]">
        <div className="max-w-5xl mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-20 text-[rgb(var(--text))]">
            Comment ça fonctionne
          </h2>

          <div className="grid md:grid-cols-3 gap-12">
            {[
              {
                title: "Importez vos données",
                desc: "CSV, données ouvertes ou jeux de données climatiques existants.",
              },
              {
                title: "Créez vos récits",
                desc: "Combinez visualisations, texte et indicateurs clés.",
              },
              {
                title: "Partagez et collaborez",
                desc: "Publiez, partagez et travaillez en équipe.",
              },
            ].map((step, i) => (
              <div
                key={i}
                className="group bg-[rgb(var(--card))] p-10 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-3 transition-all duration-300 cursor-default"
              >
                <div className="text-5xl font-bold text-[rgb(var(--primary))] mb-6 group-hover:scale-110 transition">
                  {i + 1}
                </div>

                <h4 className="text-xl font-semibold mb-3 text-[rgb(var(--text))]">
                  {step.title}
                </h4>

                <p className="text-[rgb(var(--text-muted))]">
                  {step.desc}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ================= CTA FINAL ================= */}
      <section className="py-32">
        <div className="max-w-4xl mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-6 text-[rgb(var(--text))]">
            Prêt à transformer vos données climatiques ?
          </h2>

          <p className="text-lg text-[rgb(var(--text-muted))] mb-10">
            Découvrez nos offres ou échangez avec notre équipe pour un projet sur mesure.
          </p>

          <div className="flex justify-center gap-4">
            <button
              onClick={() => navigate("/pricing")}
              className="bg-[rgb(var(--primary))] text-white px-6 py-3 rounded-xl font-medium hover:opacity-90 transition"
            >
              Voir les tarifs
            </button>

            <button
              onClick={() => navigate("/contact")}
              className="border border-[rgb(var(--border))] px-6 py-3 rounded-xl font-medium text-[rgb(var(--text))] hover:bg-[rgb(var(--bg-section))] transition"
            >
              Contacter l’équipe
            </button>
          </div>
        </div>
      </section>

    </main>
  );
}
