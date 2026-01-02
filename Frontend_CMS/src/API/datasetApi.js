import api from "./api";

const getAllDatasets = () => {
  return api.get("/datasets");
};

const getDataset = (id) => api.get(`/datasets/${id}`);

const createDataset = (data) => api.post("/datasets/analyse", data);

const deleteDataset = (id) => api.delete(`/datasets/${id}`);

export { getAllDatasets, getDataset, createDataset, deleteDataset };
