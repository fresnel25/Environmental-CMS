import api from "./api";

const getUtilisateurs = () => {
  return api.get("/users");
};

const getUtilisateur = (id) => {
  return api.get(`/users/${id}`);
};

const deleteUtilisateur = (id) => {
  return api.delete(`/users/${id}`);
};

const updateUtilisateur = (id, data) => {
  return api.put(`/users/${id}`, data);
};

export {
  getUtilisateurs,
  getUtilisateur,
  updateUtilisateur,
  deleteUtilisateur,
};

export const createUtilisateur = (data) => {
  return api.post("/tenants/users", data);
};
