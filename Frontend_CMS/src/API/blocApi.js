// src/API/blocApi.js
import api from "./api";

export const getBlocs = (articleId) =>
  api.get(`/blocs/${articleId}`);

export const createBloc = (data) =>
  api.post("/blocs", data);

export const updateBloc = (id, data) =>
  api.patch(`/blocs/${id}`, data);

export const deleteBloc = (id) =>
  api.delete(`/blocs/${id}`);
