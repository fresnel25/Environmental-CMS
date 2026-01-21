import { Outlet, useParams } from "react-router-dom";
import HeaderAbonne from "./HeaderAbonne";

const PublicTenantLayout = () => {
  const { tenantSlug } = useParams();
  return (
    <div className="flex h-screen flex-col bg-neutral-200 text-black">
      <HeaderAbonne nomTenant={tenantSlug} />

      <div className="flex-1 overflow-y-auto p-4">
        <Outlet />
      </div>
    </div>
  );
};

export default PublicTenantLayout;
