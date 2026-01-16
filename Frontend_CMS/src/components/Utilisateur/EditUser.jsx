import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";

import {
  getUtilisateur,
  updateUtilisateur,
} from "../../API/utilisateurApi";
import SelectInput from "../Utils/SelectInput";
import Input from "../Utils/Input";

const EditUser = () => {
  const { id } = useParams();
  const { tenantSlug } = useParams();
  const navigate = useNavigate();

  const [form, setForm] = useState({
    nom: "",
    prenom: "",
    email: "",
    role: "",
    statut: true,
  });

  const rolesOptions = [
    { label: "Administrateur", value: "ROLE_ADMINISTRATEUR" },
    { label: "Éditeur", value: "ROLE_EDITEUR" },
    { label: "Auteur", value: "ROLE_AUTEUR" },
    { label: "Abonné", value: "ROLE_ABONNE" },
  ];

  useEffect(() => {
    getUtilisateur(id).then(({ data }) => {
      setForm({
        nom: data.nom,
        prenom: data.prenom,
        email: data.email,
        role: data.roles?.[0] || "",
        statut: data.statut,
      });
    });
  }, [id]);

  const handleSubmit = async () => {
    await updateUtilisateur(id, {
      nom: form.nom,
      prenom: form.prenom,
      email: form.email,
      roles: [form.role],
      statut: form.statut,
    });

    navigate(`/dashboard/${tenantSlug}/utilisateurs`);
  };

  return (
    <div className="p-6 space-y-6">
      <h2 className="text-2xl font-bold">Modifier utilisateur</h2>

      <Input
        label="Nom"
        value={form.nom}
        onChange={(e) => setForm({ ...form, nom: e.target.value })}
      />

      <Input
        label="Prénom"
        value={form.prenom}
        onChange={(e) => setForm({ ...form, prenom: e.target.value })}
      />

      <Input
        label="Email"
        type="email"
        value={form.email}
        onChange={(e) => setForm({ ...form, email: e.target.value })}
      />

      <SelectInput
        label="Rôle"
        value={form.role}
        options={rolesOptions}
        placeholder="Choisir un rôle"
        onChange={(value) => setForm({ ...form, role: value })}
      />

      <div className="flex gap-4">
        <button
          onClick={handleSubmit}
          className="btn btn-primary"
        >
          Enregistrer
        </button>

        <button
          onClick={() => navigate(-1)}
          className="btn btn-outline"
        >
          Annuler
        </button>
      </div>
    </div>
  );
};

export default EditUser;
