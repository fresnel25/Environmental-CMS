import { Navigate, useParams } from "react-router-dom";
import { useAuth } from "./AuthProvider";

export const ProtectedRoute = ({ children, roles = [] }) => {
  const { user, loading } = useAuth();
  const { tenantSlug } = useParams();

  if (loading) return null;

  // Non connecté
  if (!user) {
    return <Navigate to="/login" replace />;
  }

  // Connecté mais rôle interdit
  if (roles.length && !roles.some((r) => user.roles.includes(r))) {
    return (
      <Navigate
        to={
          tenantSlug ? `/dashboard/${tenantSlug}/unauthorized` : "/unauthorized"
        }
        replace
      />
    );
  }

  // Autorisé
  return children;
};
