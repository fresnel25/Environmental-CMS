import React, { useState } from "react";
import CardForm from "../formulaire/composant_formulaire/CardForm";
import Input from "../Utils/Input";
import Page_Title from "../Page-Title/Page_Title";
import SelectInput from "../Utils/SelectInput";
import { Mail, Phone, ShieldUser, User } from "lucide-react";

const role_user = [
  { label: "Admin", value: "admin" },
  { label: "Manager", value: "manager" },
  { label: "Employé", value: "employe" },
];

const CreateUser = () => {
  const [role, setRole] = useState("");

  return (
    <div>
      <div className="flex flex-col">
        <div>
          <Page_Title Title={"Création Utilisateur"} />
        </div>
        <div className="mt-5">
          <CardForm title="Formulaire de création utilisateur">
            <div className="flex gap-4 flex-col">
              <div className="flex gap-4">
                <Input
                  icon={<User size={25} />}
                  label="Nom"
                  placeholder="entrez le nom"
                />
                <Input
                  icon={<User size={25} />}
                  label="Prénom"
                  placeholder="entrez le prénom"
                />
              </div>

              <div className="flex gap-4">
                <Input
                  icon={<Mail size={25} />}
                  label="Email"
                  placeholder="entrez le mail"
                />
                <Input
                  icon={<Phone size={25} />}
                  label="Télephone"
                  placeholder="entrez le télephone"
                />
              </div>

              <div>
                <SelectInput
                  label="Rôle utilisateur"
                  icon={<ShieldUser size={25} />}
                  options={role_user}
                  placeholder="Choisir un rôle"
                  value={role}
                  onChange={setRole}
                />
              </div>
            </div>
            
          </CardForm>
        </div>
      </div>
    </div>
  );
};

export default CreateUser;
