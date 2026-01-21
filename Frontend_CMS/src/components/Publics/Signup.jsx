import { Link } from "react-router-dom";

export default function Signup() {
  return (
    <section className="py-24">
      <div className="max-w-md mx-auto px-6">

        <h2 className="text-4xl font-bold mb-6 text-center text-[rgb(var(--text))]">
          Créer un compte
        </h2>

        <p className="text-center text-[rgb(var(--text-muted))] mb-8">
          Créez votre compte Dev4Earth en quelques secondes.
        </p>

        <form className="space-y-4">

          <input
            type="text"
            placeholder="Prénom"
            className="w-full p-3 rounded-lg border border-[rgb(var(--border))] bg-transparent"
          />

          <input
            type="text"
            placeholder="Nom"
            className="w-full p-3 rounded-lg border border-[rgb(var(--border))] bg-transparent"
          />

          <input
            type="email"
            placeholder="Adresse email"
            className="w-full p-3 rounded-lg border border-[rgb(var(--border))] bg-transparent"
          />

          <input
            type="tel"
            placeholder="Téléphone"
            className="w-full p-3 rounded-lg border border-[rgb(var(--border))] bg-transparent"
          />

          <input
            type="password"
            placeholder="Mot de passe"
            className="w-full p-3 rounded-lg border border-[rgb(var(--border))] bg-transparent"
          />

          <button
            type="submit"
            className="w-full bg-[rgb(var(--primary))] text-white py-3 rounded-lg font-medium hover:opacity-90 transition"
          >
            Créer mon compte
          </button>
        </form>

        <p className="text-center text-sm mt-6 text-[rgb(var(--text-muted))]">
          Déjà un compte ?{" "}
          <Link to="/login" className="text-[rgb(var(--primary))] font-medium">
            Se connecter
          </Link>
        </p>

      </div>
    </section>
  );
}
