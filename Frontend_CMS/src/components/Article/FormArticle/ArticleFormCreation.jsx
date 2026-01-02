import { useState } from "react";


export default function ArticleFormCreation({ initialData, onSubmit }) {
  const [form, setForm] = useState(
    initialData || { titre: "", resume: "", categorie: "classic", slug: "" }
  );

  const handleChange = (e) =>
    setForm({ ...form, [e.target.name]: e.target.value });

  return (
    <form onSubmit={(e) => { e.preventDefault(); onSubmit(form); }}>
      <input name="titre" value={form.titre} onChange={handleChange} placeholder="Titre" />
      <input name="slug" value={form.slug} onChange={handleChange} placeholder="slug" />
      <textarea name="resume" value={form.resume} onChange={handleChange} placeholder="Résumé" />

      <select name="categorie" value={form.type} onChange={handleChange}>
        <option value="classic">Article</option>
        <option value="dashboard">Dashboard</option>
      </select>

      <button type="submit">Enregistrer</button>
    </form>
  );
}
