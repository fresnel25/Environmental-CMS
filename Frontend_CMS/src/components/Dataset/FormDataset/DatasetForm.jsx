import { useState } from "react";
import { createDataset } from "../../../API/datasetApi";


const DatasetForm = () => {
  const [titre, setTitre] = useState("");
  const [typeSource, setTypeSource] = useState("csv");
  const [urlSource, setUrlSource] = useState("");
  const [delimiter, setDelimiter] = useState(",");

  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    setSuccess(false);

    try {
      const payload = {
        titre,
        type_source: typeSource,
        url_source: urlSource,
      };

      if (typeSource === "csv") {
        payload.delimiter = delimiter;
      }

      await createDataset(payload);
      setSuccess(true);

      // reset simple
      setTitre("");
      setUrlSource("");
    } catch (err) {
      console.error(err);
      setError("Erreur lors de la création du dataset");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="max-w-xl space-y-4">
      <h2 className="text-xl font-bold">Créer un dataset</h2>

      <form onSubmit={handleSubmit} className="space-y-3 text-white">
        {/* Titre */}
        <input
          type="text"
          placeholder="Titre du dataset"
          className="input input-bordered w-full"
          value={titre}
          onChange={(e) => setTitre(e.target.value)}
          required
        />

        {/* Type source */}
        <select
          className="select select-bordered w-full"
          value={typeSource}
          onChange={(e) => setTypeSource(e.target.value)}
        >
          <option value="csv">CSV</option>
          <option value="api">API</option>
        </select>

        {/* URL */}
        <input
          type="url"
          placeholder="URL de la source"
          className="input input-bordered w-full"
          value={urlSource}
          onChange={(e) => setUrlSource(e.target.value)}
          required
        />

        {/* Délimiteur CSV */}
        {typeSource === "csv" && (
          <input
            type="text"
            maxLength={1}
            placeholder="Délimiteur (ex: , ou ;)"
            className="input input-bordered w-full"
            value={delimiter}
            onChange={(e) => setDelimiter(e.target.value)}
          />
        )}

        {error && <p className="text-red-500">{error}</p>}
        {success && (
          <p className="text-green-500">Dataset créé avec succès</p>
        )}

        <button className="btn btn-primary w-full" disabled={loading}>
          {loading ? "Analyse..." : "Créer le dataset"}
        </button>
      </form>
    </div>
  );
};

export default DatasetForm;
