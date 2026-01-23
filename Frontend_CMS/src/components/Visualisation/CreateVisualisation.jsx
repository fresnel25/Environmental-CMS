import { useEffect, useState } from "react";
import { ChromePicker } from "react-color";
import { getAllDatasets, getDataset } from "../../API/datasetApi";
import { createVisualisation } from "../../API/visualisationApi";
import SelectInput from "../Utils/SelectInput";
import CardForm from "../formulaire/composant_formulaire/CardForm";
import Page_Title from "../Page-Title/Page_Title";
import Input from "../Utils/Input";

const TYPE_OPTIONS = [
  { label: "Barres", value: "bar" },
  { label: "Ligne", value: "line" },
  { label: "Camembert", value: "pie" },
  { label: "Nuage de points", value: "scatter" },
];

const CreateVisual = () => {
  const [datasets, setDatasets] = useState([]);
  const [columns, setColumns] = useState([]);

  const [datasetId, setDatasetId] = useState("");
  const [datasetIri, setDatasetIri] = useState("");

  const [type, setType] = useState("");
  const [note, setNote] = useState("");
  const [x, setX] = useState("");
  const [y, setY] = useState("");

  useEffect(() => {
    getAllDatasets().then((res) => {
      setDatasets(res.data.member);
    });
  }, []);

  useEffect(() => {
    if (!datasetId) return;
    getDataset(datasetId).then((res) => {
      setColumns(res.data.colonnes || []);
      setX("");
      setY("");
    });
  }, [datasetId]);

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!datasetIri || !type) {
      alert("Dataset et type requis");
      return;
    }

    if (
      (type === "bar" || type === "line" || type === "scatter") &&
      (!x || !y)
    ) {
      alert("Veuillez choisir X et Y");
      return;
    }

    if (type === "pie" && (!x || !y)) {
      alert("Veuillez choisir label et value");
      return;
    }

    const payload = {
      dataset: datasetIri,
      type_visualisation: type,
      correspondance_json: type === "pie" ? { label: x, value: y } : { x, y },
      note: note,
    };

    await createVisualisation(payload);
    alert("Visualisation créée");
  };

  const numericColumns = columns.filter((c) => c.type_colonne === "number");
  const stringColumns = columns.filter((c) => c.type_colonne === "string");

  return (
    <div>
      <Page_Title Title="Créer une visualisation" />

      <div className="mt-6">
        <CardForm title="Formulaire de création de visualisation">
          <Input
            label="Nom de la visualisation"
            placeholder="Entrez un nom"
            value={note}
            onChange={(e) => setNote(e.target.value)}
            type="text"
          />
          {/* DATASET */}
          <SelectInput
            label="Dataset"
            value={datasetId}
            onChange={(value) => {
              setDatasetId(value);
              setDatasetIri(`/api/datasets/${value}`);
            }}
            options={datasets.map((d) => ({
              label: d.titre,
              value: d.id,
            }))}
          />

          {/* TYPE */}
          <SelectInput
            label="Type de visualisation"
            value={type}
            onChange={(value) => {
              setType(value);
              setX("");
              setY("");
            }}
            options={TYPE_OPTIONS}
          />

          {/* PIE */}
          {type === "pie" && (
            <>
              <SelectInput
                label="Label (catégorie)"
                value={x}
                onChange={setX}
                options={stringColumns.map((c) => ({
                  label: c.nom_colonne,
                  value: c.nom_colonne,
                }))}
              />

              <SelectInput
                label="Valeur (numérique)"
                value={y}
                onChange={setY}
                options={numericColumns.map((c) => ({
                  label: c.nom_colonne,
                  value: c.nom_colonne,
                }))}
              />
            </>
          )}

          {/* BAR / LINE / SCATTER */}
          {(type === "bar" || type === "line" || type === "scatter") && (
            <>
              <SelectInput
                label="Axe X"
                value={x}
                onChange={setX}
                options={columns.map((c) => ({
                  label: c.nom_colonne,
                  value: c.nom_colonne,
                }))}
              />

              <SelectInput
                label="Axe Y (numérique)"
                value={y}
                onChange={setY}
                options={numericColumns.map((c) => ({
                  label: c.nom_colonne,
                  value: c.nom_colonne,
                }))}
              />
            </>
          )}

          <div className="flex justify-end mt-4">
            <button onClick={handleSubmit} className="btn btn-primary">
              Créer
            </button>
          </div>
        </CardForm>
      </div>
    </div>
  );
};

export default CreateVisual;
