import { useState } from "react";
import { useAuth } from "../../Auth/useAuth";
import { toast } from "react-toastify";
import ButtonForm from "./composant_formulaire/ButtonForm";
import InputForm from "./composant_formulaire/InputForm";
import ImageForm from "./composant_formulaire/ImageForm";
import TitleForm from "./composant_formulaire/TitleForm";
import image1 from "../../../public/assets/img_login_page.svg";
import { useNavigate } from "react-router-dom";

const Login = () => {
  const { login } = useAuth();
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");

    try {
      const user = await login(email, password);

      toast.success(`Bienvenue ${user.nom}`, { autoClose: 1500 });

      setTimeout(() => {
        if (user.roles.includes("ROLE_ABONNE")) {
          navigate(`/articles/${user.tenantSlug}`);
        } else {
          navigate(`/dashboard/${user.tenantSlug}`);
        }
      }, 1500);
    } catch (err) {
      toast.error("Identifiants incorrects");
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center">
      <div className="card card-xl min-h-[500px] card-border card-side bg-base-100 shadow-xl rounded-xl overflow-hidden p-0 gap-15">
        {/* Colonne image */}
        <div className="flex flex-col gap-17 p-0 m-0 justify-center w-90 bg-amber-50">
          <div className="px-4 pt-4 flex flex-col gap-2 items-center font-bold">
            <h2 className="text-4xl text-black">Bienvenue sur</h2>
            <h3 className="text-2xl text-emerald-900">
              Dev<span className="text-accent">4Earth</span>
            </h3>
          </div>
          <figure>
            <ImageForm src={image1} />
          </figure>
        </div>

        {/* Colonne formulaire */}
        <div className="card-body p-5 m-0 flex flex-col gap-7 justify-center">
          <TitleForm title={"Connexion"} />
          <form onSubmit={handleSubmit} className="flex flex-col gap-4">
            <InputForm
              label="Email"
              placeholder="Entrer votre email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
            <InputForm
              label="Mot de Passe"
              placeholder="Entrer votre mot de passe"
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
            {error && <p className="text-red-500">{error}</p>}
            <div className="flex justify-end p-4">
              <ButtonForm title="Connexion" />
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Login;
