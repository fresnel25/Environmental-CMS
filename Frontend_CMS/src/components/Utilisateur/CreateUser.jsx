import { useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import CardForm from "../formulaire/composant_formulaire/CardForm";
import Input from "../Utils/Input";
import SelectInput from "../Utils/SelectInput";
import Page_Title from "../Page-Title/Page_Title";
import { Clock, Mail, Phone, ShieldUser, User } from "lucide-react";
import { createUtilisateur } from "../../API/utilisateurApi";

const ROLE_OPTIONS = [
  { label: "Administrateur", value: "ROLE_ADMINISTRATEUR" },
  { label: "Éditeur", value: "ROLE_EDITEUR" },
  { label: "Auteur", value: "ROLE_AUTEUR" },
  { label: "Abonné", value: "ROLE_ABONNE" },
];

const CreateUser = () => {
  const { tenantSlug } = useParams();
  const navigate = useNavigate();
   const [form, setForm] = useState({
    nom: "",
    prenom: "",
    email: "",
    telephone: "",
    password: "",
    role: "ROLE_ABONNE",
  });

  const handleChange = (field, value) => {
    setForm((prev) => ({
      ...prev,
      [field]: value,
    }));
  };

  const handleSubmit = async () => {
    try {
      await createUtilisateur({
        nom: form.nom,
        prenom: form.prenom,
        email: form.email,
        password: form.password,
        telephone: form.telephone,
        role: form.role,
      });

      navigate(`/dashboard/${tenantSlug}/utilisateurs`);
    } catch (err) {
      console.error(err.response?.data);
    }
  };

  return (
    <div>
      <Page_Title Title="Création Utilisateur" />

      <div className="mt-5">
        <CardForm title="Formulaire de création utilisateur">
          <div className="flex flex-col gap-4">
            <div className="flex gap-4">
              <Input
                icon={<User size={22} />}
                label="Nom"
                placeholder="Entrez le nom"
                value={form.nom}
                onChange={(e) => handleChange("nom", e.target.value)}
              />

              <Input
                icon={<User size={22} />}
                label="Prénom"
                placeholder="Entrez le prénom"
                value={form.prenom}
                onChange={(e) => handleChange("prenom", e.target.value)}
              />
            </div>

            <div className="flex gap-4">
              <Input
                icon={<Mail size={22} />}
                label="Email"
                placeholder="Entrez l'email"
                value={form.email}
                onChange={(e) => handleChange("email", e.target.value)}
              />

              <Input
                icon={<Phone size={22} />}
                label="Téléphone"
                placeholder="Entrez le téléphone"
                value={form.telephone}
                onChange={(e) => handleChange("telephone", e.target.value)}
              />
            </div>

            <div className="flex gap-4">
              <Input
                icon={<Clock size={22} />}
                label="Mot de passe"
                placeholder="Entrez le mot de passe"
                value={form.password}
                onChange={(e) => handleChange("password", e.target.value)}
              />

              <SelectInput
                label="Rôle utilisateur"
                icon={<ShieldUser size={22} />}
                options={ROLE_OPTIONS}
                placeholder="Choisir un rôle"
                value={form.role}
                onChange={(value) => handleChange("role", value)}
              />
            </div>

            <div className="flex justify-end mt-4">
              <button onClick={handleSubmit} className="btn btn-primary">
                Créer l’utilisateur
              </button>
            </div>
          </div>
        </CardForm>
      </div>
    </div>
  );
};

export default CreateUser;
