import storytellingImg from "../../../public/assets/img_app/storytelling.png";
import datavizImg from "../../../public/assets/img_app/dataviz.png";
import collaborationImg from "../../../public/assets/img_app/collaboration.png";

export default function Features() {
  return (
    <main className="bg-[rgb(var(--bg))]">

      {/* ================= HERO ================= */}
      <section className="py-32 bg-[rgb(var(--bg-section))]">
        <div className="max-w-5xl mx-auto px-6 text-center">
          <h1 className="text-5xl font-bold text-[rgb(var(--text))] mb-6">
            Fonctionnalités
          </h1>
          <p className="text-xl text-[rgb(var(--text-muted))]">
            Tout ce dont vous avez besoin pour transformer
            des données climatiques en récits visuels clairs,
            interactifs et impactants.
          </p>
        </div>
      </section>

      {/* ================= FEATURE 1 ================= */}
      <section className="py-32">
        <div className="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
          <div>
            <h2 className="text-3xl font-bold mb-6 text-[rgb(var(--text))]">
              Data storytelling narratif
            </h2>

            <p className="text-lg text-[rgb(var(--text-muted))] mb-8">
              Créez des récits pédagogiques à partir de données climatiques
              en combinant texte, graphiques et indicateurs clés.
            </p>

            <ul className="space-y-4">
              {[
                "Structuration narrative des données",
                "Intégration de graphiques et cartes",
                "Lecture progressive et pédagogique",
                "Idéal pour la sensibilisation et l’éducation",
              ].map((item, i) => (
                <li key={i} className="flex gap-3">
                  <span className="mt-2 h-2 w-2 rounded-full bg-[rgb(var(--primary))]" />
                  <span className="text-[rgb(var(--text))]">{item}</span>
                </li>
              ))}
            </ul>
          </div>

          <img
            src={storytellingImg}
            className="rounded-3xl shadow-xl transition-all duration-500 hover:scale-105"
            alt="Data storytelling"
          />
        </div>
      </section>

      {/* ================= FEATURE 2 ================= */}
      <section className="py-32 bg-[rgb(var(--bg-section))]">
        <div className="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
          <img
            src={datavizImg}
            className="rounded-3xl shadow-xl transition-all duration-500 hover:scale-105"
            alt="Dataviz"
          />

          <div>
            <h2 className="text-3xl font-bold mb-6 text-[rgb(var(--text))]">
              Visualisations interactives
            </h2>

            <p className="text-lg text-[rgb(var(--text-muted))] mb-8">
              Importez vos données et générez automatiquement
              des graphiques, cartes et tableaux interactifs.
            </p>

            <ul className="space-y-4">
              {[
                "Import CSV et données ouvertes",
                "Graphiques et cartes interactives",
                "Exploration intuitive des données",
                "Visualisations adaptées à tous les publics",
              ].map((item, i) => (
                <li key={i} className="flex gap-3">
                  <span className="mt-2 h-2 w-2 rounded-full bg-[rgb(var(--primary))]" />
                  <span className="text-[rgb(var(--text))]">{item}</span>
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>

      {/* ================= FEATURE 3 ================= */}
      <section className="py-32">
        <div className="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
          <div>
            <h2 className="text-3xl font-bold mb-6 text-[rgb(var(--text))]">
              Collaboration et partage
            </h2>

            <p className="text-lg text-[rgb(var(--text-muted))] mb-8">
              Travaillez à plusieurs sur un même projet
              et facilitez la production de contenus collectifs.
            </p>

            <ul className="space-y-4">
              {[
                "Travail collaboratif en temps réel",
                "Gestion des rôles et validations",
                "Partage sécurisé des projets",
                "Adapté aux ONG, équipes et institutions",
              ].map((item, i) => (
                <li key={i} className="flex gap-3">
                  <span className="mt-2 h-2 w-2 rounded-full bg-[rgb(var(--primary))]" />
                  <span className="text-[rgb(var(--text))]">{item}</span>
                </li>
              ))}
            </ul>
          </div>

          <img
            src={collaborationImg}
            className="rounded-3xl shadow-xl transition-all duration-500 hover:scale-105"
            alt="Collaboration"
          />
        </div>
      </section>

      {/* ================= CTA ================= */}
      <section className="py-32 bg-[rgb(var(--bg-section))]">
        <div className="max-w-4xl mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-6 text-[rgb(var(--text))]">
            Prêt à utiliser Dev4Earth ?
          </h2>

          <p className="text-lg text-[rgb(var(--text-muted))] mb-10">
            Découvrez nos offres ou créez un compte pour commencer
            à transformer vos données climatiques.
          </p>

          <div className="flex justify-center gap-4">
            <a
              href="/pricing"
              className="bg-[rgb(var(--primary))] text-white px-6 py-3 rounded-xl font-medium hover:opacity-90 transition"
            >
              Voir les tarifs
            </a>

            <a
              href="/signup"
              className="border border-[rgb(var(--border))] px-6 py-3 rounded-xl font-medium text-[rgb(var(--text))] hover:bg-[rgb(var(--bg))] transition"
            >
              Créer un compte
            </a>
          </div>
        </div>
      </section>

    </main>
  );
}
