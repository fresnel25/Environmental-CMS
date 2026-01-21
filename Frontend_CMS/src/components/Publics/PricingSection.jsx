import { useState } from "react";
import { useNavigate } from "react-router-dom";
import PricingCard from "./PricingCard";
import collaborationImg from "../../../public/assets/img_app/collaboration.png";

const plansData = {
  monthly: [
    {
      name: "Freemium",
      description: "Découvrir la plateforme et créer vos premières visualisations.",
      price: "Gratuit",
      renewal: "Toujours gratuit",
      highlight: false,
      cta: "signup",
      features: [
        "Import CSV simple",
        "Premiers graphiques et cartes",
        "CMS narratif de base",
        "Publication publique avec attribution",
      ],
    },
    {
      name: "Pro",
      description: "Pour les créateurs et professionnels du climat.",
      price: "9 € / mois",
      renewal: "Facturation mensuelle",
      highlight: true,
      cta: "signup",
      features: [
        "Visualisations avancées",
        "Exports personnalisés",
        "Templates premium",
        "Mises à jour des données",
      ],
    },
    {
      name: "Organisation",
      description: "Pour équipes, ONG et institutions.",
      price: "Sur devis",
      renewal: "Facturation personnalisée",
      highlight: false,
      cta: "contact",
      features: [
        "Collaboration multi-utilisateurs",
        "Dashboards avancés",
        "Sécurité renforcée",
        "Support prioritaire",
      ],
    },
  ],
  yearly: [
    {
      name: "Freemium",
      description: "Découvrir la plateforme gratuitement.",
      price: "Gratuit",
      renewal: "Toujours gratuit",
      highlight: false,
      cta: "signup",
      features: [
        "Import CSV simple",
        "Premiers graphiques",
        "CMS narratif de base",
      ],
    },
    {
      name: "Pro",
      description: "Paiement annuel — économisez 27 %.",
      price: "79 € / an",
      renewal: "Facturation annuelle",
      highlight: true,
      cta: "signup",
      features: [
        "Visualisations avancées",
        "Exports personnalisés",
        "Templates premium",
        "Support prioritaire",
      ],
    },
    {
      name: "Organisation",
      description: "Offre annuelle pour structures engagées.",
      price: "Sur devis",
      renewal: "Facturation annuelle",
      highlight: false,
      cta: "contact",
      features: [
        "Collaboration avancée",
        "Sécurité entreprise",
        "Support dédié",
      ],
    },
  ],
};

export default function PricingSection() {
  const [billing, setBilling] = useState("monthly");
  const navigate = useNavigate();

  return (
    <section className="bg-[rgb(var(--bg-section))] py-28">
      <div className="max-w-7xl mx-auto px-6">

        {/* HERO */}
        <div className="text-center max-w-3xl mx-auto mb-24">
          <h1 className="text-5xl font-bold text-[rgb(var(--text))] mb-6">
            Tarification
          </h1>
          <p className="text-lg text-[rgb(var(--text-muted))]">
            Des offres flexibles pour les individus, équipes et organisations.
            Conçues pour transformer les données climatiques en récits clairs et impactants.
          </p>
        </div>

        {/* TOGGLE */}
        <div className="flex justify-center mb-20">
          <div
            onClick={() =>
              setBilling(billing === "monthly" ? "yearly" : "monthly")
            }
            className="flex bg-[rgb(var(--bg))] border border-[rgb(var(--border))] rounded-full p-1 cursor-pointer"
          >
            <span
              className={`px-6 py-2 rounded-full transition ${
                billing === "monthly"
                  ? "bg-[rgb(var(--primary))] text-white"
                  : "text-[rgb(var(--text-muted))]"
              }`}
            >
              Mensuel
            </span>
            <span
              className={`px-6 py-2 rounded-full transition ${
                billing === "yearly"
                  ? "bg-[rgb(var(--primary))] text-white"
                  : "text-[rgb(var(--text-muted))]"
              }`}
            >
              Annuel
            </span>
          </div>
        </div>

        {/* PRICING CARDS */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-10 mb-32">
          {plansData[billing].map((plan) => (
            <PricingCard
              key={plan.name}
              plan={plan}
              onAction={() =>
                plan.cta === "contact"
                  ? navigate("/contact")
                  : navigate("/signup")
              }
            />
          ))}
        </div>

        {/* COMPARE FEATURES */}
        <div className="max-w-4xl mx-auto mb-32">
          <h3 className="text-3xl font-bold text-center mb-10 text-[rgb(var(--text))]">
            Comparer les fonctionnalités
          </h3>

          <div className="bg-[rgb(var(--card))] rounded-2xl overflow-hidden border border-[rgb(var(--border))]">
            <table className="w-full text-left">
              <thead className="bg-[rgb(var(--bg))]">
                <tr>
                  <th className="p-4">Fonctionnalité</th>
                  <th className="p-4 text-center">Freemium</th>
                  <th className="p-4 text-center">Pro</th>
                  <th className="p-4 text-center">Organisation</th>
                </tr>
              </thead>
              <tbody>
                {[
                  ["Import CSV", "✔", "✔", "✔"],
                  ["Visualisations avancées", "—", "✔", "✔"],
                  ["Collaboration d’équipe", "—", "—", "✔"],
                  ["Exports personnalisés", "—", "✔", "✔"],
                  ["Support prioritaire", "—", "—", "✔"],
                ].map((row, i) => (
                  <tr key={i} className="border-t border-[rgb(var(--border))]">
                    {row.map((cell, j) => (
                      <td key={j} className="p-4 text-center">
                        {cell}
                      </td>
                    ))}
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* FAQ */}
        <div className="max-w-3xl mx-auto mb-32 space-y-6">
          <h3 className="text-3xl font-bold text-center mb-10 text-[rgb(var(--text))]">
            Questions fréquentes
          </h3>

          <details className="p-6 rounded-xl bg-[rgb(var(--card))]">
            <summary className="font-medium cursor-pointer">
              À quoi sert Dev4Earth ?
            </summary>
            <p className="mt-3 text-[rgb(var(--text-muted))]">
              Dev4Earth est une plateforme de data storytelling climatique permettant
              de transformer des données environnementales complexes en récits visuels
              clairs, pédagogiques et partageables.
            </p>
          </details>

          <details className="p-6 rounded-xl bg-[rgb(var(--card))]">
            <summary className="font-medium cursor-pointer">
              Dev4Earth est-il sécurisé ?
            </summary>
            <p className="mt-3 text-[rgb(var(--text-muted))]">
              Oui. La plateforme intègre des mécanismes de sécurité adaptés aux usages
              professionnels, avec une gestion des accès, des rôles utilisateurs
              et des données protégées.
            </p>
          </details>

          <details className="p-6 rounded-xl bg-[rgb(var(--card))]">
            <summary className="font-medium cursor-pointer">
              Puis-je changer de plan à tout moment ?
            </summary>
            <p className="mt-3 text-[rgb(var(--text-muted))]">
              Oui, vous pouvez évoluer ou rétrograder à tout moment depuis votre
              espace utilisateur, sans engagement.
            </p>
          </details>

          <details className="p-6 rounded-xl bg-[rgb(var(--card))]">
            <summary className="font-medium cursor-pointer">
              Proposez-vous des offres pour les ONG et institutions ?
            </summary>
            <p className="mt-3 text-[rgb(var(--text-muted))]">
              Oui. Dev4Earth soutient les organisations engagées dans la transition
              écologique avec des offres adaptées et des conditions préférentielles.
            </p>
          </details>

          <details className="p-6 rounded-xl bg-[rgb(var(--card))]">
            <summary className="font-medium cursor-pointer">
              Comment fonctionne la collaboration en équipe ?
            </summary>
            <p className="mt-3 text-[rgb(var(--text-muted))]">
              Les plans Organisation permettent à plusieurs utilisateurs de travailler
              sur un même projet : édition, validation, publication et partage des récits.
            </p>
          </details>
        </div>

        {/* FINAL CTA */}
        <div className="grid md:grid-cols-2 gap-12 items-center bg-[rgb(var(--card))] rounded-3xl p-12">
          <img
            src={collaborationImg}
            alt="Contact Dev4Earth"
            className="rounded-2xl shadow-lg"
          />

          <div>
            <h3 className="text-3xl font-bold mb-4 text-[rgb(var(--text))]">
              Parlons de votre projet
            </h3>
            <p className="text-[rgb(var(--text-muted))] mb-6">
              Vous représentez une organisation, une ONG ou une institution ?
              Contactez notre équipe pour une offre adaptée à vos besoins.
            </p>

            <button
              onClick={() => navigate("/contact")}
              className="bg-[rgb(var(--primary))] text-white px-6 py-3 rounded-xl font-medium hover:opacity-90 transition"
            >
              Get in touch
            </button>
          </div>
        </div>

      </div>
    </section>
  );
}
