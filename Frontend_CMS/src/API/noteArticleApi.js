import axios from "axios";
import api from "./api";

const axiosPublic = axios.create({
  baseURL: "http://localhost:8080/api/public",
});

export default axiosPublic;

export const getAllArticleWithNote = (tenantSlug) =>
  axiosPublic.get(`/${tenantSlug}/articles`);

export const noterBloc = (blocId, valeur) =>
  api.post(`/blocs/${blocId}/note`, { valeur });

export const getBlocNote = (blocId) => api.get(`/bloc/${blocId}`); //
