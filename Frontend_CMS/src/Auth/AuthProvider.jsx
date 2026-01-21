// src/auth/AuthProvider.jsx
import { createContext, useContext, useState, useEffect } from "react";
import api from "../API/api";

export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  const login = async (email, password) => {
    const { data } = await api.post("/login_check", {
      username: email,
      password,
    });

    localStorage.setItem("token", data.token);
    api.defaults.headers.common["Authorization"] = `Bearer ${data.token}`;

    const user = await fetchUser(); 
    return user;
  };

  const logout = () => {
    localStorage.removeItem("token");
    delete api.defaults.headers.common["Authorization"];
    setUser(null);
  };

  const fetchUser = async () => {
    try {
      const { data } = await api.get("/me");

      const normalizedUser = {
        ...data,
        tenantSlug: data.tenant.slug,
      };

      setUser(normalizedUser);
      return normalizedUser;
    } catch {
      setUser(null);
      throw new Error("Unauthorized");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (token) {
      api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      fetchUser();
    } else {
      setLoading(false); // pas de token → fini le loading
    }
  }, []);

  return (
    <AuthContext.Provider value={{ user, login, logout, loading }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
