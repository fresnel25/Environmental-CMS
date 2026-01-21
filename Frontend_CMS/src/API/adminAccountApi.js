import api from "./api";

const createAccount = (data) => api.post("/tenants/register", data);

export default createAccount;