import { Navigate } from "react-router-dom";
import { useAuth } from "./AuthProvider";

export const ProtectedRoute = ({ children, roles = [] }) => {
  const { user, loading } = useAuth();

  // ⚡ si on est encore en train de charger, ne rien afficher
  if (loading) return null;

  if (!user) return <Navigate to="/login" replace />;
  if (roles.length && !roles.some((r) => user.roles.includes(r)))
    return <Navigate to="/unauthorized" replace />;

  return children;
};
