import { useState } from "react";
import SelectInput from "../../Utils/SelectInput";
import CardForm from "../../formulaire/composant_formulaire/CardForm";
import Input from "../../Utils/Input";
import Textarea from "../../Utils/Textarea";

const Categorie = [
  { label: "Dashboard", value: "dashboard" },
  { label: "Article", value: "classic" },
];

const ArticleFormCreation = ({ onSubmit }) => {
  const [form, setForm] = useState({
    titre: "",
    resume: "",
    categorie: "classic",
    slug: "",
  });

  const handleChange = (e) =>
    setForm({ ...form, [e.target.name]: e.target.value });

  return (
    <CardForm title="Formulaire de création d'article">
      <form
        onSubmit={(e) => {
          e.preventDefault();
          onSubmit(form);
        }}
      >
        <Input
          label="Titre Article"
          name="titre"
          value={form.titre}
          onChange={handleChange}
          placeholder="Titre article"
        />

        <Input
          label="Slug Article"
          name="slug"
          value={form.slug}
          onChange={handleChange}
          placeholder="slug-article"
        />

        <SelectInput
          label="Type d'article"
          options={Categorie}
          value={form.categorie}
          onChange={(value) => setForm({ ...form, categorie: value })}
          placeholder="Choisir type article"
        />

        <Textarea
          label="Resumé"
          name="resume"
          value={form.resume}
          onChange={handleChange}
          placeholder="Résumé"
        />

        <div className="flex justify-end mt-4">
          <button type="submit" className="btn btn-primary">
            Enregistrer l'article
          </button>
        </div>
      </form>
    </CardForm>
  );
};

export default ArticleFormCreation;
