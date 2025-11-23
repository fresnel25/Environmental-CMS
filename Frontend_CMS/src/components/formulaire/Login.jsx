import ButtonForm from "./composant_formulaire/ButtonForm";
import InputForm from "./composant_formulaire/InputForm";
import image1 from "../../../public/assets/img_login_page.svg";
import ImageForm from "./composant_formulaire/ImageForm";
import TitleForm from "./composant_formulaire/TitleForm";

const Login = () => {
  return (
    <div className="min-h-screen  flex items-center justify-center">
      <div className="card card-xl min-h-[500px] card-border card-side bg-base-100 shadow-xl rounded-xl overflow-hidden p-0 gap-15">
        {/* Colonne image */}
        <div className="flex flex-col gap-17 p-0 m-0 justify-center w-90 bg-amber-50">
          <div className="px-4 pt-4 flex flex-col gap-2 items-center font-bold">
            <h2 className="text-4xl text-black ">Bienvenue sur</h2>
            <h3 className="text-2xl text-emerald-900">
              Environ<span className="text-accent">_Data</span>
            </h3>
          </div>
          <figure>
            <ImageForm src={image1} />
          </figure>
        </div>

        {/* Colonne formulaire */}
        <div className="card-body p-5 m-0 flex flex-col gap-7 justify-center">
          <TitleForm title={"Connexion"} />
          <InputForm label="Email" placeholder="Entrer votre email" />
          <InputForm
            label="Mot de Passe"
            placeholder="Entrer votre mot de passe"
          />
          <div className="flex justify-end p-4">
            <ButtonForm title="Connexion" />
          </div>
        </div>
      </div>
    </div>
  );
};

export default Login;
