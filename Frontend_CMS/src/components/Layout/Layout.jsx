import { Outlet, useNavigate, useParams } from "react-router-dom";
import Sidenav from "./Sidenav";
import Header from "./Header";
import { useAuth } from "../../Auth/AuthProvider";
import { useEffect } from "react";

const Layout = () => {
  const { tenantSlug } = useParams(); // récupère :tenantSlug
  const { user } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    if (!tenantSlug && user?.tenant?.slug) {
      navigate(`/dashboard/${user.tenant.slug}`, { replace: true });
    } else if (user?.tenant?.slug && tenantSlug !== user.tenant.slug) {
      navigate(`/dashboard/${user.tenant.slug}`, { replace: true });
    }
  }, [tenantSlug, user, navigate]);

  if (!tenantSlug) return null; // évite render avant navigation

  console.log("tenantSlug URL =", tenantSlug);
  console.log("user.tenant =", user?.tenant);
  console.log("slug réel =", user?.tenant?.slug);

  return (
    <div className="flex h-screen w-screen overflow-hidden">
      <Sidenav tenantSlug={tenantSlug} />

      <div className="flex flex-col flex-1 bg-neutral-200 text-black">
        <Header />
        <div className="flex-1 min-h-0 overflow-y-auto p-4">
          <Outlet />
        </div>
      </div>
    </div>
  );
};

export default Layout;
