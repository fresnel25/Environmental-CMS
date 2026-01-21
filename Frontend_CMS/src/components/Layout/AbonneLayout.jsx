import { Outlet, useNavigate, useParams } from "react-router-dom";
import { useAuth } from "../../Auth/AuthProvider";
import { useEffect } from "react";
import HeaderAbonne from "./HeaderAbonne";

const AbonneLayout = () => {
  const { tenantSlug } = useParams();
  const { user } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    console.log("USER DANS ABONNE LAYOUT :", user);

    if (!user) return;

    if (!tenantSlug || tenantSlug !== user.tenant.slug) {
      navigate(`/articles/${user.tenant.slug}`, { replace: true });
    }
  }, [tenantSlug, user, navigate]);

  if (!user) return <p>Chargement utilisateur...</p>;

  return (
    <div className="flex h-screen flex-col bg-neutral-200 text-black">
      <HeaderAbonne name={user.prenom[0]} prenom= {user.nom[0]} nomTenant={user.tenant.slug}/>

      <div className="flex-1 overflow-y-auto p-4">
        <Outlet />
      </div>
    </div>
  );
};

export default AbonneLayout;
