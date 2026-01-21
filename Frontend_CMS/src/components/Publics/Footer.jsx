import { useNavigate } from "react-router-dom";

export default function Footer() {
  const navigate = useNavigate();

  return (
    <footer className="bg-[rgb(var(--bg-section))] border-t border-[rgb(var(--border))]">
      <div className="max-w-7xl mx-auto px-6 py-16 grid md:grid-cols-4 gap-12">

        {/* Brand */}
        <div>
          <h3 className="text-xl font-bold text-[rgb(var(--text))] mb-4">
            Dev4Earth
          </h3>
          <p className="text-[rgb(var(--text-muted))]">
            Plateforme de data storytelling climatique pour transformer
            des données environnementales en récits clairs et impactants.
          </p>
        </div>

        {/* Navigation */}
        <div>
          <h4 className="font-semibold text-[rgb(var(--text))] mb-4">
            Navigation
          </h4>
          <ul className="space-y-3 text-[rgb(var(--text-muted))]">
            <li onClick={() => navigate("/")} className="cursor-pointer hover:text-[rgb(var(--text))]">
              Accueil
            </li>
            <li onClick={() => navigate("/features")} className="cursor-pointer hover:text-[rgb(var(--text))]">
              Fonctionnalités
            </li>
            <li onClick={() => navigate("/pricing")} className="cursor-pointer hover:text-[rgb(var(--text))]">
              Tarifs
            </li>
            <li onClick={() => navigate("/contact")} className="cursor-pointer hover:text-[rgb(var(--text))]">
              Contact
            </li>
          </ul>
        </div>

        {/* Compte */}
        <div>
          <h4 className="font-semibold text-[rgb(var(--text))] mb-4">
            Compte
          </h4>
          <ul className="space-y-3 text-[rgb(var(--text-muted))]">
            <li onClick={() => navigate("/signup")} className="cursor-pointer hover:text-[rgb(var(--text))]">
              Créer un compte
            </li>
            <li onClick={() => navigate("/login")} className="cursor-pointer hover:text-[rgb(var(--text))]">
              Connexion
            </li>
          </ul>
        </div>

        {/* Infos */}
        <div>
          <h4 className="font-semibold text-[rgb(var(--text))] mb-4">
            À propos
          </h4>
          <p className="text-[rgb(var(--text-muted))]">
            Dev4Earth est un projet orienté vers la pédagogie,
            la sensibilisation et l’analyse des enjeux climatiques.
          </p>
        </div>

      </div>

      {/* Bottom bar */}
      <div className="border-t border-[rgb(var(--border))] py-6">
        <div className="max-w-7xl mx-auto px-6 text-center text-sm text-[rgb(var(--text-muted))]">
          © {new Date().getFullYear()} Dev4Earth — Tous droits réservés
        </div>
      </div>
    </footer>
  );
}
