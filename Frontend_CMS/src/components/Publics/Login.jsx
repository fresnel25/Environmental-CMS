import { Link } from "react-router-dom";

export default function Login() {
  return (
    <section className="py-24">
      <div className="max-w-md mx-auto px-6">

        <h2 className="text-4xl font-bold mb-6 text-center text-[rgb(var(--text))]">
          Connexion
        </h2>

        <p className="text-center text-[rgb(var(--text-muted))] mb-8">
          Connectez-vous à votre compte Dev4Earth.
        </p>

        <form className="space-y-4">

          <input
            type="email"
            placeholder="Adresse email"
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
            Se connecter
          </button>

        </form>

        <p className="text-center text-sm mt-6 text-[rgb(var(--text-muted))]">
          Pas encore de compte ?{" "}
          <Link to="/signup" className="text-[rgb(var(--primary))] font-medium">
            Créer un compte
          </Link>
        </p>

      </div>
    </section>
  );
}
