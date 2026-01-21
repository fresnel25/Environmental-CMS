import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import createAccount from "../../API/adminAccountApi";
/* import createAccount from "../../API/createAccount"; */

export default function Signup() {
  const navigate = useNavigate();

  const [form, setForm] = useState({
    tenant: "",
    plan: "Pro",
    nom: "",
    prenom: "",
    email: "",
    telephone: "",
    password: "",
  });

  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(null);
    setLoading(true);

    try {
      await createAccount(form);
      navigate("/login");
    } catch (err) {
      setError(err.response?.data?.error || "Erreur lors de l'inscription");
    } finally {
      setLoading(false);
    }
  };

  return (
    <section className="py-24">
      <div className="max-w-md mx-auto px-6">
        <h2 className="text-4xl font-bold mb-6 text-center">Créer un compte</h2>

        {error && <div className="alert alert-error mb-4">{error}</div>}

        <form className="space-y-4" onSubmit={handleSubmit}>
          <input
            name="tenant"
            placeholder="Nom de l'organisation"
            className="w-full p-3 rounded-lg border"
            onChange={handleChange}
          />

          <input
            name="nom"
            placeholder="Nom"
            className="w-full p-3 rounded-lg border"
            onChange={handleChange}
          />

          <input
            name="prenom"
            placeholder="Prénom"
            className="w-full p-3 rounded-lg border"
            onChange={handleChange}
          />

          <input
            name="email"
            type="email"
            placeholder="Adresse email"
            className="w-full p-3 rounded-lg border"
            onChange={handleChange}
          />

          <input
            name="telephone"
            placeholder="Téléphone"
            className="w-full p-3 rounded-lg border"
            onChange={handleChange}
          />

          <input
            name="password"
            type="password"
            placeholder="Mot de passe"
            className="w-full p-3 rounded-lg border"
            onChange={handleChange}
          />

          <button
            type="submit"
            disabled={loading}
            className="w-full bg-primary text-white py-3 rounded-lg"
          >
            {loading ? "Création..." : "Créer mon compte"}
          </button>
        </form>

        <p className="text-center text-sm mt-6">
          Déjà un compte ?{" "}
          <Link to="/login" className="text-primary">
            Se connecter
          </Link>
        </p>
      </div>
    </section>
  );
}
