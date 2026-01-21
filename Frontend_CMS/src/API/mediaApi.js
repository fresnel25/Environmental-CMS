import api from "./api";

export const uploadMedia = (file) => {
  const formData = new FormData();
  formData.append("file", file);

  console.log("FormData:", [...formData]); 

  return api.post("/media/upload", formData, { withCredentials: true });
};

export const getMedias = () => api.get("/media");

export const getMedia = (id) => api.get(`/media/${id}`);

export const deleteMedia = (id) => api.delete(`/media/${id}`);
