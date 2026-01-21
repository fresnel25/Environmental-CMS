import api from "./api";

export const createVisualisation = (data) => api.post("/visualisations", data);

export const getVisualisations = () => api.get(`/visualisations`);

export const getVisualisation = (id) => api.get(`/visualisations/${id}/data`);

export const deleteVisualisation = (id) => api.delete(`/visualisations/${id}`);